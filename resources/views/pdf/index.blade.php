<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="{{ url('/') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application for Deferment of Study (International Student)</title>
    <link rel="stylesheet" media="print">

    <style>
        body {
            font-family: 'Times New Roman', serif; /* Classic and widely used in official documents */
            font-size: 12pt; /* Standard readable size for body text */
        }

        h2, h3 {
            font-family: 'Arial', sans-serif; /* Clear and legible for headings */
            font-size: 14pt; /* Slightly larger for section titles */
        }
        #computer-remarks {
            background-color: #f0f0f0; /* Light grey background */
            border-left: 4px solid #007BFF; /* Blue left border for emphasis */
            padding: 10px; /* Padding for aesthetics */
            margin-top: 10px; /* Margin to separate from other form elements */
            font-style: italic; /* Italicize text to indicate automated processing */
        }

        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { margin-bottom: 20px; }
        .header { font-size: 20px; font-weight: bold; margin-bottom: 10px; }
        .sub-header { font-size: 16px; font-weight: bold; }
        .content { margin-left: 20px; }
        .form-field { margin-bottom: 10px; }
        label { display: block; }
        input[type="text"], input[type="date"], textarea { width: 100%; padding: 8px; margin: 4px 0 8px; border: 1px solid #ccc; border-radius: 4px; }
        .checkbox-group { margin-bottom: 10px; }
        .checkbox-label { margin-right: 20px; }
        .signature { font-style: italic; }
    </style>
</head>
<body style="width: 85%; margin: auto;">
<div style="display: flex; border: 1px solid #4B5563; margin-top: 1.25rem">
    <div style="border-right: 1px solid #4B5563; border-left: 1px solid #4B5563; width: 100%; font-size: 1.875rem; line-height: 2.25rem; padding-top: 4rem; font-weight: bold; text-align: center; display: flex; align-items: center; justify-content: center; border-color: #4B5563;" class=" border-r border-l w-6/12 text-3xl py-16 items-center align-middle font-bold text-center justify-center border-gray-700">
        Application for Deferment of Study
    </div>
    <div style="text-align: left; padding-top: 2.5rem; padding-bottom: 0.5rem; padding-left: 1.25rem; padding-right: 1.25rem; align-items: center;" class="text-left py-10 px-5 align-middle">
        <div>Form No.: <strong>UTM/AMD/{{$defermentApplication->id}}</strong></div>
        <div>Edition: <strong>3</strong></div>
        <div>Effective Date: <strong>{{$defermentApplication->created_at->format('Y M, d')}}</strong></div>
        <div>Page(s): 2</div>
    </div>
</div>

<div class="section">
    <div class="font-bold text-base">Terms and Conditions:</div>
    <ol class="ml-14 mt-2 text-sm list-decimal">
        <li class="leading-5">Fill and COMPLETE the form.</li>
        <li class="leading-5">Read and sign the Student Declaration at Section II.</li>
        <li class="leading-5">Obtain approval from UTM International and your Faculty.</li>
        <li class="leading-5">Submit the COMPLETE form and documents related to Faculty Academic Office.</li>
        <li class="leading-5">Please note that completion of this form does not guarantee that you will be granted for deferment.</li>
        <li class="leading-5">Tuition fee is chargeable if registered course/s. Refer to UTM Rules (Student Financial) Part V – Sub-rules 9 (3) for more information. It is accessible at Finance menu in My UTM portal.</li>
    </ol>
</div>

<div class="section">
    <div class="font-bold border-b-4 mt-3 border-b-black text-black">Section I: To be completed by student</div>
    <div class="flex text-center align-middle justify-center">
        <label class="block m-auto w-1/3" for="full-name">Full Name:</label>
        <input type="text" disabled value="{{$student->user->name}}" class="w-2/3 border-2 border-gray-500 p-2 rounded-md w-1/2 focus:border-teal-500 focus:outline-none" id="full-name" name="full-name">
    </div>
    <div class="flex text-center align-middle justify-center">
        <label class="block m-auto w-1/3" for="full-name">ID/PASSPORT:</label>
        <input type="text" disabled value="{{$student->ic}}" class="block m-auto w-2/3" id="full-name" name="full-name">
    </div>
    <div class="flex text-center align-middle justify-center">
        <label class="block m-auto w-1/3" for="full-name">Metric Number:</label>
        <input type="text" disabled value="{{$student->user->metric_no}}" class="block m-auto w-2/3" id="full-name" name="full-name">
    </div>
    <div class="flex text-center align-middle justify-center">
        <label class="block m-auto w-1/3" for="full-name">Nationality:</label>
        <input type="text" disabled value="{{$student->nationality}}" class="block m-auto w-2/3" id="full-name" name="full-name">
    </div>
    <div class="flex text-center align-middle justify-center">
        <label class="block m-auto w-1/3" for="full-name">Program Code:</label>
        <input type="text" disabled value="{{$student->program_code}}" class="block m-auto w-2/3" id="full-name" name="full-name">
    </div>
    <div class="flex text-center align-middle justify-center">
        <label class="block m-auto w-1/3" for="full-name">Faculty:</label>
        <input type="text" disabled value="{{$student->faculty}}" class="block m-auto w-2/3" id="full-name" name="full-name">
    </div>
</div>

<div class="section">
    <form action="/submit-deferment-form" method="post">
        <div class="form-section">
            <h3 class="font-bold border-b-4 mt-3 border-b-black text-black">Section II: Details of Deferment (to be completed by student)</h3>
            <!-- Deferred before? -->
            <div style="display: flex; justify-content: space-between; width: 66.666667%; margin-top: 1rem; margin-left: auto; margin-right: auto;" class="checkbox-group mt-4 flex justify-between w-8/12 m-auto">
                <label><input type="checkbox" <?= empty($prevApplication)?'disabled':'checked' ?> name="deferred-before" value="yes"> Yes, I have deferred my study before.</label>
                <label><input type="checkbox" <?= empty($prevApplication)?'checked':'disabled' ?> name="deferred-before" value="no"> No, I have not deferred my study before.</label>
            </div>
            <div style="display: flex; justify-content: space-between; width: 66.666667%; margin-top: 1rem; margin-left: auto; margin-right: auto;" class="w-full flex mt-5 mx-auto">
                <div class="w-1/2 mx-3">
                    <label for="previous-defer-session">If yes, I deferred during Session/Semester:</label>
                    <input type="text" disabled
                    id="previous-defer-session" name="previous-defer-session" value="{{$prevApplication->semester}}" placeholder="">

                </div>
                <div class="w-1/2 mx-3">
                    <label for="wish-defer-session">I wish to defer my study during Session/Semester:</label>
                    <input disabled type="text"
                           id="wish-defer-session"
                           name="wish-defer-session"
                           value="{{$defermentApplication->semester}}"
                           placeholder="">
                </div>
            </div>

            <!-- Reasons for deferment -->
            <p class="m-3 p-3">Reason for deferment (please tick appropriate):</p>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr);" class="checkbox-group grid grid-cols-3 gap-5">
                <label style="margin: 10px;"><input type="checkbox" disabled {{$defermentApplication->type =='financial'?'checked':''}} name="reason-for-defer" value="financial-difficulties"> Financial Difficulties</label>
                <label style="margin: 10px;"><input type="checkbox" disabled {{$defermentApplication->type =='personal'?'checked':''}} name="reason-for-defer" value="personal-matters"> Personal Matters</label>
                <label style="margin: 10px;"><input type="checkbox" disabled {{$defermentApplication->type =='medical'?'checked':''}} name="reason-for-defer" value="health-problem"> Health Problem</label>
                <label style="margin: 10px;"><input type="checkbox" disabled {{$defermentApplication->type =='academic'?'checked':''}} name="reason-for-defer" value="university-nation-interests"> University/Nation Interests</label>
                <label style="margin: 10px;"><input type="checkbox" disabled {{$defermentApplication->type =='other'?'checked':''}} name="reason-for-defer" value="others"> Others </label>
            </div>
            <p class="m-3 p-3">Your case:</p>
            <textarea id="reason-for-defer-specify" disabled name="reason-for-defer-specify" rows="4" placeholder="">{{$defermentApplication->details}}
            </textarea>
            <div class="form-section">
                <h3 class="underline font-bold">Student Declaration</h3>
                <p>I understand that if the deferment is not approved and I do not register any courses, I will be terminated from my study which may affect my Student Pass. If the deferment is approved, the Department of Immigration of Malaysia will be notified by UTM International Office that I am deferring my study, and that may result in the cancellation of my Student Pass. I am obliged to pay any outstanding fees to UTM.</p>

                <label for="student-agreement">I agree to the above terms:</label>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); margin-top: 1.25rem; margin-bottom: 1.25rem;" class="grid grid-cols-4 gap-1 my-5">
                    <div class="">
                        <label><input disabled type="checkbox" checked id="student-agreement" name="student-agreement" value="agree"> Agree</label>
                    </div>
                    <label for="declaration-date">Date:</label>{{  $defermentApplication->submitted_at }}
                </div>
            </div>
        </div>
        @foreach($applicationLogs as $log)
            @if($loop->first)
                <div class="form-section">
                    <h3 class="font-bold border-b-4 mt-3 border-b-black text-black">Section IV: Supervisor Recommendation (For Postgraduate Student - Research & Mixed Mode)</h3>
                    <div class="w-full flex my-5">
                        <label class="mx-10">Recommendation:</label>
                        <div style="width: 66.666667%; margin: auto; display: flex;" class=" w-4/6 m-auto flex">
                            <label style="width: 33.33%;" class="w-1/3"><input type="checkbox" disabled {{$log->action_type=='Approval'?'checked':''}} name="supervisor-recommendation" value="recommended"> Recommended</label>
                            <label  style="width: 33.33%;"  class="w-1/3"><input type="checkbox" disabled {{$log->action_type=='Rejection'?'checked':''}} name="supervisor-recommendation" value="not-recommended"> Not Recommended</label>
                        </div>
                    </div>
                    <label for="supervisor-comments">Supervisor’s Comments:</label>
                    <textarea id="supervisor-comments" name="supervisor-comments" rows="3" disabled placeholder="Comments by Supervisor...">{{$log->remarks}}</textarea>
                    <div style="width: 33.33%; display: flex;" class="flex justify-between">
                        <label style="width: 33.33%" class="w-3/12" for="">Date:</label> {{$log->created_at->format('Y-m, D')}}
                    </div>
                </div>
            @endif

            <div class="form-section">
                <h3 class="font-bold border-b-4 mt-3 border-b-black text-black">Section V: Approval by Assoc. Chair/Director or Coordinator of the Faculty/School</h3>
                <div style="width: 100%; margin: auto; display: flex;padding-bottom: 2%" class="w-full flex my-5">
                    <label class="mx-10">Approval Status:</label>
                    <div style="width: 66.666667%; margin: auto; display: flex;" class=" w-4/6 m-auto flex">
                        <label style="width: 33.33%;" class="w-1/3"><input type="checkbox" disabled {{$log->action_type=='Approval'?'checked':''}} name="supervisor-recommendation" value="recommended"> Approved</label>
                        <label style="width: 33.33%;" class="w-1/3"><input type="checkbox" disabled {{$log->action_type=='Rejection'?'checked':''}} name="supervisor-recommendation" value="not-recommended"> Not Approved</label>
                    </div>
                </div>

                <label for="faculty-comments">Comments:</label>
                <textarea id="faculty-comments" name="faculty-comments" rows="3" disabled placeholder="Comments by Assoc. Chair/Director or Coordinator...">{{$log->remarks}}</textarea>
                <div style="width: 33.33%; display: flex;" class="flex justify-between">
                    <label style="width: 33.33%" class="w-3/12" for="">Date:</label> {{$log->created_at->format('Y-m, D')}}
                </div>
            </div>
            <div class="form-section">
                <h3 class="font-bold border-b-4 mt-3 border-b-black text-black">Section III: To Be Completed by UTM International Office</h3>
                <div style="width: 100%; margin: auto; display: flex;padding-bottom: 2%" class="w-full flex my-5">
                    <label class="mx-10">Decision:</label>
                    <div style="width: 66.666667%; margin: auto; display: flex;" class=" w-4/6 m-auto flex">
                        <label class="w-1/3"><input type="checkbox"  disabled {{$log->action_type=='Approval'?'checked':''}} name="supervisor-recommendation" value="recommended"> Approved</label>
                        <label class="w-1/3"><input type="checkbox" disabled {{$log->action_type=='Rejection'?'checked':''}} name="supervisor-recommendation" value="not-recommended"> Not Approved</label>
                    </div>
                </div>
                <label for="officer-comments">Comments:</label>
                <textarea disabled id="officer-comments" name="officer-comments" rows="3" placeholder="Comments by UTM International Office...">{{$log->remarks}}</textarea>
                <div style="width: 33.33%; display: flex;" class="flex justify-between">
                    <label style="width: 33.33%" class="w-3/12" for="">Date:</label> {{$log->created_at->format('Y-m, D')}}
                </div>
            </div>
            @if($loop->last)
                    <div class="form-section">
                        <h3 class="font-bold border-b-4 mt-3 border-b-black text-black">Section VI: For Faculty Academic Office Use Only</h3>
                        <div style="width: 66.666667%; margin: auto; display: flex;" class="w-full flex my-5">
                            <label class="mx-10">Final Decision:</label>
                            <div style="width: 66.666667%; margin: auto; display: flex;" class=" w-4/6 m-auto flex">
                                <label class="w-1/3"><input type="checkbox" disabled {{$log->action_type=='Approval'?'checked':''}} name="supervisor-recommendation" value="recommended"> Deferment Granted</label>
                                <label class="w-1/3"><input type="checkbox" disabled {{$log->action_type=='Rejection'?'checked':''}} name="supervisor-recommendation" value="not-recommended"> Deferment Denied</label>
                            </div>
                        </div>
                        <label for="academic-office-comments">Comments:</label>
                        <textarea id="academic-office-comments" name="academic-office-comments" disabled rows="3" placeholder="Comments by Faculty Academic Office...">{{$log->remarks}}</textarea>
                        <div style="width: 33.33%; display: flex;" class="flex justify-between">
                            <label style="width: 33.33%" class="w-3/12" for="">Date:</label> {{$log->created_at->format('Y-m, D')}}
                        </div>
                    </div>
            @endif

        @endforeach
        <div class="form-section my-10">
            <h3 class="font-bold border-b-4 mt-3 border-b-black text-black">U.T.M DoSAS - Generated Remarks</h3>
            <p id="computer-remarks">These remarks are generated based on the information provided in the application and do not require a manual signature.</p>
        </div>
    </form>
</div>
</body>
</html>
