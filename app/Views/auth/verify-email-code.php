<?= $this->extend('auth/default'); ?>
<?= $this->section('pageTitle'); ?>- Email Activation<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <!-- /Logo -->
                    <h4 class="mb-2">Email Activation</h4>
                    <p class="mb-4">We just sent an email to you with a code to confirm your email address. Copy that code and paste it below.</p>
                    <form action="<?= url_to('auth-action-verify') ?>" method="post">
                        <?= csrf_field() ?>
                        <?php if (session('error') !== null) : ?>
                            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                        <?php endif ?>
                        <div class="mb-3">
                            <label for="token" class="form-label">Token</label>
                            <input type="text"
                                   class="form-control"
                                   name="token"
                                   id="token"
                                   placeholder="000000"
                                   inputmode="numeric"
                                   pattern="[0-9]*"
                                   autocomplete="one-time-code"
                                   value="<?= old('token') ?>"
                                   required
                            >
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>
