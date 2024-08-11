<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Dashboard<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Congratulations Car! 🎉</h5>
                            <p class="mb-4">
                                Eyyy 🤙. You have done <span class="fw-bold">4/5</span> of your assignments.
                            </p>

                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary">View Assignments</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <?= img([
                                'src' => 'assets/img/illustrations/man-with-laptop-light.png',
                                'height' => '140',
                                'alt' => 'User'
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Productivity Report</h5>
                                    <span class="badge bg-label-success rounded-pill">August</span>
                                </div>
                                <div class="mt-sm-auto">
                                    <small class="text-success text-nowrap fw-semibold">
                                        <i class="bx bx-chevron-up"></i> 100%
                                    </small>
                                    <p class="mb-0 small">compared to last month</p>
                                </div>
                            </div>
                            <div id="productivityChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center align-middle mt-5">
            wala pa dito..
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>
