<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInfleuncerRequest extends FormRequest
{
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
        if($this->check == 'SocialAccounts'){
            return [
                'first_name'=>['required','min:3','alpha'],
                'last_name'=>['required','min:3','alpha'],
                'email'=>['required','email','unique:users'],
                'phone'=>['required','numeric','min:8'],
                'password'=>['required','min:8','required_with:password_confirmation','confirmed'],
                'password_confirmation'=>['required']
            ];
        }else if($this->check == 'Bio'){
            return [
                /**TODO: When setting up an API client, remember to validate this section
                 * This section is for social media data.Ensure it meets the requirements
                 * like the post , influencer classes and the actual social media platforms
                */
            ];
        }else if($this->check == 'Categories'){
            return [
                'bio'=>['sometimes','max:500'],
            ];
        }

    }
}
