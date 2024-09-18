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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Curricula /</span> New Curriculum</h4>
        <form class="card" method="post" action="<?= url_to('curriculum.save'); ?>">
            <div class="card-header">
                <h5>Create New Curriculum</h5>
            </div>
            <div class="card-body">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Description">
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
<?= $this->endSection('content'); ?>