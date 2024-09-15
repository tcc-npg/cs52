<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Admin | Settings<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Settings</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <?= form_open(url_to('settings.save')); ?>
                            <?= form_hidden('section', 'academic'); ?>
                            <div class="card mb-4">
                                <h5 class="card-header">Academic</h5>
                                <div class="card-body">
                                    <div>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="enrollment_flag">
                                            <label class="form-check-label" for="enrollment_flag">Is enrollment
                                                active</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="current_semester" class="form-label">Current
                                                    Semester</label>
                                                <select class="form-select" id="current_semester">
                                                    <option selected="">Select Current Semester</option>
                                                    <option value="1">First</option>
                                                    <option value="2">Second</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-1">
                                                <label for="current_semester" class="form-label">Current
                                                    Curriculum</label>
                                                <select class="form-select" id="current_semester">
                                                    <option selected="">Select Current Curriculum</option>
                                                    <option value="1">First</option>
                                                    <option value="2">Second</option>
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
                            <?= form_hidden('section', 'accounts'); ?>
                            <div class="card mb-4">
                                <h5 class="card-header">Accounts</h5>
                                <div class="card-body">
                                    <div>
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="registration_flag">
                                            <label class="form-check-label" for="registration_flag">Enable
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
