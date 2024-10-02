<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Other Payable<?= $this->endSection('pageTitle'); ?>
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
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Deadline</th>
                                <th>Payees</th>
                            </tr>
                        </thead>

                        <tbody class="table-border-bottom-0">
                            <?php foreach ($list as $payable): ?>



                                <tr class="cursor-pointer"
                                    onclick="window.location='<?= url_to('monitoring.payeeList', $payable['payable_id']); ?>'">

                                    <td><strong><?= $payable['payable_name']; ?></strong></td>
                                    <td>PHP <?= $payable['amount']; ?></td>
                                    <td><?= $payable['deadline']; ?></td>
                                    <td><?= $payable['payees']; ?></td>

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
        Add Payable
    </button>

    <div class="modal fade" id="moduleFormModal" tabindex="-1" aria-labelledby="moduleFormModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="<?= url_to('monitoring.addNewPayable'); ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="oherPayableFormModalLabel">Add Payables</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="payableName" class="form-label">Payable Name</label>
                        <input type="text" class="form-control" id="payableName" placeholder="Enter payable name"
                            name="payableName">
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="amount" placeholder="Enter amount" value=""
                            name="amount">
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" class="form-control" id="deadline" value="" name="deadline">
                    </div>
                    <div class="mb-3">
                        <label for="payees" class="form-label">Payees</label>
                        <select class="form-control" id="payees" name="payees">
                            <option value="">Select payees</option>
                            <option value="1st year">1st Year</option>
                            <option value="2nd year">2nd Year</option>
                            <option value="3rd year">3rd Year</option>
                            <option value="4th year">4th Year</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" value="Add Student">Submit</button>
                </div>


            </form>
        </div>
    </div>
</div>
</div>


<?= $this->endSection('content'); ?>