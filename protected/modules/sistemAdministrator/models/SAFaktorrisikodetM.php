<?php

class SAFaktorrisikodetM extends FaktorrisikodetM
{
	public $faktorrisiko_nama,$diagnosakep_id,$aktif,$diagnosakep_nama;
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
			'faktorrisikodet_id' => 'ID',
			'faktorrisiko_id_id' => 'Faktor Risiko',
			'faktorrisikodet_indikator' => 'Indikator',
			'faktorrisikodet_aktif' => 'Aktif',
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
		$criteria->select = 'faktorrisiko.*,t.*,diagnosakep.*';
		$criteria->join = 'JOIN faktorrisiko_m AS faktorrisiko ON faktorrisiko.faktorrisiko_id = t.faktorrisiko_id';
		$criteria->join .= ' JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = faktorrisiko.diagnosakep_id';
		$criteria->compare('faktorrisiko.faktorrisiko_id',$this->faktorrisiko_id);
		$criteria->compare('faktorrisiko.diagnosakep_id',$this->diagnosakep_id,true);
		$criteria->compare('LOWER(diagnosakep.diagnosakep_nama)',strtolower($this->diagnosakep_nama),true);
		$criteria->compare('LOWER(faktorrisiko.faktorrisiko_nama)',strtolower($this->faktorrisiko_nama),true);
		$criteria->compare('faktorrisikodet_id',$this->faktorrisikodet_id,true);
		$criteria->compare('LOWER(faktorrisikodet_indikator)',strtolower($this->faktorrisikodet_indikator),true);
		$criteria->compare('faktorrisikodet_aktif',$this->faktorrisikodet_aktif);
		if (!empty($this->aktif)) {
			if ($this->aktif == 1) {
				$criteria->addCondition('t.faktorrisikodet_aktif = TRUE');
			}
			if ($this->aktif == 0) {
				$criteria->addCondition('t.faktorrisikodet_aktif = FALSE');
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