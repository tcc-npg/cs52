<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class NewAccountFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!(auth()->user()->isProfileComplete())) {
            return redirect()->route('user.index');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
