<?php

/**
 * This is the model class for table "rl1_2_kegiatanpelayananrumahsakit_v".
 *
 * The followings are the available columns in table 'rl1_2_kegiatanpelayananrumahsakit_v':
 * @property double $tahun
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property double $hariperawatan
 * @property double $jumlahtt
 * @property double $pembagi
 * @property double $jumlahpasienkeluar
 * @property double $jumlahpasienmati
 * @property double $jumlahpasienmati48jam
 * @property double $bor
 * @property double $los
 * @property double $bto
 * @property double $toi
 * @property double $kunjunganperhari
 */
class Rl12KegiatanpelayananrumahsakitV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl12KegiatanpelayananrumahsakitV the static model class
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
		return 'rl1_2_kegiatanpelayananrumahsakit_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tahun, hariperawatan, jumlahtt, pembagi, jumlahpasienkeluar, jumlahpasienmati, jumlahpasienmati48jam, bor, los, bto, toi, kunjunganperhari', 'numerical'),
			array('nokode_rumahsakit', 'length', 'max'=>10),
			array('nama_rumahsakit', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tahun, nokode_rumahsakit, nama_rumahsakit, hariperawatan, jumlahtt, pembagi, jumlahpasienkeluar, jumlahpasienmati, jumlahpasienmati48jam, bor, los, bto, toi, kunjunganperhari', 'safe', 'on'=>'search'),
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
			'tahun' => 'Tahun',
			'nokode_rumahsakit' => 'Nokode Rumahsakit',
			'nama_rumahsakit' => 'Nama Rumahsakit',
			'hariperawatan' => 'Hariperawatan',
			'jumlahtt' => 'Jumlahtt',
			'pembagi' => 'Pembagi',
			'jumlahpasienkeluar' => 'Jumlahpasienkeluar',
			'jumlahpasienmati' => 'Jumlahpasienmati',
			'jumlahpasienmati48jam' => 'Jumlahpasienmati48jam',
			'bor' => 'Bor',
			'los' => 'Los',
			'bto' => 'Bto',
			'toi' => 'Toi',
			'kunjunganperhari' => 'Kunjunganperhari',
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

		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('nokode_rumahsakit',$this->nokode_rumahsakit,true);
		$criteria->compare('nama_rumahsakit',$this->nama_rumahsakit,true);
		$criteria->compare('hariperawatan',$this->hariperawatan);
		$criteria->compare('jumlahtt',$this->jumlahtt);
		$criteria->compare('pembagi',$this->pembagi);
		$criteria->compare('jumlahpasienkeluar',$this->jumlahpasienkeluar);
		$criteria->compare('jumlahpasienmati',$this->jumlahpasienmati);
		$criteria->compare('jumlahpasienmati48jam',$this->jumlahpasienmati48jam);
		$criteria->compare('bor',$this->bor);
		$criteria->compare('los',$this->los);
		$criteria->compare('bto',$this->bto);
		$criteria->compare('toi',$this->toi);
		$criteria->compare('kunjunganperhari',$this->kunjunganperhari);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}