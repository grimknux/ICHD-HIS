<?php

namespace App\Libraries;
//use App\Models\getUserList;

class CustomObj {


    public function validateCSRFToken($token)
    {
        $csrfName  = 'csrf_token';
        return hash_equals(csrf_hash($csrfName ), $token);
    }

    public function securePasscode($password)
    {
        $width = 192;
        $rounds = 3;

        return substr(
            implode(
                array_map(
                    function ($h) {
                        return str_pad(bin2hex(strrev($h)), 10, "0");
                    },
                    str_split(hash("tiger192,$rounds", $password, true), 8)
                )
            ),
            0, 32-(192-$width)/4
        );


    }

    public function verifyPassword($password1, $password2){

        $passInput = $this->securePasscode($password1);

        if($passInput === $password2){
            return true;
        }else{
            return false;
        }

        
    }

    public function convertEMP($lname, $fname, $mname, $rep){
        
        if(empty($lname)){
            return "";
        }

        if($rep=="N"){
            $result = ucfirst($lname).", ".ucfirst($fname)." ".ucfirst($mname[0]).".";
        }else{
            $result = ucfirst($lname).", ".ucfirst($fname)." ".ucfirst($mname[0]).". (Representative)";
        }

        return $result;
    }

    public function convertEMPNorep($lname, $fname, $mname){

        $result = ucfirst($lname).", ".ucfirst($fname)." ".ucfirst($mname[0]).".";

        return $result;
    }

    public function calculateTime($startDateTime, $endDateTime, $holidayDates ){

        $start = new \DateTime($startDateTime);
        $end = new \DateTime($endDateTime);

        $totalWorkingSeconds = 0;

        // Loop through each day between start and end
        while ($start <= $end) {
            // Check if it's a weekday and not a holiday
            if ($start->format('N') < 6 && !in_array($start->format('Y-m-d'), $holidayDates)) {
                // If the day is a working day, calculate the working seconds
                if ($start->format('Y-m-d') === $end->format('Y-m-d')) {
                    // On the same day, count from start to end
                    $totalWorkingSeconds += $end->getTimestamp() - $start->getTimestamp();
                } else {
                    // Count whole day from start to end
                    $totalWorkingSeconds += (24 * 60 * 60); // 24 hours in seconds
                }
            }
            // Move to the next day
            $start->modify('+1 day');
        }

        // Convert seconds to days, hours, and minutes
        $days = floor($totalWorkingSeconds / (24 * 60 * 60));
        $hours = floor(($totalWorkingSeconds % (24 * 60 * 60)) / 3600);
        $minutes = floor(($totalWorkingSeconds % 3600) / 60);
        
        return [
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes,
            'total_seconds' => $totalWorkingSeconds
        ];

    }

    public function calculateTime8Hrs($startDateTime, $endDateTime, $holidayDates ){

        $start = new \DateTime($startDateTime);
        $end = new \DateTime($endDateTime);

        $totalWorkingSeconds = 0;

        // Loop through each day between start and end
        while ($start <= $end) {
            // Check if it's a weekday and not a holiday
            if ($start->format('N') < 6 && !in_array($start->format('Y-m-d'), $holidayDates)) {
                // Calculate working seconds based on the current day's time
                if ($start->format('Y-m-d') === $end->format('Y-m-d')) {
                    // On the same day, count only the working hours
                    $totalWorkingSeconds += $this->computeSameDayWorkingSeconds($start, $end);
                } else {
                    // Count working hours for the full working day
                    $totalWorkingSeconds += $this->computeFullDayWorkingSeconds($start);
                }
            }
            // Move to the next day
            $start->modify('+1 day')->setTime(0, 0); // Reset time to midnight for the next iteration
        }
    
        // If no working seconds were counted, return 0s
        if ($totalWorkingSeconds <= 0) {
            return [
                'days' => 0,
                'hours' => 0,
                'minutes' => 0,
                'total_seconds' => 0
            ];
        }
    
        // Convert seconds to days, hours, and minutes
        $days = floor($totalWorkingSeconds / (24 * 60 * 60));
        $hours = floor(($totalWorkingSeconds % (24 * 60 * 60)) / 3600);
        $minutes = floor(($totalWorkingSeconds % 3600) / 60);
        
        return [
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes,
            'total_seconds' => $totalWorkingSeconds
        ];

    }

    private function computeSameDayWorkingSeconds($start, $end) {
        $workingSeconds = 0;

        // Define working time intervals
        $morningStart = clone $start;
        $morningStart->setTime(8, 0); // 8 AM
        $morningEnd = clone $start;
        $morningEnd->setTime(12, 0); // 12 PM
        $afternoonStart = clone $start;
        $afternoonStart->setTime(13, 0); // 1 PM
        $afternoonEnd = clone $start;
        $afternoonEnd->setTime(17, 0); // 5 PM

        // Calculate working seconds in the morning
        if ($end >= $morningStart && $start <= $morningEnd) {
            // Calculate effective start and end times
            $effectiveStart = max($start, $morningStart);
            $effectiveEnd = min($end, $morningEnd);
            
            // If the effective start is before the effective end, count the seconds
            if ($effectiveStart < $effectiveEnd) {
                $workingSeconds += $effectiveEnd->getTimestamp() - $effectiveStart->getTimestamp();
            }
        }

        // Calculate working seconds in the afternoon
        if ($end >= $afternoonStart && $start <= $afternoonEnd) {
            // Adjust effective start and end times considering lunch break
            $effectiveStart = max($start, $afternoonStart);
            $effectiveEnd = min($end, $afternoonEnd);
            
            // If the effective start is before the effective end, count the seconds
            if ($effectiveStart < $effectiveEnd) {
                $workingSeconds += $effectiveEnd->getTimestamp() - $effectiveStart->getTimestamp();
            }
        }

        // Handle case where start is in lunch break (12 PM to 1 PM)
        if ($start->format('H:i') >= '12:00' && $start->format('H:i') < '13:00') {
            // Adjust start to 1 PM
            $start->setTime(13, 0);
        }

        // Handle case where end is in lunch break
        if ($end->format('H:i') >= '12:00' && $end->format('H:i') < '13:00') {
            // Adjust end to 12 PM
            $end->setTime(12, 0);
        }

        return $workingSeconds;
    }
    
    // Function to compute working seconds for a full working day
    private function computeFullDayWorkingSeconds($date) {
        $workingSeconds = 0;

        // Define full working day intervals
        $morningStart = clone $date;
        $morningStart->setTime(8, 0); // 8 AM
        $morningEnd = clone $date;
        $morningEnd->setTime(12, 0); // 12 PM
        $afternoonStart = clone $date;
        $afternoonStart->setTime(13, 0); // 1 PM
        $afternoonEnd = clone $date;
        $afternoonEnd->setTime(17, 0); // 5 PM

        // Working morning period
        $workingSeconds += ($morningEnd->getTimestamp() - $morningStart->getTimestamp());
        // Working afternoon period
        $workingSeconds += ($afternoonEnd->getTimestamp() - $afternoonStart->getTimestamp());

        return $workingSeconds;
    }

}

?>