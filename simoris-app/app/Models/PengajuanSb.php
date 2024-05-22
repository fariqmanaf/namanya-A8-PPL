<?php

namespace App\Models;

use App\Models\Individuals;
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
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individuals()
    {
        return $this->belongsTo(Individuals::class);
    }

    public function detailPengajuan()
    {
        return $this->hasMany(DetailPengajuan::class);
    }
}
