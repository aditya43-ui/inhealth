<?php

class ASDiagnosakepM extends DiagnosakepM
{
    public $kelompoktandagejaladaftar_id, $kelompokfaktorrisikodaftar_id, $kelompoktandagejaladaftar_idnya, $kelompokfaktorrisikodaftar_idnya;
    public $default;
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
		$criteria->compare('LOWER(diagnosakep_kode)',strtolower($this->diagnosakep_kode),true);
		$criteria->compare('LOWER(diagnosakep_nama)',strtolower($this->diagnosakep_nama),true);
		$criteria->compare('LOWER(diagnosakep_deskripsi)',strtolower($this->diagnosakep_deskripsi),true);
		$criteria->compare('diagnosakep_aktif',$this->diagnosakep_aktif);
		if (!empty($this->aktif)) {
			if ($this->aktif == 1) {
				$criteria->addCondition('t.diagnosakep_aktif = TRUE');
			}
			if ($this->aktif == 0) {
				$criteria->addCondition('t.diagnosakep_aktif = FALSE');
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
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDialog() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
                $criteria->select = 't.diagnosakep_id, t.diagnosakep_kode, t.diagnosakep_nama, t.diagnosakep_deskripsi, t.diagnosakep_aktif';
                /*
                if (!empty($this->kelompoktandagejaladaftar_id)) {
                    if($this->kelompoktandagejaladaftar_id != 'undefined'){
                        $criteria->join = 'JOIN tandagejala_m tandagejala ON tandagejala.diagnosakep_id = t.diagnosakep_id
                                           JOIN kelompoktandagejaladaftar_m det ON det.kelompoktandagejaladaftar_id = tandagejala.kelompoktandagejaladaftar_id ';
                        $criteria->addInCondition('det.kelompoktandagejaladaftar_id ', $this->kelompoktandagejaladaftar_id);
                    }
                }else if (!empty($this->kelompokfaktorrisikodaftar_id)) {
                    if($this->kelompokfaktorrisikodaftar_id != 'undefined'){
                        $criteria->join = 'JOIN faktorrisiko_m faktorrisiko ON faktorrisiko.diagnosakep_id = t.diagnosakep_id
                                           JOIN kelompokfaktorrisikodaftar_m dets ON dets.kelompokfaktorrisikodaftar_id = faktorrisiko.kelompokfaktorrisikodaftar_id ';
                        $criteria->addInCondition('dets.kelompokfaktorrisikodaftar_id ', $this->kelompokfaktorrisikodaftar_id);
                    }
                }
                */
                if (!empty($this->kelompoktandagejaladaftar_idnya)) {
                    $array_tandagejala = explode (",", $this->kelompoktandagejaladaftar_idnya);
                    $criteria->join = 'JOIN tandagejala_m tandagejala ON tandagejala.diagnosakep_id = t.diagnosakep_id
                                       JOIN kelompoktandagejaladaftar_m det ON det.kelompoktandagejaladaftar_id = tandagejala.kelompoktandagejaladaftar_id ';
                    $criteria->addInCondition('det.kelompoktandagejaladaftar_id ', $array_tandagejala);
                }else if (!empty($this->kelompokfaktorrisikodaftar_idnya)) {
                    $array_faktorrisiko = explode (",", $this->kelompokfaktorrisikodaftar_idnya);
                    $criteria->join = 'JOIN faktorrisiko_m faktorrisiko ON faktorrisiko.diagnosakep_id = t.diagnosakep_id
                                       JOIN kelompokfaktorrisikodaftar_m dets ON dets.kelompokfaktorrisikodaftar_id = faktorrisiko.kelompokfaktorrisikodaftar_id ';
                    $criteria->addInCondition('dets.kelompokfaktorrisikodaftar_id ', $array_faktorrisiko);
                }
                $criteria->group = $criteria->select;
                
                if (!empty($this->default)){
                    $criteria->addCondition(" t.diagnosakep_id IS NULL ");
                }
                
//		$criteria->limit = 5;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false
		));
	}
}
?>
