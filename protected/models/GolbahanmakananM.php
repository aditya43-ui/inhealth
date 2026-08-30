<?php

/**
 * This is the model class for table "golbahanmakanan_m".
 *
 * The followings are the available columns in table 'golbahanmakanan_m':
 * @property integer $golbahanmakanan_id
 * @property string $golbahanmakanan_nama
 * @property string $golbahanmakanan_namalain
 * @property boolean $golbahanmakanan_aktif
 */
class GolbahanmakananM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolbahanmakananM the static model class
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
		return 'golbahanmakanan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('golbahanmakanan_nama', 'required'),
			array('golbahanmakanan_nama, golbahanmakanan_namalain', 'length', 'max'=>100),
			array('golbahanmakanan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('golbahanmakanan_id, golbahanmakanan_nama, golbahanmakanan_namalain, golbahanmakanan_aktif', 'safe', 'on'=>'search'),
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
			'golbahanmakanan_id' => 'Golongan Bahan Makanan',
			'golbahanmakanan_nama' => 'Nama Golongan Bahan Makanan',
			'golbahanmakanan_namalain' => 'Nama Lain Golongan Bahan Makanan',
			'golbahanmakanan_aktif' => 'Aktif',
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

		$criteria->compare('golbahanmakanan_id',$this->golbahanmakanan_id);
		$criteria->compare('LOWER(golbahanmakanan_nama)',strtolower($this->golbahanmakanan_nama),true);
		$criteria->compare('LOWER(golbahanmakanan_namalain)',strtolower($this->golbahanmakanan_namalain),true);
		$criteria->compare('golbahanmakanan_aktif',isset($this->golbahanmakanan_aktif)?$this->golbahanmakanan_aktif:true);
                $criteria->order="golbahanmakanan_nama ASC";
                //$criteria->addCondition('golbahanmakanan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('golbahanmakanan_id',$this->golbahanmakanan_id);
		$criteria->compare('LOWER(golbahanmakanan_nama)',strtolower($this->golbahanmakanan_nama),true);
		$criteria->compare('LOWER(golbahanmakanan_namalain)',strtolower($this->golbahanmakanan_namalain),true);
		$criteria->compare('golbahanmakanan_aktif',isset($this->golbahanmakanan_aktif)?$this->golbahanmakanan_aktif:true);
                $criteria->order="golbahanmakanan_nama ASC";
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public static function getGolBhnMakanItems()
        {
            $data = array();
            $criteria = new CDbCriteria();
           
            $criteria->order = "golbahanmakanan_nama ASC";
            $criteria->addCondition("golbahanmakanan_aktif IS TRUE");
            $models=self::model()->findAll($criteria);
            if(count((array)$models) > 0){
                foreach($models as $model)
                    // $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
                    $data[$model->golbahanmakanan_id]= ($model->golbahanmakanan_nama);
            }else{
                $data[""] = null;
            }
            
            return $data;
        }
}