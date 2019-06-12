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

    protected $admin;

    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            $this->admin = Auth::user();
            return $next($request);
        });

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
            $menu->add(Lang::get('admin.admin_menu_items_articles'), array('route' => 'articles.index'));
            $menu->add(Lang::get('admin.admin_menu_items_portfolio'), array('route' => 'articles.index'));
            $menu->add(Lang::get('admin.admin_menu_items_menu'), array('route' => 'articles.index'));
            $menu->add(Lang::get('admin.admin_menu_items_users'), array('route' => 'articles.index'));
            $menu->add(Lang::get('admin.admin_menu_items_permissions'), array('route' => 'articles.index'));
        });
    }

}
