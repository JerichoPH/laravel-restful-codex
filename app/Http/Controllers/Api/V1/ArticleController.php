<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Serializers\ArticleSerializer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use jericho\LaravelRestfulCodex\Serializers\Serializer;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    final public function index(): JsonResponse
    {
        Article::with([])->first();
        // article_category_name
        $article_serializer = new ArticleSerializer(Article::class, 'search');
        $articles = $article_serializer
            ->getBuilder()
            ->setFilterExcepts(['article_title',])
            ->extension(function ($builder) {
                $builder->where('id', 2);
            })
            ->first();

        return response()->json($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    final public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    final public function store(Request $request)
    {
        $article_serializer = new ArticleSerializer(Article::class, 'search');
        $article_serializer
            ->getBuilder()
            ->extension(function($query){

            });
        $articles = $article_serializer->saveOrFail();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    final public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    final public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    final public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    final public function destroy($id)
    {
        //
    }
}
