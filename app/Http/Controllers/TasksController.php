<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $data = [];
        
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                    'user' => $user,
                    'tasks' => $tasks,
                ];
        }
        
        return view('welcome', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;
        
        return view('tasks.create', [
                'task' => $task
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        $this->validate($request, [
             'status' => 'required|max:10',
             'content' => 'required|max:191',
            ]);
        
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     // getでtasks/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        $user = \App\User::find($id);
        $task = Task::find($id);
        
        
        if (\Auth::id() == $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
                'user' => $user,
            ]);
            
        }
        else{
            return redirect('/');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     // getでtasks/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        
            
        $user = \App\User::find($id);
        $task = Task::find($id);
        
        if (\Auth::id() == $task->user_id) {
            return view('tasks.edit', [
                'task' => $task,
                'user' => $user,
            ]);
            
        }
        else{
            return redirect('/');
        }    
         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     // putまたはpatchでtasks/idにアクセスされた場合の「更新処理
    public function update(Request $request, $id)
    {
        $this->validate($request, [
             'status' => 'required|max:10',
             'content' => 'required|max:191',
            ]);
        
        $task = Task::find($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     // deleteでtasks/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        $task = \App\Task::find($id);

        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        
        return redirect('/');
    }
}
