<?php

/**
 * This is the model class for table "kondisikeluar_m".
 *
 * The followings are the available columns in table 'kondisikeluar_m':
 * @property integer $kondisikeluar_id
 * @property integer $carakeluar_id
 * @property string $kondisikeluar_nama
 * @property string $kondisikeluar_namalain
 * @property boolean $kondisikeluar_aktif
 *
 * The followings are the available model relations:
 * @property PasienpulangT[] $pasienpulangTs
 * @property CarakeluarM $carakeluar
 */
class KondisiKeluarM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KondisiKeluarM the static model class
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
		return 'kondisikeluar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carakeluar_id, kondisikeluar_nama, kondisikeluar_namalain', 'required'),
			array('carakeluar_id', 'numerical', 'integerOnly'=>true),
			array('kondisikeluar_nama, kondisikeluar_namalain', 'length', 'max'=>100),
			array('kondisikeluar_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kondisikeluar_id, carakeluar_id, kondisikeluar_nama, kondisikeluar_namalain, kondisikeluar_aktif', 'safe', 'on'=>'search'),
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
			'pasienpulangTs' => array(self::HAS_MANY, 'PasienpulangT', 'kondisikeluar_id'),
			'carakeluar' => array(self::BELONGS_TO, 'CarakeluarM', 'carakeluar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kondisikeluar_id' => 'Id Kondisi Keluar',
			'carakeluar_id' => 'Cara Keluar',
			'kondisikeluar_nama' => 'Nama Kondisi Keluar',
			'kondisikeluar_namalain' => 'Nama Lain',
			'kondisikeluar_aktif' => 'Aktif',
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

		$criteria->compare('kondisikeluar_id',$this->kondisikeluar_id);
		$criteria->compare('carakeluar_id',$this->carakeluar_id);
		$criteria->compare('LOWER(kondisikeluar_nama)',strtolower($this->kondisikeluar_nama),true);
		$criteria->compare('LOWER(kondisikeluar_namalain)',strtolower($this->kondisikeluar_namalain),true);
		$criteria->compare('kondisikeluar_aktif',isset($this->kondisikeluar_aktif)?$this->kondisikeluar_aktif:true);

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
     /**
    * Mengambil daftar semua kondisikeluar
    * @return CActiveDataProvider 
    */
    public function getKondisikeluarItems($carakeluar_id=null)
    {
         if(!empty($carakeluar_id))
               return KondisiKeluarM::model()->findAllByAttributes(array('carakeluar_id'=>$carakeluar_id,'kondisikeluar_aktif'=>true),array('order'=>'kondisikeluar_nama'));
        else
               return array();
    }
    
    public function getKondisiKeluar()
	{
            $data = array();
            $criteria = new CDbCriteria();            
            $criteria->addCondition("kondisikeluar_aktif = TRUE");
            $criteria->order = 'kondisikeluar_nama ASC';
            $models=self::model()->findAll($criteria);
            if(count((array)$models) > 0){
                foreach($models as $model)
                    // $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
                    $data[$model->kondisikeluar_nama]= ($model->kondisikeluar_nama);
            }else{
                $data[""] = null;
            }
            
            return $data;
	}
}