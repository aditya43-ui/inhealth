<?php

class FALaporanpengeluaranobatgratisV extends LaporanpengeluaranobatgratisV
{
	public $tgl_awal,$tgl_akhir;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchTable()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=$this->criteriaSearch();
        $criteria->addBetweenCondition('date(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->limit=10;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }

    public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->addBetweenCondition('date(tglpenjualan)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }

}