<?php

/**
 * This is the model class for table "poinpegdet_r".
 *
 * The followings are the available columns in table 'poinpegdet_r':
 * @property integer $poinpegdet_id
 * @property integer $nilaipoin_id
 * @property integer $poinpegdet_poin
 * @property integer $poinpegawai_id
 * @property string $poinpegdet_desc
 *
 * The followings are the available model relations:
 * @property NilaipoinM $nilaipoin
 */
class PoinpegdetR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PoinpegdetR the static model class
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
		return 'poinpegdet_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nilaipoin_id, poinpegdet_poin, poinpegawai_id', 'required'),
			array('nilaipoin_id, poinpegdet_poin, poinpegawai_id', 'numerical', 'integerOnly'=>true),
			array('poinpegdet_desc', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('poinpegdet_id, nilaipoin_id, poinpegdet_poin, poinpegawai_id, poinpegdet_desc', 'safe', 'on'=>'search'),
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
			'nilaipoin' => array(self::BELONGS_TO, 'NilaipoinM', 'nilaipoin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'poinpegdet_id' => 'Poinpegdet',
			'nilaipoin_id' => 'Nilaipoin',
			'poinpegdet_poin' => 'Poinpegdet Poin',
			'poinpegawai_id' => 'Poinpegawai',
			'poinpegdet_desc' => 'Poinpegdet Desc',
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

		$criteria->compare('poinpegdet_id',$this->poinpegdet_id);
		$criteria->compare('nilaipoin_id',$this->nilaipoin_id);
		$criteria->compare('poinpegdet_poin',$this->poinpegdet_poin);
		$criteria->compare('poinpegawai_id',$this->poinpegawai_id);
		$criteria->compare('poinpegdet_desc',$this->poinpegdet_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
       
        
        /**
         * - digunakan untuk memanggil dropdown master nilaipoin_m dengan menampilkan data yang aktif saja
         * @return type
         */
        public function getDropNilaiPoinAktif(){
            $cri = new CDbCriteria();
            $cri->addCondition("nilaipoin_aktif = TRUE");
            $cri->order = "nilaipoin_nama ASC";
            
            return CHtml::listData(NilaipoinM::model()->findAll($cri), 'nilaipoin_id', 'NamaDanPoin');
        }
}