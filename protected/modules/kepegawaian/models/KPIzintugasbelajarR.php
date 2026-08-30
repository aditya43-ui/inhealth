<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KPIzintugasbelajarR extends IzintugasbelajarR {

    public static function model($className = __CLASS__) {
        parent::model($className);
    }

	public function searchInfo($pegawai = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		if(!empty($pegawai)){
		$criteria->addCondition('pegawai_id = '.$pegawai);
		}
		$criteria->compare('izintugasbelajar_id',$this->izintugasbelajar_id);
		$criteria->compare('DATE(tglmulaibelajar)',$this->tglmulaibelajar);
		$criteria->compare('LOWER(nomorkeputusan)',strtolower($this->nomorkeputusan),true);
		$criteria->compare('DATE(tglditetapkan)',$this->tglditetapkan);
		$criteria->compare('LOWER(pejabatmemutuskan)',strtolower($this->pejabatmemutuskan),true);
		$criteria->compare('LOWER(keteranganizin)',strtolower($this->keteranganizin),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->order='izintugasbelajar_id';
		$criteria->limit=5; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}

?>
