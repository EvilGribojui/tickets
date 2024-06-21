<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function assign(Request $request, Task $task)
    {
        $task->assigned_to = Auth::id();
        $task->save();

        return redirect()->route('tasks.show', $task);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,on_hold,closed'
        ]);

        $task->status = $request->input('status');
        $task->save();

        return redirect()->route('tasks.show', $task);
    }

    public function reply(Request $request, Task $task)
    {
        // Логика обработки ответа на задачу
        // Например, добавление комментария, отправка письма и т.д.
        return redirect()->route('tasks.show', $task);
    }
}