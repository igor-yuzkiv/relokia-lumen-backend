<?php


namespace App\Http\Controllers\Auth;


use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function getUserPermissions ()
    {
        $userPermissions = Auth::user()->getAllPermissions();
        return response($userPermissions);
    }
}
