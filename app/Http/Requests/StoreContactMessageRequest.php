<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:160'],
            'entreprise' => ['nullable', 'string', 'max:160'],
            'email' => ['required', 'email:rfc,dns', 'max:190'],
            'telephone' => ['nullable', 'string', 'max:40'],
            'sujet' => ['required', 'string', 'max:190'],
            'type_demande' => ['required', 'in:Commercial,Partenariat,Recrutement,Média,Support'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'website' => ['prohibited'],
        ];
    }
}
