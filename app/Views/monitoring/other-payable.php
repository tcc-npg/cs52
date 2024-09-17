<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Uniforms<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>


<style>
  .table-design{
    color: dark;
    border-collapse: collapse;
  }
  .table-design td,.table-design th{
    word-wrap: break-word;
    word-break: break-word;
    text-overflow: ellipsis;
  }
  
  .table-design th{
    font-size: 18px;
    font-weight: 700;
  }

  .table-design th:nth-child(1){
    width: 30%;
  }

  .table-design th:nth-child(2), .table-design th:nth-child(3), .table-design th:nth-child(4){
    width: 23.33%;
  }
</style>
<div class="container-xxl flex-grow-1 container-p-y">

    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#moduleFormModal">
    Add Payable
    </button>
    <div class="modal fade" id="moduleFormModal" tabindex="-1" aria-labelledby="moduleFormModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="moduleFormModalLabel">Add Payable</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="studentName" class="form-label">Payable Name</label>
                                <input type="text" class="form-control" id="moduleName" placeholder="Enter Payable Name">
                            </div> 

                            <div class="mb-3">
                                <label for="studentName" class="form-label">Deadline</label>
                                <input type="text" class="form-control" id="moduleName" placeholder="Enter Deadline">
                            </div> 

                            <div class="mb-3">
                                <label for="studentName" class="form-label">Amount</label>
                                <input type="text" class="form-control" id="moduleName" placeholder="Enter Amount">
                            </div> 

                            <div class="mb-3">
                                <label for="studentName" class="form-label">Peyees</label>
                                <input type="text" class="form-control" id="moduleName" placeholder="Enter Peyess">
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

  <!-- upon clickin the payable row, will link to the list of studdens who are inolved -->
    <div class="container mt-5">
    <table class="table table-hover table-design">
      <thead class="text-white">
        <tr>
          <th>name</th>
          <th>deadline</th>
          <th>amount</th>
          <th>peyees </th>
        </tr>
      </thead>
        <tr>
          <td>wadwad</td>
          <td>9/11</td>
          <td>$$$$</td>
          <td>3rd year</td>
        </tr>
        <tr>
          <td>wadwad</td>
          <td>9/11</td>
          <td>$$$$</td>
          <td>3rd year</td>
        </tr>
      <tbody>

      </tbody>
    </table>
  </div>
 
</div>
<?= $this->endSection('content'); ?>
