<?php

namespace App\Rules;

use App\Models\Document;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class UserHasDocument implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $ad = request()->route('defermentApplication');
        Log::info("Attribute: $attribute, Value: $value");
        $userHasDocument  = Document::where('application_id',$ad->id)->exists();
        $isSubmitting = request()->input('action') === 'submit';
        if (!$userHasDocument && $isSubmitting){
            $fail('Please provide documentation to support your case before submit your application!');
        }
    }


}
