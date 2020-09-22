<?php


namespace App\Http\Controllers\Auth;


use App\Repository\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller;

class UserController extends Controller
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
     * @return Response|ResponseFactory
     */
    public function getUserPermissions()
    {
        $userPermissions = Auth::user()->getAllPermissions();
        return response($userPermissions);
    }

    public function getUserList()
    {
        $userList = $this->UserRepository->getUsersForSelect();
        return \response()->json($userList->toArray());
    }
}
