package main

import (
	"context"
	"fmt"
	_ "github.com/go-sql-driver/mysql"
	"github.com/golang/protobuf/ptypes/empty"
	"github.com/jmoiron/sqlx"
	pb "github.com/niikunihiro/grpcserver/proto"
	"google.golang.org/grpc"
	"google.golang.org/grpc/reflection"
	"log"
	"net"
)

type User struct {
	ID        uint32 `db:"user_id"`
	Username  string `db:"username"`
	Email     string `db:"email"`
	BirthDate string `db:"birth_date"`
}

type UserServer struct {
	db *sqlx.DB
}

func (us UserServer) GetUser(ctx context.Context, req *pb.GetUserRequest) (*pb.User, error) {
	var user User

	err := us.db.Get(&user, "SELECT user_id, username, email, birth_date FROM users WHERE username = ?", req.Username)
	if err != nil {
		panic(err.Error())
	}

	return &pb.User{
		UserId:    user.ID,
		Username:  user.Username,
		Email:     user.Username,
		BirthDate: user.BirthDate,
	}, nil
}

func (us UserServer) CreateUser(ctx context.Context, req *pb.CreateUserRequest) (*pb.User, error) {
	var user User

	result, err := us.db.Exec(
		"INSERT INTO users (username, email, birth_date) VALUES(?, ?, ?)",
		req.Username,
		req.Email,
		req.BirthDate,
	)
	if err != nil {
		panic(err.Error())
	}
	id, err := result.LastInsertId()
	if err != nil {
		panic(err.Error())
	}

	err = us.db.Get(&user, "SELECT user_id, username, email, birth_date FROM users WHERE user_id = ?", id)
	if err != nil {
		panic(err.Error())
	}
	return &pb.User{
		UserId:    user.ID,
		Username:  user.Username,
		Email:     user.Username,
		BirthDate: user.BirthDate,
	}, nil
}

func (us UserServer) UpdateUser(ctx context.Context, req *pb.UpdateUserRequest) (*pb.User, error) {
	var user User

	return &pb.User{
		UserId:    user.ID,
		Username:  user.Username,
		Email:     user.Username,
		BirthDate: user.BirthDate,
	}, nil
}

func (us UserServer) DeleteUser(ctx context.Context, req *pb.DeleteUserRequest) (*empty.Empty, error) {
	var e *empty.Empty

	return e, nil
}

func main() {
	lis, err := net.Listen("tcp", ":18686")
	if err != nil {
		log.Fatalf("failed to listen %v", err)
	}

	db, err := sqlx.Connect("mysql", "root:musclebeauty!@tcp(127.0.0.1:13306)/grpcserver")
	if err != nil {
		fmt.Println("Failed to run mysql: ", err)
		log.Fatalln("Failed to run mysql: ", err)
	}

	s := grpc.NewServer()
	pb.RegisterUserApiServer(s, &UserServer{db: db})
	reflection.Register(s)
	if err := s.Serve(lis); err != nil {
		log.Fatalf("failed to serve: %v", err)
	}
}
