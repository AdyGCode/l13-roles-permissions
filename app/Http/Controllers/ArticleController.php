<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Routing\Attributes\Controllers\Middleware;

#[Middleware('auth')]
#[Middleware('permission:article-view')]
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $articles = Article::with('user')->latest()->paginate(10);

        //        return view('articles.index', compact('articles'));
        return view('articles.index')
            ->with('articles', $articles);
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Middleware('permission:article-create')]
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Middleware('permission:article-create')]
    public function store(StoreArticleRequest $request)
    {
        $validated = $request->validated();
        $article = Article::create($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('articles.show')
            ->with('article', $article);
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Middleware('permission:article-edit')]
    public function edit(Article $article)
    {
        return view('articles.edit')
            ->with('article', $article);
    }

    /**
     * Update the specified resource in storage.
     */
    #[Middleware('permission:article-edit')]
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $validated = $request->validated();
        $article->update($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Middleware('permission:article-delete')]
    public function destroy(Article $article)
    {
        // BEWARE NO CONFIRM THE DELETE
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}
