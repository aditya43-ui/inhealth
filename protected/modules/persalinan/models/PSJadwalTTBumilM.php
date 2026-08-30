<?php

class PSJadwalTTBumilM  extends JadwalttbumilM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwalttbumilM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchImunisasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jadwalttbumil_aktif',TRUE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        

}