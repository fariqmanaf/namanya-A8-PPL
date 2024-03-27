<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $id_alamat
 * @property string $nik
 * @property string $name
 * @property string $tgl_lahir
 * @property string $no_telp
 * @property UserAccount[] $userAccounts
 * @property SuratIzin[] $suratIzins
 * @property DataSapi[] $dataSapis
 * @property StokMantri[] $stokMantris
 * @property Alamat $alamat
 * @property PengajuanSb[] $pengajuanSbs
 * @property LaporanIb[] $laporanIbs
 * @property LaporanIb[] $laporanIbs
 */
class Individuals extends Model
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
    protected $fillable = ['id_alamat', 'nik', 'name', 'tgl_lahir', 'no_telp'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAccounts()
    {
        return $this->hasMany('App\Models\UserAccount', 'id_individual');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suratIzins()
    {
        return $this->hasMany('App\Models\SuratIzin', 'id_mantri');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataSapis()
    {
        return $this->hasMany('App\Models\DataSapi', 'id_peternak');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stokMantris()
    {
        return $this->hasMany('App\Models\StokMantri', 'id_mantri');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alamat()
    {
        return $this->belongsTo('App\Models\Alamat', 'id_alamat');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengajuanSbs()
    {
        return $this->hasMany('App\Models\PengajuanSb', 'id_mantri');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function laporanIbs()
    {
        return $this->hasMany('App\Models\LaporanIb', 'id_peternak');
        return $this->hasMany('App\Models\LaporanIb', 'id_mantri');
    }
}
