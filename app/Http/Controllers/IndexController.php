<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SlidersRepository;

use Config;

class IndexController extends AppController
{

    public function __construct(SlidersRepository $slider)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu()));

        $this->s_rep = $slider;
        
        $this->bar = 'right';
        $this->template = env('THEME').'.index';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = $this->getSlides();
        
        $slider = view(env('THEME').'.slider')->with('slides', $slides)->render();
        
        $this->vars['slider'] = $slider;
        //var_dump(htmlspecialchars($slider)); die;
        
        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function getSlides()
    {
        $slides = $this->s_rep->get();
        
        if($slides->isEmpty()) 
        {
            return FALSE;
	}
		
        $slides->transform(function($item,$key) 
        {
            $item->img = Config::get('settings.slider_path').'/'.$item->img;
            return $item;

        });
    	
    	return $slides;
    }
    
}
