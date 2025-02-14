<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<style>
        #preview {
            max-width: 200px;
            margin-top: 20px;
        }
        .label-require::after {
            content: " *"; /* Adds an asterisk with a space before it */
            color: rgb(231, 87, 87); /* Same color as the text */
        }
        .has-error .select2-container--default .select2-selection--single {
            border: 1px solid #de815c !important; /* Red border */
        }
        .has-success .select2-container--default .select2-selection--single {
            border: 1px solid #afde5c !important; /* Red border */
        }

    </style>
<div id="overlay">
    <div class="loader"></div>
</div>
<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1><?= $title ?></h1></h1>
            </div>
        </div>
    </div>
</div>

<div class="block">
    <div class="block-title text-right d-flex justify-content-between align-items-center">
        <div class="block-options pull-left">
            <h2><?= $sub_title ?></h2>
        </div>
        <div class="block-options">
            <button type="button" class="btn btn-effect-ripple btn-primary registerBtn"><i class="fa fa-floppy-o"></i> Register Patient</button>
        </div>
        
    </div>


    <form method="post" id="registerPatientForm">
        <?= csrf_field() ?>
        <div class="">
            <h4 class="sub-header"><i class="fa fa-user"></i> PERSONNAL INFORMATION</h4>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="pat_fullname" class="control-label">Fullname</label>
                            <input type="text" id="pat_fullname" name="pat_fullname" class="form-control" placeholder="Fullname" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group pat_lname">
                            <label for="pat_lname" class="control-label label-require">Lastname</label>
                            <input type="text" id="pat_lname" name="pat_lname" class="form-control" placeholder="Lastname">
                            <div class="help-block pat_lnameMessage"></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group pat_fname">
                            <label for="pat_fname" class="control-label label-require">Firstname</label>
                            <input type="text" id="pat_fname" name="pat_fname" class="form-control" placeholder="Firstname">
                            <div class="help-block pat_fnameMessage"></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group pat_mname">
                            <label for="pat_mname" class="control-label label-require">Middlename</label>
                            <input type="text" id="pat_mname" name="pat_mname" class="form-control" placeholder="Middlename">
                            <div class="help-block pat_mnameMessage"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group pat_bdate">
                            <label for="pat_bdate" class="control-label label-require">Birthdate</label>
                            <input type="date" id="pat_bdate" name="pat_bdate" class="form-control" placeholder="mm/dd/yyyy">
                            <div class="help-block pat_bdateMessage"></div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="pat_year">Year</label>
                            <input type="text" id="pat_year" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="pat_month">Month</label>
                            <input type="text" id="pat_month" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="pat_day">Day</label>
                            <input type="text" id="pat_day" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="pat_suffix" class="control-label">Suffix</label>
                            <select class="select-select2 form-control select-sm" id="pat_suffix" name="pat_suffix">
                                <option value="">Select option</option>
                                <?php foreach($getsuffix as $suffix): ?>
                                    <option value="<?= esc($suffix['suffix_code'])?>"><?= esc($suffix['suffix'])?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="help-block pat_suffixMessage"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group pat_sex">
                            <label for="pat_sex" class="control-label label-require">Sex</label>
                            <select class="select-select2 form-control select-sm" id="pat_sex" name="pat_sex">
                                <option value="">Select option</option>
                                <?php foreach($getsex as $sex): ?>
                                    <option value="<?= esc($sex['sex_code'])?>"><?= esc($sex['sex'])?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="help-block pat_sexMessage"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group pat_civilstatus">
                            <label for="pat_civilstatus" class="control-label">Civil Status</label>
                            <select class="select-select2 form-control select-sm" id="pat_civilstatus" name="pat_civilstatus">
                                <option value="">Select option</option>
                                <?php foreach($getcivilstatus as $cs): ?>
                                    <option value="<?= esc($cs['civil_status_code'])?>"><?= esc($cs['civil_status'])?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="help-block pat_civilstatusMessage"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group pat_blood_type">
                            <label for="pat_blood_type" class="control-label">Blood Type</label>
                            <select class="select-select2 form-control select-sm" id="pat_blood_type" name="pat_blood_type">
                                <option value="">Select option</option>
                                <?php foreach($getbloodtype as $bt): ?>
                                    <option value="<?= esc($bt['blood_code'])?>"><?= esc($bt['blood_type'])?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="help-block pat_blood_typeMessage"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group pat_nationality">
                            <label for="pat_nationality" class="control-label">Nationality</label>
                            <select class="select-select2 form-control select-sm" id="pat_nationality" name="pat_nationality">
                                <option value="">Select option</option>
                                <?php foreach($getnationality as $nation): ?>
                                    <option value="<?= esc($nation['nationality_code'])?>"><?= esc($nation['nationality'])?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="help-block pat_nationalityMessage"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group pat_religion">
                            <label for="pat_religion" class="control-label">Religion</label>
                            <select class="select-select2 form-control select-sm" id="pat_religion" name="pat_religion">
                                <option value="">Select option</option>
                                <?php foreach($getreligion as $religion): ?>
                                    <option value="<?= esc($religion['religion_code'])?>"><?= esc($religion['religion'])?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="help-block pat_religionMessage"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        <h4 class="sub-header"><i class="fa fa-newspaper-o"></i> CONTACT INFORMATION</h4>
        <div class="row">
            <div class="col-sm-6">
                <div class="widget">
                    <div class="widget-content widget-content-mini themed-background text-light-op">
                        CONTACT DETAILS
                    </div>
                    <div class="widget-content themed-background-muted">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="pat_contact_mobile" class="control-label">Mobile Number</label>
                                    <input type="text" id="pat_contact_mobile" name="pat_contact_mobile" class="form-control" placeholder="Mobile Number, eg: 0999 999 9999" autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <label for="pat_contact_telephone" class="control-label">Telephone Number</label>
                                    <input type="text" id="pat_contact_telephone" name="pat_contact_telephone" class="form-control" placeholder="Telephone Number, eg: (072) 222 9999" autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <label for="pat_contact_email" class="control-label">Email Address</label>
                                    <input type="text" id="pat_contact_email" name="pat_contact_email" class="form-control" placeholder="Email Address, eg: ilocos@ilocos.doh.gov.ph" autocomplete="false">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="widget">
                    <div class="widget-content widget-content-mini themed-background text-light-op">
                        CONTACT PERSON
                    </div>
                    <div class="widget-content themed-background-muted">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="pat_contact_person_name" class="control-label">Contact Name</label>
                                    <input type="text" id="pat_contact_person_name" name="pat_contact_person_name" class="form-control" placeholder="Contact Name" autocomplete="false">
                                </div>
                                <div class="form-group">
                                    <label for="pat_contact_person_address" class="control-label">Contact Address</label>
                                    <textarea class="form-control" id="pat_contact_person_address" name="pat_contact_person_address" placeholder="Contact Address" autocomplete="false"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="pat_contact_person_mobile" class="control-label">Contact Number</label>
                                    <input type="text" id="pat_contact_person_mobile" name="pat_contact_person_mobile" class="form-control" placeholder="Contact Number" autocomplete="false">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="sub-header"><i class="gi gi-google_maps"></i> DEMOGRAPHIC</h4>

        <label class="text-warning">Current Address</label>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group pat_current_street">
                    <label for="pat_current_street" class="control-label">Street/House No./Building No./Purok</label>
                    <textarea class="form-control" name="pat_current_street" id="pat_current_street" placeholder="Street/House No./Building No./Purok"></textarea>
                    <div class="help-block pat_current_streetMessage"></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group pat_current_city">
                    <label for="pat_current_city" class="control-label label-require">City/Municipality</label>
                    <select class="select-select2 form-control select-sm" id="pat_current_city" name="pat_current_city">
                        <option value="">Select option</option>
                        <?php foreach($getmuncity as $muncity): ?>
                            <option value="<?= esc($muncity['city_code'])?>"><?= esc($muncity['city']) . ' ('.esc($muncity['province']).')'?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="help-block pat_current_cityMessage"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group pat_current_brgy">
                    <label for="pat_current_barangay" class="control-label label-require">Barangay</label>
                    <select id="pat_current_brgy" name="pat_current_brgy" class="form-control select-select2" placeholder="Barangay">
                    <option value="">Select option</option>
                    </select>
                    <div class="help-block pat_current_brgyMessage"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group pat_current_district">
                    <label for="pat_current_district" class="control-label label-current-district">District</label>
                    <select id="pat_current_district" name="pat_current_district" class="form-control select-select2" placeholder="District" disabled>
                    </select>
                    <div class="help-block pat_current_districtMessage"></div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group pat_current_zip">
                    <label for="pat_current_zip" class="control-label">Zip Code</label>
                    <input type="text" id="pat_current_zip" name="pat_current_zip" class="form-control" placeholder="Zip Code">
                    <div class="help-block pat_current_zipMessage"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group pat_current_province">
                    <label for="pat_current_province" class="control-label label-require">Province</label>
                    <select id="pat_current_province" name="pat_current_province" class="form-control select-select2" disabled>
                    <option value="">Select option</option>
                    <?php foreach($getprovince as $getprov): ?>
                        <option value="<?= esc($getprov['province_code'])?>"><?= esc($getprov['province']) ?></option>
                    <?php endforeach; ?>
                    </select>
                    <div class="help-block pat_current_provinceMessage"></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group pat_current_region">
                    <label for="pat_current_region" class="control-label label-require">Region</label>
                    <select id="pat_current_region" name="pat_current_region" class="form-control select-select2" disabled>
                    <option value="">Select option</option>
                    <?php foreach($getregion as $getreg): ?>
                        <option value="<?= esc($getreg['region_code'])?>"><?= esc($getreg['region']) ?></option>
                    <?php endforeach; ?>
                    </select>
                    <div class="help-block pat_current_regionMessage"></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group pat_current_country">
                    <label for="pat_current_country" class="control-label label-require">Country</label>
                    <select id="pat_current_country" name="pat_current_country" class="form-control select-select2" disabled>
                        <option value=""></option>
                        <option value="Philippines" selected>PHILIPPINES</option>
                    </select>
                    <div class="help-block pat_current_countryMessage"></div>
                </div>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-sm-12">
                <label class="csscheckbox csscheckbox-primary"><input type="checkbox" id="same_address" name="same_address"><span></span> <em class="text-primary">Check this if Current and Permanent address is the same.</em></label>
            </div>
        </div>
        <br>
        <div id="div_permanent_address">
            <label class="text-warning">Permanent Address</label>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group pat_permanent_street">
                        <label for="pat_permanent_street" class="control-label">Street/House No./Building No./Purok</label>
                        <textarea class="form-control" name="pat_permanent_street" id="pat_permanent_street" placeholder="Street/House No./Building No./Purok"></textarea>
                        <div class="help-block pat_permanent_streetMessage"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group pat_permanent_city">
                        <label for="pat_permanent_city" class="control-label label-require">City/Municipality</label>
                        <select class="select-select2 form-control select-sm" id="pat_permanent_city" name="pat_permanent_city">
                            <option value="">Select option</option>
                            <?php foreach($getmuncity as $muncity): ?>
                                <option value="<?= esc($muncity['city_code'])?>"><?= esc($muncity['city']) . ' ('.esc($muncity['province']).')'?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="help-block pat_permanent_cityMessage"></div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group pat_permanent_brgy">
                        <label for="pat_permanent_brgy" class="control-label label-require">Barangay</label>
                        <select id="pat_permanent_brgy" name="pat_permanent_brgy" class="form-control select-select2" placeholder="Barangay">
                        <option value="">Select option</option>
                        </select>
                        <div class="help-block pat_permanent_brgyMessage"></div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group pat_permanent_district">
                        <label for="pat_permanent_district" class="control-label label-permanent-district">District</label>
                        <select id="pat_permanent_district" name="pat_permanent_district" class="form-control select-select2" placeholder="District" disabled>
                        </select>
                        <div class="help-block pat_permanent_districtMessage"></div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group pat_permanent_zip">
                        <label for="pat_permanent_zip" class="control-label label-require">Zip Code</label>
                        <input type="text" id="pat_permanent_zip" name="pat_permanent_zip" class="form-control" placeholder="Zip Code">
                        <div class="help-block pat_permanent_zipMessage"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group pat_permanent_province">
                        <label for="pat_permanent_province" class="control-label label-require">Province</label>
                        <select id="pat_permanent_province" name="pat_permanent_province" class="form-control select-select2" disabled>
                        <option value="">Select option</option>
                        <?php foreach($getprovince as $getprov): ?>
                            <option value="<?= esc($getprov['province_code'])?>"><?= esc($getprov['province']) ?></option>
                        <?php endforeach; ?>
                        </select>
                        <div class="help-block pat_permanent_provinceMessage"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group pat_permanent_region">
                        <label for="pat_permanent_region" class="control-label label-require">Region</label>
                        <select id="pat_permanent_region" name="pat_permanent_region" class="form-control select-select2" disabled>
                        <option value="">Select option</option>
                        <?php foreach($getregion as $getreg): ?>
                            <option value="<?= esc($getreg['region_code'])?>"><?= esc($getreg['region']) ?></option>
                        <?php endforeach; ?>
                        </select>
                        <div class="help-block pat_permanent_regionMessage"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group pat_permanent_country">
                        <label for="pat_permanent_country" class="control-label label-require">Country</label>
                        <select id="pat_permanent_country" name="pat_permanent_country" class="form-control select-select2" disabled>
                            <option value=""></option>
                            <option value="Philippines" selected>PHILIPPINES</option>
                        </select>
                        <div class="help-block pat_permanent_countryMessage"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-right">
                <div class="form-group form-actions">
                        <button type="button" class="btn btn-effect-ripple btn-primary registerBtn"><i class="fa fa-floppy-o"></i> Register Patient</button>
                </div>
            </div>
        </div>
    </form>
    

</div>




<?= $this->endSection(); ?>

<?= $this->section("script"); ?>

<script src="<?= base_url(); ?>public/assets/js/patient.query.js"></script>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = "none";
        }
    }

   $(document).ready(function() {
        var today = new Date();
        var tomorrow = new Date(today);
        tomorrow.setDate(today.getDate());

        var tomorrowDate = tomorrow.toISOString().split('T')[0];

        $('#pat_bdate').attr('max', tomorrowDate); 

        $('#pat_bdate').on('change', function() {
            var dob = new Date($(this).val());
            var today = new Date();
            
            var ageYears = today.getFullYear() - dob.getFullYear();
            var ageMonths = today.getMonth() - dob.getMonth();
            var ageDays = today.getDate() - dob.getDate();
            
            // Adjust for negative month or day difference
            if (ageMonths < 0) {
                ageMonths += 12;
                ageYears--;
            }
            
            if (ageDays < 0) {
                var lastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
                ageDays += lastMonth.getDate();
                ageMonths--;
            }


            $('#pat_year').val(ageYears);
            $('#pat_month').val(ageMonths);
            $('#pat_day').val(ageDays);
        });

        $("input").keydown(function(event) {
            if (event.key === "Enter" && !$(this).is("textarea")) {
                event.preventDefault();
            }
        });


        $('.select-select2').select2();

        patientApp.init();

    });
</script>

<?= $this->endSection(); ?>