<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'tes',
        ];
        return view('Layout/index', $data);
    }
}
