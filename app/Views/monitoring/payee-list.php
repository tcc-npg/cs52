<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Dashboard<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">

                    <small class="text-muted float-end"><?= $name; ?></small>
                    <button type="button" class="btn" aria-label="More options" data-bs-toggle="modal"
                        data-bs-target="#deleteModal">
                        <i class="bx bx-trash" aria-hidden="true"></i>
                    </button>

                    <!-- conifirmation modal for deleting the module -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" id="deleteForm" method="POST"
                                action="<?php echo url_to('monitoring.deleteOtherPayable'); ?>">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this module?
                                </div>
                                <div class="modal-footer">
                                    <!-- No Button: Closes the Modal -->
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>


                                    <input type="hidden" name="moduleId" id="module_id" value=<?= $payable_id; ?>>
                                    <button type="submit" class="btn btn-danger" name="">Yes, Delete</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Year Level</th>
                                <th class="text-center">Payment</th>
                                <th class="text-center">Balance</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php foreach ($list as $student): ?>
                                <tr>
                                    <td><strong><?= $student['first_name'] . ' ' . $student['last_name']; ?></strong></td>
                                    <td class="text-center"><?= strtoupper($student['year_level']); ?></td>
                                    <td class="text-center"><?= $student['payment']; ?></td>
                                    <td class="text-center">
                                        <?php
                                        $balance = $amount - $student['payment'];
                                        echo $balance
                                            ?>

                                    </td>
                                    <td class="text-center">
                                        <?php $status = $student['status'];

                                        if ($status === null) {
                                            echo 'no payment';
                                        } else {
                                            if ($status === 'p') {
                                                echo 'PAID';
                                            } else if ($status === 'c') {
                                                echo 'CLAIMED | INCOMPLETE';
                                            } else {
                                                echo 'no payment';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#editFormModal"
                                            data-id="">
                                            <i class='bx bx-edit'></i></button>
                                        <!-- MODAL FORM FOR UDATTING STUDENT STATUS -->
                                        <div class="modal fade" id="editFormModal" tabindex="-1"
                                            aria-labelledby="moduleFormModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form class="modal-content" method="POST"
                                                    action="<?= url_to('monitoring.updatePayeeInfo', $student['user_id']); ?>">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="moduleFormModalLabel">Edit Student Info
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label for="status" class="form-label"
                                                                name="payment">Payment</label>
                                                            <input type="number" class="form-control" id="payment"
                                                                name="payment" placeholder="Enter payment amount" min="0">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option value="" disabled selected>Update Status</option>
                                                                <option value="p">Paid</option>
                                                                <option value="c">Claimed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            value="Submit">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                        <button type="button" class="btn" aria-label="More options" data-bs-toggle="modal"
                                            data-bs-target="#deleteStudent"><i class='bx bx-trash'></i></button>

                                        <div class="modal fade" id="deleteStudent" tabindex="-1"
                                            aria-labelledby="deleteStudentLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form class="modal-content" id="deleteForm" method="POST"
                                                    action="<?php echo url_to('monitoring.deleteStudentInModuleList', $student['user_id']); ?>">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteStudentLabel">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this module?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <!-- No Button: Closes the Modal -->
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">No</button>


                                                        <input type="hidden" name="moduleId" id="module_id" value=''>
                                                        <button type="submit" class="btn btn-danger" name="">Yes,
                                                            Delete</button>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
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