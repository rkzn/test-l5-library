<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\VarDumper\VarDumper;

class BooksController extends Controller
{
    protected $validateRules = [
        'isbn'             => 'required|max:13|min:10',
        'title'            => 'required|max:255',
        'publisher'         => 'required|max:255',
        'pub_year'         => 'required|max:4|min:4',
        'image_url_small'  => 'nullable|url',
        'image_url_medium' => 'nullable|url',
        'image_url_large'  => 'nullable|url',
    ];

    public function __construct()
     {
//         $this->authorizeResource(Book::class);
         $this->middleware('auth');
     }

    public function index()
    {
        $books = Book::orderBy('id', 'desc')->paginate();
        return view('books.book_list', compact('books'));
    }

    public function authors()
    {
        // Отвратительно строит запрос (не отрабатывает по времени)!
        // $authors = Author::withCount('books')->orderBy('books_count', 'desc')->paginate();

        // Придется вручную сортировать авторов по количеству книг
        $authors = DB::table('book_authors')
            ->join('authors', 'authors.id', '=', 'book_authors.author_id')
            ->select(DB::raw('authors.*, count(*) as books_count'))
            ->groupBy('book_authors.author_id')
            ->orderBy('books_count', 'desc')
            ->paginate();

        return view('books.authors', compact('authors'));
    }

    public function author($id)
    {
        $author = Author::where('id', $id)->firstOrFail();
        $books = $author->books()->paginate();
        return view('books.author_books', compact('books', 'author'));
    }

    public function show($id)
    {
        $book = Book::where('id', $id)->firstOrFail();
        return view('books.book_show', compact('book'));
    }

    public function create()
    {
        return view('books.form_add');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules);

        Book::create($request->all());
        Session::flash('flash_message', 'Book successfully added!');
        return redirect('books');
    }

    public function edit($id)
    {
        $book = Book::where('id', $id)->firstOrFail();
        return view('books.form_edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validateRules);
        $book = Book::where('id', $id)->firstOrFail();
        $book->update($request->all());
        Session::flash('flash_message', 'Book successfully updated!');
        return redirect('books');
    }

    public function destroy($id)
    {
        Book::where('id', $id)->delete();
        Session::flash('flash_message', 'Book successfully deleted!');
        return redirect('books');
    }
}
