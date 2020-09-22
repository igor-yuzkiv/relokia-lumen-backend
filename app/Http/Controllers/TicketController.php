<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;
use Laravel\Lumen\Routing\Controller;

/**
 * Class TicketController
 * @package App\Http\Controllers
 */
class TicketController extends Controller
{
    /**
     * @var UserRepository
     */
    private $UserRepository;

    /**
     * @var TicketRepository
     */
    private $TicketRepository;

    /**
     * TicketController constructor.
     */
    public function __construct()
    {
        $this->UserRepository = app(UserRepository::class);
        $this->TicketRepository = app(TicketRepository::class);
    }


    /**
     * @param Request $request
     * @return Response|ResponseFactory
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                "title" => "required",
                "reporter" => "required",
            ]
        );

        if ($this->UserRepository->userHasRole(Auth::id(), User::USER_ROLE_CUSTOMER)) {
            $ticket = new Ticket();
            $ticket->fill($request->input());
            $ticket->assignee = Auth::id();
            $ticket->status = TicketRepository::TICKET_STATUS_OPEN;

            return ($ticket->save()) ? response(["success"], 200) : response(["Error"], 401);
        } else {
            return \response(["message" => "You don't have access to create ticket"], 403);
        }
    }


    public function getTicketList()
    {
        return response($this->TicketRepository->getAll()->toArray(), 200);
    }
}
