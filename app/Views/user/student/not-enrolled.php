<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Dashboard<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account /</span> My Subjects Enrolled</h4>
    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <h5 class="card-header">Subject List</h5>
                <div class="card-body">
                    You are currently not enrolled in any subjects.
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>
