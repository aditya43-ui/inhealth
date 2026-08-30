<?php

/**
 * This is the model class for table "kunjunganrehab_r".
 *
 * The followings are the available columns in table 'kunjunganrehab_r':
 * @property integer $kunjunganrehab_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $kunjunganrehabke
 * @property string $tgl_kunjunganrehab
 * @property boolean $is_terakhirkunjungan
 */
class KunjunganrehabR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kunjunganrehab_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, pasienmasukpenunjang_id', 'numerical', 'integerOnly'=>true),
			array('kunjunganrehabke', 'length', 'max'=>255),
			array('tgl_kunjunganrehab, is_terakhirkunjungan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kunjunganrehab_id, pasien_id, pendaftaran_id, pasienmasukpenunjang_id, kunjunganrehabke, tgl_kunjunganrehab, is_terakhirkunjungan', 'safe', 'on'=>'search'),
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
			'kunjunganrehab_id' => 'Kunjunganrehab',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'kunjunganrehabke' => 'Kunjunganrehabke',
			'tgl_kunjunganrehab' => 'Tgl Kunjunganrehab',
			'is_terakhirkunjungan' => 'Is Terakhirkunjungan',
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

		$criteria->compare('kunjunganrehab_id',$this->kunjunganrehab_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('kunjunganrehabke',$this->kunjunganrehabke,true);
		$criteria->compare('tgl_kunjunganrehab',$this->tgl_kunjunganrehab,true);
		$criteria->compare('is_terakhirkunjungan',$this->is_terakhirkunjungan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KunjunganrehabR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
