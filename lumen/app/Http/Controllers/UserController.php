<?php

namespace App\Http\Controllers;

use Grpc\ChannelCredentials;
use Grpcserver\GetUserRequest;
use Grpcserver\UserApiClient;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show($username)
    {
        $client = new UserApiClient('host.docker.internal:18686', [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);
        $request = new GetUserRequest;
        $request->setUsername($username);

        /** @var \Grpcserver\User $reply */
        list($reply, $status) = $client->GetUser($request)->wait();

        return json_encode([
            'user_id' => $reply->getUserId(),
            'username' => $reply->getUserName(),
            'email' => $reply->getEmail(),
            'birth_date' => $reply->getBirthDate(),
        ]);
    }
}
