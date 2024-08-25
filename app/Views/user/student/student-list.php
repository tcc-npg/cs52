<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Dashboard<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span
                class="text-muted fw-light">Student List /</span> <?= $year === 'all' ? 'All' : $year . ordinal($year) . ' Years'; ?>
    </h4>
    <div class="row">
        <div class="col-xxl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>List of <?= $year === 'all' ? 'All Students' : $year . ordinal($year) . ' Years'; ?></h5>
                    <small class="text-muted float-end"><?= count($list); ?> students</small>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Student Number</th>
                            <?php if ($year === 'all') : ?>
                                <th class="text-center">Year</th>
                            <?php endif; ?>
                            <th class="text-center">Program</th>
                            <th class="text-center">Is<br>Enrolled</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <?php foreach ($list as $student): ?>
                            <tr>
                                <td><strong><?= $student->first_name . ' ' . $student->last_name; ?></strong></td>
                                <td class="text-center"><?= $student->student_number; ?></td>
                                <?php if ($year === 'all') : ?>
                                    <th class="text-center"><?= $student->year_level . ordinal($student->year_level) . ' Year'; ?></th>
                                <?php endif; ?>
                                <td class="text-center"><?= strtoupper($student->program_code); ?></td>
                                <td class="text-center"><?= $student->is_enrolled ? 'Yes' : 'No'; ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button
                                                type="button"
                                                class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow btn-sm"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                        >
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item"
                                                   href="<?= url_to('students.profile.index', $student->user_id) ?>">Update
                                                    Profile</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Enroll Student</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider"/>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>
