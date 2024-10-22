<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Analytic<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- First Table: Module Statistics -->
    <div class="row mb-4"> <!-- Added mb-4 for spacing -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Module Statistics</h5> <!-- More specific title -->
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Module Name</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Total Students</th>
                                <th class="text-center">Claimed</th>
                                <th class="text-center">Paid</th>
                                <th class="text-center">Incomplete</th>
                                <th class="text-center">No Record</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modules as $module): ?>
                                <tr>
                                    <td><?= $module['name'] ?></td>
                                    <td class="text-center"><?= $module['amount'] ?></td>
                                    <td class="text-center"><?= $module['module_total_students'] ?></td>
                                    <td class="text-center"><?= $module['module_claimed'] ?></td>
                                    <td class="text-center"><?= $module['module_paid'] ?></td>
                                    <td class="text-center"><?= $module['module_incomplete'] ?></td>
                                    <td class="text-center"><?= $module['module_no_record'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4"> <!-- Added mb-4 for spacing -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Other Payable Statistics</h5> <!-- More specific title -->
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Module Name</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Total Students</th>
                                <th class="text-center">Claimed</th>
                                <th class="text-center">Paid</th>
                                <th class="text-center">Incomplete</th>
                                <th class="text-center">No Record</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($other_payables as $payable): ?>
                                <tr>
                                    <td><?= $payable['payable_name'] ?></td>
                                    <td class="text-center"><?= $payable['amount'] ?></td>
                                    <td class="text-center"><?= $payable['payable_total_students'] ?></td>
                                    <td class="text-center"><?= $payable['payable_claimed'] ?></td>
                                    <td class="text-center"><?= $payable['payable_paid'] ?></td>
                                    <td class="text-center"><?= $payable['payable_incomplete'] ?></td>
                                    <td class="text-center"><?= $payable['payable_no_record'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Second Table: Additional Module Statistics (Separate Section) -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Uniform Statistics</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Extra Small</th>
                                <th class="text-center">Small</th>
                                <th class="text-center">Medium</th>
                                <th class="text-center">Large</th>
                                <th class="text-center">Extra Large</th>
                                <th class="text-center">No Record</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $categories = [
                                'Polo' => ['xSmallPolo', 'smallPolo', 'mediumPolo', 'largePolo', 'xLargePolo', 'noRecordPolo'],
                                'Blouse' => ['xSmallBlouse', 'smallBlouse', 'mediumBlouse', 'largeBlouse', 'xLargeBlouse', 'noRecordBlouse'],
                                'Pants' => ['xSmallPants', 'smallPants', 'mediumPants', 'largePants', 'xLargePants', 'noRecordPants']
                            ];

                            foreach ($categories as $categoryName => $sizes): ?>
                                <tr>
                                    <td><?= $categoryName ?></td>
                                    <?php foreach ($sizes as $size): ?>
                                        <td class="text-center"><?= $uniforms[$size] ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Summary Section -->
                <div class="row mt-3 justify-content-end"> <!-- Positioned outside the table -->
                    <div class="col-auto">
                        <p><strong>Total Students:</strong> <?= $uniforms['uniform_total_students'] ?></p>
                    </div>
                    <div class="col-auto ms-3">
                        <p><strong>Paid:</strong> <?= $uniforms['uniform_paid'] ?></p>
                    </div>
                    <div class="col-auto ms-3">
                        <p><strong>Claimed:</strong> <?= $uniforms['uniform_claimed'] ?></p>
                    </div>
                    <div class="col-auto ms-3">
                        <p><strong>No Record:</strong> <?= $uniforms['uniform_no_record'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>




</div>

<?= $this->endSection('content'); ?>