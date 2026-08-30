<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KPHukdisiplinR extends HukdisiplinR {
public $hukdisiplin_lamabln,$pegawaimengetahui_nama,$pegawaimenyetujui_nama;
    public static function model($className = __CLASS__) {
        parent::model($className);
    }
	
	public function searchInfo($pegawai = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->join = "JOIN jnshukdisiplin_m ON jnshukdisiplin_m.jnshukdisiplin_id = t.jnshukdisiplin_id";
		
		if(!empty($pegawai)){
		$criteria->addCondition('pegawai_id = '.$pegawai);
		}
		if(!empty($this->hukdisiplin_id)){
			$criteria->addCondition('hukdisiplin_id = '.$this->hukdisiplin_id);
		}
		if(!empty($this->jnshukdisiplin_id)){
			$criteria->addCondition('t.jnshukdisiplin_id = '.$this->jnshukdisiplin_id);
		}
		if(!empty($this->hukdisiplin_jabatan)){
			$criteria->addCondition('t.hukdisiplin_jabatan = '.$this->hukdisiplin_jabatan);
		}
		$criteria->compare('DATE(hukdisiplin_tglhukuman)',$this->hukdisiplin_tglhukuman);
		$criteria->compare('LOWER(hukdisiplin_nosk)',strtolower($this->hukdisiplin_nosk),true);
		$criteria->compare('LOWER(hukdisiplin_ruangan)',strtolower($this->hukdisiplin_ruangan),true);
		$criteria->compare('LOWER(hukdisiplin_unitkerja)',strtolower($this->hukdisiplin_unitkerja),true);
		$criteria->compare('LOWER(hukdisiplin_tmt)',strtolower($this->hukdisiplin_tmt),true);
		$criteria->compare('LOWER(hukdisiplin_pejygberwenang)',strtolower($this->hukdisiplin_pejygberwenang),true);
		if(!empty($this->hukdisiplin_lama)){
			$criteria->addCondition('hukdisiplin_lama = '.$this->hukdisiplin_lama);
		}
		$criteria->compare('LOWER(hukdisiplin_keterangan)',strtolower($this->hukdisiplin_keterangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(hukdisiplin_satuanlama)',strtolower($this->hukdisiplin_satuanlama),true);
		$criteria->addCondition('jnshukdisiplin_m.jnshukdisiplin_aktif IS TRUE');
		$criteria->order='hukdisiplin_id';
		$criteria->limit=5; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}

?>
