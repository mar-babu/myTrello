<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
        return [
            'workspace_id' => 'required|exists:workspaces,id',
            'name' => 'required|unique:projects|max:255',
            'description' => 'required',
            'cost' => 'required',
            'to_date' => 'required|date',
            'address' => 'required|max:255',
        ];
    }
}
