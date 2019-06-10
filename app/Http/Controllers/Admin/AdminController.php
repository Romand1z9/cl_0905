<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Menu;

class AdminController extends Controller
{
    protected $p_rep;

    protected $a_rep;

    protected $user;

    protected $template;

    protected $content = FALSE;

    protected $title;

    protected $vars;

    public function __construct()
    {
        $this->user = Auth::user();

        if(!$this->user)
        {
            //abort(403);
        }
    }

    public function renderOutput()
    {
        $this->vars['title'] = $this->title;

        $menu = $this->getMenu();

        $navigation = view(env('THEME').'.admin.navigation')->with('menu',$menu)->render();
        $this->vars['navigation'] = $navigation;

        if($this->content)
        {
            $this->vars['content'] = $this->content;
        }

        $footer = view(env('THEME').'.admin.footer')->render();
        $this->vars['footer'] = $footer;

        return view($this->template)->with($this->vars);
    }

    public function getMenu()
    {
        return Menu::make('adminMenu', function($menu)
        {
            $menu->add(Lang::get('admin_menu_items_articles'), array('route' => 'admin.articles.index'));
            $menu->add(Lang::get('admin_menu_items_portfolio'),  array('route'  => 'admin.articles.index'));
            $menu->add(Lang::get('admin_menu_items_menu'),  array('route'  => 'admin.articles.index'));
            $menu->add(Lang::get('admin_menu_items_users'),  array('route'  => 'admin.articles.index'));
            $menu->add(Lang::get('admin_menu_items_permissions'),  array('route'  => 'admin.articles.index'));
        });
    }

}
