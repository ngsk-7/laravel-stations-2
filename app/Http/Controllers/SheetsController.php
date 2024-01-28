<?php

namespace App\Http\Controllers;

// use App\Models\Movie;
// use App\Models\Genre;
// use App\Http\Requests\CreateMovieRequest;
// use App\Http\Requests\UpdateMovieRequest;
use App\Models\Sheets;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class SheetsController extends Controller
{
    public function index(){
        $sheets = DB::table('sheets')->get();
        return view('getSheets',['sheets'=>$sheets]);
    }
}