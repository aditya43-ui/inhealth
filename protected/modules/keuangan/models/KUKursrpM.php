<?php

class KUKursrpM extends KursrpM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KursrpM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kursrp_id',$this->kursrp_id);
		$criteria->compare('matauang_id',$this->matauang_id);
//		if(!empty($this->matauang)){
//		   $criteria->addCondition("matauang = ".$this->matauang);
//		}
		$criteria->compare('date(tglkursrp)', MyFormatter::formatDateTimeForDb($this->tglkursrp));
		$criteria->compare('nilai', str_replace('.','',$this->nilai));
		$criteria->compare('rupiah',str_replace('.','',$this->rupiah));
		$criteria->compare('kursrp_aktif',isset($this->kursrp_aktif)?$this->kursrp_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}

?>