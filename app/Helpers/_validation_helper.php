<?php
function is_active_menu(string $currentPage, bool $isSub = false): string
{
    $class = $isSub ? 'active' : 'open';
    return url_is($currentPage) ? $class : '';
}

function isRegistrationAllowed(): bool {
    return (model(\App\Models\SettingsModel::class))->findByKey('registration_enabled')->value == 1;
}

