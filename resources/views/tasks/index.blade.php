@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Задачи</h1>
    <ul>
        @foreach ($tasks as $task)
            <li>
                <a href="{{ route('tasks.show', $task) }}">{{ $task->subject }}</a> - {{ $task->status }}
            </li>
        @endforeach
    </ul>
</div>
@endsection
