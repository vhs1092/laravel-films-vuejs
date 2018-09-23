<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Film;
use Validator;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->user =  Auth::user();
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
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try {
            Log::info('- [Comment] saving...');

            //*validate fields
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'comment' => 'required',
                'film_id' => 'required',
            ]);

            if ($validator->fails()) {
                //!Validator fails
                return response()->json(['code' => 400, 'message' => $validator->errors()]);
            }
            //* get film based on uuid
            $film = Film::where('uuid', $request->film_id)->first();
            
            Comment::create(array(
            'name' => $request->name,
            'comment' => $request->comment,
            'film_id' => $film->id,
            'user_id' => $this->user->id
             ));

            Log::info('- [Comment] comment saved...');

            //* get comments
            $comments = Comment::where('film_id', $film->id)->get();

            return response()->json(['code' => 200, 'message' => 'Successfully created', 'comments' => $comments]);

        } catch (\Exception $e) {
            Log::error('[Genre] error ' . $e->getMessage());
            return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        Comment::destroy($id);
        return Response::json(array('success' => true));
    }
}
