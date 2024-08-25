<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Dashboard<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <?php if (session('update_successful')) :
        $message = session('update_successful');
        $icon = session('toast_icon');
        $header = session('toast_header');
        $type = session('toast_color');
        echo showToast($message, $type, $header, $icon);
        ?>

        <?= $this->section('nonceScript'); ?>
        <script>
            const toastPlacement = new bootstrap.Toast(document.querySelector('#update_successful_toast'));
            toastPlacement.show();
        </script>
        <?= $this->endSection('nonceScript'); ?>
    <?php endif; ?>
    <h4 class="fw-bold py-3 mb-4"><span
                class="text-muted fw-light">Account <?php if (!$isProfileComplete): ?>/</span> Complete
        Your Profile<?php endif; ?></h4>
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <?= form_open(url_to('user.update', $userId)); ?>
                <?php if($belongsToStudentGroup == 'true') : ?>
                    <?= form_hidden('is_student', $belongsToStudentGroup); ?>
                    <?= form_hidden('user_id', strval($userId)); ?>
                <?php endif; ?>
                <?php if(url_is('students/profile/*')) : ?>
                    <?= form_hidden('from_list', 'true'); ?>
                <?php endif; ?>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <?= img([
                            'src' => 'assets/img/avatars/cat.jpg',
                            'class' => 'd-block rounded',
                            'alt' => 'User profile picture',
                            'width' => '100',
                            'height' => '100'
                        ]); ?>
                        <div class="button-wrapper"
                             data-bs-toggle="tooltip"
                             data-bs-offset="0,4"
                             data-bs-placement="top"
                             data-bs-html="true"
                             title=""
                             data-bs-original-title="<i class='bx bxs-x-circle bx-xs'></i> <span>Not yet ready</span>"
                        >
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input
                                        type="file"
                                        id="upload"
                                        class="account-file-input"
                                        hidden
                                        accept="image/png, image/jpeg"
                                        disabled
                                >
                            </label>
                            <button type="button" disabled class="btn btn-outline-secondary account-image-reset mb-4">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>

                            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <p><small class="text-light fw-semibold">User Information</small></p>
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="first_name" class="form-label required">First Name</label>
                            <input
                                    class="form-control <?= validation_show_error('first_name') ? 'invalid' : ''; ?>"
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    placeholder="First Name"
                                    autofocus
                                    required
                                    value="<?= old('first_name') ?? $userDetails->first_name ?? ''; ?>"
                            >
                            <?php if (validation_show_error('first_name')): ?>
                                <div class="error-msg p-2">
                                    <small class="text-danger"><i
                                                class='bx bxs-x-circle bs-xs'></i> <?= validation_show_error('first_name'); ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input
                                    class="form-control <?= validation_show_error('middle_name') ? 'invalid' : ''; ?>"
                                    type="text"
                                    id="middle_name"
                                    name="middle_name"
                                    placeholder="Middle Name"
                                    value="<?= old('middle_name') ?? $userDetails->middle_name ?? ''; ?>"
                            >
                            <?php if (validation_show_error('middle_name')): ?>
                                <div class="error-msg p-2">
                                    <small class="text-danger"><i
                                                class='bx bxs-x-circle'></i> <?= validation_show_error('middle_name'); ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="last_name" class="form-label required">Last Name</label>
                            <input
                                    class="form-control <?= validation_show_error('last_name') ? 'invalid' : ''; ?>"
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    placeholder="Last Name"
                                    required
                                    value="<?= old('last_name') ?? $userDetails->last_name ?? ''; ?>"
                            >
                            <?php if (validation_show_error('last_name')): ?>
                                <div class="error-msg p-2">
                                    <small class="text-danger"><i
                                                class='bx bxs-x-circle'></i> <?= validation_show_error('last_name'); ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label required" for="address">Address</label>
                            <input
                                    type="text"
                                    id="address"
                                    name="address"
                                    class="form-control <?= validation_show_error('address') ? 'invalid' : ''; ?>"
                                    maxlength="255"
                                    minlength="2"
                                    placeholder="Your Address"
                                    required
                                    value="<?= old('address') ?? $userDetails->address ?? ''; ?>"
                            >
                            <?php if (validation_show_error('address')): ?>
                                <div class="error-msg p-2">
                                    <small class="text-danger"><i
                                                class='bx bxs-x-circle'></i> <?= validation_show_error('address'); ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="phone_number" class="form-label required">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text">+63</span>
                                <input
                                        type="text"
                                        class="form-control <?= validation_show_error('phone_number') ? 'invalid' : ''; ?>"
                                        placeholder="9123456789"
                                        name="phone_number"
                                        id="phone_number"
                                        oninput="toPhoneOnly(this);"
                                        minlength="10"
                                        maxlength="11"
                                        required
                                        value="<?= old('phone_number') ?? $userDetails->phone_number ?? ''; ?>"
                                >
                                <?php if (validation_show_error('phone_number')): ?>
                                    <div class="error-msg p-2">
                                        <small class="text-danger"><i
                                                    class='bx bxs-x-circle'></i> <?= validation_show_error('phone_number'); ?>
                                        </small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="gender" class="form-label required">Gender</label>
                            <select class="form-select <?= validation_show_error('gender') ? 'invalid' : ''; ?>"
                                    id="gender" name="gender" required>
                                <option selected disabled>Select Gender</option>
                                <option
                                        value="M"
                                    <?= (!is_null(old('gender')) && old('gender') === 'M') ? 'selected' : ((($userDetails->gender ?? '') === 'M') ? 'selected' : ''); ?>
                                >
                                    Male
                                </option>
                                <option
                                        value="F"
                                    <?= (!is_null(old('gender')) && old('gender') === 'F') ? 'selected' : ((($userDetails->gender ?? '') === 'F') ? 'selected' : ''); ?>
                                >
                                    Female
                                </option>
                            </select>
                            <?php if (validation_show_error('gender')): ?>
                                <div class="error-msg p-2">
                                    <small class="text-danger"><i
                                                class='bx bxs-x-circle'></i> <?= validation_show_error('gender'); ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if ($belongsToStudentGroup == 'true'): ?>
                    <div class="card-body pt-0">
                        <p><small class="text-light fw-semibold">Student Information</small></p>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="student_number" class="form-label required z">Student Number</label>
                                <input
                                        class="form-control <?= validation_show_error('student_number') ? 'invalid' : ''; ?>"
                                        type="text"
                                        id="student_number"
                                        name="student_number"
                                        placeholder="Student Number"
                                        required
                                        value="<?= old('student_number') ?? $studentDetails->student_number ?? ''; ?>"
                                        minlength="10"
                                        maxlength="10"
                                >
                                <?php if (validation_show_error('student_number')): ?>
                                    <div class="error-msg p-2">
                                        <small class="text-danger"><i
                                                    class='bx bxs-x-circle'></i> <?= validation_show_error('student_number'); ?>
                                        </small>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="year_level" class="form-label required">Year Level</label>
                                <select class="form-select <?= validation_show_error('year_level') ? 'invalid' : ''; ?>"
                                        id="year_level" name="year_level" required>
                                    <option selected disabled>Select Year Level</option>
                                    <option
                                            value="1"
                                        <?= (!is_null(old('year_level')) && old('year_level') === '1') ? 'selected' : ((($studentDetails->year_level ?? '') == '1') ? 'selected' : ''); ?>
                                    >
                                        1st
                                    </option>
                                    <option
                                            value="2"
                                        <?= (!is_null(old('year_level')) && old('year_level') === '2') ? 'selected' : ((($studentDetails->year_level ?? '') == '2') ? 'selected' : ''); ?>
                                    >
                                        2nd
                                    </option>
                                    <option
                                            value="3"
                                        <?= (!is_null(old('year_level')) && old('year_level') === '3') ? 'selected' : ((($studentDetails->year_level ?? '') == '3') ? 'selected' : ''); ?>
                                    >
                                        3rd
                                    </option>
                                    <option
                                            value="4"
                                        <?= (!is_null(old('year_level')) && old('year_level') === '4') ? 'selected' : ((($studentDetails->year_level ?? '') == '4') ? 'selected' : ''); ?>
                                    >
                                        4th
                                    </option>
                                </select>
                                <?php if (validation_show_error('year_level')): ?>
                                    <div class="error-msg p-2">
                                        <small class="text-danger"><i
                                                    class='bx bxs-x-circle'></i> <?= validation_show_error('year_level'); ?>
                                        </small>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="program_code" class="form-label required">Program</label>
                                <select class="form-select <?= validation_show_error('program_code') ? 'invalid' : ''; ?>"
                                        id="program_code" name="program_code" required>
                                    <option disabled>Select Program</option>
                                    <option value="bscs" selected>Bachelor of Science in Computer Science</option>
                                </select>
                                <?php if (validation_show_error('program_code')): ?>
                                    <div class="error-msg p-2">
                                        <small class="text-danger"><i
                                                    class='bx bxs-x-circle'></i> <?= validation_show_error('program_code'); ?>
                                        </small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                    <div class="card-footer pt-0 float-end">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                    </div>
                <?= form_close(); ?>
                <form action="">
                    <hr class="m-0">
                    <div class="card-body">
                        <p><small class="text-light fw-semibold">Login Information</small></p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label for="email" class="form-label required">Email</label>
                                    <input
                                            class="form-control"
                                            type="email"
                                            id="email"
                                            name="email"
                                            placeholder="Email"
                                            autofocus
                                            required
                                            value="<?= $user->getEmail(); ?>"
                                            disabled
                                    >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-mb-12 mb-3">
                                        <label for="password1" class="form-label required">Password</label>
                                        <input
                                                class="form-control"
                                                type="password"
                                                id="password1"
                                                name="password1"
                                                placeholder="Password"
                                                autofocus
                                                required
                                        >
                                    </div>
                                    <div class="col-mb-12 mb-3">
                                        <label for="password2" class="form-label required">Confirm Password</label>
                                        <input
                                                class="form-control"
                                                type="password"
                                                id="password2"
                                                name="password2"
                                                placeholder="Confirm Password"
                                                autofocus
                                                required
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer pt-0 float-end"
                         data-bs-toggle="tooltip"
                         data-bs-offset="0,4"
                         data-bs-placement="top"
                         data-bs-html="true"
                         title=""
                         data-bs-original-title="<i class='bx bxs-x-circle bx-xs'></i> <span>Not yet ready</span>">
                        <button type="submit" class="btn btn-primary me-2"
                                disabled
                        >Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>
