<?php

/**
 * This is the model class for table "pegawaipendampingtransferpasien_t".
 *
 * The followings are the available columns in table 'pegawaipendampingtransferpasien_t':
 * @property integer $pegawaipendampingtransferpasien_id
 * @property integer $prosestransferpasien_id
 * @property integer $pegawai_id
 * @property string $pegawai_nama
 *
 * The followings are the available model relations:
 * @property ProsestransferpasienT $prosestransferpasien
 */
class PegawaipendampingtransferpasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaipendampingtransferpasienT the static model class
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
		return 'pegawaipendampingtransferpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prosestransferpasien_id', 'required'),
			array('prosestransferpasien_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('pegawai_nama', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawaipendampingtransferpasien_id, prosestransferpasien_id, pegawai_id, pegawai_nama', 'safe', 'on'=>'search'),
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
			'prosestransferpasien' => array(self::BELONGS_TO, 'ProsestransferpasienT', 'prosestransferpasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pegawaipendampingtransferpasien_id' => 'Pegawaipendampingtransferpasien',
			'prosestransferpasien_id' => 'Prosestransferpasien',
			'pegawai_id' => 'Pegawai',
			'pegawai_nama' => 'Pegawai Nama',
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

		$criteria->compare('pegawaipendampingtransferpasien_id',$this->pegawaipendampingtransferpasien_id);
		$criteria->compare('prosestransferpasien_id',$this->prosestransferpasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawai_nama',$this->pegawai_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}