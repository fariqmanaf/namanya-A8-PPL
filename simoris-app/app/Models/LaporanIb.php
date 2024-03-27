<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $id_sapi
 * @property integer $id_peternak
 * @property integer $id_mantri
 * @property integer $kode_pejantan
 * @property integer $kode_pembuatan
 * @property boolean $status_bunting
 * @property TotalIb[] $totalIbs
 * @property DataSapi $dataSapi
 * @property Individual $individual
 * @property Individual $individual
 */
class LaporanIb extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'laporan_ib';

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
    protected $fillable = ['id_sapi', 'id_peternak', 'id_mantri', 'kode_pejantan', 'kode_pembuatan', 'status_bunting'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function totalIbs()
    {
        return $this->hasMany('App\Models\TotalIb', 'id_laporan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataSapi()
    {
        return $this->belongsTo('App\Models\DataSapi', 'id_sapi');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individual()
    {
        return $this->belongsTo('App\Models\Individual', 'id_peternak');
        return $this->belongsTo('App\Models\Individual', 'id_mantri');
    }
}
