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
                <!-- <div class="card-header d-flex justify-content-between align-items-center">
                   
                    <small class="text-muted float-end"> students</small>
                </div> -->
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Student ID</th>
                                <th class="text-center">Sex</th>
                                <th class="text-center">Blouse/Polo</th>
                                <th class="text-center">Pants</th>
                                <th class="text-center">Balance</th>
                                <!-- will default to the the total price of the uniform-->
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php foreach ($list as $student): ?>
                                <tr>
                                    <td><strong><?= $student['first_name'] . ' ' . $student['last_name']; ?></strong></td>
                                    <td class="text-center"><?= $student['student_number']; ?></td>

                                    <td class="text-center">
                                        <?php $sex = (strtoupper($student['gender']));

                                        if ($sex === 'M') {
                                            echo 'Male';
                                        } else
                                            echo 'Female';

                                        ?>
                                    </td>


                                    <td class="text-center">
                                        <!-- NOT FINAL: Need to add dynamic dropdown menu for sizes (xs,s,m,l,xl) that will be inserted to uniforms table -->
                                        <?php $size = $student['shirt_size'];

                                        if ($size === null) {
                                            echo 'edit size';
                                        } else {
                                            echo $size;
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <!-- NOT FINAL: Need to add dynamic dropdown menu for sizes (xs,s,m,l,xl) that will be inserted to uniforms table -->
                                        <?php $size = $student['shirt_size'];

                                        if ($size === null) {
                                            echo 'edit size';
                                        } else {
                                            echo $size;
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?= $student['balance']; ?></td>
                                    <td class="text-center">
                                        <!-- NOT FINAL: Need to add dynamic dropdown menu for status (rb, p, c) that will be inserted to uniforms table -->
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
                                        <button class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#editFormModal"
                                            data-id="<?= $student['id']; ?>">
                                            Edit</button>
                                        <!-- MODAL FORM FOR EDITTING STUDENT INFORMATION -->
                                        <div class="modal fade" id="editFormModal" tabindex="-1"
                                            aria-labelledby="moduleFormModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form class="modal-content" method="POST"
                                                    action="<?= url_to('monitoring.updateStudentInfo'); ?>">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="moduleFormModalLabel">Edit Student Info
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <!-- Hidden Input to store userId -->
                                                            <input type="hidden" class="form-control" id="id"
                                                                name="id">

                                                            <label for="poloSize" class="form-label">Polo/Blouse
                                                                Size</label>
                                                            <select class="form-control" id="poloSize" name="shirtSize">
                                                                <option value="" disabled selected>Select Polo/Blouse Size
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
                                                                <option value="" disabled selected>Select Pants Size
                                                                </option>
                                                                <option value="xs">Extra Small</option>
                                                                <option value="s">Small</option>
                                                                <option value="m">Medium</option>
                                                                <option value="l">Large</option>
                                                                <option value="xl">Extra-Large</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
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

                                        <button class="btn btn-delete">Delete</button>
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
    <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#moduleFormModal">
        Add student
    </button>

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
                        <label for="studentId" class="form-label">student ID</label>
                        <input type="text" class="form-control" id="moduleName" placeholder="Enter student ID" value=""
                            name="studentId">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" value="Add Student">Submit</button>
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