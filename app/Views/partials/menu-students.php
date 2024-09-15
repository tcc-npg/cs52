<li class="menu-item <?= url_is('students*') ? 'open' : ''; ?>">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-group"></i>
        <div>Students</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item <?= is_active_menu('students'); ?>">
            <li class="menu-item <?= is_active_menu('students*'); ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-list-ul"></i>
                    <div>List</div>
                </a>
                <ul class="menu-sub menu-sub-sub">
                    <li class="menu-item <?= is_active_menu('students/list/all', true); ?>">
                        <a href="<?= url_to('students.list', 'all'); ?>" class="menu-link">
                            <div>All</div>
                        </a>
                    </li>
                    <li class="menu-item <?= is_active_menu('students/list/1', true); ?>">
                        <a href="<?= url_to('students.list', 1); ?>" class="menu-link">
                            <div>1st Year</div>
                        </a>
                    </li>
                    <li class="menu-item <?= is_active_menu('students/list/2', true); ?>">
                        <a href="<?= url_to('students.list', 2); ?>" class="menu-link">
                            <div>2nd Year</div>
                        </a>
                    </li>
                    <li class="menu-item <?= is_active_menu('students/list/3', true); ?>">
                        <a href="<?= url_to('students.list', 3); ?>" class="menu-link">
                            <div>3rd Year</div>
                        </a>
                    </li>
                    <li class="menu-item <?= is_active_menu('students/list/4', true); ?>">
                        <a href="<?= url_to('students.list', 4); ?>" class="menu-link">
                            <div>4th Year</div>
                        </a>
                    </li>
                </ul>
            </li>
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