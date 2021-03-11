<?php

namespace CuongDev\Larab\App\Http\Controllers\Api;

use CuongDev\Larab\Abstraction\Core\Controllers\ABaseApiController;
use CuongDev\Larab\Abstraction\Definition\Constant;
use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Definition\StatusCode;
use CuongDev\Larab\App\Models\User;
use CuongDev\Larab\App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ABaseApiController
{
    /** @var UserService $userService */
    protected $userService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->userService = $userService;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);
        $credentials['status'] = Constant::ACTIVE;

        if (!$token = auth()->attempt($credentials)) {
            return $this->apiResponse->setHttpStatusCode(StatusCode::HTTP_UNAUTHORIZED)->failure(null, Message::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token, 'Đăng nhập thành công!');
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return $this->apiResponse->success(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return $this->apiResponse->success(null, 'Đăng xuất thành công!');
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh(), 'Tạo mới token thành công!');
    }

    /**
     * Update profile and refresh a token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $data = $request->all();

        /** @var User $user */
        $user = auth()->user();
        $id = $user['id'];

        $result = $this->userService->update($id, $data);

        return $this->apiResponse->respond($result);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @param null $message
     * @return JsonResponse
     */
    protected function respondWithToken(string $token, $message = null): JsonResponse
    {
        return $this->apiResponse->success([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
        ], $message);
    }
}
