<?php

/**
 * This is the model class for table "hearingtest_t".
 *
 * The followings are the available columns in table 'hearingtest_t':
 * @property integer $hearingtest_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pegawai_id
 * @property integer $permintaanmcu_id
 * @property integer $ruangan_id
 * @property string $tglhearingtest
 * @property string $nmperusahaan_rwt
 * @property string $jnspekerjaan_rwt
 * @property integer $lamabekerja
 * @property string $satuan_lamakrj
 * @property string $kontakdgnbising
 * @property string $ket_kerja_lingkungan
 * @property string $hobtembak_musik
 * @property string $bahankimia_lk
 * @property string $kelainanpend_kal_kel
 * @property string $altproteksi_telinga
 * @property string $gangguan_antarperorangan
 * @property string $gangguan_lingkgaduh
 * @property string $telinga_mendenging
 * @property string $tkn_membrantympani
 * @property string $tkn_influbtelinga
 * @property string $tkn_serumen
 * @property string $tkr_membrantympani
 * @property string $tkr_influbtelinga
 * @property string $tkr_serumen
 * @property string $penuruankempendengaran
 * @property string $hasil_pendengaran
 * @property string $tkn_500
 * @property string $tkn_1k
 * @property string $tkn_2k
 * @property string $tkn_3k
 * @property string $tkn_4k
 * @property string $tkn_6k
 * @property string $tkn_8k
 * @property string $tkr_500
 * @property string $tkr_1k
 * @property string $tkr_2k
 * @property string $tkr_3k
 * @property string $tkr_4k
 * @property string $tkr_6k
 * @property string $tkr_8k
 * @property string $penurunan_presbyacusis
 * @property string $penurunan_infdanlain
 * @property string $catatan_hearingtest
 * @property string $keterangan_hearingtest
 * @property string $namapemeriksa_hearingtest
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class HearingtestT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HearingtestT the static model class
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
		return 'hearingtest_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, ruangan_id, tglhearingtest, nmperusahaan_rwt, lamabekerja, satuan_lamakrj, hobtembak_musik, bahankimia_lk, kelainanpend_kal_kel, gangguan_antarperorangan, gangguan_lingkgaduh, telinga_mendenging, tkn_membrantympani, tkn_influbtelinga, tkn_serumen, tkr_membrantympani, tkr_influbtelinga, tkr_serumen, penuruankempendengaran, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasien_id, pegawai_id, permintaanmcu_id, ruangan_id, lamabekerja, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nmperusahaan_rwt', 'length', 'max'=>150),
			array('jnspekerjaan_rwt, penurunan_presbyacusis, penurunan_infdanlain, namapemeriksa_hearingtest, hasil_telingakn, hasil_telingakr', 'length', 'max'=>100),
			array('satuan_lamakrj, penuruankempendengaran', 'length', 'max'=>10),
			array('kontakdgnbising, catatan_hearingtest', 'length', 'max'=>200),
			array('hobtembak_musik, bahankimia_lk, kelainanpend_kal_kel, gangguan_antarperorangan, gangguan_lingkgaduh, telinga_mendenging, tkn_membrantympani, tkn_influbtelinga, tkn_serumen, tkr_membrantympani, tkr_influbtelinga, tkr_serumen', 'length', 'max'=>5),
			array('altproteksi_telinga', 'length', 'max'=>30),
			array('hasil_pendengaran', 'length', 'max'=>20),
			array('ket_kerja_lingkungan, tkn_250, tkn_500, tkn_1k, tkn_2k, tkn_3k, tkn_4k, tkn_6k, tkn_8k, tkr_250, tkr_500, tkr_1k, tkr_2k, tkr_3k, tkr_4k, tkr_6k, tkr_8k, keterangan_hearingtest, update_time, bkn_250,bkn_500,bkn_1k,bkn_2k,bkn_4k,bkn_8k,bkr_250,bkr_500,bkr_1k,bkr_2k,bkr_4k,bkr_8k', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hearingtest_id, pendaftaran_id, pasien_id, pegawai_id, permintaanmcu_id, ruangan_id, tglhearingtest, nmperusahaan_rwt, jnspekerjaan_rwt, lamabekerja, satuan_lamakrj, kontakdgnbising, ket_kerja_lingkungan, hobtembak_musik, bahankimia_lk, kelainanpend_kal_kel, altproteksi_telinga, gangguan_antarperorangan, gangguan_lingkgaduh, telinga_mendenging, tkn_membrantympani, tkn_influbtelinga, tkn_serumen, tkr_membrantympani, tkr_influbtelinga, tkr_serumen, penuruankempendengaran, hasil_pendengaran, tkn_250, tkn_500, tkn_1k, tkn_2k, tkn_3k, tkn_4k, tkn_6k, tkn_8k, tkr_250, tkr_500, tkr_1k, tkr_2k, tkr_3k, tkr_4k, tkr_6k, tkr_8k, penurunan_presbyacusis, penurunan_infdanlain, catatan_hearingtest, keterangan_hearingtest, namapemeriksa_hearingtest, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, hasil_telingakn, hasil_telingakr, bkn_250,bkn_500,bkn_1k,bkn_2k,bkn_4k,bkn_8k,bkr_250,bkr_500,bkr_1k,bkr_2k,bkr_4k,bkr_8k', 'safe', 'on'=>'search'),
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
			'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
			'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hearingtest_id' => 'Hearingtest',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pegawai_id' => 'Pegawai',
			'permintaanmcu_id' => 'Permintaanmcu',
			'ruangan_id' => 'Ruangan',
			'tglhearingtest' => 'Tglhearingtest',
			'nmperusahaan_rwt' => 'Nmperusahaan Rwt',
			'jnspekerjaan_rwt' => 'Jnspekerjaan Rwt',
			'lamabekerja' => 'Lamabekerja',
			'satuan_lamakrj' => 'Satuan Lamakrj',
			'kontakdgnbising' => 'Kontakdgnbising',
			'ket_kerja_lingkungan' => 'Ket Kerja Lingkungan',
			'hobtembak_musik' => 'Hobtembak Musik',
			'bahankimia_lk' => 'Bahankimia Lk',
			'kelainanpend_kal_kel' => 'Kelainanpend Kal Kel',
			'altproteksi_telinga' => 'Alat Proteksi Telinga',
			'gangguan_antarperorangan' => 'Gangguan Antarperorangan',
			'gangguan_lingkgaduh' => 'Gangguan Lingkgaduh',
			'telinga_mendenging' => 'Telinga Mendenging',
			'tkn_membrantympani' => 'Tkn Membrantympani',
			'tkn_influbtelinga' => 'Tkn Influbtelinga',
			'tkn_serumen' => 'Tkn Serumen',
			'tkr_membrantympani' => 'Tkr Membrantympani',
			'tkr_influbtelinga' => 'Tkr Influbtelinga',
			'tkr_serumen' => 'Tkr Serumen',
			'penuruankempendengaran' => 'Penuruankempendengaran',
			'hasil_pendengaran' => 'Hasil Pendengaran',
			'tkn_500' => 'Tkn 500',
			'tkn_1k' => 'Tkn 1k',
			'tkn_2k' => 'Tkn 2k',
			'tkn_3k' => 'Tkn 3k',
			'tkn_4k' => 'Tkn 4k',
			'tkn_6k' => 'Tkn 6k',
			'tkn_8k' => 'Tkn 8k',
			'tkr_500' => 'Tkr 500',
			'tkr_1k' => 'Tkr 1k',
			'tkr_2k' => 'Tkr 2k',
			'tkr_3k' => 'Tkr 3k',
			'tkr_4k' => 'Tkr 4k',
			'tkr_6k' => 'Tkr 6k',
			'tkr_8k' => 'Tkr 8k',
			'penurunan_presbyacusis' => 'Penurunan Presbyacusis',
			'penurunan_infdanlain' => 'Penurunan Infeksi dan lainnya',
			'catatan_hearingtest' => 'Catatan',
			'keterangan_hearingtest' => 'Keterangan',
			'namapemeriksa_hearingtest' => 'Pemeriksa',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'bkn_250' => 'Bkn 250',
			'bkn_500' => 'Bkn 500',
			'bkn_1k' => 'Bkn 1k',
			'bkn_2k' => 'Bkn 2k',
			'bkn_4k' => 'Bkn 4k',
			'bkn_8k' => 'Bkn 8k',
			'bkr_250' => 'Bkr 250',
			'bkr_500' => 'Bkr 500',
			'bkr_1k' => 'Bkr 1k',
			'bkr_2k' => 'Bkr 2k',
			'bkr_4k' => 'Bkr 4k',
			'bkr_8k' => 'Bkr 8k',
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

		if(!empty($this->hearingtest_id)){
			$criteria->addCondition('hearingtest_id = '.$this->hearingtest_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->permintaanmcu_id)){
			$criteria->addCondition('permintaanmcu_id = '.$this->permintaanmcu_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(tglhearingtest)',strtolower($this->tglhearingtest),true);
		$criteria->compare('LOWER(nmperusahaan_rwt)',strtolower($this->nmperusahaan_rwt),true);
		$criteria->compare('LOWER(jnspekerjaan_rwt)',strtolower($this->jnspekerjaan_rwt),true);
		if(!empty($this->lamabekerja)){
			$criteria->addCondition('lamabekerja = '.$this->lamabekerja);
		}
		$criteria->compare('LOWER(satuan_lamakrj)',strtolower($this->satuan_lamakrj),true);
		$criteria->compare('LOWER(kontakdgnbising)',strtolower($this->kontakdgnbising),true);
		$criteria->compare('LOWER(ket_kerja_lingkungan)',strtolower($this->ket_kerja_lingkungan),true);
		$criteria->compare('LOWER(hobtembak_musik)',strtolower($this->hobtembak_musik),true);
		$criteria->compare('LOWER(bahankimia_lk)',strtolower($this->bahankimia_lk),true);
		$criteria->compare('LOWER(kelainanpend_kal_kel)',strtolower($this->kelainanpend_kal_kel),true);
		$criteria->compare('LOWER(altproteksi_telinga)',strtolower($this->altproteksi_telinga),true);
		$criteria->compare('LOWER(gangguan_antarperorangan)',strtolower($this->gangguan_antarperorangan),true);
		$criteria->compare('LOWER(gangguan_lingkgaduh)',strtolower($this->gangguan_lingkgaduh),true);
		$criteria->compare('LOWER(telinga_mendenging)',strtolower($this->telinga_mendenging),true);
		$criteria->compare('LOWER(tkn_membrantympani)',strtolower($this->tkn_membrantympani),true);
		$criteria->compare('LOWER(tkn_influbtelinga)',strtolower($this->tkn_influbtelinga),true);
		$criteria->compare('LOWER(tkn_serumen)',strtolower($this->tkn_serumen),true);
		$criteria->compare('LOWER(tkr_membrantympani)',strtolower($this->tkr_membrantympani),true);
		$criteria->compare('LOWER(tkr_influbtelinga)',strtolower($this->tkr_influbtelinga),true);
		$criteria->compare('LOWER(tkr_serumen)',strtolower($this->tkr_serumen),true);
		$criteria->compare('LOWER(penuruankempendengaran)',strtolower($this->penuruankempendengaran),true);
		$criteria->compare('LOWER(hasil_pendengaran)',strtolower($this->hasil_pendengaran),true);
		$criteria->compare('LOWER(tkn_500)',strtolower($this->tkn_500),true);
		$criteria->compare('LOWER(tkn_1k)',strtolower($this->tkn_1k),true);
		$criteria->compare('LOWER(tkn_2k)',strtolower($this->tkn_2k),true);
		$criteria->compare('LOWER(tkn_3k)',strtolower($this->tkn_3k),true);
		$criteria->compare('LOWER(tkn_4k)',strtolower($this->tkn_4k),true);
		$criteria->compare('LOWER(tkn_6k)',strtolower($this->tkn_6k),true);
		$criteria->compare('LOWER(tkn_8k)',strtolower($this->tkn_8k),true);
		$criteria->compare('LOWER(tkr_500)',strtolower($this->tkr_500),true);
		$criteria->compare('LOWER(tkr_1k)',strtolower($this->tkr_1k),true);
		$criteria->compare('LOWER(tkr_2k)',strtolower($this->tkr_2k),true);
		$criteria->compare('LOWER(tkr_3k)',strtolower($this->tkr_3k),true);
		$criteria->compare('LOWER(tkr_4k)',strtolower($this->tkr_4k),true);
		$criteria->compare('LOWER(tkr_6k)',strtolower($this->tkr_6k),true);
		$criteria->compare('LOWER(tkr_8k)',strtolower($this->tkr_8k),true);
		$criteria->compare('LOWER(penurunan_presbyacusis)',strtolower($this->penurunan_presbyacusis),true);
		$criteria->compare('LOWER(penurunan_infdanlain)',strtolower($this->penurunan_infdanlain),true);
		$criteria->compare('LOWER(catatan_hearingtest)',strtolower($this->catatan_hearingtest),true);
		$criteria->compare('LOWER(keterangan_hearingtest)',strtolower($this->keterangan_hearingtest),true);
		$criteria->compare('LOWER(namapemeriksa_hearingtest)',strtolower($this->namapemeriksa_hearingtest),true);
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