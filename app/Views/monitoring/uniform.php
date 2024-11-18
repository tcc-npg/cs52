<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?> - Uniforms<?= $this->endSection('pageTitle'); ?>
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
        <div class="col-xxl  position-relative">
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Sex</th>
                                <th class="text-center">Blouse/Polo</th>
                                <th class="text-center">Pants</th>
                                <th class="text-center">Payments</th>
                                <th class="text-center">Payment Dates</th>
                                <th class="text-center">Balance</th>
                                <th class="text-center">Status</th>
                                <?php if (auth()->user()->inGroup('admin')): ?>
                                    <th class="text-center">Actions</th>
                                <?php endif; ?>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php foreach ($list as $student_details):
                                $student = $student_details['students'];
                                $payments = $student_details['payments'];

                                $uniform_id = $student['id'];

                                $sizes = [$student['shirt_size'], $student['pants_size']];
                                $shirt_size = "";
                                $pant_size = "";


                                if ($student['shirt_size'] === null && $student['pants_size'] === null) {
                                    $shirt_size = 'edit size';
                                    $pant_size = 'edit size';

                                } else {
                                    foreach ($sizes as $size) {
                                        $holder = getSize($size);

                                        if ($size === $student['shirt_size']) {
                                            $shirt_size = $holder;
                                        }
                                        if ($size === $student['pants_size']) {
                                            $pant_size = $holder;
                                        }
                                    }

                                }


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
                                    <td><?= $student['student_number']; ?></td>
                                    <td><?= $student['first_name'] . ' ' . $student['last_name']; ?></td>

                                    <td class="text-center">
                                        <?php $sex = (strtoupper($student['gender']));

                                        if ($sex === 'M') {
                                            echo 'Male';
                                        } else
                                            echo 'Female';

                                        ?>
                                    </td>


                                    <td class="text-center">
                                        <?php echo !empty($shirt_size) ? $shirt_size : 'edit size'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo !empty($pant_size) ? $pant_size : 'edit size'; ?>
                                    </td>

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
                                                    <!-- Edit Student Info -->
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editFormModal<?= $student['user_id']; ?>">
                                                                Edit Student Info
                                                        </a>
                                                    </li>
                                                    <!-- Delete Student -->
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteStudentModal<?= $uniform_id; ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Modal for Editing Student Info -->
                                            <div class="modal fade" id="editFormModal<?= $student['user_id']; ?>" tabindex="-1"
                                                aria-labelledby="moduleFormModalLabel<?= $student['user_id']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form class="modal-content" method="POST"
                                                        action="<?= url_to('monitoring.updateStudentInfo', $student['user_id'], $student['id']); ?>">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="moduleFormModalLabel<?= $student['user_id']; ?>">Edit
                                                                Student Info</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <div class="mb-3">
                                                                <!-- Hidden Inputs for student ID and user ID -->
                                                                <input type="hidden" class="form-control" id="editStudentId"
                                                                    name="id" value="<?= $student['id']; ?>">
                                                                <input type="hidden" class="form-control" id="editUserId"
                                                                    name="user_id" value="<?= $student['user_id']; ?>">

                                                                <label for="poloSize" class="form-label">Polo/Blouse
                                                                    Size</label>
                                                                <select class="form-control" id="poloSize" name="shirtSize">
                                                                    <option value="" disabled selected>
                                                                        <?= !empty($shirt_size) ? 'Selected Polo/Blouse Size: ' . $shirt_size : 'Select Polo/Blouse Size'; ?>
                                                                    </option>
                                                                    <option value="xs">Extra Small</option>
                                                                    <option value="s">Small</option>
                                                                    <option value="m">Medium</option>
                                                                    <option value="l">Large</option>
                                                                    <option value="xl">Extra-Large</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="pantSize" class="form-label">Pant Size</label>
                                                                <select class="form-control" id="pantSize" name="pantSize">
                                                                    <option value="" disabled selected>
                                                                        <?= !empty($pant_size) ? 'Selected Pants Size: ' . $pant_size : 'Select Pants Size'; ?>
                                                                    </option>
                                                                    <option value="xs">Extra Small</option>
                                                                    <option value="s">Small</option>
                                                                    <option value="m">Medium</option>
                                                                    <option value="l">Large</option>
                                                                    <option value="xl">Extra-Large</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="payment" class="form-label">Payment</label>
                                                                <input type="number" class="form-control" id="payment"
                                                                    name="payment" placeholder="Enter payment amount" min="0"
                                                                    max="<?= $student['balance']; ?>">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-control" id="status" name="status">
                                                                    <option value="" disabled selected>Update Status</option>
                                                                    <option value="p">Paid</option>
                                                                    <option value="c">Claimed/Incomplete</option>
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
                                            <div class="modal fade" id="deleteStudentModal<?= $uniform_id; ?>" tabindex="-1"
                                                aria-labelledby="deleteStudentLabel<?= $uniform_id; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form class="modal-content" method="POST"
                                                        action="<?= url_to('monitoring.deleteStudentInUniformList', $uniform_id); ?>">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteStudentLabel<?= $uniform_id; ?>">
                                                                Confirm Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to remove the student from the list?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">No</button>
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
        <div class="d-flex justify-content-between mb-3">
            <!-- Add Student Button -->
            <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#moduleFormModal">
                Add student
            </button>

            <!-- Set Uniform Total Button -->
            <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#setTotalModal">
                Set Uniform Total
            </button>
        </div>

        <!-- Add Student Modal -->
        <div class="modal fade" id="moduleFormModal" tabindex="-1" aria-labelledby="moduleFormModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="<?= url_to('monitoring.addStudentInUniform'); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="moduleFormModalLabel">Add Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="studentId" class="form-label">Student ID</label>
                            <input type="text" class="form-control" id="studentId" placeholder="Enter student ID"
                                name="studentId" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Set Uniform Total Modal -->
        <div class="modal fade" id="setTotalModal" tabindex="-1" aria-labelledby="setTotalModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="<?= url_to('monitoring.setUniformAmount'); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="setTotalModalLabel">Set Uniform Total Amount</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="totalAmount" class="form-label">Total Amount</label>
                            <input type="number" class="form-control" id="totalAmount" name="totalAmount"
                                placeholder="Enter total amount" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Set Total</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editButtons = document.querySelectorAll('.btn-edit');
            var modal = document.getElementById('editFormModal');
            var poloSizeField = document.getElementById('poloSize');
            var pantSizeField = document.getElementById('pantSize');
            var statusField = document.getElementById('status');
            var form = document.getElementById('editStudentForm');

            // Add event listener to reset form when modal is hidden
            modal.addEventListener('hidden.bs.modal', function () {
                form.reset();  // Reset all form fields
                // Manually reset the select fields to the default option
                poloSizeField.selectedIndex = 0;
                pantSizeField.selectedIndex = 0;
                statusField.selectedIndex = 0;
            });

            // Populate the modal with dynamic data when edit button is clicked
            editButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var id = button.getAttribute('data-id');
                    var shirtSize = button.getAttribute('data-shirtsize');
                    var pantSize = button.getAttribute('data-pantsize');
                    var status = button.getAttribute('data-status');

                    // Populate the modal fields with the data attributes from the button
                    document.getElementById('id').value = id;
                    poloSizeField.value = shirtSize || "";
                    pantSizeField.value = pantSize || "";
                    statusField.value = status || "";
                });
            });
        });

    </script>
</div>
<?= $this->endSection('content'); ?>