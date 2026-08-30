<?php

/**
 * This is the model class for table "pembbonusthrdet_t".
 *
 * The followings are the available columns in table 'pembbonusthrdet_t':
 * @property integer $pembbonusthrdet_id
 * @property integer $pembbonusthr_id
 * @property integer $pengbonusthr_id
 * @property double $jmlhutang
 * @property double $jmldibayarkan
 * @property double $jmlsisahutang
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PembbonusthrT $pembbonusthr
 * @property PengbonusthrT $pengbonusthr
 */
class PembbonusthrdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembbonusthrdetT the static model class
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
		return 'pembbonusthrdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembbonusthr_id, pengbonusthr_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pembbonusthr_id, pengbonusthr_id', 'numerical', 'integerOnly'=>true),
			array('jmlhutang, jmldibayarkan, jmlsisahutang', 'numerical'),
			array('keterangan, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembbonusthrdet_id, pembbonusthr_id, pengbonusthr_id, jmlhutang, jmldibayarkan, jmlsisahutang, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pembbonusthr' => array(self::BELONGS_TO, 'PembbonusthrT', 'pembbonusthr_id'),
			'pengbonusthr' => array(self::BELONGS_TO, 'PengbonusthrT', 'pengbonusthr_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembbonusthrdet_id' => 'Pembbonusthrdet',
			'pembbonusthr_id' => 'Pemb. Bonus THR',
			'pengbonusthr_id' => 'Pengbonusthr',
			'jmlhutang' => 'Jmlhutang',
			'jmldibayarkan' => 'Jumlah Dibayarkan',
			'jmlsisahutang' => 'Jmlsisahutang',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('pembbonusthrdet_id',$this->pembbonusthrdet_id);
		$criteria->compare('pembbonusthr_id',$this->pembbonusthr_id);
		$criteria->compare('pengbonusthr_id',$this->pengbonusthr_id);
		$criteria->compare('jmlhutang',$this->jmlhutang);
		$criteria->compare('jmldibayarkan',$this->jmldibayarkan);
		$criteria->compare('jmlsisahutang',$this->jmlsisahutang);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}