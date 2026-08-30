<?php

/**
 * This is the model class for table "referensikerja_r".
 *
 * The followings are the available columns in table 'referensikerja_r':
 * @property integer $referensikerja_id
 * @property string $namareferensi
 * @property string $instansi
 * @property string $jabatan
 * @property string $no_telp
 * @property integer $pelamar_id
 *
 * The followings are the available model relations:
 * @property PelamarT $referensikerja
 */
class ReferensikerjaR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'referensikerja_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pelamar_id', 'numerical', 'integerOnly'=>true),
			array('namareferensi, instansi, jabatan, no_telp', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('referensikerja_id, namareferensi, instansi, jabatan, no_telp, pelamar_id', 'safe', 'on'=>'search'),
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
			'referensikerja' => array(self::BELONGS_TO, 'PelamarT', 'referensikerja_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'referensikerja_id' => 'Referensikerja',
			'namareferensi' => 'Namareferensi',
			'instansi' => 'Instansi',
			'jabatan' => 'Jabatan',
			'no_telp' => 'No Telp',
			'pelamar_id' => 'Pelamar',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('referensikerja_id',$this->referensikerja_id);
		$criteria->compare('namareferensi',$this->namareferensi,true);
		$criteria->compare('instansi',$this->instansi,true);
		$criteria->compare('jabatan',$this->jabatan,true);
		$criteria->compare('no_telp',$this->no_telp,true);
		$criteria->compare('pelamar_id',$this->pelamar_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReferensikerjaR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
