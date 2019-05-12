<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\MenusRepository;

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

    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput()
    {
        return view($this->template)->with($this->vars);
    }

    protected function getMenu()
    {
        $menu = $this->m_rep->get();

        return $menu;
        
    }

}
