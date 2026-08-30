<?php

class SAMenuDietM extends MenuDietM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
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
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(menudiet_nama)',strtolower($this->menudiet_nama),true);
		$criteria->compare('LOWER(menudiet_namalain)',strtolower($this->menudiet_namalain),true);
		$criteria->compare('jml_porsi',$this->jml_porsi);
		$criteria->compare('LOWER(ukuranrumahtangga)',strtolower($this->ukuranrumahtangga),true);		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	
	}	
}
?>
