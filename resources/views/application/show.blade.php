@php use App\Models\DefermentApplication;use Illuminate\Support\Facades\Vite; @endphp
<x-app-layout>
    @push('custom-css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet"/>
    @endpush
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold capitalize w-full text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <nav class="flex justify-between" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        @if(!auth()->user()->isStudent())
                            <li class="inline-flex items-center">
                                <a href="#"
                                   class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                                    </svg>
                                    {{$student->user->name}}
                                </a>
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                            </li>
                        @else
                            <li class="inline-flex items-center">
                                <a href="{{route('defermentApplication.index')}}"
                                   class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                                    </svg>
                                    my applications
                                </a>
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                            </li>
                        @endif
                        <li>
                            <div class="flex items-center">
                                <a href="#"
                                   class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                                    {{$defermentApplication->semester}}
                                </a>
                            </div>
                        </li>
                    </ol>
                    @if(auth()->user()->isStaff() && $defermentApplication->isApprovedByCurrentUser())
                        <a href="{{route('export.pdf',$defermentApplication)}}" class="uppercase border p-2.5 cursor-pointer rounded-lg border-green-700 block text-right text-green-700 font-medium">export application</a>
                    @endif
                </nav>
            </h2>
        </div>
    </x-slot>
    @if(!auth()->user()->isStudent())
        <div class="mb-10 mt-10 sm:w-8/12 mx-auto">
            <div class="my-2 flex justify-between dark:bg-gray-800 capitalize overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white w-1/3 p-2 border rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <b>semester</b>: {{$defermentApplication->semester}}
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <b>type</b>: {{$defermentApplication->type}}
                    </div>
                    <div class="p-6 text-gray-900 capitalize dark:text-gray-100">
                        <b>Student's deferment balance</b>:<span class="font-bold text-xl text-{{$defermentApplication->applicationApprovedCredit($student->id)<=1?'green':'red'}}-800"> {{$defermentApplication->applicationApprovedCredit($student->id)}}</span>  / <span class="font-bold text-xl">2</span>
                    </div>
                    @if($defermentApplication->applicationApprovedCredit($student->id))
                        <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span cla ss="font-bold">Danger alert!</span><br>
                                Student <b class="font-bold">{{$student->user->name}}</b> has already utilized {{$defermentApplication->applicationApprovedCredit($student->id)}} semesters of deferment. <br>
                                Per university policy, students may submit two deferment applications, each for one semester, with the option to extend each once, totaling up to four semesters. Please ensure compliance with this limit by reviewing the student’s deferment history before approving further requests.                            </div>
                        </div>
                    @endif
                </div>
                <div class="w-2/3 p-3 m-7">
                    <form method="post" action="{{route('defermentApplication.update',$defermentApplication)}}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" id="da" value="{{$defermentApplication->id}}">
                        <div class="my-5">
                            <div class="relative z-0 w-full mb-5 group">
                                <input type="text" value="" autofocus name="remarks" id="remarks"
                                       class="block py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"/>
                                <label for="remarks"
                                       class="peer-focus:font-medium absolute text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 text-xl peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">remarks</label>
                            </div>
                            <select name="action" id="action"
                                    {{$defermentApplication->isApprovedByCurrentUser() || $defermentApplication->status ==='rejected'? 'disabled':''}} class="block text-{{DefermentApplication::$color[$defermentApplication->status]}} py-2.5 px-2 w-full font-extrabold text-base bg-transparent border-0 border-b-2 border-{{DefermentApplication::$color[$defermentApplication->status]}} appearance-none  peer">
                                <option value="">Choose Action</option>
                                @foreach($actions as $inx =>$action)
                                    <option value="{{$inx}}"
                                            {{$inx == $defermentApplication->status?'selected':'' }}
                                            class="text-base p-2 block font-extrabold text-blue-800">{{$action}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-white grid grid-cols-4 dark:bg-gray-800 capitalize overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <b>name</b>: {{auth()->user()->isStudent()? $user->name : $student->user->name}}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <b>metric number</b>: {{auth()->user()->isStudent()?$user->metric_no : $student->user->metric_no}}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <b>ID/Passport</b>: {{auth()->user()->isStudent()?$meta->ic : $student->ic}}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <b>Nationality</b>: {{auth()->user()->isStudent()?$meta->nationality : $student->nationality}}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <b>Faculty</b>: {{auth()->user()->isStudent()?$meta->faculty : $student->faculty}}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <b>program code</b>: {{auth()->user()->isStudent()?$meta->program_code : $student->program_code}}
                </div>
            </div>
        </div>
         @if($prevApplications->all())
                <div class="mb-1 mt-1 sm:w-8/12 mx-auto">
                    <h2 class="uppercase text-gray-900 m-2 dark:text-gray-100">previous student's Applications</h2>
                    @foreach($prevApplications as $prevApplication)
                        <a target="_blank" href="{{route('defermentApplication.show',$prevApplication)}}"
                           class="px-5 text-blue-700 border-blue-500">
                            [{{$prevApplication->created_at->format('Y d,M')}} - {{ $prevApplication->semester }} - {{ $prevApplication->type }}]
                        </a>
                    @endforeach
                </div>
            @endif
        <div class="mb-5 mt-5 sm:w-8/12 mx-auto">
            <h2 class="uppercase text-gray-900 m-2 dark:text-gray-100">Application documents</h2>
            @foreach($documents as $document)
                <a href="{{route('document.download',$document)}}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">{{$document->file_name}}
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 19V5m0 14-4-4m4 4 4-4"/>
                    </svg>
                </a>
            @endforeach
        </div>
    @endif
    <div class="py-12 relative mt-20 w-full bg-white max-w-8/12 sm:w-8/12 mx-auto">
        <div class="mx-auto px-10">
            <ol class="relative mb-12  border-s border-gray-200 dark:border-gray-700">
                @foreach($applicationLogs as $date => $log)
                    <li class="mb-10 ms-4">
                        <div
                            class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                        <time
                            class="mb-1 capitalize text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{$date}}</time>
                        @foreach($log as $itm)
                            <div class="border px-4 pt-4 pb-3 mb-5 rounded-lg border-gray-300">
                                <h3 class="capitalize text-lg font-semibold dark:text-white">
                                    {!! \Illuminate\Support\Str::colorStatus($itm->new_status) !!}
                                    @if($stm = $itm->changeByUser())
                                        <span class="uppercase font-bold">By {{ $stm }}</span>
                                    @endif
                                </h3>
                                <p class="mb-4 capitalize text-base font-normal text-gray-500 dark:text-gray-400">
                                <h6 class=" capitalize text-base font-normal text-gray-500 dark:text-gray-400">details
                                    case:</h6>
                                {{$defermentApplication->details}}
                                </p>
                                @if(!empty($itm->remarks))
                                    <div
                                        class="flex items-center p-4 mb-4 w-fit text-left text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
                                        role="alert">
                                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                        </svg>
                                        <span class="sr-only">Info</span>
                                        <div>
                                            <span class="font-medium">Remarks!</span> {{$itm->remarks}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </li>
                @endforeach

            </ol>
        </div>
    </div>
    <script>
        const action = document.getElementById('action');
        action.addEventListener('change', function (e) {
            if (confirm('Are you sure to perform this action?')) {
                e.currentTarget.closest('form').submit();
            }
        });
    </script>
</x-app-layout>
