<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\CommonMethods;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\User\Contracts\UserServiceInterface;
use Modules\User\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    use CommonMethods;

    /**
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * LoginController constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {

        $user = $this->userService->findByEmail('email', $request->email);

        if (!$user) {
            return $this->apiResponse(__('messages.email_not_found'), Response::HTTP_NOT_FOUND);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            $data = ['user' => $user, 'token' => $tokenResult];
            return $this->apiResponse(__('messages.Logged'), Response::HTTP_OK, $data);
        } else {
            return $this->apiResponse(__('messages.invalid_password'), Response::HTTP_OK);
        }
    }
}
