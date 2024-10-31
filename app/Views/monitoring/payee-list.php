<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Dashboard<?= $this->endSection('pageTitle'); ?>
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
    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">

                    <small class="text-muted float-end"><?= $name; ?></small>
                    <?php if (auth()->user()->inGroup('admin')): ?>
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
                        <?php endif; ?>
                    </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Year Level</th>
                                <th class="text-center">Payments</th>
                                <th class="text-center">Payment Dates</th>
                                <th class="text-center">Balance</th>
                                <th class="text-center">Status</th>
                                <?php if (auth()->user()->inGroup('admin')): ?>
                                    <th class="text-center">Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php foreach ($list as $payee): ?>
                                <?php
                                $student = $payee['payee'];
                                $payments = $payee['payments'];
                                $totalPayment = 0; // Initialize total payment
                                $paymentDetails = []; // Array to hold individual payment details
                                $paymentDates = []; // Array to hold payment dates
                            
                                // Calculate total payment for the student and prepare details for display
                                if (!empty($payments)) {
                                    foreach ($payments as $payment) {
                                        $totalPayment += $payment['amount']; // Sum up all payments
                                        $paymentDetails[] = 'Amount: ' . number_format($payment['amount'], 2); // Format individual payment
                                        $paymentDates[] = date('M d, Y', strtotime($payment['payment_date'])); // Format payment date
                                    }
                                }
                                ?>

                                <tr>
                                <td class><?= $student['student_number']; ?></td>
                                <td class="text-center"><?= $student['first_name'] . ' ' . $student['last_name']; ?></td>
                                    <td class="text-center"><?= strtoupper($student['year_level']); ?></td>
                                    <td class="text-center">
                                        <?= !empty($paymentDetails) ? implode('<br>', $paymentDetails) : 'No Payment'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= !empty($paymentDates) ? implode('<br>', $paymentDates) : 'No Payment'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php $balance = $amount - $totalPayment; ?>
                                        <?= $balance > 0 ? number_format($balance, 2) : 'No Balance'; ?>
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
                                    <?php if (auth()->user()->inGroup('admin')): ?>
                                        <td class="text-center">
                                            <button class="btn btn-edit" data-bs-toggle="modal"
                                                data-bs-target="#editFormModal<?= $student['user_id']; ?>">
                                                <i class='bx bx-edit'></i>
                                            </button>

                                            <!-- MODAL FORM FOR UPDATING STUDENT STATUS -->
                                            <div class="modal fade" id="editFormModal<?= $student['user_id']; ?>" tabindex="-1"
                                                aria-labelledby="moduleFormModalLabel<?= $student['user_id']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form class="modal-content" method="POST"
                                                        action="<?= url_to('monitoring.updatePayeeInfo', $student['user_id'], $payable_id); ?>">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="moduleFormModalLabel<?= $student['user_id']; ?>">Edit
                                                                Student Info</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <div class="mb-3">
                                                                <label for="payment" class="form-label">Payment</label>
                                                                <input type="number" class="form-control" id="payment"
                                                                    name="payment" placeholder="Enter payment amount" min="0"
                                                                    max="<?= $balance ?>">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-control" id="status" name="status">
                                                                    <option value="" disabled selected>Update Status</option>
                                                                    <option value="p">Paid</option>
                                                                    <option value="c">Claimed</option>
                                                                </select>
                                                                <input type="hidden" name="user_id"
                                                                    value="<?= $student['user_id']; ?>">
                                                                <!-- Hidden input for user_id -->
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
                                                        action="<?php echo url_to('monitoring.deleteStudentInPayableList', $student['user_id']); ?>">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteStudentLabel">Confirm Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to remove student from list?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">No</button>
                                                            <input type="hidden" name="moduleId" id="module_id" value=''>
                                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php if (auth()->user()->inGroup('admin')): ?>
        <!-- Add Student Button -->
        <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#moduleFormModal">
            Add student
        </button>

        <!-- Modal for Adding Student -->
        <div class="modal fade" id="moduleFormModal" tabindex="-1" aria-labelledby="moduleFormModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="<?= url_to('monitoring.addStudentInPayableList'); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="moduleFormModalLabel">Add Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id" name="payableId" value="<?= $payable_id ?>">
                        <div class="mb-3">
                            <label for="studentId" class="form-label">Student ID</label>
                            <input type="text" class="form-control" id="moduleName" placeholder="Enter student ID"
                                name="studentId">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?> 
</div>
<?= $this->endSection('content'); ?>