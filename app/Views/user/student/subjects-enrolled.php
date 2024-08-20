<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Dashboard<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <?php if (session('update_successful')) :
        $message = session('update_successful');
        $icon = session('toast_icon');
        $header = session('toast_header');
        $type = session('toast_color');
        echo showToast($message, $type, $header, $icon);
        ?>

        <?= $this->section('nonceScript'); ?>
        <script>
            const toastPlacement = new bootstrap.Toast(document.querySelector('#update_successful_toast'));
            toastPlacement.show();
        </script>
        <?= $this->endSection('nonceScript'); ?>
    <?php endif; ?>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account /</span> My Subjects Enrolled</h4>
    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <h5 class="card-header">Subject List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th class="text-center">Units</th>
                            <th class="text-center">Room #</th>
                            <th>Professor</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <td><strong><?= $subject->code; ?></strong></td>
                                <td><?= $subject->name; ?></td>
                                <td class="text-center"><?= $subject->units; ?></td>
                                <td class="text-center">?</td>
                                <td>?</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>
