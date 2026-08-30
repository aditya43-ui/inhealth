<?php

class KPPerjalanandinasR extends PerjalanandinasR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GelarbelakangM the static model class
	 */
	public static function model($className=__CLASS__)
	{
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
		if(!empty($this->perjalanandinas_id)){
		$criteria->addCondition('perjalanandinas_id = '.$this->perjalanandinas_id);
		}
		$criteria->compare('nourutperj',$this->nourutperj);
		$criteria->compare('LOWER(tujuandinas)',strtolower($this->tujuandinas),true);
		$criteria->compare('LOWER(tugasdinas)',strtolower($this->tugasdinas),true);
		$criteria->compare('LOWER(descdinas)',strtolower($this->descdinas),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(kotakabupaten_nama)',strtolower($this->kotakabupaten_nama),true);
		$criteria->compare('DATE(tglmulaidinas)',$this->tglmulaidinas);
		$criteria->compare('DATE(sampaidengan)',$this->sampaidengan);
		$criteria->compare('LOWER(negaratujuan)',strtolower($this->negaratujuan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->order='nourutperj';
		$criteria->limit=5; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}