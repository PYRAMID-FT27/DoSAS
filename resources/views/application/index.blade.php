<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold capitalize w-6/12 text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('my application') }}
            </h2>
            <h2 class="w-2/12 text-right items-end justify-end">
                <a href="{{route('defermentApplication.create')}}" class="capitalize block w-fit cursor-pointer items-end justify-end px-5 font-extrabold rounded-lg hover:bg-green-700 hover:text-white py-3 text-right text-green-700 border-2 border-green-700">{{ __('new application') }} </a>
            </h2>
        </div>
    </x-slot>
    <div class="py-12 w-full sm:w-8/12 mx-auto">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400 border-b ">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        created at
                    </th>
                    <th scope="col" class="px-6 py-3 ">
                        semester
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50">
                        type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        submitted at
                    </th>
                    <th scope="col" class="px-6 py-3">
                        notes
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50">
                        status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($defermentApplications as $defermentApplication)
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                        {{$defermentApplication->created_at->format('Y,M d')}}
                    </th>
                    <td class="px-6 py-4">
                        {{$defermentApplication->semester}}
                    </td>
                    <td class="px-6 py-4 bg-gray-50 capitalize dark:bg-gray-800">
                        {!! $defermentApplication->getType() !!}
                    </td>
                    <td class="px-6 py-4 capitalize">
                        {{$defermentApplication->submitted_at?:'Not yet'}}
                    </td>
                    <td class="px-6 py-4">
                        {{$defermentApplication->notes??'-'}}
                    </td>
                        <td class="px-6 py-4 bg-gray-50 capitalize">
                            {!! $defermentApplication->getStatus() !!}
                        </td>
                        <td class="px-6 py-4 flex justify-between dark:bg-red-800">
                        @if($defermentApplication->isEditable())
                            <a href="{{route('defermentApplication.edit',$defermentApplication)}}" class="text-blue-800 w-1/3 text-base font-medium me-2 px-2.5 py-0.5  dark:text-blue-400">Edit</a>
                                <div class="w-1/3">
                                    <form action="{{route('defermentApplication.destroy',$defermentApplication)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button >
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 64 64">
                                                <path d="M 28 3 C 25.791 3 24 4.791 24 7 L 24 9 L 23.599609 9 L 7 11 L 7 14 L 57 14 L 57 11 L 40.400391 9 L 40 9 L 40 7 C 40 4.791 38.209 3 36 3 L 28 3 z M 28 7 L 36 7 L 36 9 L 28 9 L 28 7 z M 10 16 L 14 58 L 50 58 L 53.923828 17 L 10 16 z M 32 23 C 33.333 23 34 24 34 24 L 34 53 L 30 53 L 30 24 C 30 24 30.667 23 32 23 z M 18.976562 23.070312 C 20.306563 22.977313 21.042969 23.929688 21.042969 23.929688 L 23.007812 53 L 18.996094 53 L 17.052734 24.207031 C 17.052734 24.207031 17.646563 23.163313 18.976562 23.070312 z M 44.978516 23.070312 C 46.308516 23.163312 46.904297 24.207031 46.904297 24.207031 L 44.960938 53 L 40.949219 53 L 42.914062 23.929688 C 42.914062 23.929688 43.648516 22.977312 44.978516 23.070312 z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @else
                            <a title="you can not do action after submission" class="w-1/3">
                                <svg class="w-6 h-6 text-red-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                                    <path d="M7.324 9.917A2.479 2.479 0 0 1 7.99 7.7l.71-.71a2.484 2.484 0 0 1 2.222-.688 4.538 4.538 0 1 0-3.6 3.615h.002ZM7.99 18.3a2.5 2.5 0 0 1-.6-2.564A2.5 2.5 0 0 1 6 13.5v-1c.005-.544.19-1.072.526-1.5H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h7.687l-.697-.7ZM19.5 12h-1.12a4.441 4.441 0 0 0-.579-1.387l.8-.795a.5.5 0 0 0 0-.707l-.707-.707a.5.5 0 0 0-.707 0l-.795.8A4.443 4.443 0 0 0 15 8.62V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.12c-.492.113-.96.309-1.387.579l-.795-.795a.5.5 0 0 0-.707 0l-.707.707a.5.5 0 0 0 0 .707l.8.8c-.272.424-.47.891-.584 1.382H8.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1.12c.113.492.309.96.579 1.387l-.795.795a.5.5 0 0 0 0 .707l.707.707a.5.5 0 0 0 .707 0l.8-.8c.424.272.892.47 1.382.584v1.12a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1.12c.492-.113.96-.309 1.387-.579l.795.8a.5.5 0 0 0 .707 0l.707-.707a.5.5 0 0 0 0-.707l-.8-.795c.273-.427.47-.898.584-1.392h1.12a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5ZM14 15.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                                </svg>
                            </a>

                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $defermentApplications->links() }}
        </div>
    </div>

</x-app-layout>
