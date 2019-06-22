<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class IndexController extends AdminController
{

    public function __construct()
    {
        parent::__construct();

        $this->template = config('settings.theme').'.admin.index';
    }

    public function index()
    {
        if (Gate::denies('VIEW_ADMIN'))
        {
            abort(403);
        }

        $this->title = Lang::get('admin.admin_index_title');

        return $this->renderOutput();

    }
}
