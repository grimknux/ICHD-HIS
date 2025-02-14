
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>AppUI - Web App Bootstrap Admin Template</title>

        <meta name="description" content="AppUI is a Web App Bootstrap Admin Template created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

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

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/css/appui/themes.css">
        <link rel="stylesheet" href="<?= base_url(); ?>public/assets/css/appui/themes/green.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="<?= base_url(); ?>public/assets/js/appui/vendor/modernizr-3.3.1.min.js"></script>
    </head>
    <body>
        <!-- Full Background -->
        <!-- For best results use an image with a resolution of 1280x1280 pixels (prefer a blurred image for smaller file size) -->
        <img src="<?= base_url(); ?>public/assets/img/placeholders/layout/error_full_bg.jpg" alt="Full Background" class="full-bg full-bg-bottom animation-pulseSlow">
        <!-- END Full Background -->

        <!-- Error Container -->
        <div id="error-container">
            <div class="row text-center">
                <div class="col-md-6 col-md-offset-3">
                    <h2 class="text-light animation-fadeInQuick"><strong>ERROR <?= $error_code ?>: <?= $error_desc ?></strong></h2>
                    <h2 class="text-muted animation-fadeInQuickInv"><em><?= $message ?></em></h2>
                </div>
                <div class="col-md-4 col-md-offset-4">
                    <a href="<?= base_url() ?>" class="btn btn-effect-ripple btn-default"><i class="fa fa-home"></i> Go back Home</a>
                </div>
            </div>
        </div>
        <!-- END Error Container -->
    </body>
</html>