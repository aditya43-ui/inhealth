<?php
class AMInformasipemakaianambulansV extends InformasipemakaianambulansV
{
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function searchPemakaian()
    {
        $criteria=$this->criteriaSearch();
        $criteria->addBetweenCondition('DATE(tglpemakaianambulans)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->limit=10;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}
