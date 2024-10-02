<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Modules<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="container mt-3">
        <div class="dropdown text-left">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                Select Module
            </button>
            
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            <?php foreach ($modules as $module) : ?>
                <li><a class="dropdown-item" href="<?= url_to('monitoring.viewData', $module['module_id']) ; ?>"> <?= $module['code'] ?></a></li>
                <?php endforeach; ?>
            </ul>
            
        </div>
    </div>


    <div class="container mt-5">
        <h3 class="text-center">Module Compliance</h3>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <canvas id="modulePaidPieChart"></canvas>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h3 class="text-center">Uniform Analytics</h3>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <canvas id="pantsPieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?=
    $total_students = 0;
$paid = 0;
$claimed = 0;

foreach ($students as $student):      
    $total_students += 1;
    if ($student['status'] == 'p') {
        $paid++;
    }
    if ($student['status'] == 'c') {
        $claimed++;
    }


endforeach; ?>


<script>
    // Module Pie Chart
    // Will have drop down optiontaht will displa the different modules available catgeorized by year

    // percentage variable
    var paid = <?= $paid ?>;
    var claimed = <?= $claimed ?>;
    var totalStudents = <?= $total_students ?>; // Fixed typo from total_studens to total_students
    var unpaid = totalStudents - paid - claimed; // Calculate unpaid correctly

    var paidPercent = (paid / totalStudents * 100).toFixed(2);
    var claimedPercent = (claimed / totalStudents * 100).toFixed(2);
    var unpaidPercent = (unpaid / totalStudents * 100).toFixed(2); // Calculate unpaid percentage

    var ctxPie = document.getElementById('modulePaidPieChart').getContext('2d');
    var myPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Paid', 'Claimed/NoPayment', 'Unclaimed'], // Changed 'NoPayment/Claimed' to 'Claimed'
            datasets: [{
                data: [paid, claimed, unpaid], // Fixed data array to include claimed and unpaid
                backgroundColor: ['#A3DE83', '#FFD700', '#FF6B6B'] // Added a color for Unclaimed
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var currentValue = dataset.data[tooltipItem.index];
                        var label = data.labels[tooltipItem.index];
                        return label + ': ' + currentValue; // Show the number, not the percentage
                    }
                }
            }
        }
    });


    var ctxPie = document.getElementById('pantsPieChart').getContext('2d');
    var myPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Extra Small', 'Small', 'Medium', 'Large', 'Extra Large'],
            datasets: [{
                data: [20, 20, 20, 20, 20], // Data values
                backgroundColor: ['#FF6B6B', '#4ECDC4', '#FFE66D', '#FF9AA2', '#A3DE83'], // Colors for each segment
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

</script>

<?= $this->endSection('content'); ?>