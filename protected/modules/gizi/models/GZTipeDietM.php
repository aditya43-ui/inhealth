<?php

class GZTipeDietM extends TipeDietM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
     public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(tipediet_nama)',strtolower($this->tipediet_nama),true);
		$criteria->compare('LOWER(tipediet_namalainnya)',strtolower($this->tipediet_namalainnya),true);
		$criteria->compare('tipediet_aktif',isset($this->tipediet_aktif)?$this->tipediet_aktif:true);
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>
