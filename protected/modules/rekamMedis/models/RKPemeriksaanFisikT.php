<?php

class RKPemeriksaanFisikT extends PemeriksaanfisikT{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanfisikT the static model class
	 */
	public $kriteria_td,$namaGCS,$indexmassatubuh;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	* menampilkan paramedis
	* @param type $ruangan_id
	* @return type
	*/
	public function getParamedisItems($ruangan=null)
	{
	    $criteria = new CDbCriteria;
	    $criteria->join = 'LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id LEFT JOIN kelompokpegawai_m ON kelompokpegawai_m.kelompokpegawai_id = pegawai_m.kelompokpegawai_id';
            if (empty($ruangan)){
                $ruangan_id = Yii::app()->user->getState('ruangan_id');
            }else{
                $ruangan_id = $ruangan;
            }
	    
	    $criteria->addCondition('t.ruangan_id='.$ruangan_id);
	    $paramedis = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
	    //$criteria->addCondition('kelompokpegawai_m.kelompokpegawai_id='.$paramedis);
            $criteria->addCondition('kelompokpegawai_m.kelompokpegawai_id <> 1 ');
	    $criteria->order = "pegawai_m.nama_pegawai ASC";
	    return RuanganpegawaiM::model()->findAll($criteria);
	}
	
}
