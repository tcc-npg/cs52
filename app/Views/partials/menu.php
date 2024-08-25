<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?= base_url('/'); ?>" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">CS52</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?= url_is('/') ? 'active' : ''; ?>">
            <a href="<?= base_url('/'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- Account -->
        <li class="menu-item <?= url_is('user*') ? 'open' : ''; ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div>Account</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= url_is('user') ? 'active' : ''; ?>">
                    <a href="<?= url_to('user.index'); ?>" class="menu-link">
                        <div>Profile</div>
                    </a>
                </li>
                <?php if (auth()->user()->inGroup('student')) : ?>
                    <li class="menu-item <?= url_is('user/subjects-enrolled') ? 'active' : ''; ?>">
                        <a href="<?= url_to('user.subjects-enrolled'); ?>" class="menu-link">
                            <div>My Subjects</div>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>

        <?php if (auth()->user()->inGroup('admin')): ?>
            <?= $this->include('partials/menu-students')  ;?>
        <?php endif; ?>

        <!-- Academic Resources -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Academic Resources</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div>Library</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chat"></i>
                <div>Forum</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div>Flashcards</div>
            </a>
        </li>
    </ul>
</aside>