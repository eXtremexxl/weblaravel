<!DOCTYPE html>
<html lang="en">
<head>
    <title>tmanager</title>

    <script>
        function showAlert(message){
            if (message){
                alert(message)
            }
        }
    </script>

<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0 150px;
        }



        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }

        form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #ffffff;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fdfdfd;
            margin-bottom: 10px;
            transition: box-shadow 0.3s ease;
        }

        li:hover {
            box-shadow: 0 5px 4px rgba(0, 0, 0, 0.1);
        }

        .task-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .task-title span {
            font-size: 14px;
        }

        .task-title span.completed {
            text-decoration: line-through;
            color: #888888;
        }

        .delete-button {
            background-color: #dc3545;
            color: #ffffff;
            font-size: 12px;
            padding: 5px 10px;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        .checkbox {
            cursor: pointer;
        }
        
    </style>

</head>

<body>
    <h1>Task Manager</h1>

    @if (session('success'))
        <script>
            showAlert('{{ session('success') }}');
        </script>
    @endif

    <form action="/tasks" method="post">
        @csrf
        <input type="text" name="title" placeholder="Enter task" required maxlength="255">
        <button type="submit">Add Task</button>
    </form>

    <ul>
        @foreach($tasks as $task)
            <li 
                data-id="{{ $task->id }}" 
                ondblclick="toggleTask(this)" 
                style="cursor: pointer; {{ $task->is_completed ? 'text-decoration: line-through; color: gray;' : '' }}">
                {{ $task->title }}
                <form action="/tasks/{{ $task->id }}" method="post" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    <script>
        function toggleTask(taskElement) {
            const taskId = taskElement.dataset.id;

            fetch(`/tasks/${taskId}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_completed) {
                        taskElement.style.textDecoration = 'line-through';
                        taskElement.style.color = 'gray';
                        location.reload();
                    } else {
                        taskElement.style.textDecoration = 'none';
                        taskElement.style.color = 'black';
                        location.reload();
                    }
                }
            })
            .catch(error => console.error('Ошибка:', error));
        }
    </script>
</body>
</html>