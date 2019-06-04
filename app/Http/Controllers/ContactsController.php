<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ContactsController extends AppController
{
    public function __construct()
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu));

        $this->bar = 'left';

        $this->template = env('THEME').'.contacts';

    }

    public function index(Request $request)
    {
        /*if ($request->isMethod('post'))
        {

            $messages = [
                'required' => 'Поле :attribute Обязательно к заполнению',
                'email'    => 'Поле :attribute должно содержать правильный email адрес',
            ];

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'
            ],$messages);

            $data = $request->all();

            $result = Mail::send(env('THEME').'.email', ['data' => $data], function ($m) use ($data) {
                $mail_admin = env('MAIL_ADMIN');

                $m->from($data['email'], $data['name']);

                $m->to($mail_admin, 'Mr. Admin')->subject('Question');
            });

            if($result)
            {
                return redirect()->route('contacts')->with('status', 'Email is send');
            }

        }*/

        $this->title = Lang::get('contacts.title');

        $content = view(env('THEME').'.contact_content')->render();
        $this->vars['content'] = $content;

        $this->contentLeftBar = view(env('THEME').'.contact_sidebar')->render();

        return $this->renderOutput();
    }

}
