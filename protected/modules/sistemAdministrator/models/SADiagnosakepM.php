<?php

class SADiagnosakepM extends DiagnosakepM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
	public $aktif;
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
			'diagnosakep_id' => 'Diagnosakep',
			'diagnosakep_kode' => 'Kode Diagnosa',
			'diagnosakep_nama' => 'Diagnosa Keperawatan',
			'diagnosakep_deskripsi' => 'Deskripsi',
			'diagnosakep_aktif' => 'Aktif',
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('diagnosakep_kode',$this->diagnosakep_kode,true);
		$criteria->compare('diagnosakep_nama',$this->diagnosakep_nama,true);
		$criteria->compare('diagnosakep_deskripsi',$this->diagnosakep_deskripsi,true);
		$criteria->compare('diagnosakep_aktif',isset($this->diagnosakep_aktif)?$this->diagnosakep_aktif:true);
		
		return $criteria;
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPrint() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
}
?>
