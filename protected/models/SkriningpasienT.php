<?php

/**
 * This is the model class for table "skriningpasien_t".
 *
 * The followings are the available columns in table 'skriningpasien_t':
 * @property integer $skriningpasien_id
 * @property integer $pasien_id
 * @property string $ispasienrujukandariluar
 * @property string $keadaanumumpasien_lemah
 * @property string $keadaanumumpasien_tidaksadarpingsan
 * @property string $kesadaran
 * @property string $pernafasan
 * @property string $resikojatuh
 * @property string $nyeridada
 * @property string $ekspresiwajah_gelisah
 * @property string $ekspresiwajah_nyeri
 * @property string $skalanyeri
 * @property integer $bagiantubuh_id
 * @property string $batuk
 * @property string $keputusanhasilskrining
 * @property integer $petugas_id
 * @property string $tanggalskrining
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PegawaiM $petugas
 */
class SkriningpasienT extends CActiveRecord
{
    public $kesadaran2;
    public $petugaspengisi_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SkriningpasienT the static model class
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
		return 'skriningpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, petugas_id', 'required'),
			array('pasien_id, pendaftaran_id, bagiantubuh_id, petugas_id', 'numerical', 'integerOnly'=>true),
			array('keadaanumumpasien_lemah, keadaanumumpasien_tidaksadarpingsan, pernafasan, resikojatuh, ekspresiwajah_gelisah, ekspresiwajah_nyeri, skalanyeri, batuk, keputusanhasilskrining', 'length', 'max'=>100),
			array('kesadaran, kesadaran2, nyeridada', 'length', 'max'=>100),
			array('petugaspengisi_id, jumlahskor, tanggalskrining, ispasienrujukandariluar, pakai_sk, kesadaran', 'safe'),
            array('asalrujukan, alasandirujuk, kodediagnosa, diagnosarujukan, tensi, nadi, suhu, respratoryrate, terapi, tindakan, alasan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('skriningpasien_id, pasien_id, ispasienrujukandariluar, keadaanumumpasien_lemah, keadaanumumpasien_tidaksadarpingsan, kesadaran, pernafasan, resikojatuh, nyeridada, ekspresiwajah_gelisah, ekspresiwajah_nyeri, skalanyeri, bagiantubuh_id, batuk, keputusanhasilskrining, petugas_id, tanggalskrining', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
            'bagiantubuh' => array(self::BELONGS_TO, 'BagiantubuhM', 'bagiantubuh_id'),
			'petugaspengisi' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspengisi_id'),
			'skriningpasiendetTs' => array(self::HAS_MANY, 'SkriningpasiendetT', 'skriningpasien_id'),
			'perencanaanevaluasiTs' => array(self::HAS_MANY, 'PerencanaanevaluasiT', 'skriningpasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'skriningpasien_id' => 'Skriningpasien',
			'pasien_id' => 'Pasien',
			'ispasienrujukandariluar' => 'Ispasienrujukandariluar',
			'keadaanumumpasien_lemah' => 'a. Lemah',
			'keadaanumumpasien_tidaksadarpingsan' => 'b. Tidak sadar / pingsan',
			'kesadaran' => 'KESADARAN',
			'pernafasan' => 'PERNAFASAN',
			'resikojatuh' => 'RESIKO JATUH',
			'nyeridada' => 'NYERI DADA',
			'ekspresiwajah_gelisah' => 'a. Gelisah',
			'ekspresiwajah_nyeri' => 'b. Nyeri',
			'skalanyeri' => 'SKALA NYERI',
			'bagiantubuh_id' => 'Lokasi',
			'batuk' => 'BATUK',
			'keputusanhasilskrining' => 'Keputusanhasilskrining',
			'petugas_id' => 'Petugas',
			'tanggalskrining' => 'Tanggalskrining',
            'tensi' => 'Tekanan Darah',
            'nadi' => 'Nadi',
            'suhu' => 'Suhu Tubuh',
            'respratoryrate' => 'Pernapasan',
            'asalrujukan' => 'Asal Rujukan',
            'alasandirujuk' => 'Alasan Dirujuk',
            'kodediagnosa' => 'Diagnosa',
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

		$criteria->compare('skriningpasien_id',$this->skriningpasien_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ispasienrujukandariluar',$this->ispasienrujukandariluar,true);
		$criteria->compare('keadaanumumpasien_lemah',$this->keadaanumumpasien_lemah,true);
		$criteria->compare('keadaanumumpasien_tidaksadarpingsan',$this->keadaanumumpasien_tidaksadarpingsan,true);
		$criteria->compare('kesadaran',$this->kesadaran,true);
		$criteria->compare('pernafasan',$this->pernafasan,true);
		$criteria->compare('resikojatuh',$this->resikojatuh,true);
		$criteria->compare('nyeridada',$this->nyeridada,true);
		$criteria->compare('ekspresiwajah_gelisah',$this->ekspresiwajah_gelisah,true);
		$criteria->compare('ekspresiwajah_nyeri',$this->ekspresiwajah_nyeri,true);
		$criteria->compare('skalanyeri',$this->skalanyeri,true);
		$criteria->compare('bagiantubuh_id',$this->bagiantubuh_id);
		$criteria->compare('batuk',$this->batuk,true);
		$criteria->compare('keputusanhasilskrining',$this->keputusanhasilskrining,true);
		$criteria->compare('petugas_id',$this->petugas_id);
		$criteria->compare('tanggalskrining',$this->tanggalskrining,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchRiwayat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
