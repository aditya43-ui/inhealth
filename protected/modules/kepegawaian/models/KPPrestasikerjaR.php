<?php

class KPPrestasikerjaR extends PrestasikerjaR
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
		if(!empty($this->prestasikerja_id)){
		$criteria->addCondition('prestasikerja_id = '.$this->prestasikerja_id);
		}
		$criteria->compare('DATE(tglprestasidiperoleh)',$this->tglprestasidiperoleh);
		$criteria->compare('nourutprestasi',$this->nourutprestasi);
		$criteria->compare('LOWER(instansipemberi)',strtolower($this->instansipemberi),true);
		$criteria->compare('LOWER(pejabatpemberi)',strtolower($this->pejabatpemberi),true);
		$criteria->compare('LOWER(namapenghargaan)',strtolower($this->namapenghargaan),true);
		$criteria->compare('LOWER(keteranganprestasi)',strtolower($this->keteranganprestasi),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->order='nourutprestasi';
		$criteria->limit=5; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}