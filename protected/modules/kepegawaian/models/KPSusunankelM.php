<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KPSusunankelM extends SusunankelM {

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
		if(!empty($this->susunankel_id)){
		$criteria->addCondition('susunankel_id = '.$this->susunankel_id);
		}
		$criteria->compare('nourutkel',$this->nourutkel);
		$criteria->compare('LOWER(hubkeluarga)',strtolower($this->hubkeluarga),true);
		$criteria->compare('LOWER(susunankel_nama)',strtolower($this->susunankel_nama),true);
		$criteria->compare('LOWER(susunankel_jk)',strtolower($this->susunankel_jk),true);
		$criteria->compare('LOWER(susunankel_tempatlahir)',strtolower($this->susunankel_tempatlahir),true);
		$criteria->compare('LOWER(susunankel_tanggallahir)',strtolower($this->susunankel_tanggallahir),true);
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('LOWER(susunankel_tanggalpernikahan)',strtolower($this->susunankel_tanggalpernikahan),true);
		$criteria->compare('LOWER(susunankel_tempatpernikahan)',strtolower($this->susunankel_tempatpernikahan),true);
		$criteria->compare('LOWER(susunankeluarga_nip)',strtolower($this->susunankeluarga_nip),true);
		$criteria->compare('LOWER(nopesertabpjs)',strtolower($this->nopesertabpjs),true);

		
		$criteria->order='nourutkel';
		$criteria->limit=3; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

?>
