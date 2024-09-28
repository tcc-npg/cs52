<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Modules<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<style>
        .hover-opacity {
            color: #5f61e6; 
            border: 1px solid blue;
            opacity: 80%;
            transition: background-color 0.25s;
        }

        .hover-opacity:hover {
            color: white;
            background-color: #5f61e6;
            opacity: 100%;
        }
    </style>

<div class="container-xxl flex-grow-1 container-p-y">




    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#moduleFormModal">
    Add module
    </button>

    
    <div class="modal fade" id="moduleFormModal" tabindex="-1" aria-labelledby="moduleFormModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="moduleFormModalLabel">Module Information Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form inside modal -->
                    <form>
                        <!-- Module Name -->
                        <div class="mb-3">
                            <label for="moduleName" class="form-label">Module Name</label>
                            <input type="text" class="form-control" id="moduleName" placeholder="Enter module name">
                        </div>  

                        <!-- Professor -->
                        <div class="mb-3">
                            <label for="professorName" class="form-label">Professor</label>
                            <input type="text" class="form-control" id="professorName" placeholder="Enter professor's name">
                        </div>

                        <!-- Course Code -->
                        <div class="mb-3">
                            <label for="courseCode" class="form-label">Course Code</label>
                            <input type="text" class="form-control" id="courseCode" placeholder="Enter course code">
                        </div>

                        <!-- Year Level -->
                        <div class="mb-3">
                            <label for="yearLevel" class="form-label">Year Level</label>
                            <select class="form-select" id="yearLevel">
                                <option selected>Select year level</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

<div class="container my-4   ">
    <div class="row g-4">

        <?php foreach ($list as $module) : ?>

        <div class="col-md-4 p-0">
            <a href="<?php echo url_to('monitoring.studentsList', $module['module_id'], $module['name'])?>">
                <div class="position-relative p-3 rounded-3 hover-opacity">
                    <div class="text-left fw-bold pt-5 ">
                        <p class="fs-3 mb-0"><?php  echo strtoupper($module['name'])?></p>
                        <!-- FIX: connect to the user_details of the professor (no data) -->
                        <p class="fs-4 mb-0"><?php echo $module['prof_id']?></p>
                        <p class="fs-5"><?php echo $module['code']?></p>
                    </div>
                </div>
            </a>
        </div>

        <?php endforeach ?> 
    </div>
</div>



  
</div>
<?= $this->endSection('content'); ?>
