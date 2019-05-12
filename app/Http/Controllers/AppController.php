<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MenusRepository;
use Menu;

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

        $menu = $this->getMenu();

        $this->vars['navigation'] = view(env('THEME').'.navigation')->with('menu', $menu)->render();

        return view($this->template)->with($this->vars);
    }

    protected function getMenu()
    {
        $menu = $this->m_rep->get();

        $mBuilder = Menu::make('MyNav', function($m) use ($menu) 
        {
			
            foreach($menu as $item) 
            {
				
                if($item->parent == 0) 
                {
					$m->add($item->title,$item->path)->id($item->id);
				}
                else 
                {
                    if($m->find($item->parent))
                    {
						$m->find($item->parent)->add($item->title,$item->path)->id($item->id);
					}
				}
			}
			
		});

        return $mBuilder;
        
    }

}
