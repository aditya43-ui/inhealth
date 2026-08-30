<?php

class SARujukankeluarM extends RujukankeluarM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UbahcarabayarR the static model class
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
	$criteria->compare('rujukankeluar_id',$this->rujukankeluar_id);
	$criteria->compare('LOWER(rumahsakitrujukan)',strtolower($this->rumahsakitrujukan),true);
	$criteria->compare('LOWER(alamatrsrujukan)',strtolower($this->alamatrsrujukan),true);
	$criteria->compare('LOWER(telp_fax)',strtolower($this->telp_fax),true);
	$criteria->compare('rujukankeluar_aktif',isset($this->rujukankeluar_aktif)?$this->rujukankeluar_aktif:true);
	$criteria->limit=-1; 

	return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
	));
	}
}
?>
