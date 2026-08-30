<?php

/**
 * This is the model class for table "pengajuanjasapenggajian_meta_v".
 *
 * The followings are the available columns in table 'pengajuanjasapenggajian_meta_v':
 * @property integer $pegawai_id
 * @property integer $pembayaranjasa_id
 * @property boolean $is_penggajian
 */
class PengajuanjasapenggajianMetaV extends CActiveRecord
{
        public $status_gaji;
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanjasapenggajianMetaV the static model class
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
		return 'pengajuanjasapenggajian_meta_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pembayaranjasa_id', 'numerical', 'integerOnly'=>true),
			array('is_penggajian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, pembayaranjasa_id, is_penggajian', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'pembayaranjasa_id' => 'Pembayaranjasa',
			'is_penggajian' => 'Is Penggajian',
                        'status_gaji' => 'Status Pengajuan'
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

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pembayaranjasa_id',$this->pembayaranjasa_id);
		$criteria->compare('is_penggajian',$this->is_penggajian);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}