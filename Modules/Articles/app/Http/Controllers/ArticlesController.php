<?php

namespace Modules\Articles\Http\Controllers;

use App\Http\Controllers\Controller;
use DOMDocument;
use Illuminate\Http\Request;
use Modules\Articles\Models\Article;
use Modules\Articles\Models\Category;
use Illuminate\Support\Str;

class ArticlesController extends Controller
{
    public function index()
    {
        return view('articles::articles.index', [
            'articles' => Article::with('categories', 'author')
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }

    public function publicIndex()
    {
        return view('articles::public.index', [
            'articles' => Article::with('categories', 'author')
                ->orderBy('created_at', 'desc')
                ->where('published', 1)
                ->get(),
        ]);
    }

    public function create()
    {
        return view('articles::articles.create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255', 'unique:articles,title'],
            'content' => ['required', 'string'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'exists:categories,id'],
            'publication' => ['nullable'],
        ]);

        try {
            $dom = new DOMDocument();
            @$dom->loadHTML($validated['content']);
            $images = $dom->getElementsByTagName('img');

            if ($images->length > 0) {
                $imageSrc = $images->item(0)->getAttribute('src');
            } else {
                $imageSrc = null;
            }

            $article = Article::create([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'content' => $validated['content'],
                'image' => $imageSrc,
                'published' => isset($validated['publication']),
            ]);

            $article->categories()->attach($validated['categories']);
            $article->author()->associate(auth()->user());
            $article->save();

            return redirect(route('articles.index'))->with('success', 'Artikel is aangemaakt!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        return view('articles::show');
    }

    public function publicShow($slug)
    {
        return view('articles::public.show', [
            'article' => Article::with('categories', 'author')->where('slug', $slug)->first(),
        ]);
    }

    public function edit(int $id)
    {
        return view('articles::articles.edit', [
            'article' => Article::with('categories', 'author')->findOrFail($id),
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'content' => ['required', 'string'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'exists:categories,id'],
            'publication' => ['nullable'],
        ]);

        try {
            $article = Article::find($id);

            $article->update([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'content' => $validated['content'],
                'published' => isset($validated['publication']),
            ]);

            $article->categories()->detach();
            $article->categories()->attach($validated['categories']);

            $article->save();

            return redirect(route('articles.index'))->with('success', 'Artikel is aangepast!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function destroy(int $id)
    {
        try {
            $article = Article::with('categories', 'author')->findOrFail($id);
            $article->categories()->detach();
            $article->delete();

            return redirect(route('articles.index'))->with('success', 'Artikel is verwijderd!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }


    }
}
