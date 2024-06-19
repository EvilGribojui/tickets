<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|integer|min:1|max:5',
            'subject' => 'required|string|max:255',
            'sender' => 'required|string|max:255',
            'body' => 'required|string',
            // Validate other fields as needed
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|integer|min:1|max:5',
            'subject' => 'required|string|max:255',
            'sender' => 'required|string|max:255',
            'body' => 'required|string',
            // Validate other fields as needed
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }

    public function assign(Request $request, Task $task)
    {
        $task->assigned_to = auth()->user()->id;
        $task->status = 'in_progress';
        $task->save();

        return redirect()->route('tasks.show', $task);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $task->status = $request->input('status');
        $task->save();

        return redirect()->route('tasks.show', $task);
    }
}
