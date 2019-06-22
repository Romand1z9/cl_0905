<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Repositories\PortfoliosRepository;

use Illuminate\Support\Facades\Lang;

class PortfolioController extends AppController
{
    public function __construct(PortfoliosRepository $p_rep)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu));

        $this->p_rep = $p_rep;
        $this->template = config('settings.theme').'.portfolios';

    }

    public function index()
    {
        //
        $this->title = Lang::get('portfolios.title');
        $this->keywords = Lang::get('portfolios.title');
        $this->meta_description = Lang::get('portfolios.title');

        $portfolios = $this->getPortfolios();

        $content = view(config('settings.theme').'.portfolios_content')->with('portfolios',$portfolios)->render();
        $this->vars['content'] = $content;

        return $this->renderOutput();
    }

    public function show($alias)
    {
        $portfolio = $this->p_rep->one($alias);
        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), FALSE);

        $this->title = $portfolio->title;
        $this->keywords = $portfolio->keywords;
        $this->meta_desc = $portfolio->meta_desc;

        $content = view(config('settings.theme').'.portfolio_content')->with(['portfolio' => $portfolio,'portfolios' => $portfolios])->render();
        $this->vars['content'] = $content;

        return $this->renderOutput();
    }

    public function getPortfolios($take = FALSE, $paginate = TRUE)
    {
        $portfolios = $this->p_rep->get('*', $take, $paginate);

        if($portfolios)
        {
            $portfolios->load('filter');
        }

        return $portfolios;
    }
}
