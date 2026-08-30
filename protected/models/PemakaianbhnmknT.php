<?php

/**
 * This is the model class for table "pemakaianbhnmkn_t".
 *
 * The followings are the available columns in table 'pemakaianbhnmkn_t':
 * @property integer $pemakaianbhnmkn_id
 * @property string $no_pemakaianbhnmkn
 * @property string $tglpemakaianbhnmkn
 * @property string $ruanganpemakaibhnmkn
 * @property integer $pegmengetahui_id
 * @property string $ketpemakaian
 * @property string $create_time
 * @property string $update_time
 * @property string $create_ruangan
 * @property string $update_ruangan
 * @property string $create_loginpemakai
 *
 * The followings are the available model relations:
 * @property PemakaianbhnmkndetT[] $pemakaianbhnmkndetTs
 */
class PemakaianbhnmknT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemakaianbhnmknT the static model class
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
		return 'pemakaianbhnmkn_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_pemakaianbhnmkn, tglpemakaianbhnmkn, ruanganpemakaibhnmkn, pegmengetahui_id, create_time, create_ruangan, create_loginpemakai', 'required'),
			array('pegmengetahui_id', 'numerical', 'integerOnly'=>true),
			array('no_pemakaianbhnmkn', 'length', 'max'=>20),
			array('ketpemakaian', 'length', 'max'=>255),
                    array('untukkeperluan', 'length', 'max'=>500),
			array('update_time, update_ruangan, untukkeperluan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemakaianbhnmkn_id, no_pemakaianbhnmkn, tglpemakaianbhnmkn, ruanganpemakaibhnmkn, pegmengetahui_id, ketpemakaian, create_time, update_time, create_ruangan, update_ruangan, create_loginpemakai, untukkeperluan', 'safe', 'on'=>'search'),
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
			'pemakaianbhnmkndetTs' => array(self::HAS_MANY, 'PemakaianbhnmkndetT', 'pemakaianbhnmkn_id'),
                    'ruangans' => array(self::BELONGS_TO, 'RuanganM', 'ruanganpemakaibhnmkn'),
                    'pegmengetahuis' => array(self::BELONGS_TO, 'PegawaiM', 'pegmengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemakaianbhnmkn_id' => 'Pemakaianbhnmkn',
			'no_pemakaianbhnmkn' => 'No Pemakaian Bahan Makanan',
			'tglpemakaianbhnmkn' => 'Tanggal Pemakaian Bahan Makanan',
			'ruanganpemakaibhnmkn' => 'Ruangan Pemakaian Bahan Makanan',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'ketpemakaian' => 'Keterangan Pemakai',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_ruangan' => 'Create Ruangan',
			'update_ruangan' => 'Update Ruangan',
			'create_loginpemakai' => 'Create Loginpemakai',
                    'untukkeperluan' => 'Untuk Keperluan',
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

		$criteria->compare('pemakaianbhnmkn_id',$this->pemakaianbhnmkn_id);
		$criteria->compare('no_pemakaianbhnmkn',$this->no_pemakaianbhnmkn,true);
		$criteria->compare('tglpemakaianbhnmkn',$this->tglpemakaianbhnmkn,true);
		$criteria->compare('ruanganpemakaibhnmkn',$this->ruanganpemakaibhnmkn,true);
		$criteria->compare('pegmengetahui_id',$this->pegmengetahui_id);
		$criteria->compare('ketpemakaian',$this->ketpemakaian,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('update_ruangan',$this->update_ruangan,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}