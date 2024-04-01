<?php

namespace App\Models;

use App\Models\Individuals;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * @property integer $id
 * @property integer $id_individual
 * @property integer $id_roles
 * @property string $email
 * @property string $password
 * @property string $status
 * @property Individual $individual
 * @property Role $role
 */
class UserAccounts extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
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
    protected $fillable = ['id','individuals_id', 'roles_id', 'email', 'password', 'status'];
    protected $casts = ['password' => 'hashed'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individual()
    {
        return $this->belongsTo(Individuals::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Roles::class);
    }
}
