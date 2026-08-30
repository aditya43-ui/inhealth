<?php

/**
 * This is the model class for table "setoranbdhara_t".
 *
 * The followings are the available columns in table 'setoranbdhara_t':
 * @property integer $setoranbdhara_id
 * @property integer $profilrs_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $setorbank_id
 * @property string $nosetoranbdhara
 * @property string $tglsetoranbdhara
 * @property integer $mengetahui_id
 * @property string $tglmengetahui
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class SetoranbdharaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SetoranbdharaT the static model class
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
		return 'setoranbdhara_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, ruangan_id, pegawai_id, nosetoranbdhara, tglsetoranbdhara, mengetahui_nama, mengetahui_id', 'required'),
			array('profilrs_id, ruangan_id, pegawai_id, setorbank_id, mengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nosetoranbdhara', 'length', 'max'=>50),
			array('tglmengetahui, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('setoranbdhara_id, profilrs_id, ruangan_id, pegawai_id, setorbank_id, nosetoranbdhara, tglsetoranbdhara, mengetahui_id, tglmengetahui, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'setoranbdhara_id' => 'Setoran Bendahara',
			'profilrs_id' => 'Profilrs',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai Setoran',
			'pegawai_nama' => 'Pegawai Setoran',
			'setorbank_id' => 'Setoran Bank',
			'nosetoranbdhara' => 'No. Setoran',
			'tglsetoranbdhara' => 'Tgl. Setoran',
			'mengetahui_id' => 'Pegawai Mengetahui',
			'tglmengetahui' => 'Tgl. Mengetahui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('setoranbdhara_id',$this->setoranbdhara_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('setorbank_id',$this->setorbank_id);
		$criteria->compare('nosetoranbdhara',$this->nosetoranbdhara,true);
		$criteria->compare('tglsetoranbdhara',$this->tglsetoranbdhara,true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('tglmengetahui',$this->tglmengetahui,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}