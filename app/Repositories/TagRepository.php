<?php


namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Http\UploadedFile;

class TagRepository 
{
    private $model;

    public function __construct()
    {
        $this->model = new Tag();
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

