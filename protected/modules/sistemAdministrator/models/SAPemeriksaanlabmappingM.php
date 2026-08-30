<?php

/**
 * This is the model class for table "pemeriksaanlabmapping_m".
 *
 * The followings are the available columns in table 'pemeriksaanlabmapping_m':
 * @property integer $pemeriksaanlabalat_id
 * @property integer $nilairujukan_id
 */

class SAPemeriksaanlabmappingM extends PemeriksaanlabmappingM
{
	public $pemeriksaanlabalat_nama; //untuk pencarian
	public $pemeriksaanlabalat_kode; //untuk pencarian
	public $kelompokdet; //untuk pencarian
	public $namapemeriksaandet; //untuk pencarian
	public $nilairujukan_jeniskelamin; //untuk pencarian
	public $nilairujukan_nama; //untuk pencarian
	public $nilairujukan_min; //untuk pencarian
	public $nilairujukan_max; //untuk pencarian
	public $nilairujukan_satuan; //untuk pencarian
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabmappingM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function search()
	{
		$criteria=new CDbCriteria;
        $criteria->with = array('pemeriksaanlabalat','nilairujukan');
        $criteria->order = 't.pemeriksaanlabalat_id';
		if (!empty($this->pemeriksaanlabalat_id)){
			$criteria->addCondition('t.pemeriksaanlabalat_id ='.$this->pemeriksaanlabalat_id);
		}
	    $criteria->compare('LOWER(pemeriksaanlabalat.pemeriksaanlabalat_nama)',strtolower($this->pemeriksaanlabalat_nama),true);
	    $criteria->compare('LOWER(nilairujukan.nilairujukan_nama)',strtolower($this->nilairujukan_nama),true);
		$criteria->compare('LOWER(pemeriksaanlabalat.pemeriksaanlabalat_kode)', strtolower($this->pemeriksaanlabalat_kode), true);
		$criteria->compare('LOWER(nilairujukan.kelompokdet)', strtolower($this->kelompokdet), true);
		$criteria->compare('LOWER(nilairujukan.namapemeriksaandet)', strtolower($this->namapemeriksaandet), true);
		$criteria->compare('LOWER(nilairujukan.nilairujukan_jeniskelamin)', strtolower($this->nilairujukan_jeniskelamin), true);
		$criteria->compare('nilairujukan.nilairujukan_min', $this->nilairujukan_min);
		$criteria->compare('nilairujukan.nilairujukan_max', $this->nilairujukan_max);
		$criteria->compare('LOWER(nilairujukan.nilairujukan_satuan)', strtolower($this->nilairujukan_satuan), true);
		if (!empty($this->nilairujukan_id)){
			$criteria->addCondition('t.nilairujukan_id ='.$this->nilairujukan_id);
		}

		return $criteria;
	}
	
        public function searchTabel()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->search();
            $criteria->limit=10;
			
			return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'pemeriksaanlabalat_nama'=>array(
                                    'asc'=>'pemeriksaanlabalat.pemeriksaanlabalat_nama',
                                    'desc'=>'pemeriksaanlabalat.pemeriksaanlabalat_nama DESC',
                                ),
                                '*',
                            ),
                        ),
		));
            /*return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            
			 * ));
			 */
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->search();
            $criteria->limit=-1; 
			
			return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
                        'sort'=>array(
                            'attributes'=>array(
                                'pemeriksaanlabalat_nama'=>array(
                                    'asc'=>'pemeriksaanlabalat.pemeriksaanlabalat_nama',
                                    'desc'=>'pemeriksaanlabalat.pemeriksaanlabalat_nama DESC',
                                ),
                                '*',
                            ),
                        ),
		));
            /*return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            
			 * ));
			 */
        }
		
	/**
	* nilai yang sudah ada converting symbol
	*/
	public function getNilaiRujukan()
	{
		return CustomFunction::symbolsConverter($this->nilairujukan->nilairujukan_nama);
	}
}