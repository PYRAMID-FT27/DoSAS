<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold capitalize text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('my application') }}
        </h2>
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
                        <td class="px-6 py-4 dark:bg-red-800">
                        @if($defermentApplication->isEditable())
                            <a href="{{route('defermentApplication.edit',$defermentApplication)}}" class="text-blue-800 text-base font-medium me-2 px-2.5 py-0.5  dark:text-blue-400">Edit</a>
                            @else
                            <a title="you can not do action after submission">
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
