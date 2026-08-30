<?php

/**
 * This is the model class for table "informasisep_v".
 *
 * The followings are the available columns in table 'informasisep_v':
 * @property integer $sep_id
 * @property string $tglsep
 * @property string $nosep
 * @property string $nokartuasuransi
 * @property string $tglrujukan
 * @property string $norujukan
 * @property string $ppkrujukan
 * @property string $ppkpelayanan
 * @property integer $jnspelayanan
 * @property string $catatansep
 * @property string $diagnosaawal
 * @property string $politujuan
 * @property integer $klsrawat
 * @property integer $lakalantas
 * @property integer $penjamin_lakalantas
 * @property string $lokasi_lakalantas
 * @property string $no_telpon_peserta
 * @property integer $poli_eksekutif
 * @property integer $cob
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 */
class InformasisepV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasisepV the static model class
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
		return 'informasisep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sep_id, jnspelayanan, klsrawat, lakalantas, penjamin_lakalantas, poli_eksekutif, cob', 'numerical', 'integerOnly'=>true),
			array('nosep, politujuan', 'length', 'max'=>100),
			array('nokartuasuransi, norujukan, ppkrujukan, ppkpelayanan, nama_pasien', 'length', 'max'=>50),
			array('lokasi_lakalantas', 'length', 'max'=>250),
			array('no_telpon_peserta', 'length', 'max'=>15),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('tglsep, tglrujukan, catatansep, diagnosaawal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sep_id, tglsep, nosep, nokartuasuransi, tglrujukan, norujukan, ppkrujukan, ppkpelayanan, jnspelayanan, catatansep, diagnosaawal, politujuan, klsrawat, lakalantas, penjamin_lakalantas, lokasi_lakalantas, no_telpon_peserta, poli_eksekutif, cob, no_pendaftaran, no_rekam_medik, nama_pasien', 'safe', 'on'=>'search'),
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
			'sep_id' => 'Sep',
			'tglsep' => 'Tglsep',
			'nosep' => 'Nosep',
			'nokartuasuransi' => 'Nokartuasuransi',
			'tglrujukan' => 'Tglrujukan',
			'norujukan' => 'Norujukan',
			'ppkrujukan' => 'Ppkrujukan',
			'ppkpelayanan' => 'Ppkpelayanan',
			'jnspelayanan' => 'Jnspelayanan',
			'catatansep' => 'Catatansep',
			'diagnosaawal' => 'Diagnosaawal',
			'politujuan' => 'Politujuan',
			'klsrawat' => 'Klsrawat',
			'lakalantas' => 'Lakalantas',
			'penjamin_lakalantas' => 'Penjamin Lakalantas',
			'lokasi_lakalantas' => 'Lokasi Lakalantas',
			'no_telpon_peserta' => 'No Telpon Peserta',
			'poli_eksekutif' => 'Poli Eksekutif',
			'cob' => 'Cob',
			'no_pendaftaran' => 'No. Pendaftaran',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
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

		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('tglsep',$this->tglsep,true);
		$criteria->compare('nosep',$this->nosep,true);
		$criteria->compare('nokartuasuransi',$this->nokartuasuransi,true);
		$criteria->compare('tglrujukan',$this->tglrujukan,true);
		$criteria->compare('norujukan',$this->norujukan,true);
		$criteria->compare('ppkrujukan',$this->ppkrujukan,true);
		$criteria->compare('ppkpelayanan',$this->ppkpelayanan,true);
		$criteria->compare('jnspelayanan',$this->jnspelayanan);
		$criteria->compare('catatansep',$this->catatansep,true);
		$criteria->compare('diagnosaawal',$this->diagnosaawal,true);
		$criteria->compare('politujuan',$this->politujuan,true);
		$criteria->compare('klsrawat',$this->klsrawat);
		$criteria->compare('lakalantas',$this->lakalantas);
		$criteria->compare('penjamin_lakalantas',$this->penjamin_lakalantas);
		$criteria->compare('lokasi_lakalantas',$this->lokasi_lakalantas,true);
		$criteria->compare('no_telpon_peserta',$this->no_telpon_peserta,true);
		$criteria->compare('poli_eksekutif',$this->poli_eksekutif);
		$criteria->compare('cob',$this->cob);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}