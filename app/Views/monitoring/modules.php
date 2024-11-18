<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Modules<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<style>
    .hover-opacity {
        transition: opacity 0.05s ease;
    }

    .hover-opacity:hover {
        opacity: 0.5;
    }
</style>
</style>

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

    <?php if (auth()->user()->inGroup('admin')): ?>

        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#moduleFormModal">
            Add module
        </button>


        <div class="modal fade" id="moduleFormModal" tabindex="-1" aria-labelledby="moduleFormModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="<?= url_to('monitoring.addModule'); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="moduleFormModalLabel">Add New Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="payees" class="form-label">Select Year Level</label>
                            <select class="form-control" id="payees" name="yearLevel">
                                <option value="" disabled selected>Select year level</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="subjectCode" class="form-label">Subjects</label>
                            <select class="form-control" id="subjectCode" name="subjectCode">
                                <option value="" disabled selected>Please select a subject</option>
                                <?php foreach ($subject_list as $subject): ?>
                                    <option value="<?= $subject->code ?>" data-year="<?= $subject->year_level ?>">
                                        <?= $subject->code ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" min='0' class="form-control" id="amount" placeholder="Enter amount"
                                value="" name="amount">
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
    <div class="container my-4   ">
        <div class="row g-4">

            <?php foreach ($list as $module): ?>

                <div class="col-md-4 p-1">
                    <a href="<?php echo url_to('monitoring.studentsList', $module['module_id'], $module['name']) ?>">
                        <div
                            class="position-relative p-3 rounded-3 d-flex flex-column justify-content-end h-75 bg-light hover-opacity border border-primary m-0">
                            <div class="text-left fw-bold pt-5">
                                <p class="fs-3 mb-0"><?php echo strtoupper($module['name']) ?></p>
                                <p class="fs-5"><?php echo $module['code'] ?></p>
                            </div>
                        </div>
                    </a>
                </div>

            <?php endforeach ?>
        </div>
    </div>


    <script>
        document.getElementById("payees").addEventListener("change", function () {
            const selectedYear = this.value;
            const subjectSelect = document.getElementById("subjectCode");

            // Loop through each option in subjectCode and show/hide based on the selected year level
            Array.from(subjectSelect.options).forEach(option => {
                const subjectYear = option.getAttribute("data-year");

                if (selectedYear === "all" || subjectYear === selectedYear || !subjectYear) {
                    option.style.display = "";  // Show option
                } else {
                    option.style.display = "none";  // Hide option
                }
            });

            // Reset the subject selection to the default option
            subjectSelect.selectedIndex = 0;
        });

    </script>

</div>
<?= $this->endSection('content'); ?>