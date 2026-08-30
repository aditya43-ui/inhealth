<?php

/**
 * This is the model class for table "carakeluar_m".
 *
 * The followings are the available columns in table 'carakeluar_m':
 * @property integer $carakeluar_id
 * @property string $carakeluar_nama
 * @property string $carakeluar_namalain
 * @property boolean $carakeluar_aktif
 *
 * The followings are the available model relations:
 * @property PasienpulangT[] $pasienpulangTs
 * @property KondisikeluarM[] $kondisikeluarMs
 */
class CarakeluarM extends CActiveRecord
{
    public $statuskeluar_kemenkes_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarakeluarM the static model class
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
		return 'carakeluar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carakeluar_nama, carakeluar_namalain', 'required'),
			array('kode_carakeluar_inacbg', 'numerical', 'integerOnly'=>true),
			array('carakeluar_nama, carakeluar_namalain', 'length', 'max'=>100),
            array('statuskeluar_kemenkes', 'length', 'max'=>50),
			array('carakeluar_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('carakeluar_id, carakeluar_nama, carakeluar_namalain, carakeluar_aktif, statuskeluar_kemenkes, kode_carakeluar_inacbg', 'safe', 'on'=>'search'),
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
			'pasienpulangTs' => array(self::HAS_MANY, 'PasienpulangT', 'carakeluar_id'),
			'kondisikeluarMs' => array(self::HAS_MANY, 'KondisikeluarM', 'carakeluar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'carakeluar_id' => 'Id Cara Keluar',
			'carakeluar_nama' => 'Nama Cara Keluar',
			'carakeluar_namalain' => 'Nama Lain',
			'carakeluar_aktif' => 'Aktif',
            'statuskeluar_kemenkes' => 'Status Keluar Kemenkes',
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

		$criteria->compare('carakeluar_id',$this->carakeluar_id);
		$criteria->compare('LOWER(carakeluar_nama)',strtolower($this->carakeluar_nama),true);
		$criteria->compare('LOWER(carakeluar_namalain)',strtolower($this->carakeluar_namalain),true);
		$criteria->compare('carakeluar_aktif',isset($this->carakeluar_aktif)?$this->carakeluar_aktif:true);

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
        
        public function getCaraKeluar()
	{
            $data = array();
            $criteria = new CDbCriteria();            
            $criteria->addCondition("carakeluar_aktif = TRUE");
            $criteria->order = 'carakeluar_nama ASC';
            $models=self::model()->findAll($criteria);
            if(count((array)$models) > 0){
                foreach($models as $model)
                    // $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
                    $data[$model->carakeluar_nama]= ($model->carakeluar_nama);
            }else{
                $data[""] = null;
            }
            
            return $data;
	}

        public static function getCarakeluarItems()
        {
            return self::model()->findAll('carakeluar_aktif=TRUE ORDER BY carakeluar_nama');
        }
}