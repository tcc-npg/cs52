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
<link rel="stylesheet" href="<?= base_url('/assets/vendor/css/pages/page-auth.css'); ?>"/>

<body>
<?= $this->renderSection('content'); ?>
<?= $this->include('partials/scripts'); ?>
</body>
</html>
