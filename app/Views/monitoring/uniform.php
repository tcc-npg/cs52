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
                                <th>Name</th>
                                <th class="text-center">Sex</th>
                                <th class="text-center">Blouse/Polo</th>
                                <th class="text-center">Pants</th>
                                <th class="text-center">Paid Amount</th>
                                <th class="text-center">Last Payment Date</th>
                                <th class="text-center">Balance</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>

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

                                        $holder = '';
                                        switch ($size) {
                                            case 'xs':
                                                $holder = "Extra Small";
                                                break;
                                            case "s":
                                                $holder = "Small";
                                                break;
                                            case "m":
                                                $holder = "Medium";
                                                break;
                                            case "l":
                                                $holder = "Large";
                                                break;
                                            case "xl":
                                                $holder = "Extra Large";
                                                break;
                                        }
                                        if ($size === $student['shirt_size']) {
                                            $shirt_size = $holder;
                                        } else {
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
                                        <?php $balance = $student['amount'] - $totalPayment; ?>
                                        <?= $balance > 0 ? number_format($balance, 2) : 'No Balance'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php $status = $student['status'];

                                        if ($status === null) {
                                            echo 'no record';
                                        } else {
                                            if ($status === 'p') {
                                                echo 'PAID';
                                            } else if ($status === 'c') {
                                                echo 'CLAIMED/NO PAYMENT';
                                            } else {
                                                echo 'no record';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <!-- Edit Button -->
                                        <button class="btn btn-edit" data-bs-toggle="modal"
                                            data-bs-target="#editFormModal<?= $student['user_id']; ?>">
                                            <i class='bx bx-edit'></i>
                                        </button>

                                        <!-- MODAL FORM FOR EDITING STUDENT INFORMATION -->
                                        <div class="modal fade" id="editFormModal<?= $student['user_id']; ?>" tabindex="-1"
                                            aria-labelledby="moduleFormModalLabel<?= $student['user_id']; ?>"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form class="modal-content" method="POST"
                                                    action="<?= url_to('monitoring.updateStudentInfo', $student['user_id'], $student['id']); ?>">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="moduleFormModalLabel">Edit Student Info
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <!-- Hidden Input to store id and user_id -->
                                                            <input type="hidden" class="form-control" id="editStudentId"
                                                                name="id">
                                                            <input type="hidden" class="form-control" id="editUserId"
                                                                name="user_id">

                                                            <label for="poloSize" class="form-label">Polo/Blouse
                                                                Size</label>
                                                            <select class="form-control" id="poloSize" name="shirtSize">
                                                                <option value="" disabled selected>
                                                                    <?php echo !empty($shirt_size) ? 'Selected Polo/Blouse Size: ' . $shirt_size : 'Select Polo/Blouse Size'; ?>
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
                                                                    <?php echo !empty($pant_size) ? 'Selected Pants Size: ' . $pant_size : 'Select Pants Size'; ?>
                                                                </option>
                                                                <option value="xs">Extra Small</option>
                                                                <option value="s">Small</option>
                                                                <option value="m">Medium</option>
                                                                <option value="l">Large</option>
                                                                <option value="xl">Extra-Large</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="payment" class="form-label"
                                                                name="payment">Payment</label>
                                                            <input type="number" class="form-control" id="payment"
                                                                name="payment" placeholder="Enter payment amount" min="0"
                                                                max='<?= $balance ?>'>
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
                                                        <button type="submit" class="btn btn-primary"
                                                            value="Submit">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Delete Button -->
                                        <!-- Delete Button -->
                                        <button type="button" class="btn" aria-label="More options" data-bs-toggle="modal"
                                            data-bs-target="#deleteStudentModal<?= $uniform_id; ?>">
                                            <i class='bx bx-trash'></i>
                                        </button>

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
                                                        Are you sure you want to delete this student from the uniform list?
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

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- need to connect to connect get the student nummber and create a querry to the db to get the user_id based from the given student_number -->
    <!-- Container to wrap both buttons with flexbox for horizontal alignment -->
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