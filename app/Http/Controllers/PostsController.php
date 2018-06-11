<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keywords = $request->keywords;
        //$date = date_create($request->date);
        $fromdate = $request->fromdate;
        $todate = $request->todate;

        //キーワード検索
        if ($keywords != null)
        {
            $post = Post::where('title', 'like', '%'.$keywords.'%')->latest()->paginate(5);
        }
        //日付絞り込み
        else if ($fromdate != null && $todate != null)
        {
            $fromdate = date_create($fromdate);
            $fromdate = date_format($fromdate, "Y-m-d");
            $todate = date_create($todate);
            $todate = date_format($todate, "Y-m-d");
            $post = Post::where('created_at', '>=', $fromdate)->where('created_at', '<=', $todate)->latest()->paginate(5);
        }
        else if ($fromdate != null)
        {
            $fromdate = date_create($fromdate);
            $fromdate = date_format($fromdate, "Y-m-d");
            $post = Post::where('created_at', '>=', $fromdate)->latest()->paginate(5);
        }
        else if ($todate != null)
        {
            $todate = date_create($todate);
            $todate = date_format($todate, "Y-m-d");
            $post = Post::where('created_at', '<=', $todate)->latest()->paginate(5);
        }
        //全件出力
        else
        {
            //paginate()を使う場合はget()はいらない？
            //all()にlatest()は使えない？
            //↑latest()は降順に並べ替えるだけでなく、データの取得も含まれる？
            $post = Post::latest()->paginate(5);
        }

        return view('posts.index', ['posts' => $post]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        return view('posts.create', ['post' => $post]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:posts|min:3|max:30',
            'content' => 'required',
        ]);

        $post = Post::create($request->all());
        session()->flash('imessage', 'insert commit');
        return redirect()->route('posts.show', [$post->id]);

    }

    public function comment(Request $request)
    {
        $validatedData = $request->validate([
            'comment' => 'required|max:50',
        ]);

        // $user = \Auth::user();
        // $user_id = $user->id;
        // dd($user_id);
        // $request->fill(['name' => '']);

        $comment = Comment::create($request->all());
        //dd($comment);
        return redirect()->route('posts.show', [$comment->post_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd($id);
        $post = Post::findOrFail($id);
        $comments = Comment::where('post_id', $id)
            ->join('users','users.id','=','comments.user_id')->latest('comments.created_at')->get();

        //dd($comments);
        //return view('posts.contents')->with('posts',$post);
        return view('posts.contents', ['post' => $post, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', ['post' => $post]);
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
        $post->update($request->all());
        session()->flash('umessage', 'update commit');
        return redirect()->route('posts.show', [$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        session()->flash('dmessage', 'delete commit');
        return redirect('/')->with('flash_message', 'Post Deleted!');
        //return view('posts.index', ['posts' => $post]);
    }
}
