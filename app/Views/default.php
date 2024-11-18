<!DOCTYPE html>
<html
        lang="en"
        class="light-style layout-menu-fixed"
        dir="ltr"
        data-theme="theme-default"
        data-assets-path="/assets/"
        data-template="vertical-menu-template-free"
>
<?= $this->include('partials/header'); ?>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar <?= !auth()->user()->isProfileComplete() ? 'layout-without-menu' : ''; ?>">
    <div class="layout-container">
        <!-- Menu -->
        <?= auth()->user()->isProfileComplete() ? $this->include('partials/menu') : ''; ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <?= $this->include('partials/nav-top'); ?>
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <?= $this->renderSection('content'); ?>
                <!-- / Content -->

                <!-- Footer -->
                <?= $this->include('partials/footer'); ?>
                <!-- / Footer -->
                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->    
        </div>
        <!-- / Layout page -->
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
<?= $this->include('partials/scripts'); ?>
<?= $this->renderSection('nonceScript'); ?>
</body>
</html>
