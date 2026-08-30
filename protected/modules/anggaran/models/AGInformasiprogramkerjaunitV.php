<?php

/**
 * This is the model class for table "informasiprogramkerjaunit_v".
 *
 * The followings are the available columns in table 'informasiprogramkerjaunit_v':
 * @property integer $rencanggaranpeng_id
 * @property integer $konfiganggaran_id
 * @property string $deskripsiperiode
 * @property integer $unitkerja_id
 * @property string $kodeunitkerja
 * @property string $namaunitkerja
 * @property integer $rencanggaranpengdet_id
 * @property integer $programkerja_id
 * @property string $programkerja_kode
 * @property string $programkerja_nama
 * @property integer $subprogramkerja_id
 * @property string $subprogramkerja_kode
 * @property string $subprogramkerja_nama
 * @property integer $kegiatanprogram_id
 * @property string $kegiatanprogram_kode
 * @property string $kegiatanprogram_nama
 * @property integer $subkegiatanprogram_id
 * @property string $subkegiatanprogram_kode
 * @property string $subkegiatanprogram_nama
 */
class AGInformasiprogramkerjaunitV extends InformasiprogramkerjaunitV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiprogramkerjaunitV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi() {
		$prov = $this->search();
		$prov->criteria->group = 'deskripsiperiode, namaunitkerja, programkerja_kode, subprogramkerja_kode, kegiatanprogram_kode, subkegiatanprogram_kode, '
			. 'subkegiatanprogram_nama, kegiatanprogram_nama, subprogramkerja_nama, programkerja_nama';
		$prov->criteria->select = $prov->criteria->group;
		$prov->criteria->order = 'deskripsiperiode, namaunitkerja, programkerja_kode, subprogramkerja_kode, kegiatanprogram_kode, subkegiatanprogram_kode';
		
		// var_dump($prov->criteria); die;
		
		return $prov;
	}

}