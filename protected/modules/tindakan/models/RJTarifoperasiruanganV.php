<?php

/**
 * This is the model class for table "tarifoperasiruangan_v".
 *
 * The followings are the available columns in table 'tarifoperasiruangan_v':
 * @property integer $kegiatanoperasi_id
 * @property string $kegiatanoperasi_kode
 * @property string $kegiatanoperasi_nama
 * @property integer $operasi_id
 * @property string $operasi_kode
 * @property string $operasi_nama
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property integer $komponenunit_id
 * @property string $komponenunit_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $tindakanmedis_nama
 * @property string $daftartindakan_katakunci
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $jenistarif_id
 * @property string $jenistarif_nama
 * @property integer $perdatarif_id
 * @property string $perdanama_sk
 * @property string $noperda
 * @property string $tglperda
 * @property string $perdatentang
 * @property string $ditetapkanoleh
 * @property string $tempatditetapkan
 * @property double $hargaoperasi
 * @property double $hargaoperasidenganpenyulit
 */
class RJTarifoperasiruanganV extends TarifoperasiruanganV
{
	public $is_pilih;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarifoperasiruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}