<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:5|max:100',
            'last_name' => 'required|max:100',
            'document' => 'required|unique:users,document,' . $this->id,
            'email' => 'required|email|max:150|unique:users,email,' . $this->id,
            'category_id' => 'required|numeric',
            'address' => 'required|max:180',
            'country' => 'required|max:44',
            'phone_number' => 'required|numeric|min:1000000000|max:9999999999',
        ];
    }
}
