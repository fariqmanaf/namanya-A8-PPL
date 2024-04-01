<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $id_mantri
 * @property integer $id_semen
 * @property integer $total
 * @property integer $used
 * @property Individual $individual
 * @property JenisSeman $jenisSeman
 */
class StokMantri extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'stok_mantri';

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
    protected $fillable = ['id_mantri', 'id_jenis', 'total', 'used'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individual()
    {
        return $this->belongsTo('App\Models\Individual', 'id_mantri');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisSemen()
    {
        return $this->belongsTo('App\Models\JenisSemen', 'id_jenis');
    }
}
