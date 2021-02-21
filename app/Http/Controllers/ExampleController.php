<?php

namespace App\Http\Controllers;

use App\Models\Produto;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getWelcome() 
    {
        return app()->version();
    }
    
    public function getTeste()
    {
        $produto = Produto::create([
            'controleexterno' => 123,
            'nome' => 'Toalha de banho'
        ]);

        dd($produto);
    }

}
