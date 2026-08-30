<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KPPengorganisasiR extends PengorganisasiR {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

	public function searchInfo($pegawai = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		if(!empty($pegawai)){
		$criteria->addCondition('pegawai_id = '.$pegawai);
		}
		if(!empty($this->pengorganisasi_id)){
		$criteria->addCondition('pengorganisasi_id = '.$this->pengorganisasi_id);
		}
		$criteria->compare('LOWER(pengorganisasi_nama)',strtolower($this->pengorganisasi_nama),true);
		$criteria->compare('LOWER(pengorganisasi_kedudukan)',strtolower($this->pengorganisasi_kedudukan),true);
		$criteria->compare('LOWER(pengorganisasi_lamanya)',strtolower($this->pengorganisasi_lamanya),true);
		$criteria->compare('LOWER(pengorganisasi_tahun)',strtolower($this->pengorganisasi_tahun),true);
		$criteria->compare('LOWER(pengorganisasi_tempat)',strtolower($this->pengorganisasi_tempat),true);
		$criteria->order='pengorganisasi_nama';
		$criteria->limit=5; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

?>
