<!DOCTYPE html>
<html lang="en">
<head>
    <title>tmanager</title>
</head>
<body>
    <h1>Task Manager</h1>

    <form action="/tasks" method="post">
        @csrf
        <input type="text" name="title" placeholder="enter task" required>
        <button type="submit">Add Task</button>
    </form>

    <ul>
        @foreach($tasks as $task)
        <li>
            <form action="/tasks/{{$task->id}}" method="post">
                @csrf 
                @method('PATCH')
                <input type="checkbox" onchange="this.form.submit() {{ $task->is_completed ? 'checked' : '' }}">
                <span style = "{{ $task->is_completed ? 'text-decoration: line-through;' : '' }} ">
                    {{ $task->title }}
                </span>
            </form>

            <form action="/tasks/{{ $task->id }}" method="post" style="display:inline;">
                @csrf 
                @method('DELETE')
                <button type = "submit">Delete</button>
            </form>
        </li>
        @endforeach
    </ul>

</body>
</html>