<?php

declare(strict_types=1);

namespace App\Http\Requests;

/**
 * Class ClientRequestRequest.php
 *
 * @package App\Http\Requests
 */
class ClientRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'patronymic_name' => 'max:255',
            'email' => 'required|email|max:255|unique:client'
        ];
    }
}