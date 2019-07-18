<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Home;
use App\About;
use App\Contact;
use App\Article;
use App\Dog;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $home = Home::first();
        $contact = Contact::first();
        $articles = Article::latest()->paginate(4);
        $dogs1 = Dog::inRandomOrder()->whereNotNull('dog_image')->paginate(4);
        $dogs2 = Dog::inRandomOrder()->whereNotNull('dog_image')->paginate(4);

        return view('home',compact('home','contact','articles','dogs1','dogs2'));
    }

    public function view_about_us()
    {
        $about = About::first();

        return view('about_us',compact('about'));
    }

    public function view_contact_us()
    {
        $contact = Contact::first();
        return view('contact_us',compact('contact'));
    }

    public function view_articles()
    {
        $articles = Article::latest()->paginate(12);
        return view('articles', compact('articles'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
