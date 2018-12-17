<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Grpcserver;

/**
 */
class UserApiClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Grpcserver\GetUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetUser(\Grpcserver\GetUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grpcserver.UserApi/GetUser',
        $argument,
        ['\Grpcserver\User', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Grpcserver\CreateUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateUser(\Grpcserver\CreateUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grpcserver.UserApi/CreateUser',
        $argument,
        ['\Grpcserver\User', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Grpcserver\UpdateUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateUser(\Grpcserver\UpdateUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grpcserver.UserApi/UpdateUser',
        $argument,
        ['\Grpcserver\User', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Grpcserver\DeleteUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteUser(\Grpcserver\DeleteUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/grpcserver.UserApi/DeleteUser',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
