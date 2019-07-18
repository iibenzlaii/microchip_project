<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ManageArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::paginate(20);

        return view('manage_articles.index',compact('articles'))->with('i', (request()->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage_articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'article_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasfile('article_image')){
            $image_name = time().'.'.request()->article_image->getClientOriginalExtension();
            request()->article_image->move(public_path('image/articles'), $image_name);
            $article = new Article([
                'article_name' => $request->article_name,
                'article_content' => $request->article_content,
                'article_image' => $image_name,
            ]);
            $article->save();
        }
        else {
            $article = new Article([
                'article_name' => $request->article_name,
                'article_content' => $request->article_content,
            ]);
            $article->save();
        }

        return redirect()->route('manage_articles.index')->with('success','เพิ่มบทความแล้ว');
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
        $article = Article::find($id);

        return view('manage_articles.edit',compact('article'));                
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
        request()->validate([
            'article_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasfile('article_image')){
            $image_name = time().'.'.request()->article_image->getClientOriginalExtension();
            request()->article_image->move(public_path('image/articles'), $image_name);

            $article = Article::find($id);
            $article->article_name = $request->article_name;
            $article->article_content = $request->article_content;
            $article->article_image = $image_name; 
            $article->save();
        }
        else {
            $article = Article::find($id);
            $article->article_name = $request->article_name;
            $article->article_content = $request->article_content;
            $article->save();
        }
        
        return redirect()->route('manage_articles.index')-> with('success','แก้ไขบทความแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();

        return redirect()->route('manage_articles.index')->with('success','ลบบทความแล้ว');
    }
}
