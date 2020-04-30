<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Post;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
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
        return view ('posts.create');

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

        Post::create([

       'title' => $request->title,
       'description' => $request->description,
       'content' => $request->content,
       'image' => $image,
       'published_at' => $request->published_at

       ]);
      
        session()->flash('success', 'Post created successfully.');

        return redirect ( route('posts.index'));


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
        return view ('posts.create')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        
        // Storing all requested input in a data variable.

        $data = $request->only(['title', 'description', 'published_at', 'content']);

        // Check if the submitted form has new image

        if ($request->hasFile('image')) {
        
            // Upload the new images

            $image = $request->image->store('posts');
        
             // Then, delete the old image

             Storage::delete($post->image);
            
             // Assign the new image to our data variable

            $data ['image'] = $image;

        }


        // Update all atrribute to the Database

             $post->update($data);
 

        // Flash success message 
        
        session()->flash('success', 'Post Updated Successfully.');


        // Lastly, return redirect  

        return redirect( route('posts.index') );




    }




 /**
     * Formal Remove the specified resource from storage by James Onuyaa.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    
    *public function destroy(Post $post)
    * {
        * $post->delete();
    
        * session()->flash('success', 'Post trashed successfully.');
        
       *  return redirect ( route('posts.index'));
     * } 
    */

 /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id',  $id)->firstOrFail();


        if ($post->trashed())
        {
            Storage:: delete($post->image);

            $post->forceDelete();


        }
         else

        {  $post->delete();
        
        }
      
        session()->flash('success', 'Post deleted successfully.');
        
        return redirect ( route('posts.index'));
    


    }


     /**
     * Display a list of all trashed posts
     *
  
     * @return \Illuminate\Http\Response
     */

    public function trashed()
    {

        $trashed = Post::withTrashed()->get();

        return view ('posts.index')->with('posts', $trashed);




    }
}
