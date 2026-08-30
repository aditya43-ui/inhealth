<?php

class PPJadwalBukaPoliM  extends JadwalbukapoliM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwalbukapoliM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
       
	public function searchMasterPP()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);			
		}
		$criteria->compare('LOWER(hari)',strtolower($this->hari),true);
		$criteria->compare('jmabuka',strtolower($this->jmabuka), true);
		$criteria->compare('jammulai',strtolower($this->jammulai), true);
		$criteria->compare('jamtutup',strtolower($this->jamtutup), true);
		$criteria->compare('maxantiranpoli',$this->maxantiranpoli);
		$criteria->with=array('ruangan');

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
                
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria(array(
				'distinct' => true,
				'select' => array('ruangan_id')
				));

		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);			
		}
		$criteria->compare('LOWER(hari)',strtolower($this->hari),true);
		$criteria->compare('jmabuka',strtolower($this->jmabuka));
		$criteria->compare('jammulai',strtolower($this->jammulai));
		$criteria->compare('jamtutup',strtolower($this->jamtutup));
		$criteria->compare('maxantiranpoli',$this->maxantiranpoli);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}     
        
	public function searchMasterPPPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);			
		}
		$criteria->compare('LOWER(hari)',strtolower($this->hari),true);
		$criteria->compare('jmabuka',strtolower($this->jmabuka));
		$criteria->compare('jammulai',strtolower($this->jammulai));
		$criteria->compare('jamtutup',strtolower($this->jamtutup));
		$criteria->compare('maxantiranpoli',$this->maxantiranpoli);
		$criteria->limit = -1;
		$criteria->with=array('ruangan');

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>true,
		));
	}
}