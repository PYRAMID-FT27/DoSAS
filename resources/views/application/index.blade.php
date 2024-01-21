<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold capitalize text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('my application') }}
        </h2>
    </x-slot>
    <div class="py-12 w-full sm:w-8/12 mx-auto">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        created at
                    </th>
                    <th scope="col" class="px-6 py-3">
                        status
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        semester
                    </th>
                    <th scope="col" class="px-6 py-3">
                        type
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                        submitted_at
                    </th>
                    <th scope="col" class="px-6 py-3">
                        notes
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
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
                        {!! $defermentApplication->getStatus() !!}
                    </td>
                    <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                        {{$defermentApplication->semester}}
                    </td>
                    <td class="px-6 py-4">
                        {!! $defermentApplication->getType() !!}
                    </td>
                    <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                        {{$defermentApplication->submitted_at?:'Not yet'}}
                    </td>
                    <td class="px-6 py-4">
                        {{$defermentApplication->notes??'-'}}
                    </td>
                    <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                        #
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $defermentApplications->links() }}
        </div>
    </div>

</x-app-layout>
