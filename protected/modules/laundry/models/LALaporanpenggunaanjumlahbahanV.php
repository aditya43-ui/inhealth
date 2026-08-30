<?php

/**
 * This is the model class for table "laporanpenggunaanjumlahbahan_v".
 *
 * The followings are the available columns in table 'laporanpenggunaanjumlahbahan_v':
 * @property string $jmlpemakaian
 * @property string $tglpencucianlinen
 * @property string $bahanperawatan_nama
 * @property string $satuanpemakaian
 */
class LALaporanpenggunaanjumlahbahanV extends LaporanpenggunaanjumlahbahanV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpengirimanlinenV the static model class
	 */
	public $tgl_awal, $tgl_akhir, $jml_tampil;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(tglpencucianlinen)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(jmlpemakaian)',strtolower($this->jmlpemakaian),true);
		$criteria->compare('LOWER(bahanperawatan_nama)',strtolower($this->bahanperawatan_nama),true);
		$criteria->compare('LOWER(satuanpemakaian)',strtolower($this->satuanpemakaian),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
//			$criteria->limit=$this->jml_tampil;	
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
//					'pagination'=>false,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}