<?php

function redirectBackWithToast(string $updateSuccessMessage, string $toastColor, string $toastHeader, string $toastIcon): CodeIgniter\HTTP\RedirectResponse
{
    return redirect()->back()->withInput()
        ->with('update_successful', $updateSuccessMessage)
        ->with('toast_color', $toastColor)
        ->with('toast_icon', $toastIcon)
        ->with('toast_header', $toastHeader);
}