<?php

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

class FilesRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'files' => ['array','max:1'],
            'files.*' => [ 'file'],
            // 'files' => 'nullable|array',//|max:10', // Example validation rules for up to 10 files
            // 'files.*' => ['file'],
        ];
    }
}
