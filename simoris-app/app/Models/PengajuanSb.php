<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $id_mantri
 * @property integer $id_jenis
 * @property integer $jumlah
 * @property boolean $is_taken
 * @property string $tanggal
 * @property Individual $individual
 * @property JenisSeman $jenisSeman
 */
class PengajuanSb extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pengajuan_sb';

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
    protected $fillable = ['id_mantri', 'id_jenis', 'jumlah', 'is_taken', 'tanggal'];

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
    public function jenisSeman()
    {
        return $this->belongsTo('App\Models\JenisSeman', 'id_jenis');
    }
}
