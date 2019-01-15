<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enum\Transaction\EnumTransactionType;

/**
 * Class TransactionRequest
 *
 * @package App\Http\Requests
 */
class TransactionRequest extends Request
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
            'client_id' => 'required',
            'sum' => 'required|integer|max:10000|min:1',
            'type' => 'required|in:'. EnumTransactionType::DEFAULT . ',' . EnumTransactionType::REFUND
        ];
    }
}