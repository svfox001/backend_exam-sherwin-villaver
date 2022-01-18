<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment\CommentRepositoryInterface;

class CommentController extends Controller
{
    private $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

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
    public function store(Request $request, $slug)
    {
        $data = $request->all();
        $data['commentable_type'] = "App\\Post";
        $data['commentable_id'] = $request->post_id;
        $data['creator_id'] = auth()->user()->id;
        $comment = $this->commentRepository->create($data);
        return response()->json([
            "data" => $comment
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = $this->commentRepository->findCommentsByPostId($id);
        return response()->json([
            "data" => $comment
        ]);
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
    public function update(Request $request, $slug, $id)
    {
        $comment = $this->commentRepository->update($id, $request->all());
        
        return response()->json([
            "data" => $comment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $id)
    {
        $this->commentRepository->deleteById($id);
        return response()->json([
            "status" => "record deleted successfully"
        ]);
    }
}
