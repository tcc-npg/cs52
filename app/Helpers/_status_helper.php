<?php
function getPaymentStatus($status): string
{
    $s = is_null($status) ? 'No record' : constant("App\Enums\Status::$status")->value;
    $c = is_null($status) ? 'secondary' : ($status === 'p' ? 'success' : 'primary');
    
    return "<span class=\"badge bg-label-$c me-1\">$s</span>";
}

