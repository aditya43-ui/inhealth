<?php

class PPPemeriksaanFisikT extends PemeriksaanfisikT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanfisikT the static model class
	 */
	public $kulit,$mata,$hidung,$tenggorokan,$jantung,$kepala,$telinga,$leher,$payudara,$abdomen;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDokter()
        {
	    return DokterV::model()->findAll();
	}
	
	/**
	* menampilkan paramedis
	* @param type $ruangan_id
	* @return type
	*/
	public function getParamedisItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->join = 'LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id LEFT JOIN kelompokpegawai_m ON kelompokpegawai_m.kelompokpegawai_id = pegawai_m.kelompokpegawai_id';
	    $ruangan_id = Yii::app()->user->getState('ruangan_id');
	    $criteria->addCondition('t.ruangan_id='.$ruangan_id);
	    $paramedis = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
	    $criteria->addCondition('kelompokpegawai_m.kelompokpegawai_id='.$paramedis);
	    
	    return RuanganpegawaiM::model()->findAll($criteria);
	}

}
