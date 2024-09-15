<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Inventory System | Dashboard<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php if (session('update_successful')): ?>

            <?= showToast(); ?>

            <?= $this->section('nonceScript'); ?>
            <script>
                const toastPlacement = new bootstrap.Toast(document.querySelector('#update_successful_toast'));
                toastPlacement.show();
            </script>
            <?= $this->endSection('nonceScript'); ?>

        <?php endif; ?>
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Curricula / Subjects /</span> Update Subject
        </h4>
        <form class="card" method="post" action="">
            <div class="card-header">
                <h5>Update Subject</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <small class="text-muted">You are editing <?= $subject->name; ?></small>
                    </div>
                    <div class="col-md-6">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Code" value="<?= $subject->code; ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= $subject->name; ?>">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
<?= $this->endSection('content'); ?>