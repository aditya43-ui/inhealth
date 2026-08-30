<?php


class SAKelasPelayananM extends KelaspelayananM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelaspelayananM the static model class
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
		
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
		if (!empty($this->jeniskelas_id)){
			$criteria->addCondition('t.jeniskelas_id ='.$this->jeniskelas_id);
		}
                $criteria->compare('LOWER(jeniskelas.jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
                $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('kelaspelayanan_aktif',isset($this->kelaspelayanan_aktif)?$this->kelaspelayanan_aktif:true);
                $criteria->with = array('jeniskelas');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}