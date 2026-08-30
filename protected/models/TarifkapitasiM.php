<?php

/**
 * This is the model class for table "tarifkapitasi_m".
 *
 * The followings are the available columns in table 'tarifkapitasi_m':
 * @property integer $tarifkapitasi_id
 * @property string $tarifkapitasi_nama
 * @property string $tarifkapitasi_namalain
 * @property double $tarifkapitasi_nominal
 * @property string $tarifkapitasi_keterangan
 * @property boolean $tarifkapitasi_aktif
 */
class TarifkapitasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarifkapitasiM the static model class
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
		return 'tarifkapitasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tarifkapitasi_nama', 'required'),
			array('tarifkapitasi_nominal', 'numerical'),
			array('tarifkapitasi_nama, tarifkapitasi_namalain', 'length', 'max'=>100),
			array('tarifkapitasi_keterangan, tarifkapitasi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tarifkapitasi_id, tarifkapitasi_nama, tarifkapitasi_namalain, tarifkapitasi_nominal, tarifkapitasi_keterangan, tarifkapitasi_aktif', 'safe', 'on'=>'search'),
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
			'tarifkapitasi_id' => 'Tarifkapitasi',
			'tarifkapitasi_nama' => 'Tarifkapitasi Nama',
			'tarifkapitasi_namalain' => 'Tarifkapitasi Namalain',
			'tarifkapitasi_nominal' => 'Tarifkapitasi Nominal',
			'tarifkapitasi_keterangan' => 'Tarifkapitasi Keterangan',
			'tarifkapitasi_aktif' => 'Tarifkapitasi Aktif',
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

		if(!empty($this->tarifkapitasi_id)){
			$criteria->addCondition('tarifkapitasi_id = '.$this->tarifkapitasi_id);
		}
		$criteria->compare('LOWER(tarifkapitasi_nama)',strtolower($this->tarifkapitasi_nama),true);
		$criteria->compare('LOWER(tarifkapitasi_namalain)',strtolower($this->tarifkapitasi_namalain),true);
		$criteria->compare('tarifkapitasi_nominal',$this->tarifkapitasi_nominal);
		$criteria->compare('LOWER(tarifkapitasi_keterangan)',strtolower($this->tarifkapitasi_keterangan),true);
		$criteria->compare('tarifkapitasi_aktif',$this->tarifkapitasi_aktif);

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