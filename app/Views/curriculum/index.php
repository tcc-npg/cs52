<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Inventory System | Dashboard<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Curricula /</span> List</h4>
        <div class="card">
            <h5 class="card-header">Curriculum List</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <caption class="ms-4">
                            Count: <?php echo count($curricula); ?>
                        </caption>
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date Created</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($curricula as $curriculum): ?>
                            <tr>
                                <td><?php echo $curriculum->description; ?></td>
                                <td><?php echo $curriculum->date_created; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?php echo url_to('curriculum.new'); ?>" class="btn btn-primary">Create New</a>
            </div>
        </div>
    </div>
<?= $this->endSection('content'); ?>