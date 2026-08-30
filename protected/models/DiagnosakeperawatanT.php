<?php

/**
 * This is the model class for table "diagnosakeperawatan_t".
 *
 * The followings are the available columns in table 'diagnosakeperawatan_t':
 * @property integer $diagnosakeperawatan_id
 * @property integer $pemindahanpasien_id
 * @property string $nama_diagnosa
 * @property string $statusdiagnosa
 *
 * The followings are the available model relations:
 * @property PemindahanpasienT $pemindahanpasien
 */
class DiagnosakeperawatanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosakeperawatanT the static model class
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
		return 'diagnosakeperawatan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemindahanpasien_id', 'required'),
			array('pemindahanpasien_id', 'numerical', 'integerOnly'=>true),
			array('nama_diagnosa', 'length', 'max'=>200),
			array('statusdiagnosa', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diagnosakeperawatan_id, pemindahanpasien_id, nama_diagnosa, statusdiagnosa', 'safe', 'on'=>'search'),
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
			'pemindahanpasien' => array(self::BELONGS_TO, 'PemindahanpasienT', 'pemindahanpasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'diagnosakeperawatan_id' => 'Diagnosakeperawatan',
			'pemindahanpasien_id' => 'Pemindahanpasien',
			'nama_diagnosa' => 'Nama Diagnosa',
			'statusdiagnosa' => 'Statusdiagnosa',
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

		$criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
		$criteria->compare('pemindahanpasien_id',$this->pemindahanpasien_id);
		$criteria->compare('nama_diagnosa',$this->nama_diagnosa,true);
		$criteria->compare('statusdiagnosa',$this->statusdiagnosa,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}