<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Repositories\ProdutoRepository;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\This;

class ProdutoController extends Controller
{
    private $repository;

    public function __construct(ProdutoRepository $repository)
    {
        $this->repository = $repository;
    }
     
    public function getProdutos() 
    {
        $produto = Produto::with('tags')->paginate(15);

        return response()->json($produto);
    }

    public function postProdutos(Request $request) 
    {
        $this->validate($request, [
            'produtos' => 'required|mimes:json,xml'
        ]);

        $result = $this->repository->criaProduto($request->file('produtos'));
        return response()->json(['ok'], 201);
    }
}
