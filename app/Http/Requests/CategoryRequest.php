<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Filter;


class CategoryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'min:3',
                'max:255',
                'required',
                'string',
                'unique:categories',
                'filter:username,bla',
                // new Filter(['username', 'bla']),
            ],


            'parent_id'   => 'required|integer|exists:categories,id',
            'description' => 'nullable|min:5|max:255',
            'image'       => 'required|image|max:512000|dimensions:min_width=300,min_height=300',
            'status'      => 'required|in:active,draft',
        ];
    }


    public function messages()
    {
        return [
            // To Set Your Own MSG
            'name.required' => ' :attribute Is Required',
            'parent_id.integer' => 'You Should Choose Tha Parent',
        ];
    }


}
