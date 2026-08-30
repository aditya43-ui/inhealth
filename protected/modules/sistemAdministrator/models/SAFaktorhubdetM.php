<?php

class SAFaktorhubdetM extends FaktorhubdetM
{
	public $faktorhub_nama,$diagnosakep_id,$aktif,$diagnosakep_nama;
        public $faktorhub_daftar_id;
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
			'faktorhubdet_id' => 'ID',
			'faktorhub_id_id' => 'Faktor Risiko',
			'faktorhubdet_indikator' => 'Indikator',
			'faktorhubdet_aktif' => 'Aktif',
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
		$criteria->select = 'faktorhub.*,t.*,diagnosakep.*';
		$criteria->join = 'JOIN faktorhub_m AS faktorhub ON faktorhub.faktorhub_id = t.faktorhub_id';
		$criteria->join .= ' JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = faktorhub.diagnosakep_id';
		$criteria->compare('faktorhub.faktorhub_id',$this->faktorhub_id);
		$criteria->compare('faktorhub.diagnosakep_id',$this->diagnosakep_id,true);
		$criteria->compare('LOWER(diagnosakep.diagnosakep_nama)',strtolower($this->diagnosakep_nama),true);
		$criteria->compare('LOWER(faktorhub.faktorhub_nama)',strtolower($this->faktorhub_nama),true);
		$criteria->compare('faktorhubdet_id',$this->faktorhubdet_id,true);
		$criteria->compare('LOWER(faktorhubdet_indikator)',strtolower($this->faktorhubdet_indikator),true);
		$criteria->compare('faktorhubdet_aktif',$this->faktorhubdet_aktif);
		if (!empty($this->aktif)) {
			if ($this->aktif == 1) {
				$criteria->addCondition('t.faktorhubdet_aktif = TRUE');
			}
			if ($this->aktif == 0) {
				$criteria->addCondition('t.faktorhubdet_aktif = FALSE');
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