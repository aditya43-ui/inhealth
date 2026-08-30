<?php

/**
 * This is the model class for table "produksigasmedisdet_t".
 *
 * The followings are the available columns in table 'produksigasmedisdet_t':
 * @property integer $produksigasmedisdet_id
 * @property integer $produksigasmedis_id
 * @property integer $obatalkes_id
 * @property integer $satuankecil_id
 * @property double $kapasitas
 * @property double $qty_gasmedis
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $waktu_awal
 * @property string $waktu_selesai
 *
 * The followings are the available model relations:
 * @property ProduksigasmedisT $produksigasmedis
 * @property ObatalkesM $obatalkes
 * @property SatuankecilM $satuankecil
 */
class ProduksigasmedisdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProduksigasmedisdetT the static model class
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
		return 'produksigasmedisdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('produksigasmedis_id, obatalkes_id, satuankecil_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kapasitas, qty_gasmedis', 'numerical'),
			array('create_time, update_time, waktu_awal, waktu_selesai', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('produksigasmedisdet_id, produksigasmedis_id, obatalkes_id, satuankecil_id, kapasitas, qty_gasmedis, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, waktu_awal, waktu_selesai', 'safe', 'on'=>'search'),
                    
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
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
			'produksigasmedis' => array(self::BELONGS_TO, 'ProduksigasmedisT', 'produksigasmedis_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'produksigasmedisdet_id' => 'Produksigasmedisdet',
			'produksigasmedis_id' => 'Produksigasmedis',
			'obatalkes_id' => 'Obatalkes',
			'satuankecil_id' => 'Satuankecil',
			'kapasitas' => 'Kapasitas',
			'qty_gasmedis' => 'Qty Gasmedis',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'waktu_awal' => 'Waktu Awal',
			'waktu_selesai' => 'Waktu Selesai',
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

		$criteria->compare('produksigasmedisdet_id',$this->produksigasmedisdet_id);
		$criteria->compare('produksigasmedis_id',$this->produksigasmedis_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('kapasitas',$this->kapasitas);
		$criteria->compare('qty_gasmedis',$this->qty_gasmedis);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('waktu_awal',$this->waktu_awal,true);
		$criteria->compare('waktu_selesai',$this->waktu_selesai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}