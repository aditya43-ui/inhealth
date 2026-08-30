<?php

/**
 * This is the model class for table "nilairujukan_m".
 *
 * The followings are the available columns in table 'nilairujukan_m':
 * @property integer $nilairujukan_id
 * @property integer $pemeriksaanlab_id
 * @property string $nilairujukan_jeniskelamin
 * @property string $kelompokumur
 * @property string $nilairujukan_nama
 * @property double $nilairujukan_min
 * @property double $nilairujukan_max
 * @property string $nilairujukan_satuan
 * @property string $nilairujukan_metode
 * @property string $nilairujukan_keterangan
 * @property boolean $nilairujukan_aktif
 */
class SANilaiRujukanM extends NilairujukanM
{
    public $daftartindakan_id;
    public $jenispemeriksaanlab_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NilairujukanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getNilaiRujukan(){
		return CustomFunction::symbolsConverter($this->nilairujukan_nama);
	}
	public function getNilaiSatuan(){
		return CustomFunction::symbolsConverter($this->nilairujukan_satuan);
	}
}