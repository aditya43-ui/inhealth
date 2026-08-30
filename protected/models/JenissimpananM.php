<?php

/**
 * This is the model class for table "jenissimpanan_m".
 *
 * The followings are the available columns in table 'jenissimpanan_m':
 * @property integer $jenissimpanan_id
 * @property string $kodesimpanan
 * @property string $jenissimpanan
 * @property string $jenissimpanan_namalain
 * @property integer $jangkapenarikanbln
 * @property double $persenjasathn
 * @property double $persenpajakthn
 * @property string $jns_create_time
 * @property string $jns_update_time
 * @property string $jns_create_login
 * @property string $jns_update_login
 * @property boolean $jenissimpanan_aktif
 * @property boolean $jenissimpanan_singkatan
 */
class JenissimpananM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jenissimpanan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kodesimpanan, jenissimpanan, jns_create_time, jns_create_login, jenissimpanan_singkatan, jenissimpanan_aktif', 'required'),
			array('jangkapenarikanbln', 'numerical', 'integerOnly'=>true),
			array('persenjasathn, persenpajakthn', 'numerical'),
			array('kodesimpanan', 'length', 'max'=>10),
			array('jenissimpanan', 'length', 'max'=>50),
			array('jenissimpanan_namalain', 'length', 'max'=>30),
			array('jns_create_login, jns_update_login', 'length', 'max'=>100),
			array('jns_update_time, jenissimpanan_aktif, jenissimpanan_singkatan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jenissimpanan_id, kodesimpanan, jenissimpanan, jenissimpanan_namalain, jangkapenarikanbln, persenjasathn, persenpajakthn, jns_create_time, jns_update_time, jns_create_login, jns_update_login, jenissimpanan_aktif', 'safe', 'on'=>'search'),
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
			'jenissimpanan_id' => 'ID',
			'kodesimpanan' => 'Kode Simpanan',
			'jenissimpanan' => 'Jenis Simpanan',
			'jenissimpanan_namalain' => 'Nama Lainnya',
			'jangkapenarikanbln' => 'Jangka Penarikan / Bulan',
			'persenjasathn' => 'Jasa(%) / Tahun',
			'persenpajakthn' => 'Pajak(%) / Tahun',
			'jns_create_time' => 'Create Time',
			'jns_update_time' => 'Update Time',
			'jns_create_login' => 'Create Login',
			'jns_update_login' => 'Update Login',
			'jenissimpanan_aktif' => 'Aktif',
			'jenissimpanan_singkatan' => 'Singkatan',
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

		$criteria->compare('jenissimpanan_id',$this->jenissimpanan_id);
		$criteria->compare('LOWER(kodesimpanan)',strtolower($this->kodesimpanan),true);
		$criteria->compare('LOWER(jenissimpanan_namalain)',strtolower($this->jenissimpanan_namalain),true);
		$criteria->compare('LOWER(jenissimpanan)',strtolower($this->jenissimpanan),true);
		$criteria->compare('jangkapenarikanbln',$this->jangkapenarikanbln);
		$criteria->compare('persenjasathn',$this->persenjasathn);
		$criteria->compare('persenpajakthn',$this->persenpajakthn);
		$criteria->compare('jns_create_time',$this->jns_create_time,true);
		$criteria->compare('jns_update_time',$this->jns_update_time,true);
		$criteria->compare('jns_create_login',$this->jns_create_login,true);
		$criteria->compare('jns_update_login',$this->jns_update_login,true);
		$criteria->compare('jenissimpanan_aktif',$this->jenissimpanan_aktif);
		$criteria->compare('LOWER(jenissimpanan_singkatan)',strtolower($this->jenissimpanan_singkatan));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JenissimpananM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
