<?php

namespace App\Http\Controllers;

use App\Support\Seo\RobotsTxt;
use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(RobotsTxt $robots): Response
    {
        return response($robots->render(), 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
