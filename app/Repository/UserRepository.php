<?php


namespace App\Repository;

use App\Models\User;
use App\Models\User as Model;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends CoreRepository
{

    function getUsersForSelect()
    {
        $result = $this->startCondition()
            ->select(["id", "name"])
            ->get();
        return $result;
    }

    /**
     * @param string $api_key
     * @return mixed|User
     */
    public function getUserInfoByApiKey(string $api_key)
    {
        $user = $this->startCondition()
            ->where("api_key", $api_key)
            ->first();
        $user->getRoleNames();
        return $user;
    }

    /**
     * @param $userId
     * @param $roles
     * @return bool
     */
    public function userHasRole($userId, $roles): bool
    {
        return $this
            ->startCondition()
            ->whereId($userId)
            ->first()
            ->hasRole($roles);
    }

    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }
}
