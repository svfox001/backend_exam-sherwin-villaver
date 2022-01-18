<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Post\PostRepositoryInterface;
use App\Http\Resources\PostResource;
use App\Post\PostTransformer;
use Str;

class PostController extends Controller
{
    private $postRepository;
    private $postTransformer;

    public function __construct(
        PostRepositoryInterface $postRepository,
        PostTransformer $postTransformer
    ){
        $this->postRepository = $postRepository;
        $this->postTransformer = $postTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->postTransformer->transform($this->postRepository->paginate(15)->toArray());
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
     * @param  \Illuminate\Http\Request\PostStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title'],'-');
        $validated['user_id'] = auth()->user()->id;
        $validated['image'] = $request->image;
        $post = $this->postRepository->create($validated);

        return response()->json([
            "data" => $post
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
       $post = $this->postRepository->findBySlug($id);
       return response()->json([
           "data" => $post
       ], 200);
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
    public function update(Request $request, $slug)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title,'-');
        $post = $this->postRepository->updateBySlug($slug, $data);
        return response()->json([
            "data" => $post
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->postRepository->deleteBySlug($slug);
        return response()->json([
            "status" => "record deleted successfully"
        ], 200);
    }
}
