<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SAAsalRujukanM extends AsalrujukanM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
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

		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		$criteria->compare('LOWER(asalrujukan_institusi)',strtolower($this->asalrujukan_institusi),true);
		$criteria->compare('LOWER(asalrujukan_namalainnya)',strtolower($this->asalrujukan_namalainnya),true);
		$criteria->compare('asalrujukan_aktif',isset($this->asalrujukan_aktif)?$this->asalrujukan_aktif:true);
		//$criteria->order = 'asalrujukan_id';
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
                    
		));
	}
}
?>
