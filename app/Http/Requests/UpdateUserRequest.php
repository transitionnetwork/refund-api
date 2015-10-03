<?php

namespace App\Http\Requests;

class UpdateUserRequest extends Request
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
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|unique:users,email,' . $this->route()->getParameter('users')->id,
        ];
    }

    /**
     * Return a JSON response if an error occurs
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        $error_message = '';

        $i = 0;
        foreach ($errors as $error)
        {
            foreach ($error as $key => $field)
            {
                $error_message .= ($i > 0) ? ' ' . $field : $field;

                $i++;
            }
        }

        return response()->json(['message' => $error_message, 'code' => 422], 422);
    }
}
