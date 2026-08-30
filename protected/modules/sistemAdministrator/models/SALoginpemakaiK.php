<?php
class SALoginpemakaiK extends LoginpemakaiK
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	* kriteria pencarian untuk dashboard
	* @return \CActiveDataProvider
	*/
	public function searchDashboard()
	{
	   // Warning: Please modify the following code to remove attributes that
	   // should not be searched.

	   $criteria=new CDbCriteria;
	   $criteria->compare('DATE(waktuterakhiraktifitas)', date("Y-m-d"));
	   $criteria->order = 'lastlogin DESC';
	   $criteria->limit = 5;
	   return new CActiveDataProvider($this, array(
		   'criteria'=>$criteria,
		   'pagination'=>false
	   ));
	}

}