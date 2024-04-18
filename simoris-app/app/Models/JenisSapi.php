<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property string $jenis
 * @property DataSapi[] $dataSapis
 */
class JenisSapi extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'jenis_sapi';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataSapis()
    {
        return $this->hasMany(DataSapi::class);
    }

    public function stok_sb()
    {
        return $this->hasMany(StokSb::class);
    }
}
