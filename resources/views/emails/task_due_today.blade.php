<!DOCTYPE html>
<html>
<head>
    <title>Task Due Today</title>
</head>
<body>
<p>Dear {{ $task->user->name }},</p>
<p>This is a reminder that the task <strong>{{ $task->title }}</strong> is due today.</p>
<p>Description: {{ $task->description }}</p>
<p>Due Date: {{ $task->due_date }}</p>
<p>Thank you!</p>
</body>
</html>
