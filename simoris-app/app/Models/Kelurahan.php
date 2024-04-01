<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property string $kelurahan
 * @property Alamat[] $alamats
 */
class Kelurahan extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'kelurahan';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['kelurahan'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alamat()
    {
        return $this->hasMany(Alamat::class);
    }
}
