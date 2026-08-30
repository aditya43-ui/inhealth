<?php

class RIPemeriksaanFisikT extends PemeriksaanfisikT
{
	public $namaGCS;
	public $gambartubuh_id, $file_sample, $temp_file, $gambartubuh_id1, $path;
	
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

	public function getPPDS(){
							
		return PpdsM::model()->findAllByAttributes(array('ppds_aktif'=>true),array('order'=>'ppds_nama ASC'));
	}
	
	public function getParamedisItems()
	{	               
            $criteria = new CDbCriteria;
	    $criteria->join = 'LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id LEFT JOIN kelompokpegawai_m ON kelompokpegawai_m.kelompokpegawai_id = pegawai_m.kelompokpegawai_id';
	    $ruangan_id = Yii::app()->user->getState('ruangan_id');            
	    $criteria->addCondition('t.ruangan_id='.$ruangan_id);
            
            
	    $paramedis = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
	    
           // if ($ruangan_id == 8)://ruang bersalin
                $paramedis .= ','.Params::KELOMPOKPEGAWAI_ID_BIDAN;               
            //endif;
	    $criteria->addCondition("kelompokpegawai_m.kelompokpegawai_id IN(".$paramedis.")");
            $criteria->order = "pegawai_m.nama_pegawai ASC";
	    return RuanganpegawaiM::model()->findAll($criteria);
	}

}
