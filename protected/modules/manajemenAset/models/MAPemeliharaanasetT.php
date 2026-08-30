<?php
class MAPemeliharaanasetT extends PemeliharaanasetT
{
	public $pegmengetahui_nama,$petugas_nama1,$petugas_nama2;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pemeliharaanaset_id)){
			$criteria->addCondition('pemeliharaanaset_id = '.$this->pemeliharaanaset_id);
		}
		$criteria->compare('LOWER(pemeliharaanaset_no)',strtolower($this->pemeliharaanaset_no),true);
		$criteria->compare('LOWER(pemeliharaanaset_tgl)',strtolower($this->pemeliharaanaset_tgl),true);
		$criteria->compare('LOWER(pemeliharaanaset_ket)',strtolower($this->pemeliharaanaset_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegpetugas1_id)){
			$criteria->addCondition('pegpetugas1_id = '.$this->pegpetugas1_id);
		}
		if(!empty($this->pegpetugas2_id)){
			$criteria->addCondition('pegpetugas2_id = '.$this->pegpetugas2_id);
		}
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

		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}