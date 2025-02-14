<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<style>
    table th.thead-sm {
        font-size: 11px !important;
    }
    .green-border {
        border: 2px solid #35a442;
        
    }
</style>
<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1><?= $title ?></h1></h1>
            </div>
        </div>
    </div>
</div>

<div class="block overflow-hidden">
    <div class="block-title text-right d-flex justify-content-between align-items-center">
        <div class="block-options pull-left">
            <h2><?= $sub_title ?></h2>
        </div>
        <div class="block-options">
            <a href="javascript:void(0)" id="cancelSearch" class="btn btn-effect-ripple btn-warning" data-toggle="modal" style="display: none"><i class="fa fa-search-minus"></i> Clear search</a>
            <a href="#searchModal" class="btn btn-effect-ripple btn-info" data-toggle="modal"><i class="fa fa-search"></i> Search</a>
            <a href="<?= base_url('patient/add') ?>" class="btn btn-effect-ripple btn-primary"><i class="fa fa-plus-square"></i> Add Patient</a>
        </div>
        
    </div>
    <div class="table-responsive block-content-full">
    <b class="text-primary">Note: <em>This table is generated using Datatable with "serverSide" processing <code>TRUE</code>. This table will load patient data by page and search filter.</em></b>
        <table id="pat_Datatable" class="table table-striped table-condensed table-vcenter table-bordered table-sm remove-margin">
            <thead>
                <tr>
                    <th class="text-center thead-sm" style="width: 15%;">ID</th>
                    <th class="text-center thead-sm" style="width: 20%;">Name</th>
                    <th class="text-center thead-sm" style="width: 8%;">Sex</th>
                    <th class="text-center thead-sm" style="width: 15%;">Birthdate</th>
                    <th class="text-center thead-sm" style="width: 20%;">Adress</th>
                    <th class="text-center thead-sm" style="width: 12%;">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="block overflow-hidden">
    <div class="block-title text-right d-flex justify-content-between align-items-center">
        <div class="block-options pull-left">
            <h2><?= $sub_title ?></h2>
        </div>
        <div class="block-options">
            <a href="<?= base_url('patient/add') ?>" class="btn btn-effect-ripple btn-primary"><i class="fa fa-plus-square"></i> Add Patient</a>
        </div>
        
    </div>
    <div class="table-responsive block-content-full">
    <b class="text-primary">Note: <em>This table is generated using Datatable with "serverSide" processing <code>FALSE</code>. This table will load all patient data at once.</em></b>
        <table id="pat_Datatable_2" class="table table-striped table-condensed table-vcenter table-bordered table-sm remove-margin">
            <thead>
                <tr>
                    <th class="text-center thead-sm" style="width: 15%;">ID</th>
                    <th class="text-center thead-sm" style="width: 20%;">Name</th>
                    <th class="text-center thead-sm" style="width: 8%;">Sex</th>
                    <th class="text-center thead-sm" style="width: 15%;">Birthdate</th>
                    <th class="text-center thead-sm" style="width: 20%;">Adress</th>
                    <th class="text-center thead-sm" style="width: 12%;">Action</th>
                </tr>
            </thead>
        </table>
    </div>

    
</div>

<div id="searchModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><strong>Search Patient</strong></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-horizontal" onsubmit="return false;">
                            <div class="form-group form-group-float">
                                <input type="text" class="form-control form-control-float" id="patient_id_filter" placeholder=" ">
                                <label for="patient_id_filter" class="floating-label">Patient ID</label>
                            </div>
                            <div class="form-group form-group-float">
                                <input type="text" class="form-control form-control-float" id="patient_lname_filter" placeholder=" ">
                                <label for="patient_lname_filter" class="floating-label">Lastname</label>
                            </div>
                            <div class="form-group form-group-float">
                                <input type="text" class="form-control form-control-float" id="patient_fname_filter" placeholder=" ">
                                <label for="patient_fname_filter" class="floating-label">Firstname</label>
                            </div>
                            <div class="form-group form-group-float">
                                <input type="text" class="form-control form-control-float" id="patient_mname_filter" placeholder=" ">
                                <label for="patient_mname_filter" class="floating-label">Middlename</label>
                            </div>
                            <div class="form-group form-group-float">
                                <input type="date" class="form-control form-control-float" id="patient_bdate_filter" placeholder=" ">
                                <label for="patient_bdate_filter" class="floating-label">Birthdate</label>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-effect-ripple btn-primary" id="filterBtn"><i class="fa fa-search"></i> Search</button>
                <button type="button" class="btn btn-effect-ripple btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="viewPatientModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><strong>Patient Details</strong></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="widget">
                            <div class="widget-content themed-background-green text-left clearfix">
                                <a href="javascript:void(0)" class="pull-right">
                                    <img src="<?= base_url('public/assets/img/placeholders/avatars/avatar7@2x.jpg')?>" alt="avatar" class="img-circle img-thumbnail img-thumbnail-avatar">
                                </a>
                                <h3 class="widget-heading text-light"><b id="pat_name"></b></h3>
                                <h4 class="widget-heading text-light-op"  id="pat_code"></h4>
                            </div>
                            <div class="widget-content block">
                                <div class="block-content-full">
                

                                    <table class="table table-condensed table-sm" style="table-layout: fixed">
                                        <tr class="success">
                                            <td class="" style="padding-left:15px; width: 100%" colspan="12">
                                            <strong style="font-size: 15px"><u><i class="fa fa-user"></i> Personnal Information</u></strong></div>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 24.99%" colspan="3">
                                                <strong>Sex</strong></div> <br>
                                                <div id="pat_sex"></div>
                                            </td>
                                            <td style="padding-left:15px; width: 33.36%" colspan="4">
                                                <strong>Birthdate</strong> <br>
                                                <span id="pat_bdate"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 41.65%" colspan="5">
                                                <strong>Age</strong> <br>
                                                <span id="pat_age"></span>
                                            </td>
                                        </tr>
                                        
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 25%" colspan="3">
                                                <strong>CivilStatus</strong></div> <br>
                                                <div id="pat_cs"></div>
                                            </td>
                                            <td style="padding-left:15px; width: 25%" colspan="3">
                                                <strong>Blood Type</strong> <br>
                                                <span id="pat_blood"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 25%" colspan="3">
                                                <strong>Nationality</strong> <br>
                                                <span id="pat_nationality"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 25%" colspan="3">
                                                <strong>Religion</strong> <br>
                                                <span id="pat_religion"></span>
                                            </td>
                                        </tr>

                                        <tr class="success">
                                            <td style="padding-left:15px; width: 100%" colspan="12">
                                            <strong style="font-size: 15px"><u><i class="fa fa-newspaper-o"></i> Contact Information</u></strong></div>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 33.33%" colspan="4">
                                                <strong>Mobile Number</strong></div> <br>
                                                <span id="pat_mobile"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 33.34%" colspan="4">
                                                <strong>Telephone Number</strong> <br>
                                                <span id="pat_tel"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 33.33%" colspan="4">
                                                <strong>Email Address</strong> <br>
                                                <span id="pat_email"></span>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 33.33%" colspan="4">
                                                <strong>Contact Name</strong></div> <br>
                                                <span id="pat_ref_name"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 33.34%" colspan="4">
                                                <strong>Contact Address</strong> <br>
                                                <span id="pat_ref_address"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 33.33%" colspan="4">
                                                <strong>Contact Number</strong> <br>
                                                <span id="pat_ref_number"></span>
                                            </td>
                                        </tr>

                                        <tr class="success">
                                            <td style="padding-left:15px; width: 100%" colspan="12">
                                            <strong style="font-size: 15px"><u><i class="gi gi-google_maps"></i> Demographic</u></strong></div>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 100%" colspan="12">
                                            <strong><u>CURRENT ADDRESS</u></strong></div>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 100%" colspan="12">
                                                <strong>Street/House No./Building No./Purok</strong></div> <br>
                                                <span id="pat_cur_street"></span>
                                            </td>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 41.65%" colspan="5">
                                                <strong>City/Municipality</strong></div> <br>
                                                <span id="pat_cur_city"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 41.65%" colspan="5">
                                                <strong>Barangay</strong> <br>
                                                <span id="pat_cur_brgy"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 16.7%" colspan="2">
                                                <strong>Zip Code</strong> <br>
                                                <span id="pat_cur_zip"></span>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 50%" colspan="6">
                                                <strong>District</strong></div> <br>
                                                <span id="pat_cur_district"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 50%" colspan="6">
                                                <strong>Province</strong> <br>
                                                <span id="pat_cur_province"></span>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 100%" colspan="12">
                                            <strong><u>PRESENT ADDRESS</u></strong></div>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 100%" colspan="12">
                                                <strong>Street/House No./Building No./Purok</strong></div> <br>
                                                <span id="pat_per_street"></span>
                                            </td>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 41.65%" colspan="5">
                                                <strong>City/Municipality</strong></div> <br>
                                                <span id="pat_per_city"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 41.65%" colspan="5">
                                                <strong>Barangay</strong> <br>
                                                <span id="pat_per_brgy"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 16.7%" colspan="2">
                                                <strong>Zip Code</strong> <br>
                                                <span id="pat_per_zip"></span>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <td style="padding-left:15px; width: 50%" colspan="6">
                                                <strong>District</strong></div> <br>
                                                <span id="pat_per_district"></span>
                                            </td>
                                            <td style="padding-left:15px; width: 50%" colspan="6">
                                                <strong>Province</strong> <br>
                                                <span id="pat_per_province"></span>
                                            </td>
                                        </tr>

                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-effect-ripple btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>

<?= $this->section("script"); ?>
<script src="<?= base_url(); ?>public/assets/js/datatable/dt.patient.js"></script>
<script src="<?= base_url(); ?>public/assets/js/patient.query.js"></script>

<script>
    $(document).ready(function() {
        dtPatient.init();
        patientApp.init();
    });
</script>
<?= $this->endSection(); ?>