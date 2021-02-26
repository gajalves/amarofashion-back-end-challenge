<?php


namespace App\Repositories;

use App\Models\Produto;
use App\Models\Tag;
use Illuminate\Http\UploadedFile;

class ProdutoRepository 
{
    private $model;

    public function __construct()
    {
        $this->model = new Produto();
    }   

    public function criaProduto(UploadedFile $file) : array
    {
        $mime = $file->getClientOriginalExtension();
        
        if ($mime == "json") 
        {
            return $this->handleJsonData($file);
        }
        else if ($mime == "xml") 
        {
            return $this->handleXMlData($file);
        }
        else 
        {
            throw new \Exception();
        }
        
    }

    public function handleJsonData(UploadedFile $file) : array
    {
        $produtos = json_decode($file->get(), true)['products'];
        //dd($produtos);
        foreach($produtos as $produto) 
        {            
            $produtoExiste = $this->model->where('controleexterno', $produto['id'])->first();

            if ($produtoExiste) 
            {
                continue;
            }

           $model = $this->model->create([
                'nome' => $produto['name'],
                'controleexterno' => $produto['id']
            ]);

            
            $tagsIds = $this->getTagsId($produto['tags']);            
            $model->tags()->sync($tagsIds);
            
        }
        
        return [];
    }

    public function handleXMLData() : array
    {
        return [];
    }

    public function getTagsId(array $tagNames) : array 
    {
        $result = [];
        foreach($tagNames as $tag) 
        {
            $model = Tag::where('nome', $tag)->first();

            if ($model) 
            {
                $result[] = $model->id;
                continue;
            }
            else 
            {
                $model = Tag::create([
                    'nome' => $tag
                ]);

                //validar o model de criação


                $result[] = $model->id;
            }
        }

        return $result;
    }
}

