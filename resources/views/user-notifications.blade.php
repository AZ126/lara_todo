<x-app-layout>
    <div class="py-12 mt-5 pt-5">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container-fluid">
                    <h1>Notifications</h1>
                    <div>
                            @if (auth()->user()->unreadNotifications)
                                <li class="d-flex justify-content-end mx-1 my-2">
                                    <a href="{{ route('mark-as-read') }}" class="btn btn-success btn-sm">Mark All as
                                        Read</a>
                                </li>
                            @endif

                            @foreach (auth()->user()->unreadNotifications as $notification)
                                <a href="#" class="text-success">
                                    <li class="p-1 text-success"> {{ $notification->data['message'] }}</li>
                                </a>
                            @endforeach
                            @foreach (auth()->user()->readNotifications as $notification)
                                <a href="#" class="text-secondary">
                                    <li class="p-1 text-secondary"> {{ $notification->data['message'] }}</li>
                                </a>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
