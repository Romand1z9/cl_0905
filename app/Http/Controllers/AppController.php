<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{

    protected $p_rep; // Portfolio
    protected $s_rep; // Sliders
    protected $a_rep; // Articles
    protected $m_rep; // Menus

    protected $template;

    protected $vars;

    protected $bar = FALSE;
    protected $contentLeftBar = FALSE;
    protected $contentRightBar = FALSE;

    public function __construct()
    {
        
    }

    protected function renderOutput()
    {
        return view($this->template)->with($this->vars);
    }

}
