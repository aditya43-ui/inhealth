<?php

class RDKasusPenyakitDiagnosaM extends KasuspenyakitdiagnosaM
{
    public $diagnosa_nourut;
    public $diagnosa_kode;
    public $diagnosa_nama;
    public $diagnosa_namalainnya;
    public $diagnosa_katakunci;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskasuspenyakit_id, diagnosa_id', 'required'),
			array('jeniskasuspenyakit_id, diagnosa_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diagnosa_nourut, diagnosa_kode, diagnosa_nama, diagnosa_namalainnya, diagnosa_katakunci,
                               jeniskasuspenyakit_id, diagnosa_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'diagnosa_id' => 'Diagnosa',
                        'diagnosa_nourut'=>'No. Urut',
                        'diagnosa_kode'=>'Kode',
                        'diagnosa_nama'=>'Nama',
                        'diagnosa_namalainnya'=>'Nama Lain',
                        'diagnosa_katakunci'=>'Kata Kunci',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->with = array('diagnosa');
		$criteria->compare('LOWER(diagnosa.diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa.diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa.diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa.diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->compare('diagnosa.diagnosa_nourut',$this->diagnosa_nourut);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);				
		}
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);				
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}