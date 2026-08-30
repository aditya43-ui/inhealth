<?php

/**
 * This is the model class for table "terimamutasi_t".
 *
 * The followings are the available columns in table 'terimamutasi_t':
 * @property integer $terimamutasi_id
 * @property integer $mutasioaruangan_id
 * @property string $tglterima
 * @property string $noterimamutasi
 * @property double $totalharganetto
 * @property double $totalhargajual
 * @property string $keterangan_terima
 * @property integer $ruanganpenerima_id
 * @property integer $ruanganasal_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pegawaipenerima_id
 * @property integer $pegawaimengetahui_id
 *
 * The followings are the available model relations:
 * @property MutasioaruanganT $mutasioaruangan
 * @property RuanganM $ruanganasal
 * @property RuanganM $ruanganpenerima
 * @property PegawaiM $pegawaipenerima
 * @property PegawaiM $pegawaimengetahui
 * @property MutasioaruanganT[] $mutasioaruanganTs
 * @property TerimamutasidetailT[] $terimamutasidetailTs
 */
class TerimamutasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimamutasiT the static model class
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
		return 'terimamutasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglterima, noterimamutasi, totalharganetto, totalhargajual, ruanganpenerima_id, ruanganasal_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('mutasioaruangan_id, ruanganpenerima_id, ruanganasal_id, pegawaipenerima_id, pegawaimengetahui_id', 'numerical', 'integerOnly'=>true),
			array('totalharganetto, totalhargajual', 'numerical'),
			array('noterimamutasi', 'length', 'max'=>20),
			array('keterangan_terima, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terimamutasi_id, mutasioaruangan_id, tglterima, noterimamutasi, totalharganetto, totalhargajual, keterangan_terima, ruanganpenerima_id, ruanganasal_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawaipenerima_id, pegawaimengetahui_id', 'safe', 'on'=>'search'),
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
			'mutasioaruangan' => array(self::BELONGS_TO, 'MutasioaruanganT', 'mutasioaruangan_id'),
			'ruanganasal' => array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
			'ruanganpenerima' => array(self::BELONGS_TO, 'RuanganM', 'ruanganpenerima_id'),
			'pegawaipenerima' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaipenerima_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
			'mutasioaruanganTs' => array(self::HAS_MANY, 'MutasioaruanganT', 'terimamutasi_id'),
			'terimamutasidetailTs' => array(self::HAS_MANY, 'TerimamutasidetailT', 'terimamutasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'terimamutasi_id' => 'Terima Mutasi',
			'mutasioaruangan_id' => 'Mutasi Ruangan',
			'tglterima' => 'Tanggal Terima',
			'noterimamutasi' => 'No. Terima Mutasi',
			'totalharganetto' => 'Total Harga Netto',
			'totalhargajual' => 'Total Harga Jual',
			'keterangan_terima' => 'Keterangan Terima',
			'ruanganpenerima_id' => 'Ruangan Penerima',
			'ruanganasal_id' => 'Ruangan Asal',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegawaipenerima_id' => 'Pegawai Penerima',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
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

		$criteria->compare('terimamutasi_id',$this->terimamutasi_id);
		$criteria->compare('mutasioaruangan_id',$this->mutasioaruangan_id);
		$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('noterimamutasi',$this->noterimamutasi,true);
		$criteria->compare('totalharganetto',$this->totalharganetto);
		$criteria->compare('totalhargajual',$this->totalhargajual);
		$criteria->compare('keterangan_terima',$this->keterangan_terima,true);
		$criteria->compare('ruanganpenerima_id',$this->ruanganpenerima_id);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pegawaipenerima_id',$this->pegawaipenerima_id);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}