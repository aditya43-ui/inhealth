<?php

/**
 * This is the model class for table "modelantrian_m".
 *
 * The followings are the available columns in table 'modelantrian_m':
 * @property integer $modelantrian_id
 * @property string $modelantrian_kode
 * @property string $modelantrian_nama
 * @property string $modelantrian_singkatan
 * @property string $modelantrian_layanan
 * @property string $modelantrian_deskripsi
 * @property string $modelantrian_formatnomor
 * @property integer $modelantrian_maksantrian
 * @property boolean $modelantrian_aktif
 */
class ModelantrianM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ModelantrianM the static model class
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
		return 'modelantrian_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('modelantrian_kode, modelantrian_nama, modelantrian_singkatan, modelantrian_layanan, modelantrian_deskripsi, modelantrian_formatnomor, modelantrian_maksantrian', 'required'),
			array('modelantrian_maksantrian', 'numerical', 'integerOnly'=>true),
			array('modelantrian_kode, modelantrian_formatnomor', 'length', 'max'=>5),
			array('modelantrian_nama', 'length', 'max'=>100),
			array('modelantrian_warna, modelantrian_singkatan', 'length', 'max'=>10),
			array('modelantrian_layanan, modelantrian_gambar', 'length', 'max'=>200),
			array('modelantrian_aktif, lokasi_karcisantrian_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('modelantrian_id, modelantrian_kode, modelantrian_nama, modelantrian_singkatan, modelantrian_layanan, modelantrian_deskripsi, modelantrian_formatnomor, modelantrian_maksantrian, modelantrian_aktif', 'safe', 'on'=>'search'),
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
			'lokasiKarcisAntrian' => array(self::BELONGS_TO,'LokasiKarcisantrianM','lokasi_karcisantrian_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'modelantrian_id' => 'ID',
			'modelantrian_kode' => 'Antrian Kode',
			'modelantrian_nama' => 'Antrian Nama',
			'modelantrian_singkatan' => 'Singkatan',
			'modelantrian_layanan' => 'Layanan',
			'modelantrian_deskripsi' => 'Deskripsi',
			'modelantrian_formatnomor' => 'Format Nomor',
			'modelantrian_maksantrian' => 'Maks. Antrian',
			'modelantrian_aktif' => 'Aktif',
			'lokasi_karcisantrian_id' => 'Lokasi Karcis',
			'modelantrian_labeltombol' => 'Label Tombol',
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

		if(!empty($this->modelantrian_id)){
			$criteria->addCondition('modelantrian_id = '.$this->modelantrian_id);
		}
		$criteria->compare('LOWER(modelantrian_kode)',strtolower($this->modelantrian_kode),true);
		$criteria->compare('LOWER(modelantrian_nama)',strtolower($this->modelantrian_nama),true);
		$criteria->compare('LOWER(modelantrian_singkatan)',strtolower($this->modelantrian_singkatan),true);
		$criteria->compare('LOWER(modelantrian_layanan)',strtolower($this->modelantrian_layanan),true);
		$criteria->compare('LOWER(modelantrian_deskripsi)',strtolower($this->modelantrian_deskripsi),true);
		$criteria->compare('LOWER(modelantrian_formatnomor)',strtolower($this->modelantrian_formatnomor),true);
		if(!empty($this->modelantrian_maksantrian)){
			$criteria->addCondition('modelantrian_maksantrian = '.$this->modelantrian_maksantrian);
		}
		$criteria->compare('modelantrian_aktif',$this->modelantrian_aktif);

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
        
        public static function dropModelAntrian($arrId = []){
            $res = [];
            
            $cri = new CDbCriteria;
            $cri->addCondition(" modelantrian_aktif = TRUE ");
            if (!empty($arrId)){
                $cri->addInCondition("modelantrian_id", $arrId);
            }
            $cri->order = "modelantrian_nama ASC";
            $load = self::model()->findAll($cri);
            if (!empty($load)){
                foreach($load as $key => $val){
                    $res[$val->modelantrian_id] = $val->modelantrian_nama;
                }
            }
            
            return $res;
        }
}