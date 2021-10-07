<?php

namespace App\Http\Controllers;

use App\Models\TopicLike;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user = $request->user();
        $topic = Topic::find($request->topic_id);

        if (TopicLike::where('topic_id', $topic->id)->where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'already exists'
            ], 200);
        }

        $topic_like = new TopicLike();
        $topic_like->user()->associate($user);
        $topic_like->topic()->associate($topic);
        $topic_like->save();

        return response()->json([
            'message' => 'success'
        ], 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function show(TopicLike $topicLike)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function edit(TopicLike $topicLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TopicLike $topicLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TopicLike  $topicLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(TopicLike $topicLike)
    {
        //
    }
}
