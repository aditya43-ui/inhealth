<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class INKategoriPengaduanM extends KategoriPengaduanM 

{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return GolonganumurM the static model class
     */
    public static function model($className=__CLASS__)
    {
		return parent::model($className);
    }
	
	public static function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("kategoripengaduan_aktif = TRUE");
		$criteria->order = 'namakategori ASC';
		return self::model()->findAll($criteria);
	}
	
	public function searchDialog()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('kategoripengaduan_id',$this->instalasi_id);
		$criteria->compare('LOWER(namakategori)',strtolower($this->namakategori),true);
		$criteria->compare('LOWER(warnakategoripengaduan)',strtolower($this->warnakategoripengaduan),true);
		$criteria->compare('LOWER(estimasipenyelesaian)',strtolower($this->estimasipenyelesaian),true);
		$criteria->compare('kategoripengaduan_aktif',isset($this->kategoripengaduan_aktif)?$this->kategoripengaduan_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getKategoriPengaduanItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('kategoripengaduan_aktif = TRUE');
		$criteria->order = "namakategori";
		return self::model()->findAll($criteria);
	}
}
?>
