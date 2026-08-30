<?php

class RMHasilpemeriksaanrmT extends HasilpemeriksaanrmT
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function search10Terakhir()
    {
	    $criteria=new CDbCriteria;
	    $criteria->order= 'tglpemeriksaanrm DESC';
	    $criteria->limit=10; 

	    return new CActiveDataProvider($this, array(
	            'criteria'=>$criteria,
	            'pagination'=>false,
	    ));
    }
}