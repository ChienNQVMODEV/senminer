<?php

namespace App\Http\Controllers;

use App\Http\Resources\ComicHome;
use App\Http\Resources\ComicDetail;
use App\Models\Chapter;
use App\Models\Comic;
use Illuminate\Http\Request;

class ComicController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getListComics(Request $request)
    {
        $comics = Comic::orderBy('updated_at', 'DESC')->paginate(10);
        return $this->responseSuccess(ComicHome::collection($comics));
    }

    public function getDetailComic(Request $request)
    {
        $comic = Comic::find($request->id);
        return $this->responseSuccess(new ComicDetail($comic));
    }

    public function getDetailChapter(Request $request)
    {
        $chapter = Chapter::find($request->id);
        // $array = (array) $chapter->content;
        // dd($chapter->content);
        return $this->responseSuccess($chapter);
    }
}
