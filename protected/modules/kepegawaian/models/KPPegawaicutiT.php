<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KPPegawaicutiT extends PegawaicutiT {
    public $lamacuti_konfigsystem, $pejabatmenyetujui_nama;
    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInfo($pegawai = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->with=array('jeniscuti');
		if(!empty($pegawai)){
		$criteria->addCondition('pegawai_id = '.$pegawai);
		}
		if(!empty($this->pegawaicuti_id)){
		$criteria->addCondition('pegawaicuti_id = '.$this->pegawaicuti_id);
		}
		if(!empty($this->jeniscuti_id)){
		$criteria->addCondition('t.jeniscuti_id = '.$this->jeniscuti_id);
		}
		$criteria->compare('DATE(tglmulaicuti)',$this->tglmulaicuti);
		$criteria->compare('DATE(tglakhircuti)',$this->tglakhircuti);
		$criteria->compare('LOWER(lamacuti)',strtolower($this->lamacuti),true);
		$criteria->compare('LOWER(noskcuti)',strtolower($this->noskcuti),true);
		$criteria->compare('DATE(tglditetapkanskcuti)',$this->tglditetapkanskcuti);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(keperluancuti)',strtolower($this->keperluancuti),true);
		$criteria->compare('LOWER(pejabatmenyetujui)',strtolower($this->pejabatmenyetujui),true);
		$criteria->compare('LOWER(pejabatmengetahui)',strtolower($this->pejabatmengetahui),true);
		$criteria->addCondition('jeniscuti.jeniscuti_aktif IS TRUE');
		$criteria->order='pegawaicuti_id';
		$criteria->limit=5; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}

?>
