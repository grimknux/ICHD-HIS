<?= $this->extend("layouts/login"); ?>

<?= $this->section("content"); ?>
<style>

</style>

<div id="overlay">
    <div class="loader"></div>
</div>
<div id="login-container">
    <!-- Login Header -->
    <h1 class="h2 text-light text-center push-top-bottom animation-pullDown">
        <i class="fa fa-cube text-light-op"></i> <strong>ICHDHIS</strong>
    </h1>
    <!-- END Login Header -->

    <!-- Login Block -->
    <div class="block animation-fadeInQuick">
        <!-- Login Title -->
        <div class="block-title">
            <h2>Please Login</h2>
        </div>
        <!-- END Login Title -->

        <!-- Login Form -->
        <form id="form_login" method="POST" class="form-horizontal">
            <?= csrf_field() ?>
            <div class="error-box" style="display:none;">
                <h5><b class="error-message">test</b></h5>
            </div>
            <div class="form-group username">
                <label for="username" class="col-xs-12">Email</label>
                <div class="col-xs-12">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Your email..">
                    <div class="help-block usernameMessage"></div>
                </div>
            </div>
            <div class="form-group password">
                <label for="password" class="col-xs-12">Password</label>
                <div class="col-xs-12">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Your password..">
                    <div class="help-block passwordMessage"></div>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-xs-12 text-right">
                    <button type="submit" class="btn btn-effect-ripple btn-sm btn-success">Log In</button>
                </div>
            </div>
        </form>
        <!-- END Login Form -->
    </div>
    <!-- END Login Block -->

    <!-- Footer -->
    <footer class="text-muted text-center animation-pullUp">
        <small><span id="year-copy"></span> &copy; <a href="<?= base_url() ?>" target="_blank">ICHDHIS v.1</a></small>
    </footer>
    <!-- END Footer -->
</div>




<?= $this->endSection(); ?>

<?= $this->section("script"); ?>

<script src="<?= base_url(); ?>public/assets/js/login.query.js"></script>

<script>
</script>

<?= $this->endSection(); ?>