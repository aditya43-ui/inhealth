<?php

/**
 * This is the model class for table "orderbatalpembayaranpelayanan_t".
 *
 * The followings are the available columns in table 'orderbatalpembayaranpelayanan_t':
 * @property integer $orderbatalpembayaranpelayanan_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $penjamin_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_login
 * @property string $update_login
 */
class OrderbatalpembayaranpelayananT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orderbatalpembayaranpelayanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayaranpelayanan_id, pendaftaran_id, pasien_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('create_login, update_login', 'length', 'max'=>255),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('orderbatalpembayaranpelayanan_id, pembayaranpelayanan_id, pendaftaran_id, pasien_id, penjamin_id, create_time, update_time, create_login, update_login', 'safe', 'on'=>'search'),
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
			'orderbatalpembayaranpelayanan_id' => 'Orderbatalpembayaranpelayanan',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'penjamin_id' => 'Penjamin',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_login' => 'Create Login',
			'update_login' => 'Update Login',
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

		$criteria->compare('orderbatalpembayaranpelayanan_id',$this->orderbatalpembayaranpelayanan_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_login',$this->create_login,true);
		$criteria->compare('update_login',$this->update_login,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderbatalpembayaranpelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
