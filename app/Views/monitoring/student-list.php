<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- <?php echo $name; ?><?= $this->endSection('pageTitle'); ?>
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
        <?php if (auth()->user()->inGroup('admin')) {
            echo $this->include('monitoring/search-bar');
        } ?>
        
        <div class="col-xxl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <!-- Back Button and Module Name Row -->
                    <div class="d-flex align-items-center">
                        <a href="<?php echo url_to('monitoring.modules') ?>" class="btn p-0 d-flex align-items-center"
                            aria-label="Back">
                            <i class="bx bx-arrow-back me-2" aria-hidden="true"></i>
                            <small class="text-muted"><?php echo $name; ?></small>
                        </a>
                    </div>

                    <!-- Delete Button (Admin Only) -->
                    <?php if (auth()->user()->inGroup('admin')): ?>
                        <button type="button" class="btn" aria-label="More options" data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                            <i class="bx bx-trash" aria-hidden="true"></i>
                        </button>
                    <?php endif; ?>

                    <!-- Modal for Deleting the Module -->
                    <?php if (auth()->user()->inGroup('admin')): ?>
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form class="modal-content" id="deleteForm" method="POST"
                                    action="<?php echo url_to('monitoring.deleteModule'); ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this module?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        <input type="hidden" name="moduleId" id="module_id" value="<?= $module_id; ?>">
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>



                <!-- Table for Module List -->
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
                            <?php foreach ($module_list as $module): ?>

                                <?php
                                $student = $module['students'];
                                $payments = $module['payments'];
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
                                    <td class="text-center"><?= $student['first_name'] . ' ' . $student['last_name']; ?>
                                    </td>
                                    <td class="text-center"><?= strtoupper($student['year_level']); ?></td>
                                    <td class="text-center">
                                        <?= !empty($paymentDetails) ? implode('<br>', $paymentDetails) : 'No Payment'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= !empty($paymentDates) ? implode('<br>', $paymentDates) : 'No Payment'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $student['balance'] > 0 ? number_format($student['balance'], 2) : 'No Balance'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo getPaymentStatus($student['status']); ?>
                                    </td>

                                    <?php if (auth()->user()->inGroup('admin')): ?>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button"
                                                    class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow btn-sm"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <!-- Edit Student -->
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editFormModal<?= $student['user_id']; ?>">
                                                            Edit Student Info
                                                        </a>
                                                    </li>
                                                    <!-- Delete Student -->
                                                    <l <a class="dropdown-item" href="javascript:void(0);"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteStudent<?= $student['user_id']; ?>">
                                                        Delete
                                                        </a>
                                                        </li>
                                                </ul>
                                            </div>

                                            <!-- Modal for Editing Student Status -->
                                            <div class="modal fade" id="editFormModal<?= $student['user_id']; ?>" tabindex="-1"
                                                aria-labelledby="moduleFormModalLabel<?= $student['user_id']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form class="modal-content" method="POST"
                                                        action="<?= url_to('monitoring.updateStudentModuleStatus', $student['user_id'], $module_id); ?>">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="moduleFormModalLabel<?= $student['user_id']; ?>">Edit
                                                                Student Info</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">

                                                            <!-- Hidden input to hold the name value -->
                                                            <input type="hidden" name="moduleName" value="<?= $name; ?>">

                                                            <div class="mb-3">
                                                                <label for="payment" class="form-label">Update Payment</label>
                                                                <input type="number" class="form-control" id="payment"
                                                                    name="payment" placeholder="Enter payment amount" min="0"
                                                                    max="<?= $student['balance'] ?>">

                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-control" id="status" name="status">
                                                                    <option value="" disabled selected>Update Status</option>
                                                                    <option value="p">Paid</option>
                                                                    <option value="c">Claimed | Incomplete</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Modal for Deleting Student -->
                                            <div class="modal fade" id="deleteStudent<?= $student['user_id']; ?>" tabindex="-1"
                                                aria-labelledby="deleteStudentLabel<?= $student['user_id']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form class="modal-content" id="deleteForm" method="POST"
                                                        action="<?= url_to('monitoring.deleteStudentInModuleList', $student['user_id']); ?>">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteStudentLabel">Confirm Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this student from the module?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">No</button>
                                                            <input type="hidden" name="moduleId" id="module_id" value="">
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
                <form class="modal-content" method="POST" action="<?= url_to('monitoring.addStudentInModuleList'); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="moduleFormModalLabel">Add Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="id" name="moduleId" value="<?= $module_id ?>">
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