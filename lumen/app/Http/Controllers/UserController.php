<?php

namespace App\Http\Controllers;

use Grpc\ChannelCredentials;
use Grpcserver\CreateUserRequest;
use Grpcserver\GetUserRequest;
use Grpcserver\UserApiClient;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /** @var UserApiClient $client */
    private $client;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new UserApiClient('host.docker.internal:18686', [
            'credentials' => ChannelCredentials::createInsecure(),
        ]);
    }

    public function show($username)
    {
        $request = new GetUserRequest;
        $request->setUsername($username);

        /** @var \Grpcserver\User $reply */
        list($reply, $status) = $this->client->GetUser($request)->wait();

        return json_encode([
            'user_id' => $reply->getUserId(),
            'username' => $reply->getUserName(),
            'email' => $reply->getEmail(),
            'birth_date' => $reply->getBirthDate(),
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $userRequest = new CreateUserRequest;
        $userRequest->setUsername($request->input('username'));
        $userRequest->setEmail($request->input('email'));
        $userRequest->setBirthDate($request->input('birth_date'));

        /** @var \Grpcserver\User $reply */
        list($reply, $status) = $this->client->CreateUser($userRequest)->wait();
        return json_encode([
            'user_id' => $reply->getUserId(),
            'username' => $reply->getUserName(),
            'email' => $reply->getEmail(),
            'birth_date' => $reply->getBirthDate(),
        ]);
    }
}
