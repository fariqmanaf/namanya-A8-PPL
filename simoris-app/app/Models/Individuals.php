<?php

namespace App\Models;

use App\Models\UserAccounts;
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
    protected $fillable = ['id', 'nik', 'name', 'tgl_lahir', 'no_telp', 'alamats_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAccounts()
    {
        return $this->hasMany(UserAccounts::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suratIzins()
    {
        return $this->hasMany(SuratIzin::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataSapis()
    {
        return $this->hasMany(DataSapi::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stokMantris()
    {
        return $this->hasMany(StokMantri::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wilayah_kerja()
    {
        return $this->hasMany(WilayahKerja::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alamat()
    {
        return $this->belongsTo(Alamat::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengajuanSbs()
    {
        return $this->hasMany(PengajuanSb::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function laporanIbs()
    {
        return $this->hasMany(LaporanIb::class);
    }
}
