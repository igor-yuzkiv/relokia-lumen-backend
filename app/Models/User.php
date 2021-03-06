<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Spatie\Permission\Traits\HasRoles;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, HasRoles;

    const USER_ROLE_GUEST = "Guest";
    const USER_ROLE_CUSTOMER = "Customer";
    const USER_ROLE_AGENT = "Agent";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'api_key'
    ];

    protected $guard_name = 'api';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @return mixed|null
     */
    public function getUserRole()
    {
        $roles = $this->getRoleNames();
        return isset($roles[0]) ? $roles[0] : null;
    }

    public function assignee()
    {
        $this->hasMany(Ticket::class, "assignee", "id");
    }

    public function reporter()
    {
        $this->hasMany(Ticket::class, "reporter", "id");
    }
}
