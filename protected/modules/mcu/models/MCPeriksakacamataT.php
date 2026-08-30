<?php
class MCPeriksakacamataT extends PeriksakacamataT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeriksakacamataT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDetailPeriksakacamata($pendaftaran_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->periksakacamata_id)){
			$criteria->addCondition('periksakacamata_id = '.$this->periksakacamata_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(tglperiksakacamata)',strtolower($this->tglperiksakacamata),true);
		$criteria->compare('LOWER(pro_kacamata)',strtolower($this->pro_kacamata),true);
		$criteria->compare('LOWER(permintaanke_kacamata)',strtolower($this->permintaanke_kacamata),true);
		$criteria->compare('LOWER(jatuhtempo_kacamata)',strtolower($this->jatuhtempo_kacamata),true);
		$criteria->compare('LOWER(hasil_penglihatan)',strtolower($this->hasil_penglihatan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		
        $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}