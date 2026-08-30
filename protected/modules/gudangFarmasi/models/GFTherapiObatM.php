<?php


class GFTherapiObatM extends TherapiobatM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TherapiobatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchPrint()
	{
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->therapiobat_id)){
			$criteria->addCondition('therapiobat_id = '.$this->therapiobat_id);
		}
		$criteria->compare('LOWER(therapiobat_nama)',strtolower($this->therapiobat_nama),true);
		$criteria->compare('LOWER(therapiobat_namalain)',strtolower($this->therapiobat_namalain),true);
		$criteria->compare('therapiobat_aktif',isset($this->therapiobat_aktif)?$this->therapiobat_aktif:true);
		$criteria->order='therapiobat_nama';
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

			$criteria=new CDbCriteria;
			if (!empty($this->therapiobat_id)){
				$criteria->addCondition('therapiobat_id ='.$this->therapiobat_id);
			}
			$criteria->compare('LOWER(therapiobat_nama)',strtolower($this->therapiobat_nama),true);
			$criteria->addCondition("therapiobat_aktif = TRUE");
			$criteria->order='therapiobat_nama ASC';
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}