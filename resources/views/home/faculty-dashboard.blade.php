<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('home') }}
        </h2>
    </x-slot>

    <div class="py-12 sm:flex w-full sm:w-3/4 mx-auto">
        <div class="sm:w-7/12 mx-auto sm:px-6 lg:px-8">
            <div class="p-6 uppercase text-gray-900 dark:text-gray-100">
               information
            </div>
            <div class="bg-white dark:bg-gray-800 capitalize overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 capitalize text-gray-900 dark:text-gray-100">
                   <b>name</b>: {{$meta->title.' '.$user->name}}
                </div>
                <div class="p-6 capitalize text-gray-900 dark:text-gray-100">
                    <b>department</b>: {{$user->department}}
                </div>
                <div class="p-6 capitalize text-gray-900 dark:text-gray-100">
                    <b>filed</b>: {{$meta->research_interests}}
                </div>
                <div class="p-6 capitalize text-gray-900 dark:text-gray-100">
                    <b>Office</b>: {{$meta->office_location}}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <b> Capacity: Number of Students Supervised  </b>: {{$meta->max_students}}
                </div>
            </div>
        </div>
        <div class="sm:w-5/12 pt:4 mx-auto sm:px-6 lg:px-8">
            <div class="p-6 uppercase text-gray-900 dark:text-gray-100">
                contact info
            </div>
            <div class="bg-white dark:bg-gray-800 capitalize overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                   <b>email</b>: {{$user->email}}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                   <b>phone number</b>: {{$user->phone_number}}
                </div>
            </div>
            <div class="p-6 uppercase text-gray-900 dark:text-gray-100">
                academic info
            </div>
            <div class="bg-white dark:bg-gray-800 capitalize overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($meta->load('students')->students()->get() as $item)
                    <div class="p-6 text-gray-900 flex justify-between dark:text-gray-100">
                        <p class="w-7/12"><b>student name</b>:{{$item->title}}.{{$item->load('user')->user->name}}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
