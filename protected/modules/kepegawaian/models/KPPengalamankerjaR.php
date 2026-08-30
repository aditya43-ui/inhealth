<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KPPengalamankerjaR extends PengalamankerjaR {

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
		if(!empty($this->pengalamankerja_id)){
		$criteria->addCondition('pengalamankerja_id = '.$this->pengalamankerja_id);
		}
		$criteria->compare('pengalamankerja_nourut',$this->pengalamankerja_nourut);
		$criteria->compare('LOWER(namaperusahaan)',strtolower($this->namaperusahaan),true);
		$criteria->compare('LOWER(bidangperusahaan)',strtolower($this->bidangperusahaan),true);
		$criteria->compare('LOWER(jabatanterahkir)',strtolower($this->jabatanterahkir),true);
		$criteria->compare('LOWER(tglmasuk)',strtolower($this->tglmasuk),true);
		$criteria->compare('LOWER(tglkeluar)',strtolower($this->tglkeluar),true);
		$criteria->compare('lama_tahun',$this->lama_tahun);
		$criteria->compare('lama_bulan',$this->lama_bulan);
		$criteria->compare('LOWER(alasanberhenti)',strtolower($this->alasanberhenti),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->order='pengalamankerja_nourut';
		$criteria->limit=3; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

?>
