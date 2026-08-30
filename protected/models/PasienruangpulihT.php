<?php

/**
 * This is the model class for table "pasienruangpulih_t".
 *
 * The followings are the available columns in table 'pasienruangpulih_t':
 * @property integer $pasienruangpulih_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $asesmentnyeri_id
 * @property integer $masukkamar_id
 * @property integer $tindaklanjutpasien_masukkamar_id
 * @property string $masukruanganpulih_tanggal
 * @property string $masukruanganpulih_jam
 * @property integer $dokteranastesi_id
 * @property integer $petugas_saatmasukruangpulih_id
 * @property integer $totalskor_aldrettemasukrpulih
 * @property boolean $isdisposableinfuspump
 * @property string $disposableinfuspump_ket
 * @property boolean $ismelaluicathepidural
 * @property string $melaluicathepidural_ket
 * @property boolean $istatalaksananyerilainnya
 * @property string $istatalaksananyerilainnya_ket
 * @property string $keluarruanganpulih_tanggal
 * @property string $keluarruanganpulih_jam
 * @property integer $petugas_saatkeluarruangpulih_id
 * @property integer $score_skalanyeri
 * @property string $keteranganskala_nyeri
 * @property integer $totalskor_aldrettekeluarrpulih
 * @property string $instruksi_bilanyeri
 * @property string $intruksi_mualmuntah
 * @property string $instruksi_infus
 * @property string $instruksi_makanminum
 * @property string $instruksi_obat
 * @property string $tindaklanjutpasien
 * @property integer $tindaklanjutpasien_ruanganrawat_id
 * @property integer $tindaklanjutpasien_kamarruangan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property AsesmentnyeriT $asesmentnyeri
 * @property MasukkamarT $masukkamar
 * @property MasukkamarT $tindaklanjutpasienMasukkamar
 * @property PegawaiM $dokteranastesi
 * @property PegawaiM $petugasSaatkeluarruangpulih
 */
class PasienruangpulihT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienruangpulihT the static model class
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
		return 'pasienruangpulih_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, masukkamar_id, masukruanganpulih_tanggal, masukruanganpulih_jam, dokteranastesi_id, perawatanastesi_id, petugas_saatmasukruangpulih_id', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, asesmentnyeri_id, masukkamar_id, tindaklanjutpasien_masukkamar_id, dokteranastesi_id, petugas_saatmasukruangpulih_id, totalskor_aldrettemasukrpulih, petugas_saatkeluarruangpulih_id, score_skalanyeri, totalskor_aldrettekeluarrpulih, tindaklanjutpasien_ruanganrawat_id, tindaklanjutpasien_kamarruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
                        array('keluarruanganpulih_tanggal, keluarruanganpulih_jam, petugas_saatkeluarruangpulih_id', 'required', 'on'=>'keluar'),
			array('disposableinfuspump_ket, melaluicathepidural_ket, istatalaksananyerilainnya_ket', 'length', 'max'=>200),
			array('keteranganskala_nyeri', 'length', 'max'=>100),
			array('tindaklanjutpasien', 'length', 'max'=>50),
			array('keluarruanganpulih_tanggal, keluarruanganpulih_jam, petugas_saatkeluarruangpulih_id, tindaklanjutpasien, tindaklanjutpasien_ruanganrawat_id, tindaklanjutpasien_kamarruangan_id, isdisposableinfuspump, ismelaluicathepidural, istatalaksananyerilainnya, instruksi_bilanyeri, intruksi_mualmuntah, instruksi_infus, instruksi_makanminum, instruksi_obat, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienruangpulih_id, pasien_id, pendaftaran_id, pasienadmisi_id, asesmentnyeri_id, masukkamar_id, tindaklanjutpasien_masukkamar_id, masukruanganpulih_tanggal, masukruanganpulih_jam, dokteranastesi_id, petugas_saatmasukruangpulih_id, totalskor_aldrettemasukrpulih, isdisposableinfuspump, disposableinfuspump_ket, ismelaluicathepidural, melaluicathepidural_ket, istatalaksananyerilainnya, istatalaksananyerilainnya_ket, keluarruanganpulih_tanggal, keluarruanganpulih_jam, petugas_saatkeluarruangpulih_id, score_skalanyeri, keteranganskala_nyeri, totalskor_aldrettekeluarrpulih, instruksi_bilanyeri, intruksi_mualmuntah, instruksi_infus, instruksi_makanminum, instruksi_obat, tindaklanjutpasien, tindaklanjutpasien_ruanganrawat_id, tindaklanjutpasien_kamarruangan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'asesmentnyeri' => array(self::BELONGS_TO, 'AsesmentnyeriT', 'asesmentnyeri_id'),
			'masukkamar' => array(self::BELONGS_TO, 'MasukkamarT', 'masukkamar_id'),
			'tindaklanjutpasienMasukkamar' => array(self::BELONGS_TO, 'MasukkamarT', 'tindaklanjutpasien_masukkamar_id'),
			'dokteranastesi' => array(self::BELONGS_TO, 'PegawaiM', 'dokteranastesi_id'),
			'petugasSaatkeluarruangpulih' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_saatkeluarruangpulih_id'),
			'tindaklanjutpasienRuanganrawat' => array(self::BELONGS_TO, 'RuanganM', 'tindaklanjutpasien_ruanganrawat_id'),
			'tindaklanjutpasienKamarruangan' => array(self::BELONGS_TO, 'KamarruanganM', 'tindaklanjutpasien_kamarruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienruangpulih_id' => 'Pasienruangpulih',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'asesmentnyeri_id' => 'Asesmentnyeri',
			'masukkamar_id' => 'Masukkamar',
			'tindaklanjutpasien_masukkamar_id' => 'Tindaklanjutpasien Masukkamar',
			'masukruanganpulih_tanggal' => 'Tanggal Masuk',
			'masukruanganpulih_jam' => 'Jam Masuk',
			'dokteranastesi_id' => 'Dokter Anestesiologi',
			'perawatanastesi_id' => 'Perawat Anestesiologi',
			'petugas_saatmasukruangpulih_id' => 'Petugas Ruang Pulih',
			'totalskor_aldrettemasukrpulih' => 'Totalskor Aldrettemasukrpulih',
			'isdisposableinfuspump' => 'Disposable Infus Pump',
			'disposableinfuspump_ket' => 'Disposableinfuspump Ket',
			'ismelaluicathepidural' => 'Melalui Kateter Epidural',
			'melaluicathepidural_ket' => 'Melaluicathepidural Ket',
			'istatalaksananyerilainnya' => 'Lainnya',
			'istatalaksananyerilainnya_ket' => 'Istatalaksananyerilainnya Ket',
			'keluarruanganpulih_tanggal' => 'Tanggal Keluar',
			'keluarruanganpulih_jam' => 'Jam Keluar',
			'petugas_saatkeluarruangpulih_id' => 'Petugas Ruang Pulih',
			'score_skalanyeri' => 'Score Skalanyeri',
			'keteranganskala_nyeri' => 'Keteranganskala Nyeri',
			'totalskor_aldrettekeluarrpulih' => 'Totalskor Aldrettekeluarrpulih',
			'instruksi_bilanyeri' => 'Bila Nyeri',
			'intruksi_mualmuntah' => 'Mual / Muntah',
			'instruksi_infus' => 'Infus',
			'instruksi_makanminum' => 'Makan / Minum',
			'instruksi_obat' => 'Obat',
			'tindaklanjutpasien' => 'Tindak Lanjut ke',
			'tindaklanjutpasien_ruanganrawat_id' => 'Tindaklanjutpasien Ruanganrawat',
			'tindaklanjutpasien_kamarruangan_id' => 'Tindaklanjutpasien Kamarruangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasienruangpulih_id)){
			$criteria->addCondition('pasienruangpulih_id = '.$this->pasienruangpulih_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->asesmentnyeri_id)){
			$criteria->addCondition('asesmentnyeri_id = '.$this->asesmentnyeri_id);
		}
		if(!empty($this->masukkamar_id)){
			$criteria->addCondition('masukkamar_id = '.$this->masukkamar_id);
		}
		if(!empty($this->tindaklanjutpasien_masukkamar_id)){
			$criteria->addCondition('tindaklanjutpasien_masukkamar_id = '.$this->tindaklanjutpasien_masukkamar_id);
		}
		$criteria->compare('LOWER(masukruanganpulih_tanggal)',strtolower($this->masukruanganpulih_tanggal),true);
		$criteria->compare('LOWER(masukruanganpulih_jam)',strtolower($this->masukruanganpulih_jam),true);
		if(!empty($this->dokteranastesi_id)){
			$criteria->addCondition('dokteranastesi_id = '.$this->dokteranastesi_id);
		}
		if(!empty($this->petugas_saatmasukruangpulih_id)){
			$criteria->addCondition('petugas_saatmasukruangpulih_id = '.$this->petugas_saatmasukruangpulih_id);
		}
		if(!empty($this->totalskor_aldrettemasukrpulih)){
			$criteria->addCondition('totalskor_aldrettemasukrpulih = '.$this->totalskor_aldrettemasukrpulih);
		}
		$criteria->compare('isdisposableinfuspump',$this->isdisposableinfuspump);
		$criteria->compare('LOWER(disposableinfuspump_ket)',strtolower($this->disposableinfuspump_ket),true);
		$criteria->compare('ismelaluicathepidural',$this->ismelaluicathepidural);
		$criteria->compare('LOWER(melaluicathepidural_ket)',strtolower($this->melaluicathepidural_ket),true);
		$criteria->compare('istatalaksananyerilainnya',$this->istatalaksananyerilainnya);
		$criteria->compare('LOWER(istatalaksananyerilainnya_ket)',strtolower($this->istatalaksananyerilainnya_ket),true);
		$criteria->compare('LOWER(keluarruanganpulih_tanggal)',strtolower($this->keluarruanganpulih_tanggal),true);
		$criteria->compare('LOWER(keluarruanganpulih_jam)',strtolower($this->keluarruanganpulih_jam),true);
		if(!empty($this->petugas_saatkeluarruangpulih_id)){
			$criteria->addCondition('petugas_saatkeluarruangpulih_id = '.$this->petugas_saatkeluarruangpulih_id);
		}
		if(!empty($this->score_skalanyeri)){
			$criteria->addCondition('score_skalanyeri = '.$this->score_skalanyeri);
		}
		$criteria->compare('LOWER(keteranganskala_nyeri)',strtolower($this->keteranganskala_nyeri),true);
		if(!empty($this->totalskor_aldrettekeluarrpulih)){
			$criteria->addCondition('totalskor_aldrettekeluarrpulih = '.$this->totalskor_aldrettekeluarrpulih);
		}
		$criteria->compare('LOWER(instruksi_bilanyeri)',strtolower($this->instruksi_bilanyeri),true);
		$criteria->compare('LOWER(intruksi_mualmuntah)',strtolower($this->intruksi_mualmuntah),true);
		$criteria->compare('LOWER(instruksi_infus)',strtolower($this->instruksi_infus),true);
		$criteria->compare('LOWER(instruksi_makanminum)',strtolower($this->instruksi_makanminum),true);
		$criteria->compare('LOWER(instruksi_obat)',strtolower($this->instruksi_obat),true);
		$criteria->compare('LOWER(tindaklanjutpasien)',strtolower($this->tindaklanjutpasien),true);
		if(!empty($this->tindaklanjutpasien_ruanganrawat_id)){
			$criteria->addCondition('tindaklanjutpasien_ruanganrawat_id = '.$this->tindaklanjutpasien_ruanganrawat_id);
		}
		if(!empty($this->tindaklanjutpasien_kamarruangan_id)){
			$criteria->addCondition('tindaklanjutpasien_kamarruangan_id = '.$this->tindaklanjutpasien_kamarruangan_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}