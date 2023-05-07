<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class AssignmentFileUploadRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fileData.data' => ['required',
                File::types([
                    'image/jpeg',
                    'image/gif',
                    'image/png',
                    'application/pdf',
                    'video/mp4',
                    'video/x-ms-wmv',
                    'video/x-msvideo',
                    'video/h264',
                    'video/webm']
                )->max(10 * 1024)],
            'project' => ['required']
        ];
    }
}
