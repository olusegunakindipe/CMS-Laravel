<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostsRequest;
use App\Post;
use App\Category;
use App\Tag;
use App\User;

class PostsController extends Controller 

{

    public function __construct(){

        $this->middleware('verifyCategoriesCount')->only(['create','store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')
        ->with('categories',Category::all())
        ->with('tags',Tag::all())
        ->with('users',User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {

        
        $image = $request->image->store('posts');
        $post = Post:: create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'published_at' =>$request->published_at,
            'category_id' => $request->category,
            'user_id'=> auth()->user()->id
         
        ]);

        if($request->tags){
            $post->tags()->attach($request->tags);
        }

        session()->flash('success', 'Post created Successfully');

        return redirect(route('posts.index'));
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
    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)
        ->with('categories',Category::all())
        ->with('tags', Tag::all())
        ->with('users',User::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostsRequest $request, Post $post)
    {
        //This is an alternative
        // $data= $request->only(['title', 'content','description','published_at'])

        // $data['image'] = $image 
        
        //if the new file has a image
        if ($request->hasFile('image')) {
            //upload it to the post file
            $image = $request->image->store('posts');
            $post->deleteImage();
        }
        if($request->tags) {
            $post->tags()->sync($request->tags);
        }

        $post ->update([

            'name' => $request->name,
            'title'=>$request->title,
            'content'=>$request->content,
            'published_at'=>$request->published_at,
            'image'=> $image

        ]);

        session()->flash('success', 'Post Updated Successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Post $post) //route model binding produces 404 in this case
        public function destroy($id)
    {
      $post = Post::withTrashed()->where('id', $id)->first();

        if($post->trashed()) {

            $post->deleteImage();
            $post->forceDelete();
        } else {
            $post->delete();
        }

        session()->flash('success', 'Post deleted Successfully');

        return redirect(route('posts.index'));
    }

     /**
     * display a list of all trashed posts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trashed(){

        $trashed = Post::onlyTrashed()->get(); //This returns all the posts with trashed post inclusive

        return view('posts.index')->with('posts', $trashed);

    }

    public function restore($id){
        $post = Post::withTrashed()->where('id',$id)->first();

        $post->restore();

        session()->flash('success', 'Post restored Successfully');

        return redirect()->back();
    }
}
