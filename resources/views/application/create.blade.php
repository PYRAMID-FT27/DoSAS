<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold capitalize text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    @if(!auth()->user()->isStudent())
                        <li class="inline-flex items-center">
                            <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                                </svg>
                                {{$student->user->name}}
                            </a>
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </li>
                    @else
                        <li class="inline-flex items-center">
                            <a href="{{route('defermentApplication.index')}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                                </svg>
                                my applications
                            </a>
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </li>
                    @endif
                    <li>
                        <div class="flex items-center">
                            <a href="#" class="ms-1 text-sm capitalize font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                                {{empty($defermentApplication)?'new Application':$defermentApplication->semester}}
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>
        </h2>
    </x-slot>
    @if ($errors->any())
        <div class="w-full sm:w-4/12 mx-auto">
            @foreach($errors->all() as $error)
                @php(notify()->error($error))
            @endforeach
        </div>
    @endif
    <div class="py-12 w-full sm:w-4/12 mx-auto">
        <div class="relative bg-white p-10 overflow-x-auto shadow-md sm:rounded-lg">
            <form method="post" action="{{route('defermentApplication.store')}}" class="border-0 mx-auto" enctype="multipart/form-data">
                @method('POST')
                @include('application.form')
                <div class="my-5">
                    <a href="{{route('defermentApplication.index')}}" class="text-red-800 font-xl capitalize text-sm w-full sm:w-auto px-5 py-2.5 text-center">back</a>
                    <button type="submit" value="save" name="action" class="text-blue-800 border border-blue-800 capitalize font-xl rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">save</button>
                    <button type="submit" value="submit" name="action" class="text-white uppercase bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
