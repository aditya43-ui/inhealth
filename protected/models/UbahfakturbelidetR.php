<?php

/**
 * This is the model class for table "ubahfakturbelidet_r".
 *
 * The followings are the available columns in table 'ubahfakturbelidet_r':
 * @property integer $ubahfakturbelidet_id
 * @property integer $ubahfakturbeli_id
 * @property integer $fakturdetail_id
 * @property integer $obatalkes_id
 * @property integer $jmlterima_awal
 * @property integer $jmlterima_akhir
 * @property double $harganettofaktur_awal
 * @property double $harganettofaktur_akhir
 * @property double $jmldiscount_awal
 * @property double $jmldiscount_akhir
 * @property double $persenppnfaktur_awal
 * @property double $persenppnfaktur_akhir
 * @property double $hargasatuan_awal
 * @property double $hargasatuan_akhir
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property boolean $ishapus
 * @property boolean $istambah
 */
class UbahfakturbelidetR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbahfakturbelidetR the static model class
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
		return 'ubahfakturbelidet_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ubahfakturbeli_id, create_time, create_loginpemakai_id', 'required'),
			array('ubahfakturbeli_id, fakturdetail_id, obatalkes_id, jmlterima_awal, jmlterima_akhir, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('harganettofaktur_awal, harganettofaktur_akhir, jmldiscount_awal, jmldiscount_akhir, persenppnfaktur_awal, persenppnfaktur_akhir, hargasatuan_awal, hargasatuan_akhir', 'numerical'),
			array('update_time, ishapus, istambah', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ubahfakturbelidet_id, ubahfakturbeli_id, fakturdetail_id, obatalkes_id, jmlterima_awal, jmlterima_akhir, harganettofaktur_awal, harganettofaktur_akhir, jmldiscount_awal, jmldiscount_akhir, persenppnfaktur_awal, persenppnfaktur_akhir, hargasatuan_awal, hargasatuan_akhir, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, ishapus, istambah', 'safe', 'on'=>'search'),
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
			'ubahfakturbelidet_id' => 'Ubahfakturbelidet',
			'ubahfakturbeli_id' => 'Ubahfakturbeli',
			'fakturdetail_id' => 'Fakturdetail',
			'obatalkes_id' => 'Obatalkes',
			'jmlterima_awal' => 'Jmlterima Awal',
			'jmlterima_akhir' => 'Jmlterima Akhir',
			'harganettofaktur_awal' => 'Harganettofaktur Awal',
			'harganettofaktur_akhir' => 'Harganettofaktur Akhir',
			'jmldiscount_awal' => 'Jumlah Keringanan Awal',
			'jmldiscount_akhir' => 'jumlah Keringanan Akhir',
			'persenppnfaktur_awal' => 'Persenppnfaktur Awal',
			'persenppnfaktur_akhir' => 'Persenppnfaktur Akhir',
			'hargasatuan_awal' => 'Hargasatuan Awal',
			'hargasatuan_akhir' => 'Hargasatuan Akhir',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'ishapus' => 'Ishapus',
			'istambah' => 'Istambah',
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

		$criteria->compare('ubahfakturbelidet_id',$this->ubahfakturbelidet_id);
		$criteria->compare('ubahfakturbeli_id',$this->ubahfakturbeli_id);
		$criteria->compare('fakturdetail_id',$this->fakturdetail_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('jmlterima_awal',$this->jmlterima_awal);
		$criteria->compare('jmlterima_akhir',$this->jmlterima_akhir);
		$criteria->compare('harganettofaktur_awal',$this->harganettofaktur_awal);
		$criteria->compare('harganettofaktur_akhir',$this->harganettofaktur_akhir);
		$criteria->compare('jmldiscount_awal',$this->jmldiscount_awal);
		$criteria->compare('jmldiscount_akhir',$this->jmldiscount_akhir);
		$criteria->compare('persenppnfaktur_awal',$this->persenppnfaktur_awal);
		$criteria->compare('persenppnfaktur_akhir',$this->persenppnfaktur_akhir);
		$criteria->compare('hargasatuan_awal',$this->hargasatuan_awal);
		$criteria->compare('hargasatuan_akhir',$this->hargasatuan_akhir);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('ishapus',$this->ishapus);
		$criteria->compare('istambah',$this->istambah);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}