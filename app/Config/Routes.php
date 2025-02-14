<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$myroutes = [];

$myroutes['/'] = 'Login::index';
$myroutes['thisLogin'] = 'Login::loginQuery';
$myroutes['logout'] = 'Login::logout';

$myroutes['patient/view'] = 'Patient::index';
$myroutes['patient/add'] = 'Patient::index_add';
$myroutes['get/patient/lib/municipality'] = 'Patient::getMunicipalityDetail';
$myroutes['get/patient/lib/barangay'] = 'Patient::getBarangay';
$myroutes['get/patient/lib/district'] = 'Patient::checkIfDistrict';
$myroutes['form/patient/register'] = 'Patient::registerPatient';
$myroutes['get/table/patient'] = 'Patient::patientView';
$myroutes['get/table/patient2'] = 'Patient::patientView2';
$myroutes['get/view/data/patient'] = 'Patient::getPatientData';
$myroutes['form/patient/delete'] = 'Patient::deletePatient';

$myroutes['patient/edit/(:segment)'] = 'PatientEdit::index/$1';
$myroutes['form/patient/update'] = 'PatientEdit::updatePatient';


$routes->map($myroutes);


$routes->set404Override(function()
{

    echo view('errors/error404',['error_code' => '404','error_desc' => 'Page Not Found', 'message' => 'We sorry but this page can\'t be found..']);

});
