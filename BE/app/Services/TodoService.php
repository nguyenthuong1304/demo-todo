<?php

namespace App\Services;

use App\Models\Todo;
use Carbon\Carbon;

class TodoService {

    public function paginate(array $query) {
        $todos = Todo::when(
                isset($query['title']),
                fn ($q) => $q->where('title', 'like', '%'.$query['title'].'%')
            )
            ->when(
                isset($query['start_date']),
                fn ($q) => $q->where('start_date', '>=', $query['start_date'])
            )
            ->when(
                isset($query['due_date']),
                fn ($q) => $q->where('due_date', '<=', $query['due_date'])
            )
            ->when(
                isset($query['status']),
                fn ($q) => $q->where('status', $query['status'])
            )
            ->orderBy('created_at', 'desc')
            ->with('user:id,name')
            ->paginate(25);

        return $todos;
    }

    public function store(array $inputs) {
        return Todo::create($this->prepareData($inputs));
    }

    public function update(int $id, array $inputs) {
        $todo = $this->show($id);

        $todo->update($this->prepareData($inputs));
    }

    public function show($id) {
        return Todo::findOrFail($id);
    }

    public function assignTodo(array $inputs) {
        $this->updateTodosByIds($inputs['todo_ids'], ['user_id' => $inputs['user_id']]);
    }

    public function changeStatus(array $inputs) {
        $this->updateTodosByIds($inputs['todo_ids'], ['status' => $inputs['status']]);
    }

    private function updateTodosByIds(array $ids, array $data) {
        Todo::whereIn('id', $ids)->update($data);
    }

    private function prepareData($inputs) {
        return [
            ...$inputs,
            'start_date' => Carbon::parse($inputs['start_date'])->format('Y-m-d'),
            'due_date' => Carbon::parse($inputs['due_date'])->format('Y-m-d'),
        ];
    }
}
