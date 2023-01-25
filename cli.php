<?php


use App\Entities\Task\Task;

$task = new Task(
    'Первая читка',2,2,1,'25.01.2023',''
);

$command = new \App\Commands\CreateEntityCommand($task);

$handler = new \App\Commands\Task\CreateTaskCommandHandler();

$handler->handle($command);