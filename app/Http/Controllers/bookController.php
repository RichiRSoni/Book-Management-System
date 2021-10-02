<?php

namespace App\Http\Controllers;

use App\Models\BookManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class bookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookarray = bookManagement::all();

        return view('book.index', compact('bookarray'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'bookName' => ['required', 'string', 'min:3', 'max:255'],
            'bookAuthor' => ['required', 'string', 'min:3', 'max:255'],
            'bookDetails' => ['required', 'string', 'min:3', 'max:255'],
            'bookPrice' => 'required|integer',
            'bookQty' => 'required|integer',
            'bookImage' => 'required|mimes:jpeg,jpg,png',
        ]);
        //get file data using file
        $file123 = $request->file('bookImage');
        //File in-built function to
        $extension = $file123->getClientOriginalExtension();
        $mimetype = $file123->getClientMimeType();
        $getfilename = $file123->getFilename();

        // we will use original name to file upload
        $original_filename = $file123->getClientOriginalName();

        //upload file in folder
        Storage::disk('public')->put($original_filename, File::get($file123));

        $bookq = new bookManagement([
            'bookName' => $request->get('bookName'),
            'bookAuthor' => $request->get('bookAuthor'),
            'bookDetails' => $request->get('bookDetails'),
            'bookPrice' => $request->get('bookPrice'),
            'bookQty' => $request->get('bookQty'),
            'bookImage' => $original_filename,
        ]);

        $bookq->save();

        return redirect('/admin/book/create')->with('success', 'Book is added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bookarray = bookManagement::where('bookId', $id)->first();

        return view('book.edit', compact('bookarray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'bookName' => ['required', 'string', 'min:3', 'max:255'],
            'bookAuthor' => ['required', 'string', 'min:3', 'max:255'],
            'bookDetails' => ['required', 'string', 'min:3', 'max:255'],
            'bookPrice' => 'required|integer',
            'bookQty' => 'required|integer',
            'bookImage' => 'required|mimes:jpeg,jpg,png',
        ]);

        $bookarray = bookManagement:: where('bookId', $id)->first();

        if ($request->hasFile('bookImage')) {
            $file123 = $request->file('bookImage');
            $filename = $file123->getClientOriginalName();
            $file123->move(public_path('images'), $filename);
            $bookarray->bookImage = $request->file('bookImage')->getClientOriginalName();
        }
        $bookarray->bookName = $request->get('bookName');
        $bookarray->bookAuthor = $request->get('bookAuthor');
        $bookarray->bookDetails = $request->get('bookDetails');
        $bookarray->bookPrice = $request->get('bookPrice');
        $bookarray->bookQty = $request->get('bookQty');
        //$bookarray->bookImage=$original_filename;

        $bookarray->save();

        return redirect('/admin/book')->with('success', 'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = bookManagement::find($id);
        $book->delete();

        return redirect('/admin/book')->with('success', 'category deleted successfully');
    }
}
