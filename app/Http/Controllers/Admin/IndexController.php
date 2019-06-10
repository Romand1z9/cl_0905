<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;

class IndexController extends AdminController
{

    public function __construct()
    {
        parent::__construct();

        $this->template = env('THEME').'.admin.index';
    }

    public function index()
    {
        $this->title = Lang::get('admin_index_title');

        return $this->renderOutput();

    }
}
