<?php

namespace App\Http\Controllers\Author;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\newAuthorPost;
use App\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Auth::user()->posts()->latest()->get();
        return view('author.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        $tags=Tag::all();
        return view('author.post.create',compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|unique:posts' ,
            'image'=>'required',
            'categories'=>'required',
            'tags'=>'required',
            'body'=>'required',
            
        ]);
        $post = new Post();
        $post->slug= str_slug($request->title);
        $post->user_id=Auth::id();
        $formData = $request->all();
       
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = 'image' . Str::random(5) . '.' . $extension;
            $path = "assets/backend/assets/images/post/";
            $request->file('image')->move($path, $name);
            $formData['image'] = $path . $name;
        }
        if(isset($request->status)){
            $post->status=true;
        }else{
            $post->status=false; 
        }
        // $post->categories()->attach($request->categories);
        // $post->tags()->attach($request->tags);

        $post->is_approved=false;
        
        $post->categories[]=$request->categories;
        $post->tags[]=$request->tags;
        // dd($request->all());
        $post->fill($formData)->save();
        
        
        $users = User::where('role_id','1')->get();
        Notification::send($users, new NewAuthorPost($post));
        Toastr::success('Post Successfully Saved :)','Success');
        return redirect()->route('author.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if($post->user_id !=Auth::id()){
            Toastr::error('you are not accessed for this post');
            return redirect()->back();
        }
        return view('author.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.edit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->user_id !=Auth::id()){
            Toastr::error('you are not accessed for this post');
            return redirect()->back();
        $post->delete();
        
        return view('author.post.index');
    }
   }

}
