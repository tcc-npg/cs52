<?php
function showToast(string $msg, string $type = 'success', string $header = 'Success', string $icon = 'bxs-check-circle'): string
{
    return sprintf(
        '<div
                    class="bs-toast toast bg-%s fade toast-placement-ex m-2 top-0 start-50 translate-middle-x"
                    role="alert"
                    aria-live="assertive"
                    aria-atomic="true"
                    data-delay="2000"
                    id="update_successful_toast"
                >
                <div class="toast-header">
                    <i class="bx %s"></i>
                    <div class="me-auto fw-semibold">&nbsp;%s</div>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                    <div class="toast-body">%s</div>
                </div>',
        $type, $icon, $header, $msg
    );
}