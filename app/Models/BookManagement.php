<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//class Book extends Model
class bookManagement extends Model
{
    use HasFactory;
   // protected $table='book';
    protected $primaryKey = 'bookId';
    protected $fillable=[
        'bookName',
        'bookAuthor',
        'bookDetails',
        'bookPrice',
        'bookQty',
        'bookImage',
    ];
}
