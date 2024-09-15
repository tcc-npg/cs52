<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Admin | Settings<?= $this->endSection('pageTitle'); ?>
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Site Administration /</span> Settings</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <?= form_open(url_to('settings.save')); ?>
                            <?= form_hidden('form', 'academic'); ?>
                            <div class="card mb-4">
                                <h5 class="card-header">Academic</h5>
                                <div class="card-body">
                                    <div>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="is_enrollment_active"
                                                   name="is_enrollment_active" <?= $groups['academic']['is_enrollment_active']->value == 1 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="is_enrollment_active">Is enrollment
                                                active</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="current_semester" class="form-label">Current
                                                    Semester</label>
                                                <select class="form-select" id="current_semester"
                                                        name="current_semester">
                                                    <option selected disabled>Select Current Semester</option>
                                                    <option value="1" <?= $groups['academic']['current_semester']->value == 1 ? 'selected' : ''; ?>>
                                                        First
                                                    </option>
                                                    <option value="2" <?= $groups['academic']['current_semester']->value == 2 ? 'selected' : ''; ?>
                                                    ">Second</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-1">
                                                <label for="current_curriculum" class="form-label">Current
                                                    Curriculum</label>
                                                <select class="form-select" id="current_curriculum"
                                                        name="current_curriculum">
                                                    <option disabled selected>Select Current Curriculum</option>
                                                    <?php foreach ($curricula as $curriculum): ?>
                                                        <option
                                                                value="<?= $curriculum->id; ?>"
                                                            <?= $groups['academic']['current_curriculum']->value == $curriculum->id ? 'selected' : '';; ?>
                                                        >
                                                            <?= $curriculum->description; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <small><a href="javascript:void(0);">Create new curriculum</a></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-end">
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <?= form_open(url_to('settings.save')); ?>
                            <?= form_hidden('form', 'accounts'); ?>
                            <div class="card mb-4">
                                <h5 class="card-header">Accounts</h5>
                                <div class="card-body">
                                    <div>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" name="registration_enabled"
                                                   id="registration_enabled" <?= $groups['accounts']['registration_enabled']->value == 1 ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="registration_enabled">Enable
                                                account registration?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-end">
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>
