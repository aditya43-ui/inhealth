<?php
class AKRekperiodM extends RekperiodM
{
	public $is_rekeningbaru;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekperiodM the static model class
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

		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		if(!empty($this->perideawal)){
			$criteria->addCondition("DATE(perideawal) = '".$this->perideawal."'");
		}
		if(!empty($this->sampaidgn)){
			$criteria->addCondition("DATE(sampaidgn) = '".$this->sampaidgn."'");
		}
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('isclosing',isset($this->isclosing)?$this->isclosing:0);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		if(!empty($this->perideawal)){
			$criteria->addCondition("DATE(perideawal) = '".$this->perideawal."'");
		}
		if(!empty($this->sampaidgn)){
			$criteria->addCondition("DATE(sampaidgn) = '".$this->sampaidgn."'");
		}
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->addCondition("isclosing = false");
		$criteria->order = "perideawal ASC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function getTglPeriode()
	{
		$next_year = date('Y-m-d',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));
		$criteria = new CDbCriteria();
		//$criteria->addCondition('DATE(perideawal) <=\''.$next_year.'\'');
		$criteria->addCondition('DATE(sampaidgn) >= \''.$next_year.'\'');
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->order = "deskripsi ASC";
		$criteria->addCondition("isclosing IS FALSE");
        $periodes = RekperiodM::model()->findAll($criteria);
		foreach($periodes as $i => $periode){
			$periodes[$i]->deskripsi = $periode->deskripsi . ' [' . $periode->perideawal . ' s/d ' . $periode->sampaidgn . ']';
		}
		return $periodes;
	}
	
}