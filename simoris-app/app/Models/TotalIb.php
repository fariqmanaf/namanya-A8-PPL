<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $id_laporan
 * @property integer $id_semen
 * @property string $tgl_ib
 * @property LaporanIb $laporanIb
 * @property JenisSeman $jenisSeman
 */
class TotalIb extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'total_ib';

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
    protected $fillable = ['id_laporan', 'id_semen', 'tgl_ib'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function laporanIb()
    {
        return $this->belongsTo('App\Models\LaporanIb', 'id_laporan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisSeman()
    {
        return $this->belongsTo('App\Models\JenisSeman', 'id_semen');
    }
}
