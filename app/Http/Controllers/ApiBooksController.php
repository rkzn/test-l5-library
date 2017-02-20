<?php

namespace App\Http\Controllers;

use App\Book;

/**
 * Class ApiBooksController
 *
 * @package App\Http\Controllers
 */
class ApiBooksController extends Controller
{
    /**
     * ApiBooksController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'index',
                'show',
            ],
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        $books = Book::orderBy('id', 'desc')->paginate();
        return $books;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $book = Book::with('authors')->where('id', $id)->firstOrFail();
        return $book;
    }
}
