<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepository $userRepository;   // Репозиторий пользователей

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function AllUsers(Request $request): \Illuminate\Http\JsonResponse
    {
        $users = $this->userRepository->allUsers();

        return response()->json($users);
    }

    public function profile(): \Illuminate\Http\JsonResponse
    {
        $data = $this->userRepository->getUser(auth('sanctum')->id());

        return response()->json(['logined' => true, 'data' => $data ?? null]);
    }

    public function destory(int $id): \Illuminate\Http\JsonResponse
    {
        $user = $this->userRepository->deleteUser($id);

        return response()->json($user);
    }

    public function updateProfile()
    {
    }
}
