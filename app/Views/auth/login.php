<?= $this->extend('auth/default'); ?>
<?= $this->section('pageTitle'); ?>- Login<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-2">Welcome to <?= APP_NAME; ?>! 👋</h4>
                    <p class="mb-4">Sign in</p>
                    <form action="<?= url_to('login') ?>" method="post">
                        <?= csrf_field() ?>
                        <?php if (session('error') !== null) : ?>
                            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                        <?php elseif (session('errors') !== null) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php if (is_array(session('errors'))) : ?>
                                    <?php foreach (session('errors') as $error) : ?>
                                        <?= $error ?>
                                        <br>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= session('errors') ?>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                        <?php if (session('message') !== null) : ?>
                            <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                        <?php endif ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email"
                                    autofocus
                                    required
                                    value="<?= old('email') ?>"
                            />
                        </div>
                        <div class=" mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                                <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                                    <a href="<?= url_to('magic-link') ?>">
                                        <small>Forgot Password?</small>
                                    </a>
                                <?php endif ?>
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        placeholder="Enter your password"
                                        aria-describedby="password"
                                        autocomplete="false"
                                />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                           id="remember-me" <?php if (old('remember')): ?> checked<?php endif ?>/>
                                    <label class="form-check-label" for="remember-me"> Remember Me</label>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>

                    <?php if(isRegistrationAllowed()): ?>
                        <p class="text-center">
                            <a href="<?= url_to('register') ?>">
                                <span>Create an account</span>
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>
