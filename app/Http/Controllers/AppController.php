<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MenusRepository;
use Illuminate\Support\Facades\Config;
use Menu;

class AppController extends Controller
{

    protected $p_rep; // Portfolio
    protected $s_rep; // Sliders
    protected $a_rep; // Articles
    protected $m_rep; // Menus

    protected $template;

    protected $title;
    protected $keywords;
    protected $meta_description;

    protected $vars;

    protected $sidebar = 'no';
    protected $contentLeftBar = FALSE;
    protected $contentRightBar = FALSE;

    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput()
    {

        $this->vars['title'] = $this->title;
        $this->vars['keywords'] = $this->keywords;
        $this->vars['meta_description'] = $this->meta_description;

        $menu = $this->getMenu();

        $this->vars['navigation'] = view(env('THEME').'.navigation')->with('menu', $menu)->render();

        if ($this->contentRightBar)
        {
            $right_bar = view(env('THEME').'.right_sidebar')->with('content_right_bar', $this->contentRightBar)->render();
            $this->vars['right_bar'] = $right_bar;
        }

        if($this->contentLeftBar)
        {
            $left_bar = view(env('THEME').'.left_bar')->with('content_left_bar',$this->contentLeftBar)->render();
            $this->vars['left_bar'] = $left_bar;
        }

        $this->vars['sidebar'] = $this->sidebar;

        $footer = view(env('THEME').'.footer')->render();
        $this->vars['footer'] = $footer;

        return view($this->template)->with($this->vars);
    }

    protected function getMenu()
    {
        $menu = $this->m_rep->get();

        $mBuilder = Menu::make('MyNav', function($m) use ($menu) 
        {
			
            foreach($menu as $item) 
            {
                $item->path = env('APP_URL').$item->path;
				
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
