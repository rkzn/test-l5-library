<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('id', 'desc')->paginate();
        return view('books.index', compact('books'));
    }

    public function show($id)
    {
        $book = Book::where('id', $id)->firstOrFail();
        return view('books.show', compact('book'));
    }

    public function create()
    {
        return view('books.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'isbn' => 'required|max:13',
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            'pub_year' => 'required|max:4',
        ]);

        Book::create($request->all());
        return redirect('books');
    }

    public function edit($id)
    {
        $book = Book::where('id', $id)->firstOrFail();
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::where('id', $id)->firstOrFail();
        $book->update($request->all());
        return redirect('books');
    }

    public function destroy($id)
    {
        Book::where('id', $id)->delete();
        return redirect('books');
    }
}
