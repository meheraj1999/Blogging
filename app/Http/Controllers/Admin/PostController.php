<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\AuthorPostApprove;
use App\Subscriber;
use App\Tag;
use Brian2694\Toastr\Facades\Toastr;
// use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Notifications\newPostNotify;
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
        $posts=Post::latest()->get();
        return view('admin.post.index',compact('posts'));
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
        return view('admin.post.create',compact('categories','tags'));
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

        $post->is_approved=true;
        
        $post->fill($formData)->save();

        $subscribers=Subscriber::all();

       foreach($subscribers as $subscriber)
       {
           
        Notification::route('mail',$subscriber->email)
        ->notify(new NewPostNotify($post));
       }
        // dd($request->all());
        Toastr::success('category Create Successfully', 'Success');
        return redirect()->route('admin.post.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {return view('admin.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */

     public function pending()
     {
        $posts=Post::WHERE('is_approved', false)->get();
        return view('admin.post.pending',compact('posts'));
     }

     public function approval($id)
     {
        $post=Post::find($id);
        if($post->is_approved==false){
            $post->is_approved=true;
            $post->save();
            $post->user->notify(new AuthorPostApprove($post));

            $subscribers=Subscriber::all();

            foreach($subscribers as $subscriber)
            {
                
             Notification::route('mail',$subscriber->email)
             ->notify(new NewPostNotify($post));
            }
            Toastr::success('post Approve Successfully', 'Success');

        }
        else{
            Toastr::info('post already approved', 'info');
        }
        return redirect()->back();
     }


    public function edit(Post $post)
    {
        $categories=Category::all();
        $tags=Tag::all();
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
        
    
        $post->delete();
    
        return redirect()->route('admin.post.index');
    }
}
