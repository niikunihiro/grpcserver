<?php

namespace App\Http\Controllers;

use Grpc\ChannelCredentials;
use Grpcserver\CreateUserRequest;
use Grpcserver\GetUserRequest;
use Grpcserver\UpdateUserRequest;
use Grpcserver\UserApiClient;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /** @var UserApiClient $client */
    private $client;

    /**
     * Create a new controller instance.
     *
     * @param UserApiClient $apiClient
     */
    public function __construct(UserApiClient $apiClient)
    {
        $this->client = $apiClient;
    }

    public function show(GetUserRequest $request, $username)
    {
        $request->setUsername($username);

        /** @var \Grpcserver\User $reply */
        list($reply, $status) = $this->client->GetUser($request)->wait();

        return response()->json([
            'user_id' => $reply->getUserId(),
            'username' => $reply->getUserName(),
            'email' => $reply->getEmail(),
            'birth_date' => $reply->getBirthDate(),
        ]);
    }

    /**
     * @param CreateUserRequest $userRequest
     * @param Request $request
     * @return array
     */
    public function store(CreateUserRequest $userRequest, Request $request)
    {
        $userRequest->setUsername($request->input('username'));
        $userRequest->setEmail($request->input('email'));
        $userRequest->setBirthDate($request->input('birth_date'));

        /** @var \Grpcserver\User $reply */
        list($reply, $status) = $this->client->CreateUser($userRequest)->wait();

        return response()->json([
            'user_id' => $reply->getUserId(),
            'username' => $reply->getUserName(),
            'email' => $reply->getEmail(),
            'birth_date' => $reply->getBirthDate(),
        ]);
    }

    /**
     * @param UpdateUserRequest $userRequest
     * @param Request           $request
     * @param string            $username
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $userRequest, Request $request, string $username)
    {
        $userRequest->setUserId($request->input('user_id'));
        $userRequest->setUsername($request->input('username'));
        $userRequest->setEmail($request->input('email'));
        $userRequest->setBirthDate($request->input('birth_date'));

        /** @var \Grpcserver\User $reply */
        list($reply, $status) = $this->client->UpdateUser($userRequest)->wait();

        return response()->json([
            'user_id' => $reply->getUserId(),
            'username' => $reply->getUserName(),
            'email' => $reply->getEmail(),
            'birth_date' => $reply->getBirthDate(),
        ]);
    }
}
