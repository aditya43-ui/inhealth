<?php

/**
 * This is the model class for table "jenislinen_m".
 *
 * The followings are the available columns in table 'jenislinen_m':
 * @property integer $jenislinen_id
 * @property string $jenislinen_no
 * @property string $jenislinen_nama
 * @property string $tgldiedarkan
 * @property string $ukuranitem
 * @property double $beratitem
 * @property integer $qtyitem
 * @property string $warnalinen
 * @property boolean $isberwarna
 */
class SAJenislinenM extends JenislinenM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenislinenM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenislinen_id' => 'ID',
			'jenislinen_no' => 'No Jenis Linen',
			'jenislinen_nama' => 'Jenis Linen',
			'tgldiedarkan' => 'Tanggal Diedarkan',
			'ukuranitem' => 'Ukuran',
			'beratitem' => 'Berat',
			'qtyitem' => 'Qty',
			'warnalinen' => 'Warna Linen',
			'isberwarna' => 'Berwarna',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$format=new MyFormatter();

		if(!empty($this->jenislinen_id)){
			$criteria->addCondition('jenislinen_id = '.$this->jenislinen_id);
		}
		$criteria->compare('jenislinen_no',$this->jenislinen_no);
		$criteria->compare('LOWER(jenislinen_nama)',strtolower($this->jenislinen_nama),true);
		$criteria->compare('tgldiedarkan',$format->formatDateTimeForDb($this->tgldiedarkan));
		$criteria->compare('LOWER(ukuranitem)',strtolower($this->ukuranitem),true);
		$criteria->compare('beratitem',$this->beratitem);
		if(!empty($this->qtyitem)){
			$criteria->addCondition('qtyitem = '.$this->qtyitem);
		}
		$criteria->compare('LOWER(warnalinen)',strtolower($this->warnalinen),true);
		$criteria->compare('isberwarna', isset($this->isberwarna)?$this->isberwarna:true);

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
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}