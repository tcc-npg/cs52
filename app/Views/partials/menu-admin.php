<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Site Administration</span>
</li>
<li class="menu-item <?= is_active_menu('settings', true); ?>">
    <a href="<?= url_to('settings.index'); ?>" class="menu-link">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div>Settings</div>
    </a>
</li>