<?php


namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{

    /**
     * @var UserRepository
     */
    private $UserRepository;

    public function __construct()
    {
        $this->UserRepository = app(UserRepository::class);
    }


    /**
     * @param Request $request
     * @return JsonResponse|Response|ResponseFactory
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email|exists:App\Models\User,email",
            "password" => "required",
        ]);

        $user = User::whereEmail($request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            $user->api_key = Hash::make(Str::random(40));
            $user->update();

            return response()->json([
                'api_key' => $user->api_key,
                'user' => $this->UserRepository->getUserInfoByApiKey($user->api_key)
            ]);
        } else {
            return response()->json(['message' => ['Email or password is invalid.']], 401);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function registration(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed",
        ]);

        $user = new User();
        $user->fill($request->input());
        $user->password = Hash::make($request->password);
        $user->api_key = Hash::make(Str::random(40));
        $user->save();

        User::whereId($user->id)->first()->assignRole([User::USER_ROLE_GUEST]);

        return response()->json([
            'api_key' => $user->api_key,
            'user' => $this->UserRepository->getUserInfoByApiKey($user->api_key)
        ]);
    }
}
