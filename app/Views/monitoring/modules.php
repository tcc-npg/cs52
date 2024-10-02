<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Modules<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<style>
    .hover-opacity {
        transition: opacity 0.05s ease;
    }

    .hover-opacity:hover {
        opacity: 0.5;
    }
</style>
</style>

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



    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#moduleFormModal">
        Add module
    </button>


    <div class="modal fade" id="moduleFormModal" tabindex="-1" aria-labelledby="moduleFormModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="<?= url_to('monitoring.addModule'); ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="moduleFormModalLabel">Add New Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">

                        <label for="subjectCode" class="form-label">Subjects</label>

                        <select class="form-control" id="subjectCode" name="subjectCode">
                            <option value="" disabled selected>Please select a subject</option>
                            <?php foreach ($subject_list as $subject): ?>
                                <option><?= $subject->code ?></option>
                            <?php endforeach; ?>
                        </select>   
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container my-4   ">
        <div class="row g-4">

            <?php foreach ($list as $module): ?>

                <div class="col-md-4 p-1">
                    <a href="<?php echo url_to('monitoring.studentsList', $module['module_id'], $module['name']) ?>">
                        <div
                            class="position-relative p-3 rounded-3 d-flex flex-column justify-content-end h-75 bg-light hover-opacity border border-primary m-0">
                            <div class="text-left fw-bold pt-5">
                                <p class="fs-3 mb-0"><?php echo strtoupper($module['name']) ?></p>
                                <p class="fs-5"><?php echo $module['code'] ?></p>
                            </div>
                        </div>
                    </a>
                </div>

            <?php endforeach ?>
        </div>
    </div>




</div>
<?= $this->endSection('content'); ?>