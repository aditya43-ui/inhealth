<?php

/**
 * This is the model class for table "pajak_m".
 *
 * The followings are the available columns in table 'pajak_m':
 * @property integer $pajak_id
 * @property string $pajak_nama
 * @property string $pajak_namalain
 * @property boolean $pajak_aktif
 * @property string $keterangan
 * @property integer $rekening5_id
 * @property string $debitkredit
 */
class PajakM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PajakM the static model class
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
		return 'pajak_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pajak_nama, pajak_namalain, pajak_aktif', 'required'),
			array('rekening5_id', 'numerical', 'integerOnly'=>true),
			array('pajak_nama, pajak_namalain', 'length', 'max'=>100),
			array('debitkredit', 'length', 'max'=>1),
			array('keterangan, ispajakpegawai, isppnkeluaran, isppnmasukan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pajak_id, pajak_nama, pajak_namalain, pajak_aktif, keterangan, rekening5_id, debitkredit, ispajakpegawai, isppnkeluaran, isppnmasukan', 'safe', 'on'=>'search'),
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
                    'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pajak_id' => 'Pajak',
			'pajak_nama' => 'Nama Pajak',
			'pajak_namalain' => 'Nama Lain Pajak',
			'pajak_aktif' => 'Pajak Aktif',
			'keterangan' => 'Keterangan',
			'rekening5_id' => 'Kode Rekening',
			'debitkredit' => 'Saldo Normal',
                        'ispajakpegawai' => 'Pajak Pegawai',
                    
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

		$criteria->compare('pajak_id',$this->pajak_id);
		$criteria->compare('pajak_nama',$this->pajak_nama,true);
		$criteria->compare('pajak_namalain',$this->pajak_namalain,true);
		$criteria->compare('pajak_aktif',$this->pajak_aktif);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('debitkredit',$this->debitkredit,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}