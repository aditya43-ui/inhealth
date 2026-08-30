<?php

class PIPemeriksaanFisikT extends PemeriksaanfisikT
{
	public $namaGCS, $gcs_jenis,$ppds_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanfisikT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
	    $paramedis = array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN);
        
        if (in_array($ruangan_id, array(Params::RUANGAN_ID_NICU, Params::RUANGAN_ID_BAYI_SAKIT))) {
            $paramedis[] = Params::KELOMPOKPEGAWAI_ID_BIDAN;
        }
        
	    $criteria->compare('kelompokpegawai_m.kelompokpegawai_id', $paramedis);
	    
	    return RuanganpegawaiM::model()->findAll($criteria);
	}

	
	public function getPPDS(){
							
		return PpdsM::model()->findAllByAttributes(array('ppds_aktif'=>true),array('order'=>'ppds_nama ASC'));
	}
	
}
