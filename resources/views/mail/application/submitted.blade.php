<x-mail::message>
#    New Deferment Application Submitted

      Hello Supervisor,
      A new deferment application has been submitted,

      Applicant: {{ $da->student->user->name }}
     Please review the application at your earliest convenience.

    <x-mail::button :url="$buttonRoute">
        view application
    </x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
