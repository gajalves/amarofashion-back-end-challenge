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

    public function getProdutoByControleExterno(Int $controleexterno) 
    {
        $produto = Produto::with('tags')->where('controleexterno', '=', $controleexterno)->get();

        return response()->json($produto);
    }

    public function postProdutos(Request $request) 
    {
        $this->validate($request, [
            'produtos' => 'required|mimes:json,xml'
        ]);

        try 
        {
            $result = $this->repository->criaProdutos($request->file('produtos'));
        }
        catch (\Exception $ex)
        {
            return response()->json(['deu ruim'], 422);
        }
        return response()->json(['ok'], 201);
    }
    
    public function postProduto(Request $request) 
    {        
        $this->validate($request, [
            'controleexterno' => 'required|int|unique:produtos',
            'nome' => 'required|string',
            'tags.*' => 'required'
        ]);

        $result = $this->repository->criaProduto($request->only(['controleexterno', 'nome', 'tags']));
        
        return response()->json($result, 201);                
    }

    public function putProduto(Request $request, int $controleexterno) 
    {
        $request->merge(['controleexterno' => $controleexterno]);

        $this->validate($request, [
            'controleexterno' => 'required|exists:produtos'
        ]);

        $result = $this->repository->updateProduto($controleexterno, $request->all());

        return response()->json($result);
    }

    public function deleteProduto(Request $request, int $controleexterno) 
    {
        $request->merge(['controleexterno' => $controleexterno]);

        $this->validate($request, [
            'controleexterno' => 'required|exists:produtos'
        ]);

        $this->repository->deleteProduto($controleexterno);

        return response()->json(['ok']);
    }
}
