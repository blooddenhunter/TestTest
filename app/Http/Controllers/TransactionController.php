<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Client;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TransactionController
 *
 * @package App\Http\Controllers
 */
class TransactionController extends Controller
{

    /**
     * @param int $clientId
     *
     * @return View
     */
    public function create(int $clientId) : View
    {
        return view(
            'page.transaction.create',
            ['clientId' => $clientId]
        );
    }


    /**
     * @param TransactionRequest $request
     * @param Transaction        $transaction
     *
     * @return Response
     */
    public function store(TransactionRequest $request, Transaction $transaction) : Response
    {
        $client = Client::find($request->input('client_id'));

        if($client->isLocked()){
            abort(404);
        }

        $transaction->fill($request->all());
        $transaction->save();

        return response('success', 200);
    }


    /**
     * @param int $clientId
     *
     * @return Response
     */
    public function getByClientId(int $clientId) : Response
    {
        $transaction = Transaction::where('client_id', $clientId)
            ->orderBy('created_at', 'ASC')
            ->get();

        return response($transaction,200);
    }

    /**
     * @param Transaction $transactionModel
     * @param Request     $request
     *
     * @return View
     */
    public function report(Transaction $transactionModel, Request $request) : View
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $transactions = [];

        if($from && $to){
            $transactions = $transactionModel->report(
                Carbon::parse($from),
                Carbon::parse($to)
            )
                ->get();
        }

        return view('page.transaction.report', ['transactions' => $transactions]);
    }
}