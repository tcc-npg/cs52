<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class NewAccountFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (is_null(auth()->user()->getUserDetails()->user_id)) {
            return redirect()->route('profile.index');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
