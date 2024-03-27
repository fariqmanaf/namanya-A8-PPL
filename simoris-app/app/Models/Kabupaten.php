<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property string $kabupaten
 * @property Alamat[] $alamats
 */
class Kabupaten extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'kabupaten';

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
    protected $fillable = ['kabupaten'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alamats()
    {
        return $this->hasMany('App\Models\Alamat', 'id_kabupaten');
    }
}
