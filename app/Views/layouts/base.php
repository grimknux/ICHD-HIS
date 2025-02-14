<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Ilocos CHD - Hospital Information System</title>

        <meta name="description" content="Hospital Information System of the Ilocos Center for Health Development">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <meta name="csrf-token" content="<?= csrf_hash() ?>">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="<?= base_url(); ?>public/assets/img/favicon.png">
        <link rel="apple-touch-icon" href="<?= base_url(); ?>public/assets/img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="<?= base_url(); ?>public/assets/img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="<?= base_url(); ?>public/assets/img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="<?= base_url(); ?>public/assets/img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="<?= base_url(); ?>public/assets/img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="<?= base_url(); ?>public/assets/img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="<?= base_url(); ?>public/assets/img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="<?= base_url(); ?>public/assets/img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/css/appui/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/css/appui/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/css/appui/main.css">
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/css/appui/buttons.dataTables.min.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/css/appui/themes.css">
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/css/appui/themes/green.css">
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/css/form-floating.css">

        <style>
            #overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
                display: none; /* Hidden by default */
                z-index: 9999; /* Make sure it appears above other elements */
            }

            .loader {
                border: 4px solid #f3f3f3; /* Light grey border for the spinner */
                border-top: 4px solid #3498db; /* Blue border for the spinner */
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 2s linear infinite;
                position: absolute;
                top: 50%;
                left: 50%;
                margin-top: -25px; /* Center the spinner vertically */
                margin-left: -25px; /* Center the spinner horizontally */
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            table input {
                padding: 1px;
                border: 1px solid #cccc;
                border-radius: 5px;
            }

            tbody td { font-size: 12px; }
            
            
        </style>
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="<?= base_url(); ?>public/assets/js/appui/vendor/modernizr-3.3.1.min.js"></script>
    </head>

    <body>

        <div id="page-wrapper" class="page-loading">
            <div class="preloader">
                <div class="inner">
                    <div class="preloader-spinner themed-background hidden-lt-ie10"></div>
                    <h3 class="text-primary visible-lt-ie10"><strong>Loading..</strong></h3>
                </div>
            </div>
            <div id="page-container" class="header-fixed-top sidebar-visible-lg-full">
                <!-- SIDEBAR SECTION -->
                <div id="sidebar">
                    <div id="sidebar-brand" class="themed-background">
                        <a class="sidebar-title">
                            <img src="<?= base_url(); ?>public/assets/img/dohlogo.png" style="width: 30px; height: 30px;"> <span class="sidebar-nav-mini-hide">ICHD<strong>HIS</strong></span>
                        </a>
                    </div>

                    <div id="sidebar-scroll">
                        <div class="sidebar-content">
                            <ul class="sidebar-nav">

                                <li id="inbox" class="<?= ($navactive === 'patient') ? 'active' : '' ?>">
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="gi gi-disk_save sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Patient</span></a>
                                    <ul>
                                        <li>
                                            <a href="<?= base_url('patient/add') ?>" class="<?= ($navsubactive === 'patient_add') ? 'active' : '' ?>">Add Patient</a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url('patient/view') ?>" class="<?= ($navsubactive === 'patient_list') ? 'active' : '' ?>">Patient List</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>

                            <div class="sidebar-separator push">
                                <i class="fa fa-ellipsis-h"></i>
                            </div>
                        </div>
                    </div>

                    <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">
                        <div class="progress progress-mini push-bit">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                        <div class="text-left">
                            <small> <div id="i"></div></small><br>
                            <small> &copy; 2022-23, Version 2.0</small>
                        </div>
                    </div>
                </div>
                <!-- END SIDEBAR SECTION -->


                <div id="main-container">
                    <!-- NAVIGATION BAR SECTION -->
                    <header class="navbar navbar-inverse navbar-fixed-top">
                        <ul class="nav navbar-nav-custom">
                            <li>
                                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                                    <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                                    <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
                                </a>
                            </li>
                            <!-- END Main Sidebar Toggle Button -->

                            <!-- Header Link -->
                            <li class="hidden-xs animation-fadeInQuick">
                                <a><strong style="font-size: 15px">Department of Health - Ilocos Center For Health Development</strong></a>
                            </li>
                            <!-- END Header Link -->
                        </ul>
                        <!-- END Left Header Navigation -->

                        <!-- Right Header Navigation -->
                        <ul class="nav navbar-nav-custom pull-right">

                            <!-- User Dropdown -->
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= base_url('public/assets/img/placeholders/avatars/avatar9.jpg'); ?>" alt="avatar">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-header">
                                        Welcome! 
                                    </li>
                                    <li>
                                        <a href="<?= base_url('changepass') ?>" title="Change Password" data-placement="left">
                                            <i class="fa fa-inbox fa-fw pull-right"></i>
                                            Change Password
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('logout'); ?>" data-toggle="tooltip" data-placement="left" title='Logout'>
                                            <i class="fa fa-power-off fa-fw pull-right"></i>
                                            Log out
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </header>
                    <!-- END NAVIGATION BAR SECTION -->
                    
                    <div id="page-content">
                        
                        <!-- PAGE CONTENT HERE -->
                        <?= $this->renderSection("content"); ?>    

                        
                    </div>
                </div>
            </div>
        </div>


        

        <script src="<?= base_url(); ?>public/assets/js/appui/jquery3.1.min.js"></script>
        <script src="<?= base_url(); ?>public/assets/js/appui/app.js"></script>
        <script src="<?= base_url(); ?>public/assets/js/appui/vendor/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>public/assets/js/appui/plugins.js"></script>
        <script src="<?= base_url(); ?>public/assets/js/appui/pages/uiTables.js"></script>
        <script src="<?= base_url(); ?>public/assets/js/appui/pages/formsComponents.js"></script>
        <script src="<?= base_url(); ?>public/assets/js/appui/pages/appSocial.js"></script>
        <script src="<?= base_url(); ?>public/assets/js/appui/pages/compGallery.js"></script>
        <script src="<?= base_url(); ?>public/assets/js/appui/dataTables.buttons.min.js"></script>
        <script src="<?= base_url(); ?>public/assets/js/appui/buttons.print.min.js"></script>
        <script src="<?= base_url(); ?>public/assets/js/appui/sweetalert2.all.min.js"></script>
        <script src="<?= base_url(); ?>public/assets/js/handleValidationErrors.js"></script>
        <script>
            var base_url = "<?php echo base_url(); ?>";
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
        </script>

        <?= $this->renderSection("script"); ?>


    </body>
</html>
