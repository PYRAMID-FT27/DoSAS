<?php

namespace App\Http\Requests;

use App\Models\DefermentApplication;
use App\Models\Document;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreDefermentApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::isLoginBy() ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $roles = DefermentApplication::$roles;
        $docsRule['docs'] = Rule::requiredIf(function () {
            $isSubmitting = request()->input('action') === 'submit';
            return $isSubmitting && !$this->request->get('docs');
        });
        $roles = array_merge($docsRule, $roles);
        return $roles;

    }
    public function messages()
    {
        $docsErorrMessage['docs.required'] = 'Please provide documentation to support your case before submit your application!!';
        $msg = DefermentApplication::$errorMessages;
        $msg = array_merge($docsErorrMessage, $msg);
        return $msg;
    }
}
