<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('task')) {
            return $this->route('task')->user_id === auth()->user()->id;
        }

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
            'title' => 'required|max:255',
            'description' => 'required',
            'due_date'  => 'date',
            'status' => 'required',
        ];
    }

    /**
     * Demo that we can mutate the data in the form request
     */
    public function validationData(): array
    {
        $data = $this->all();

        if ($data['status'] && is_string($data['status'])) {
            $data['status'] = constant('\App\Enums\TaskStatusEnum::' . $data['status']);
        }

        return $data;
    }
}
