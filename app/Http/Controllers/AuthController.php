<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserRepository $userRepository;   // Репозиторий пользователей

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = UserDTO::toArray($request->validated());
        $user = $this->userRepository->createUser($data);
        $path = storage_path('app/public/users/avatar/')."$user->login.png";
        \Avatar::create($request->first_name.' '.$request->last_name)
            ->setDimension(400, 400)
            ->setFontSize(200)
            ->save($path);
        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'data' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = User::query()->where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('myapp')->plainTextToken;

            return response()->json([
                'data' => $user,
                'token' => $token,
            ]);
        }

        return response()->json(['status' => 401, 'message' => 'Unauthorised'], 401);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth('sanctum')->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json(['status' => true]);
    }

    public function logined(Request $request)
    {
        if (auth('sanctum')->user() == null) {
            return response()->json(['message' => false]);
        } else {
            return response()->json(['message' => true]);
        }
//        return response()->json(["test" => "test","message" => auth('sanctum')->user()]);
    }
}
