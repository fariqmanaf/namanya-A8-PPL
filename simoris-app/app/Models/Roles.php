<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property string $role_name
 * @property UserAccount[] $userAccounts
 */
class Roles extends Model
{
    use HasFactory;
    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['role_name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAccounts()
    {
        return $this->hasMany('App\Models\UserAccount', 'id_roles');
    }
}
