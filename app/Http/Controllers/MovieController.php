<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use function Psy\debug;

class MovieController extends Controller
{
    public function index(Request $request){
        $keyword = $request->query('keyword');
        $isShowing = $request->query('is_showing');
        $moviesQuery = Movie::query();
        if(!empty($keyword)){
            $moviesQuery->where('title','like',"%$keyword%")
            ->orWhere('description','like',"%$keyword%");
        }
        if(isset($isShowing) && ($isShowing == 0 || $isShowing == 1)){
            $moviesQuery->where('is_showing',$isShowing);
        }
        // $moviesQuery->paginate(20);
        $movies = $moviesQuery->orderBy('id')->paginate(20);
        return view('getMovie',['movies'=>$movies]);
    }
    public function create(){
        $movies = Movie::all();
        return view('createMovie');
    }
    public function edit($id){
        $movies = Movie::where('id',$id)->get();
        return view('editMovie',['movies'=>$movies]);
    }
    public function store(UpdateMovieRequest $request){

        $movieData = new Movie;

        //ユーザーの保存
        $movieData->fill([
            $movieData->title = $request->input('title'),
            $movieData->image_url = $request->input('image_url'),
            $movieData->published_year = $request->input('published_year'),
            $movieData->is_showing = $request->input('is_showing'),
            $movieData->description = $request->input('description'),
        ])->save();

        return redirect(route('admin.movies'));

    }
    public function update(UpdateMovieRequest $request){
        $id = $request->id;

        $movieData = Movie::find($id);

        //ユーザーの保存
        $movieData->fill([
            $movieData->title = $request->input('title'),
            $movieData->image_url = $request->input('image_url'),
            $movieData->published_year = $request->input('published_year'),
            $movieData->is_showing = $request->input('is_showing'),
            $movieData->description = $request->input('description'),
        ])->save();

        return redirect(route('admin.movies'));

    }
    public function destroy($id){
        $movieData = Movie::find($id);
        $movieDataExists = Movie::where('id',$id)->exists();
        if($movieDataExists){
            $movieData->delete();
        }else{
            abort(404);
        }
        return redirect(route('admin.movies'));
    }
}