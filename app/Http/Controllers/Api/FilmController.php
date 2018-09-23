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
            $films = Film::all();
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
                'photo' => 'required|mimes:jpeg,jpg,png,gif|max:10240'
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

            if (isset($request->photo)) {
                //get photo
                $upload_file = $request->file('photo');
                $extension = $upload_file->getClientOriginalExtension();
                $imageName = Carbon::now()->timestamp . '_' . $upload_file->getFilename().'.'.$extension;
                //* save image in public storage
                Storage::disk('public')->put($imageName, File::get($cover));

                $film_data['photo'] = $imageName;
            }

            //*get films
            $genres = [];
            if (isset($request->genres)) {
                foreach ($film_genres as $film_genre) {
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
            return response()->json(['film' => $film]);
        } catch (\Exception $e) {
            Log::error('[Film] error ' . $e->getMessage());
            return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get active genres
     *
     * @return \Illuminate\Http\Response
     */
    public function get_genres()
    {
        try {
            Log::info('- [Film] get genres');
            $genres = Genre::where('status', 1)->get();
            return response()->json(['genres' => $genres]);
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
}
