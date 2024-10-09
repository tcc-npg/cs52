<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Modules<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="container mt-3">
        <div class="dropdown text-left">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="moduleDropdownButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                Select Module
            </button>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moduleDropdownButton">
                <?php foreach ($modules as $module): ?>
                    <li><a class="dropdown-item" href="<?= url_to('monitoring.viewData', $module['module_id']); ?>">
                            <?= $module['code'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="container mt-5">
        <h3 class="text-center">Module Compliance</h3>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <canvas id="modulePaidPieChart"></canvas>
                <p id="moduleNotDefined" class="text-center" style="display: none;">Please Select a Module</p>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h3 class="text-center">Uniform Analytics</h3>
        <div class="row justify-content-center">
            <div class="container mt-3">
                <div id="uniformLegend" class="text-center"></div>
            </div>

            <div class="row justify-content-center mt-3">
                <div class="col-md-8">
                    <div class="dropdown text-left">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="chartDropdownButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Select Chart
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chartDropdownButton">
                            <li><a class="dropdown-item" href="#" id="showPolo">Polo Chart</a></li>
                            <li><a class="dropdown-item" href="#" id="showBlouse">Blouse Chart</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4" id="poloChartContainer">
                <canvas id="poloPieChart" style="max-height: 200px;"></canvas>
                <p id="noPoloDataMessage" class="text-center" style="display: none;">No data available for Polo Sizes.
                </p>
                <h4 class="text-center">Polo</h4>
            </div>
            <div class="col-md-4" id="blouseChartContainer" style="display: none;">
                <canvas id="blousePieChart" style="max-height: 200px;"></canvas>
                <p id="noBlouseDataMessage" class="text-center" style="display: none;">No data available for Blouse
                    Sizes.</p>
                <h4 class="text-center">Blouse</h4>
            </div>
            <div class="col-md-4">
                <canvas id="pantPieChart" style="max-height: 200px;"></canvas>
                <p id="noPantsDataMessage" class="text-center" style="display: none;">No data available for Pants Sizes.
                </p>
                <h4 class="text-center">Pants</h4>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h3 class="text-center">Uniform Compliance</h3>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <canvas id="uniformComplianceChart"></canvas>
                <p id="noModuleComplianceDataMessage" class="text-center" style="display: none;">No data available</p>
            </div>
        </div>
    </div>
</div>


<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
$total_students = 0;
$paid = 0;
$claimed = 0;

foreach ($students as $student) {
    $total_students += 1;
    if ($student['status'] === 'p') {
        $paid++;
    } elseif ($student['status'] === 'c') {
        $claimed++;
    }
}

$total_students_uniforms = 0;
$xSmallPants = 0;
$smallPants = 0;
$mediumPants = 0;
$largePants = 0;
$xLargePants = 0;
$noRecordPants = 0;

$xSmallPolo = 0;
$smallPolo = 0;
$mediumPolo = 0;
$largePolo = 0;
$xLargePolo = 0;
$noRecordPolo = 0;

$xSmallBlouse = 0;
$smallBlouse = 0;
$mediumBlouse = 0;
$largeBlouse = 0;
$xLargeBlouse = 0;
$noRecordBlouse = 0;

$paidUniform = 0;
$claimedUniform = 0;

foreach ($uniforms as $uniform) {
    $total_students_uniforms += 1;

    // Pants size
    switch ($uniform['pants_size']) {
        case 'xs':
            $xSmallPants++;
            break;
        case 's':
            $smallPants++;
            break;
        case 'm':
            $mediumPants++;
            break;
        case 'l':
            $largePants++;
            break;
        case 'xl':
            $xLargePants++;
            break;
        default:
            $noRecordPants++;
            break;
    }

    // Polo/Blouse sizes based on gender
    if ($uniform['gender'] === 'M') {
        switch ($uniform['shirt_size']) {
            case 'xs':
                $xSmallPolo++;
                break;
            case 's':
                $smallPolo++;
                break;
            case 'm':
                $mediumPolo++;
                break;
            case 'l':
                $largePolo++;
                break;
            case 'xl':
                $xLargePolo++;
                break;
            default:
                $noRecordPolo++;
                break;
        }
    } else {
        switch ($uniform['shirt_size']) {
            case 'xs':
                $xSmallBlouse++;
                break;
            case 's':
                $smallBlouse++;
                break;
            case 'm':
                $mediumBlouse++;
                break;
            case 'l':
                $largeBlouse++;
                break;
            case 'xl':
                $xLargeBlouse++;
                break;
            default:
                $noRecordBlouse++;
                break;
        }
    }

    if ($uniform['status'] === 'p') {
        $paidUniform++;
    } elseif ($uniform['status'] === 'c') {
        $claimedUniform++;
    }
}
?>

<style>
    canvas {
        width: 100% !important;
        height: auto !important;
        max-height: 200px;
    }

    .dropdown-menu {
        max-height: 200px;
        overflow-y: auto;
    }
</style>

<script>
    function allZero(arr) {
        return arr.every(value => value === 0);
    }

    // Module Pie Chart
    var paid = <?= $paid ?>;
    var claimed = <?= $claimed ?>;
    var totalStudents = <?= $total_students ?>;
    var unpaid = totalStudents - paid - claimed;
    var moduleData = [paid, claimed, unpaid]

    if (!allZero(moduleData)) {
        var ctxPie = document.getElementById('modulePaidPieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Paid', 'Claimed', 'Unclaimed'],
                datasets: [{
                    data: moduleData,
                    backgroundColor: ['#A3DE83', '#FFD700', '#FF6B6B']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

    } else {
        document.getElementById('modulePaidPieChart').style.display = 'none';
        document.getElementById('moduleNotDefined').style.display = 'block';
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Pants Pie Chart
        var pantData = [<?= $xSmallPants ?>, <?= $smallPants ?>, <?= $mediumPants ?>, <?= $largePants ?>, <?= $xLargePants ?>, <?= $noRecordPants ?>];
        if (!allZero(pantData)) {
            var ctxPants = document.getElementById('pantPieChart').getContext('2d');
            new Chart(ctxPants, {
                type: 'pie',
                data: {
                    labels: ['XS', 'S', 'M', 'L', 'XL', 'No Record'],
                    datasets: [{
                        data: pantData,
                        backgroundColor: ['#FFB3C1', '#FFD966', '#8FD1E8', '#FFA07A', '#90EE90 ', '#D3D3D3']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
        } else {
            document.getElementById('pantPieChart').style.display = 'none';
            document.getElementById('noPantsDataMessage').style.display = 'block';
        }

        // Polo Pie Chart
        var poloData = [<?= $xSmallPolo ?>, <?= $smallPolo ?>, <?= $mediumPolo ?>, <?= $largePolo ?>, <?= $xLargePolo ?>, <?= $noRecordPolo ?>];
        if (!allZero(poloData)) {
            var ctxPolo = document.getElementById('poloPieChart').getContext('2d');
            new Chart(ctxPolo, {
                type: 'pie',
                data: {
                    labels: ['XS', 'S', 'M', 'L', 'XL', 'No Record'],
                    datasets: [{
                        data: poloData,
                        backgroundColor: ['#FFB3C1', '#FFD966', '#8FD1E8', '#FFA07A', '#90EE90 ', '#D3D3D3']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
        } else {
            document.getElementById('poloPieChart').style.display = 'none';
            document.getElementById('noPoloDataMessage').style.display = 'block';
        }

        // Blouse Pie Chart
        var blouseData = [<?= $xSmallBlouse ?>, <?= $smallBlouse ?>, <?= $mediumBlouse ?>, <?= $largeBlouse ?>, <?= $xLargeBlouse ?>, <?= $noRecordBlouse ?>];
        if (!allZero(blouseData)) {
            var ctxBlouse = document.getElementById('blousePieChart').getContext('2d');
            new Chart(ctxBlouse, {
                type: 'pie',
                data: {
                    labels: ['XS', 'S', 'M', 'L', 'XL', 'No Record'],
                    datasets: [{
                        data: blouseData,
                        backgroundColor: ['#FFB3C1', '#FFD966', '#8FD1E8', '#FFA07A', '#90EE90 ', '#D3D3D3']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
        } else {
            document.getElementById('blousePieChart').style.display = 'none';
            document.getElementById('noBlouseDataMessage').style.display = 'block';
        }
    });

    var paidUniform = <?= $paidUniform ?>;
    var claimedUniform = <?= $claimedUniform ?>;
    var totalStudentsUniforms = <?= $total_students_uniforms ?>;
    var unpaidUniforms = totalStudents - paid - claimed;
    var uniformComplinaceData = [paidUniform, claimedUniform, unpaidUniforms];

    if (!allZero(uniformComplinaceData)) {
        var ctxPie = document.getElementById('uniformComplianceChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Paid', 'Claimed', 'Unclaimed'],
                datasets: [{
                    data: uniformComplinaceData,
                    backgroundColor: ['#A3DE83', '#FFD700', '#FF6B6B']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    } else {
        document.getElementById('uniformComplianceChart').style.display = 'none';
        document.getElementById('noModuleComplianceDataMessage').style.display = 'block';
    }




    var uniformLabels = ['Extra Small', 'Small', 'Medium', 'Large', 'Extra Large', 'No Record'];
    var uniformColors = ['#FFB3C1', '#FFD966', '#8FD1E8', '#FFA07A', '#90EE90 ', '#D3D3D3'];

    function generateCustomLegend() {
        var legendHTML = '<ul class="list-inline">';
        uniformLabels.forEach(function (label, index) {
            legendHTML += '<li class="list-inline-item"><span style="background-color:' + uniformColors[index] + ';width:20px;height:20px;display:inline-block;margin-right:5px;"></span>' + label + '</li>';
        });
        legendHTML += '</ul>';
        document.getElementById('uniformLegend').innerHTML = legendHTML;
    }


    // Call the function to generate the custom legend
    generateCustomLegend();

    // Show Polo chart by default
    document.getElementById('poloChartContainer').style.display = 'block';
    document.getElementById('blouseChartContainer').style.display = 'none';

    // Event listeners for dropdown options
    document.getElementById('showPolo').addEventListener('click', function () {
        document.getElementById('poloChartContainer').style.display = 'block';
        document.getElementById('blouseChartContainer').style.display = 'none';
    });

    document.getElementById('showBlouse').addEventListener('click', function () {
        document.getElementById('poloChartContainer').style.display = 'none';
        document.getElementById('blouseChartContainer').style.display = 'block';
    });



</script>

<?= $this->endSection('content'); ?>