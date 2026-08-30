<?php

/**
 * This is the model class for table "permintaanmcu_t".
 *
 * The followings are the available columns in table 'permintaanmcu_t':
 * @property integer $permintaanmcu_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $daftartindakan_id
 * @property integer $tipepaket_id
 * @property integer $paketpelayanan_id
 * @property string $tglpermintaan
 * @property string $tglrencanaperiksa
 * @property string $noantrianperm
 * @property boolean $pernahmcu
 * @property string $keteranganpermintaan
 * @property integer $ruangantujuan_id
 * @property double $tarifperpaketmcu
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PermintaanmcuT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaanmcuT the static model class
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
		return 'permintaanmcu_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, tipepaket_id, paketpelayanan_id, tglpermintaan, tglrencanaperiksa, noantrianperm, ruangantujuan_id, tarifperpaketmcu, create_time, create_loginpemakai_id', 'required'),
			array('tindakanpelayanan_id, pendaftaran_id, daftartindakan_id, tipepaket_id, paketpelayanan_id, ruangantujuan_id', 'numerical', 'integerOnly'=>true),
			array('tarifperpaketmcu', 'numerical'),
			array('noantrianperm', 'length', 'max'=>3),
			array('pernahmcu, keteranganpermintaan, update_time, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permintaanmcu_id, tindakanpelayanan_id, pendaftaran_id, daftartindakan_id, tipepaket_id, paketpelayanan_id, tglpermintaan, tglrencanaperiksa, noantrianperm, pernahmcu, keteranganpermintaan, ruangantujuan_id, tarifperpaketmcu, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'paketpelayanan'=>array(self::BELONGS_TO,'PaketpelayananM','paketpelayanan_id'),
                    'tipepaket'=>array(self::BELONGS_TO,'TipepaketM','tipepaket_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permintaanmcu_id' => 'Permintaan MCU',
			'tindakanpelayanan_id' => 'Tindakan Pelayanan',
			'pendaftaran_id' => 'Pendaftaran',
			'daftartindakan_id' => 'Daftar Tindakan',
			'tipepaket_id' => 'Tipe Paket',
			'paketpelayanan_id' => 'Paket Pelayanan',
			'tglpermintaan' => 'Tgl. Permintaan',
			'tglrencanaperiksa' => 'Tgl. Rencana Periksa',
			'noantrianperm' => 'No. Antrian',
			'pernahmcu' => 'Pernah Ke MCU',
			'keteranganpermintaan' => 'Keterangan Permintaan',
			'ruangantujuan_id' => 'Ruangan Tujuan',
			'tarifperpaketmcu' => 'Tarif Paket MCU',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('permintaanmcu_id',$this->permintaanmcu_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('paketpelayanan_id',$this->paketpelayanan_id);
		$criteria->compare('tglpermintaan',$this->tglpermintaan,true);
		$criteria->compare('tglrencanaperiksa',$this->tglrencanaperiksa,true);
		$criteria->compare('noantrianperm',$this->noantrianperm,true);
		$criteria->compare('pernahmcu',$this->pernahmcu);
		$criteria->compare('keteranganpermintaan',$this->keteranganpermintaan,true);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('tarifperpaketmcu',$this->tarifperpaketmcu);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}