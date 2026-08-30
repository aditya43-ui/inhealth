<?php

class SAIntervensidetM extends IntervensidetM
{
	public $intervensi_nama,$diagnosakep_id,$aktif,$diagnosakep_nama, $hasTab;
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
			'intervensidet_id' => 'ID',
			'intervensi_id_id' => 'Intervensi',
			'intervensidet_indikator' => 'Indikator',
			'intervensidet_aktif' => 'Aktif',
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
		$criteria->select = 'intervensi.*,t.*,diagnosakep.*';
		$criteria->join = 'JOIN intervensi_m AS intervensi ON intervensi.intervensi_id = t.intervensi_id';
		$criteria->join .= ' JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = intervensi.diagnosakep_id';
		$criteria->compare('intervensi.intervensi_id',$this->intervensi_id);
		$criteria->compare('intervensi.diagnosakep_id',$this->diagnosakep_id,true);
		$criteria->compare('LOWER(diagnosakep.diagnosakep_nama)',strtolower($this->diagnosakep_nama),true);
		$criteria->compare('LOWER(intervensi.intervensi_nama)',strtolower($this->intervensi_nama),true);
		$criteria->compare('intervensidet_id',$this->intervensidet_id,true);
		$criteria->compare('LOWER(intervensidet_indikator)',strtolower($this->intervensidet_indikator),true);
		$criteria->compare('intervensidet_aktif',isset($this->intervensidet_aktif)?$this->intervensidet_aktif:true);
		
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