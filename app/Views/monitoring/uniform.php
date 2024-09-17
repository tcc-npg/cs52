<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Uniforms<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>


<div class="container-xxl flex-grow-1 container-p-y">
    
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
                        <th>Student ID</th>
                        <th>Sex</th>
                        <th>Blouse/Polo</th>
                        <th>Pants</th>
                        <th>Balance</th>  <!-- will default to the the total price of the uniform-->
                        <th>Status</th>
                            
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <?php foreach ($list as $student): ?>
                            <tr>
                                <td><strong><?= $student['first_name'] . ' ' . $student['last_name']; ?></strong></td>
                                <td class=""><?= $student['student_number']; ?></td>
                               
                                <td>
                                    <?php $sex = (strtoupper($student['gender'])); 
                                    
                                    if ($sex === 'M') {
                                        echo 'Male';
                                    }
                                    else
                                    echo 'Female';

                                    ?>
                                </td>


                                <td> 
                                    <!-- NOT FINAL: Need to add dynamic dropdown menu for sizes (xs,s,m,l,xl) that will be inserted to uniforms table -->
                                    <?php $size = $student['shirt_size']; 

                                    if ($size === null){
                                        echo 'enter size';
                                    }
                                    
                                    
                                    else{
                                        echo $size;
                                    }                                    
                                    ?>
                                </td>
                                <td>
                                       <!-- NOT FINAL: Need to add dynamic dropdown menu for sizes (xs,s,m,l,xl) that will be inserted to uniforms table -->
                                       <?php $size = $student['shirt_size']; 

                                        if ($size === null){
                                            echo 'enter size';
                                        }


                                        else{
                                            echo $size;
                                        }                                    
                                        ?>
                                </td>
                                <td><?= $student['balance']; ?></td>
                                <td>  
                                     <!-- NOT FINAL: Need to add dynamic dropdown menu for status (rb, p, c) that will be inserted to uniforms table -->
                                    <?php $status = $student['status']; 

                                    if ($size === null){
                                        echo 'no reocrd';
                                    }
                                    
                                    
                                    else{
                                        echo $status;
                                    }                                    
                                    ?> 
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

        <div class="modal fade" id="moduleFormModal" tabindex="-1" aria-labelledby="moduleFormModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="moduleFormModalLabel">Add Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="studentName" class="form-label">student ID</label>
                                <input type="text" class="form-control" id="moduleName" placeholder="Enter student ID" value="">
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
