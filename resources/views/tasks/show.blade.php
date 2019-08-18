@extends('layouts.app')

@section('content')

<!-- ここにページ毎のコンテンツを書く -->
    @if (Auth::id() == $task->user_id)
        <h1>id = {{ $task->id }} のタスク詳細ページ</h1>
        
        <table class="table table-bordered">
            <tr>
                <th>id</th>
                <td>{{ $task->id }}</td>
            </tr>
            <tr>
                <th>ステータス</th>
                <td>{{ $task->status }}</td>
            </tr>
            <tr>
                <th>タスク</th>
                <td>{{ $task->content }}</td>
            </tr>
        </table>
        {!! link_to_route('tasks.edit', 'このタスクを編集', ['id' => $task->id], ['class' => 'btn btn-light']) !!}
            
        {!! Form::model($task, ['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
            {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Tasklist</h1>
                 {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif   
@endsection