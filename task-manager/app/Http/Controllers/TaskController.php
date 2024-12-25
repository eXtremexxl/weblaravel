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

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);
        Task::create(['title' => $request->title]);
        return redirect('/')->with('success' , 'Задача добавлена');
        
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return redirect('/')->with('success' , 'Задача удалена');
    }

    public function update($id)
    {
        $task = Task::findOrFail($id);
        $task->is_completed = !$task->is_completed;
        $task->save();
        return redirect('/');
    }
}
