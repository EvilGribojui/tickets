@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $task->subject }}</h1>
    <p>{{ $task->body }}</p>

    <h3>Действия</h3>
    <form method="POST" action="{{ route('tasks.assign', $task) }}">
        @csrf
        <button type="submit">Взять в работу</button>
    </form>

    <form method="POST" action="{{ route('tasks.updateStatus', $task) }}">
        @csrf
        <label for="status">Изменить статус:</label>
        <select name="status" id="status">
            <option value="new" {{ $task->status == 'new' ? 'selected' : '' }}>Новое</option>
            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>В работе</option>
            <option value="on_hold" {{ $task->status == 'on_hold' ? 'selected' : '' }}>Пауза</option>
            <option value="closed" {{ $task->status == 'closed' ? 'selected' : '' }}>Закрыто</option>
        </select>
        <button type="submit">Изменить статус</button>
    </form>

    <form method="POST" action="{{ route('tasks.reply', $task) }}">
        @csrf
        <label for="reply">Ответ:</label>
        <textarea name="reply" id="reply"></textarea>
        <button type="submit">Ответить</button>
    </form>
</div>
@endsection
