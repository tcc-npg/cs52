<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Other Payable<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>

<div class="container-xxl flex-grow-1 container-p-y">
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
                            <?php foreach ($list as $payable) : ?>
                            
                            <tr class="cursor-pointer"  onclick="window.location='<?= url_to('monitoring.payeeList'); ?>'">
                        
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

        <div class="modal fade" id="moduleFormModal" tabindex="-1" aria-labelledby="moduleFormModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="moduleFormModalLabel">Add Payables</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="studentName" class="form-label">Payable Name</label>
                                <input type="text" class="form-control" id="moduleName" placeholder="Enter payable name" value="">
                            </div> 
                            <div class="mb-3">
                                <label for="studentName" class="form-label">Amount</label>
                                <input type="text" class="form-control" id="moduleName" placeholder="Enter amount" value="">
                            </div> 
                            <div class="mb-3">
                                <label for="studentName" class="form-label">Deadline</label>
                                <input type="date" class="form-control" id="moduleName"  value="">
                            </div> 
                            <div class="mb-3">
                                <label for="studentName" class="form-label">Payees</label>
                                <input type="text" class="form-control" id="moduleName" placeholder="Enter payees" value="">
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
</div>


<?= $this->endSection('content'); ?>
