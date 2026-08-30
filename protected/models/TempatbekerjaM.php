<?php

/**
 * This is the model class for table "tempatbekerja_m".
 *
 * The followings are the available columns in table 'tempatbekerja_m':
 * @property integer $tempatbekerja_id
 * @property string $tempatbekerja_nama
 * @property string $tempatbekerja_namalainnya
 * @property string $tempatbekerja_Alamat
 * @property integer $tempatbekerja_urutan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan_id
 */
class TempatbekerjaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TempatbekerjaM the static model class
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
		return 'tempatbekerja_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tempatbekerja_nama, tempatbekerja_Alamat, tempatbekerja_urutan', 'required'),
			array('tempatbekerja_urutan, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('tempatbekerja_nama, tempatbekerja_namalainnya', 'length', 'max'=>50),
			array('tempatbekerja_logo', 'file'),
			array('tempatbekerja_Alamat, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('update_time, tempatbekerja_aktif, tempatbekerja_logo, penjamin_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tempatbekerja_id, tempatbekerja_nama, tempatbekerja_logo, penjamin_id, tempatbekerja_namalainnya,tempatbekerja_aktif, tempatbekerja_Alamat, tempatbekerja_urutan, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'tempatbekerja_id' => 'ID Tempat Bekerja',
			'tempatbekerja_nama' => 'Nama Tempat Bekerja',
			'tempatbekerja_namalainnya' => 'Nama lain',
			'tempatbekerja_Alamat' => 'Tempat Bekerja Alamat',
			'tempatbekerja_urutan' => 'Tempat Bekerja Urutan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'tempatbekerja_logo' => 'Logo Tempat Bekerja',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
			'tempatbekerja_aktif' => 'Tempat Bekerja Aktif',
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

		$criteria->compare('tempatbekerja_id',$this->tempatbekerja_id);
		$criteria->compare('tempatbekerja_nama',$this->tempatbekerja_nama,true);
		$criteria->compare('tempatbekerja_namalainnya',$this->tempatbekerja_namalainnya,true);
		$criteria->compare('tempatbekerja_Alamat',$this->tempatbekerja_Alamat,true);
		$criteria->compare('tempatbekerja_urutan',$this->tempatbekerja_urutan);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);
		$criteria->compare('tempatbekerja_aktif',isset($this->tempatbekerja_aktif)?$this->tempatbekerja_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function getTempatPekerjaanItems()
	{
		return TempatbekerjaM::model()->findAll('tempatbekerja_aktif=TRUE ORDER BY tempatbekerja_nama');
	}
	public function getPenjaminItems()
	{
		return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE ORDER BY penjamin_nama ASC');
	}
}