<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Resources\article as ArticleResource;
use App\Http\Requests;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Some Articles
        $articles = Article::paginate(15);
        
        // Return collection of Articles as a resource
        return ArticleResource::collection($articles);
    }

   

    public function store(Request $request)
    {
        $article = $request->isMethod('put') ? Article::findOrFail($request->article_id) : new Article;
        $article_id = $request->input('article_id');
        $article_title = $request->input('title');
        $article_body = $request->input('body');

        if($article->save()){
            return new ArticleResource($article);
        }
    }

   
    public function show($id)
    {
        // Get A Single Article
        $article = Article::findOrFail($id);
        // return the single article as a resource
        return new ArticleResource($article);
    }

    public function destroy($id)
    {
        // Get A Single Article
        $article = Article::findOrFail($id);
        if($article->delete()){
            return new ArticleResource($article);
        }   
        
    }
}
