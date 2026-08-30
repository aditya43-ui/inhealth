<?php

/**
 * This is the model class for table "orderbatalalokasi_t".
 *
 * The followings are the available columns in table 'orderbatalalokasi_t':
 * @property integer $orderbatalalokasi_id
 * @property integer $alokasidana_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $penjamin_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 */
class OrderbatalalokasiT extends CActiveRecord
{
	public $ceklis;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orderbatalalokasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alokasidana_id, pendaftaran_id, pasien_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('create_loginpemakai', 'length', 'max'=>255),
			array('create_time, update_time, update_loginpemakai', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('orderbatalalokasi_id, alokasidana_id, pendaftaran_id, pasien_id, penjamin_id, create_time, update_time, create_loginpemakai, update_loginpemakai', 'safe', 'on'=>'search'),
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
			'orderbatalalokasi_id' => 'Orderbatalalokasi',
			'alokasidana_id' => 'Alokasidana',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'penjamin_id' => 'Penjamin',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('orderbatalalokasi_id',$this->orderbatalalokasi_id);
		$criteria->compare('alokasidana_id',$this->alokasidana_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderbatalalokasiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
