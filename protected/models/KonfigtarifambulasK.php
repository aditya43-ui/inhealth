<?php

/**
 * This is the model class for table "konfigtarifambulas_k".
 *
 * The followings are the available columns in table 'konfigtarifambulas_k':
 * @property integer $konfigtarifambulans_id
 * @property integer $komponenunit_id
 * @property double $tarifjasasarana
 * @property double $jasapengemudi_prosentase
 * @property double $jasapendamping_prosentase
 * @property double $jasadokter_persentase
 * @property boolean $konfigurasitarifambulans_aktif
 */
class KonfigtarifambulasK extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KonfigtarifambulasK the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'konfigtarifambulas_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('komponenunit_id, tarifjasasarana', 'required'),
			array('komponenunit_id', 'numerical', 'integerOnly'=>true),
			array('tarifjasasarana, jasapengemudi_prosentase, jasapendamping_prosentase, jasadokter_persentase', 'numerical'),
			array('konfigurasitarifambulans_aktif', 'safe'),
            array('jasaparamedis, akomodasimedis, uanghariandokter, uangmakandokter', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('konfigtarifambulans_id, komponenunit_id, tarifjasasarana, jasapengemudi_prosentase, jasapendamping_prosentase, jasadokter_persentase, konfigurasitarifambulans_aktif', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'konfigtarifambulans_id' => 'Konfigurasi Tarif Ambulans',
			'komponenunit_id' => 'Komponen Unit',
			'tarifjasasarana' => 'Tarif Jasa',
			'jasapengemudi_prosentase' => '% Jasa Pengemudi',
			'jasapendamping_prosentase' => '% Jasa Pendamping',
			'jasadokter_persentase' => '% Jasa Dokter',
			'konfigurasitarifambulans_aktif' => 'Aktif',
            'jasaparamedis' => 'Jasa Paramedis',
            'akomodasimedis' => 'Akomodasi Medis',
            'uanghariandokter' => 'Uang Harian Dokter',
            'uangmakandokter' => 'Uang Makan Dokter',
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

		if(!empty($this->konfigtarifambulans_id)){
			$criteria->addCondition('konfigtarifambulans_id = '.$this->konfigtarifambulans_id);
		}
		if(!empty($this->komponenunit_id)){
			$criteria->addCondition('komponenunit_id = '.$this->komponenunit_id);
		}
		$criteria->compare('tarifjasasarana',$this->tarifjasasarana);
		$criteria->compare('jasapengemudi_prosentase',$this->jasapengemudi_prosentase);
		$criteria->compare('jasapendamping_prosentase',$this->jasapendamping_prosentase);
		$criteria->compare('jasadokter_persentase',$this->jasadokter_persentase);
		$criteria->compare('konfigurasitarifambulans_aktif',$this->konfigurasitarifambulans_aktif);

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