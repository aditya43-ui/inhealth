<?php

class SAAlternatifdxM extends AlternatifdxM
{
	public $diagnosakep_nama,$diagnosakep_id,$aktif;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
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
			'alternatifdx_id' => 'ID',
			'diagnosakep_id' => 'Diagnosa Keperawatan',
			'alternatifdx_nama' => 'Indikator',
			'alternatifdx_aktif' => 'Aktif',
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
		$criteria->with = array('diagnosakep');
		$criteria->compare('alternatifdx_id',$this->alternatifdx_id);
		$criteria->compare('diagnosakep_id',$this->diagnosakep_id,true);
		$criteria->compare('LOWER(diagnosakep.diagnosakep_nama)',strtolower($this->diagnosakep_nama),true);
		$criteria->compare('LOWER(alternatifdx_nama)',strtolower($this->alternatifdx_nama),true);
		$criteria->compare('alternatifdx_aktif',$this->alternatifdx_aktif);
		if (!empty($this->aktif)) {
			if ($this->aktif == 1) {
				$criteria->addCondition('t.alternatifdx_aktif = TRUE');
			}
			if ($this->aktif == 0) {
				$criteria->addCondition('t.alternatifdx_aktif = FALSE');
			} 
		}
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