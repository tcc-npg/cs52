<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Dashboard<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    
    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                   
                    <small class="text-muted float-end"><?= count($module_list); ?> students</small>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Student Number</th>
                            <th class="text-center">Year Level</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <?php foreach ($module_list as $student): ?>
                            <tr>
                                <td><strong><?= $student['first_name'] . ' ' . $student['last_name']; ?></strong></td>
                                <td class="text-center"><?= $student['student_number']; ?></td>
                               
                                <td class="text-center"><?= strtoupper($student['year_level']); ?></td>
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