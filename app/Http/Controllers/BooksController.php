<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

/**
 * Class BooksController
 *
 * @package App\Http\Controllers
 */
class BooksController extends Controller
{
    /**
     * @var array
     */
    protected $validateRules = [
        'isbn'             => 'required|max:13|min:10',
        'title'            => 'required|max:255',
        'publisher'        => 'nullable|max:255',
        'pub_year'         => 'nullable|max:4|min:4',
        'image_url_small'  => 'nullable|url',
        'image_url_medium' => 'nullable|url',
        'image_url_large'  => 'nullable|url',
    ];

    /**
     * BooksController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'index',
                'show',
                'authors',
                'author',
            ],
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $books = Book::orderBy('id', 'desc')->paginate();
        return view('books.book_list', compact('books'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function authors()
    {
        $authors = $this->getAuthors(25);

        return view('books.authors', compact('authors'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function authorsForm($id)
    {
        $book = Book::where('id', $id)->firstOrFail();
        $authors = $this->getAuthors();

        return view('books.form_authors', compact('authors', 'book'));
    }

    /**
     * @param int  $perPage
     * @param null $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function getAuthors($perPage = 15, $page = null)
    {
        // Отвратительно строит запрос (не отрабатывает по времени)!
        // $authors = Author::withCount('books')->orderBy('books_count', 'desc')->paginate();

        // Придется вручную сортировать авторов по количеству книг
        return DB::table('book_authors')
            ->join('authors', 'authors.id', '=', 'book_authors.author_id')
            ->select(DB::raw('authors.*, count(*) as books_count'))
            ->groupBy('book_authors.author_id')
            ->orderBy('books_count', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attachAuthors($id)
    {
        $book = Book::where('id', $id)->firstOrFail();

        $book->authors()->detach(explode(',', Input::get('exclude')));
        $book->authors()->sync(Input::get('authors', []), false);

        return $this->bookAuthors($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bookAuthors($id)
    {
        $book = Book::where('id', $id)->firstOrFail();
        $authors = $this->getAuthors(10);
        $authors->withPath(route('books.book_authors', $id));
        $authors->appends(['page' => Input::get('page', 1)]);
        return view('books.form_authors', compact('book', 'authors'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function author($id)
    {
        $author = Author::where('id', $id)->firstOrFail();
        $books = $author->books()->paginate();
        return view('books.author_books', compact('books', 'author'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $book = Book::where('id', $id)->firstOrFail();
        return view('books.book_show', compact('book'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('books.form_add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules);

        Book::create($request->all());
        Session::flash('flash_message', 'Book successfully added!');
        return redirect('books');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $book = Book::where('id', $id)->firstOrFail();
        $authors = $this->getAuthors(10);
        $authors->withPath(route('books.book_authors', $id));
        $authors->appends(['page' => Input::get('page', 1)]);
        return view('books.form_edit', compact('book', 'authors'));
    }

    /**
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validateRules);
        $book = Book::where('id', $id)->firstOrFail();
        $book->update($request->all());
        Session::flash('flash_message', 'Book successfully updated!');
        return redirect('books');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Book::where('id', $id)->delete();
        Session::flash('flash_message', 'Book successfully deleted!');
        return redirect('books');
    }
}
