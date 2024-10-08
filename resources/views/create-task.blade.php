<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container">
                    <div class="row mt-5">
                        <div class="col-6 mx-auto pt-5">
                            <div class="container">
                                @if (Route::is('tasks.show'))
                                    <h2>Edit Task</h2>
                                @else
                                    <h2>Create New Task</h2>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form
                                    action="{{ Route::is('tasks.show') ? route('tasks.update', $task->id) : route('tasks.store') }}"
                                    method="POST">
                                    @csrf
                                    @if (Route::is('tasks.show'))
                                        @method('PUT')
                                    @endif
                                    @php
                                        $category = isset($task) ? $task->category : '';
                                        $title = isset($task) ? $task->title : '';
                                        $description = isset($task) ? $task->description : '';
                                        $completed = isset($task) ? $task->is_completed : '';
                                        $datetime = isset($task) ? $task->deadline : '';
                                        [$deadLineDate, $deadLineTime] = $datetime ? explode(' ', $datetime) : ['', ''];
                                    @endphp
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ $title }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Title</label>
                                        <select name="category" class="form-control">
                                            <option value="">Select Category</option>
                                            <option value="Work" {{ $category == 'Work' ? 'selected' : '' }}>Work
                                            </option>
                                            <option value="Personal" {{ $category == 'Personal' ? 'selected' : '' }}>
                                                Personal</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="desc">Description</label>
                                        <textarea name="desc" class="form-control" rows="5">{{ $description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="deadline">Deadline</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="date" name="deadline" class="form-control"
                                                    value="{{ $deadLineDate }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="time" name="deadlineTime" class="form-control"
                                                    value="{{ $deadLineTime }}">
                                            </div>
                                        </div>
                                    </div>

                                    @if (Route::is('tasks.show'))
                                        <div class="form-group">
                                            <label for="completed">Mark As Done: </label>
                                            <input type="checkbox" name="completed" class="ml-3" value="1"
                                                {{ $task->is_completed == 1 ? 'checked' : '' }} />
                                        </div>
                                    @endif

                                    <button type="submit" class="btn btn-success">
                                        {{ Route::is('tasks.show') ? 'Update Task' : 'Create Task' }}
                                    </button>
                                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
