<?php

/**
 * This is the model class for table "pabrik_m".
 *
 * The followings are the available columns in table 'pabrik_m':
 * @property integer $pabrik_id
 * @property string $pabrik_kode
 * @property string $pabrik_nama
 * @property string $pabrik_namalain
 * @property string $pabrik_alamat
 * @property string $pabrik_propinsi
 * @property string $pabrik_kabupaten
 * @property boolean $pabrik_aktif
 *
 * The followings are the available model relations:
 * @property ObatalkesM[] $obatalkesMs
 */
class PabrikM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PabrikM the static model class
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
		return 'pabrik_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pabrik_kode, pabrik_nama, pabrik_namalain', 'required'),
			array('pabrik_kode', 'length', 'max'=>20),
			array('jenismodal', 'length', 'max'=>50),
			array('pabrik_nama, pabrik_namalain, pabrik_propinsi, pabrik_kabupaten', 'length', 'max'=>100),
			array('pabrik_alamat, pabrik_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pabrik_id, pabrik_kode, pabrik_nama, pabrik_namalain, pabrik_alamat, pabrik_propinsi, pabrik_kabupaten, pabrik_aktif, jenismodal', 'safe', 'on'=>'search'),
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
			'obatalkesMs' => array(self::HAS_MANY, 'ObatalkesM', 'pabrik_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pabrik_id' => 'Pabrik',
			'pabrik_kode' => 'Kode',
			'pabrik_nama' => 'Nama',
			'pabrik_namalain' => 'Nama Lain',
			'pabrik_alamat' => 'Alamat',
			'pabrik_propinsi' => 'Provinsi',
			'pabrik_kabupaten' => 'Kabupaten',
			'pabrik_aktif' => 'Status Aktif',
			'jenismodal' => 'Jenis Modal',
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

		if(!empty($this->pabrik_id)){
			$criteria->addCondition('pabrik_id = '.$this->pabrik_id);
		}
		$criteria->compare('LOWER(pabrik_kode)',strtolower($this->pabrik_kode),true);
		$criteria->compare('LOWER(pabrik_nama)',strtolower($this->pabrik_nama),true);
		$criteria->compare('LOWER(pabrik_namalain)',strtolower($this->pabrik_namalain),true);
		$criteria->compare('LOWER(pabrik_alamat)',strtolower($this->pabrik_alamat),true);
		$criteria->compare('LOWER(pabrik_propinsi)',strtolower($this->pabrik_propinsi),true);
		$criteria->compare('LOWER(pabrik_kabupaten)',strtolower($this->pabrik_kabupaten),true);
		$criteria->compare('pabrik_aktif',$this->pabrik_aktif);

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