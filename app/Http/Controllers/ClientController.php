<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * @return View
     */
    public function index() : View
    {
        $clients = Client::paginate(25);

        return view('page.client.index', ['clients' => $clients]);
    }


    /**
     * @return View
     */
    public function create() : View
    {
        return view('page.client.create');
    }


    /**
     * @param ClientRequest $request
     * @param Client        $client
     *
     * @return Response
     */
    public function store(ClientRequest $request, Client $client) : Response
    {
        $client->fill($request->all());
        $client->save();

        return response('success', 200);
    }

    /**
     * @param int $clientId
     *
     * @return Response
     */
    public function locked(int $clientId) : Response
    {
        $client = Client::find($clientId);

        if($client->isLocked()){
            return abort(404);
        }

        $client->ban();

        return response($client, 200);
    }
}