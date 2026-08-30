<?php
class MCTreadmillT extends TreadmillT
{
	public $duration_treadmill;
	public $blood_preasure;
	public $td_systolic,$td_diastolic,$heart_rate;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TreadmillT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDetailTreadmill($pendaftaran_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->treadmill_id)){
			$criteria->addCondition('treadmill_id = '.$this->treadmill_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(tgltreadmill)',strtolower($this->tgltreadmill),true);
		$criteria->compare('LOWER(resttime_menit)',strtolower($this->resttime_menit),true);
		$criteria->compare('LOWER(worktime_menit)',strtolower($this->worktime_menit),true);
		$criteria->compare('LOWER(recoverytime_menit)',strtolower($this->recoverytime_menit),true);
		$criteria->compare('LOWER(totaltime_menit)',strtolower($this->totaltime_menit),true);
		$criteria->compare('LOWER(interpretation_tradmill)',strtolower($this->interpretation_tradmill),true);
		$criteria->compare('LOWER(hasiltreadmill)',strtolower($this->hasiltreadmill),true);
		$criteria->compare('LOWER(namapemeriksa_treadmill)',strtolower($this->namapemeriksa_treadmill),true);
		$criteria->compare('LOWER(tingkatkebugaran)',strtolower($this->tingkatkebugaran),true);
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
	public function searchInformasiDetailTreadmill($pendaftaran_id) {
        $criteria= Yii::app()->db->createCommand()
					->select()
					->from('treadmill_t t')
					->join('treadmilldetail_t td','t.treadmill_id = td.treadmill_id')
					->where('t.pendaftaran_id=:pendaftaran_id', array(':pendaftaran_id'=>$pendaftaran_id))
					->queryAll();
        return $criteria;
    }
	
}