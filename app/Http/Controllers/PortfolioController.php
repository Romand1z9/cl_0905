<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Repositories\PortfoliosRepository;

class PortfolioController extends AppController
{
    public function __construct(PortfoliosRepository $p_rep)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu));

        $this->p_rep = $p_rep;
        $this->template = env('THEME').'.portfolios';

    }

    public function index()
    {
        //
        $this->title = 'Портфолио';
        $this->keywords = 'Портфолио';
        $this->meta_desc = 'Портфолио';

        $portfolios = $this->getPortfolios();

        $content = view(env('THEME').'.portfolios_content')->with('portfolios',$portfolios)->render();
        $this->vars['content'] = $content;

        return $this->renderOutput();
    }

    public function getPortfolios()
    {
        $portfolios = $this->p_rep->get('*',FALSE,TRUE);
        if($portfolios)
        {
            $portfolios->load('filter');
        }

        return $portfolios;
    }
}
