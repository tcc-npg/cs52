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
        <li class="menu-item <?= is_active_menu('/', true); ?>">
            <a href="<?= base_url('/'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- Account -->
        <li class="menu-item <?= is_active_menu('user*'); ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div>Account</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= is_active_menu('user', true); ?>">
                    <a href="<?= url_to('user.index'); ?>" class="menu-link">
                        <div>Profile</div>
                    </a>
                </li>
                <?php if (auth()->user()->inGroup('student')) : ?>
                    <li class="menu-item <?= is_active_menu('user/subjects-enrolled', true); ?>">
                        <a href="<?= url_to('user.subjects-enrolled'); ?>" class="menu-link">
                            <div>My Subjects</div>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>

        <!-- Students menu -->
        <?php if (auth()->user()->inGroup('admin')): ?>
            <?= $this->include('partials/menu-students')  ;?>
        <?php endif; ?>

         <!-- Inventory System -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Inventory System</span>
        </li>
        <li class="menu-item">
            <a href="<?php echo url_to('inventory.dashboard'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Academic</span>
        </li>
        <li class="menu-item">
            <a href="<?php echo url_to('curriculum.index'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Curriculum List</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="<?php echo url_to('subjects.list'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Subject List</div>
            </a>
        </li>

        <!-- Admin -->
        <?php if (auth()->user()->inGroup('admin')): ?>
            <?= $this->include('partials/menu-admin')  ;?>
        <?php endif; ?>
    </ul>
</aside>