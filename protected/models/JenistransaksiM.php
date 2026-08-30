<?php

/**
 * This is the model class for table "jenistransaksi_m".
 *
 * The followings are the available columns in table 'jenistransaksi_m':
 * @property integer $jenistransaksi_id
 * @property string $namatransaksi
 * @property string $namatransaksilainnnya
 * @property integer $akundebit
 * @property integer $akunkredit
 * @property boolean $jenistransaksi_aktif
 */
class JenistransaksiM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jenistransaksi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('namatransaksi', 'required'),
			array('akundebit, akunkredit', 'numerical', 'integerOnly'=>true),
			array('namatransaksi', 'length', 'max'=>200),
			array('namatransaksilainnnya', 'length', 'max'=>100),
			array('jenistransaksi_aktif', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jenistransaksi_id, namatransaksi, namatransaksilainnnya, akundebit, akunkredit, jenistransaksi_aktif', 'safe', 'on'=>'search'),
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
			'jenistransaksi_id' => 'ID',
			'namatransaksi' => 'Nama Transaksi',
			'namatransaksilainnnya' => 'Nama Lainnnya',
			'akundebit' => 'Akun Debit',
			'akunkredit' => 'Akun Kredit',
			'jenistransaksi_aktif' => 'Aktif',
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

		$criteria->compare('jenistransaksi_id',$this->jenistransaksi_id);
		$criteria->compare('LOWER(namatransaksi)',strtolower($this->namatransaksi),true);
		$criteria->compare('LOWER(namatransaksilainnnya)',strtolower($this->namatransaksilainnnya),true);
		$criteria->compare('akundebit',$this->akundebit);
		$criteria->compare('akunkredit',$this->akunkredit);
		$criteria->compare('jenistransaksi_aktif',$this->jenistransaksi_aktif);
		$criteria->order='jenistransaksi_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JenistransaksiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
