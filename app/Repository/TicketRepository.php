<?php


namespace App\Repository;

use App\Models\Ticket as Model;

class TicketRepository extends CoreRepository
{
    const TICKET_STATUS_OPEN = "open";
    const TICKET_STATUS_CLOSE = "closed";
    const TICKET_STATUS_ON_HOLD = "on-hold";

    public function getAll()
    {
        $result = $this->startCondition()
            ->orderBy("create_at", "ASC")
            ->get();
        return $result;
    }

    public function getForEdit($id)
    {
        $result = $this->startCondition()
            ->whereId($id)
            ->first();
        return $result;
    }

    protected function getModelClass()
    {
        return Model::class;
    }


}
