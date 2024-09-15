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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Curricula /</span> Subjects List</h4>
        <div class="card">
            <h5 class="card-header">Subjects List</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th class="text-center">Code</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <?php foreach ($subjects_list as $subject): ?>
                            <tr>
                                <td><strong><?= $subject->code; ?></strong></td>
                                <td><?= $subject->name; ?></td>
                                <td class="text-center"><?= $subject->units; ?></td>
                                <td><a href="<?php echo url_to('subjects.updatePage', $subject->id); ?>" class="btn btn-primary btn-xs">Update</a></td>
                                <td>
                                    <form action="<?php echo url_to('subjects.delete', $subject->id); ?>" method="post">
                                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection('content'); ?>