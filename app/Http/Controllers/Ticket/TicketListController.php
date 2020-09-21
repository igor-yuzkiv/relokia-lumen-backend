<?php


namespace App\Http\Controllers\Ticket;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller;

class TicketListController extends Controller
{
    public function index(Request $request)
    {
        $user = User::first();
        return response($user->getAllPermissions());
    }
}
