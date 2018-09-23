<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Genre;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Comment;
use Webpatser\Uuid\Uuid;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\File;

class FilmController extends Controller
{
    public function __construct()
    {
        $this->user =  Auth::user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            Log::info('- [Film] Listing data...');
            $films = Film::with('user')->get();
            foreach ($films as $key => &$value) {
                $value->storage_path = \Storage::disk('local')->url('images/'.$value->photo);
            }
            return response()->json(['films' => $films, 'code' => 200]);
        } catch (\Exception $e) {
            Log::error('[Film] error ' . $e->getMessage());
            return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();

            Log::info('- [Film] saving film...');

            //*validate fields
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'release_date' => 'required',
                'rating' => 'required|numeric',
                'ticket_price' => 'required|numeric',
                'genres' => 'required',
                'country' => 'required',
                'photo' => 'required'
            ]);

            if ($validator->fails()) {
                //!Validator fails
                return response()->json(['code' => 400, 'message' => $validator->errors()]);
            }

            $film_data = $request->all();
        
            //* get slug from name
            $film_data['slug'] = strtolower(str_replace(" ", "-", $film_data['name']));
        
            $film_data['user_id'] = $this->user->id;
            $film_data['uuid'] = Uuid::generate(4)->string;
            $film_data['release_date'] = Carbon::parse($film_data['release_date'])->format('Y-m-d');

            if (isset($request->photo)) {
                //get photo
                $upload_file = $request->file('photo');
                $upload_image = $this->uploadPhoto($request);
                $imageName = $upload_image->filename;
                $film_data['photo'] = $imageName;
            }

            //*get films
            $genres = [];
            if (isset($request->genres)) {
                foreach ($request->genres as $film_genre) {
                    $genres[] = $film_genre;
                }
            }
            //* storing data
            $film = Film::create($film_data);
            //* sync with many to many relation
            $film->genres()->sync($genres);

            \DB::commit();

            Log::info('- [Film] film saved...');
            return response()->json(['code' => 200, 'message' => 'Successfully created']);
        } catch (\Exception $e) {
            \DB::rollback();
            Log::error('[Film] error ' . $e->getMessage());
            return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            Log::info('- [Film] film '.$slug.' show');
            $film = Film::where('slug', $slug)->first();
            $film['genres'] = "";
            if ($film->genres()->get()->count()) {
                foreach ($film->genres()->get() as $genre) {
                    $genres[] = $genre->name;
                }
                $film['genres'] =  $genres;
            }
            $film->storage_path = \Storage::disk('local')->url('images/'.$film->photo);

            //fetching the associated comments
            $comments = [];
            if ($film->comments()->get()->count()) {
                $comments = $film->comments()->get();
            }

            return response()->json(['info' => $film, 'comments' => $comments]);
        } catch (\Exception $e) {
            Log::error('[Film] error ' . $e->getMessage());
            return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }

    /**
     * get film comments
     *
     * @return \Illuminate\Http\Response
     */
    public function get_film_comments(Request $request)
    {
        try {
            Log::info('- [Genre] Listing data...');
            $comments = Comment::where('film_id', $request->film_uuid)->get();
            return response()->json(['comments' => $comments, 'code' => 200]);
        } catch (\Exception $e) {
            Log::error('[Genre] error ' . $e->getMessage());
            return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }

    /**
     * Get initial data to create film
     *
     * @return \Illuminate\Http\Response
     */
    public function get_data()
    {
        try {
            Log::info('- [Genre] Get initial data...');
            $genres = Genre::where('status', 1)->get();
            $countries = config('countries.data');
            return response()->json(['genres' => $genres, 'countries' => $countries]);
        } catch (\Exception $e) {
            Log::error('[Genre] error ' . $e->getMessage());
            return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }

    /**
     * Upload photo to storage
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadPhoto($request)
    {
        $imageData = $request->get('photo');
        $fileName = self::getName($imageData);
        $img = \Image::make($imageData);
        //$img->resize(100, 100);
        $img->stream();
        $path = 'images/' . $fileName;
        $ret = [];
        $upload = \Storage::disk('public')->put($path, $img->__toString(), 'public');
        if (!$upload) {
            $ret = ['error' => true, 'message' => 'File can not upload'];
        } else {
            $ret = ['error' => false, 'filename' => $fileName];
        }

        return (object)$ret;
    }

    /**
     * Unique Photo name
     *
     * @return \Illuminate\Http\Response
     */

    public static function getName($inputField)
    {
        return Carbon::now()->timestamp . '_' .
                uniqid() . '.' .
                explode(
                    '/',
                    explode(':', substr($inputField, 0, strpos($inputField, ';')))[1]
                )[1];
    }
}
