<?php

/**
 * This is the model class for table "asuransipasien_m".
 *
 * The followings are the available columns in table 'asuransipasien_m':
 * @property integer $asuransipasien_id
 * @property integer $pasien_id
 * @property integer $jenispeserta_id
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property string $nokartuasuransi
 * @property string $nopeserta
 * @property string $namapemilikasuransi
 * @property string $tglcetakkartuasuransi
 * @property integer $kelastanggunganasuransi_id
 * @property string $kodefeskestk1
 * @property string $nama_feskestk1
 * @property string $kodefeskesgigi
 * @property string $namafeskesgigi
 * @property string $namaperusahaan
 * @property string $nomorpokokperusahaan
 * @property string $masaberlakukartu
 * @property string $nokartukeluarga
 * @property string $nopassport
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property string $status_konfirmasi
 * @property string $tgl_konfirmasi
 * @property boolean $asuransipasien_aktif
 * @property string $bpjs_pesertadinsos
 * @property string $bpjs_prolanisprb
 * @property string $bpjs_nosktm
 *
 * The followings are the available model relations:
 * @property CarabayarM $carabayar
 * @property JenispesertaM $jenispeserta
 * @property PasienM $pasien
 * @property PenjaminpasienM $penjamin
 * @property KelaspelayananM $kelastanggunganasuransi
 */
class AsuransipasienM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsuransipasienM the static model class
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
		return 'asuransipasien_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, penjamin_id, carabayar_id, nokartuasuransi, nopeserta, namapemilikasuransi, create_time, create_loginpemakai_id, kelastanggunganasuransi_id', 'required'),
			array('pasien_id, jenispeserta_id, penjamin_id, carabayar_id, kelastanggunganasuransi_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('nokartuasuransi, nopeserta, namapemilikasuransi, kodefeskestk1, kodefeskesgigi, namaperusahaan, nomorpokokperusahaan, status_konfirmasi, jenispersertakode_bpjs', 'length', 'max'=>50),
			array('nama_feskestk1, namafeskesgigi, nopassport', 'length', 'max'=>200),
			array('nokartukeluarga, jenispeserta_bpjs', 'length', 'max'=>100),
			array('tglcetakkartuasuransi, masaberlakukartu, update_time, tgl_konfirmasi, asuransipasien_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nominal_tanggungan, asuransipasien_id, pasien_id, jenispeserta_id, penjamin_id, carabayar_id, nokartuasuransi, nopeserta, namapemilikasuransi, tglcetakkartuasuransi, kelastanggunganasuransi_id, kodefeskestk1, nama_feskestk1, kodefeskesgigi, namafeskesgigi, namaperusahaan, nomorpokokperusahaan, masaberlakukartu, nokartukeluarga, nopassport, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, status_konfirmasi, tgl_konfirmasi, asuransipasien_aktif, jenispersertakode_bpjs, jenispeserta_bpjs', 'safe', 'on'=>'search'),
			array('bpjs_pesertadinsos, bpjs_prolanisprb, bpjs_nosktm', 'safe'),

			array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
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
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'jenispeserta' => array(self::BELONGS_TO, 'JenispesertaM', 'jenispeserta_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
			'kelastanggunganasuransi' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelastanggunganasuransi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asuransipasien_id' => 'Asuransi Pasien',
			'pasien_id' => 'Pasien',
			'jenispeserta_id' => 'Jenis Peserta',
			'penjamin_id' => 'Penjamin',
			'carabayar_id' => 'Jenis Penjamin',
			'nokartuasuransi' => 'No. Kartu Asuransi',
			'nopeserta' => 'No. Peserta',
			'namapemilikasuransi' => 'Nama Pemilik Asuransi',
			'tglcetakkartuasuransi' => 'Tanggal Cetak Kartu Asuransi',
			'kelastanggunganasuransi_id' => 'Kelas Tanggungan Asuransi',
			'kodefeskestk1' => 'Kode Fes. Kes TK 1',
			'nama_feskestk1' => 'Nama Fes. Kes TK 1',
			'kodefeskesgigi' => 'Kode Fes. Kes Gigi',
			'namafeskesgigi' => 'Nama Fes. Kes Gigi',
			'namaperusahaan' => 'Nama Perusahaan ',
			'nomorpokokperusahaan' => 'Nomor Pokok Perusahaan',
			'masaberlakukartu' => 'Masa Berlaku Kartu',
			'nokartukeluarga' => 'No. Kartu Keluarga',
			'nopassport' => 'No. Passport',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'status_konfirmasi' => 'Status Konfirmasi',
			'tgl_konfirmasi' => 'Tgl. Konfirmasi',
			'tgl_konfirmasi2' => 'Tgl. Konfirmasi',
			'asuransipasien_aktif' => 'Asuransi Pasien Aktif',
			'hubkeluarga' => 'Status Hubungan Keluarga',
            'nominal_tanggungan'=> 'Nominal Tanggungan',
			'asalrujukan_id' => 'Asal Rujukan'
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

		if(!empty($this->asuransipasien_id)){
			$criteria->addCondition('asuransipasien_id = '.$this->asuransipasien_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->jenispeserta_id)){
			$criteria->addCondition('jenispeserta_id = '.$this->jenispeserta_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(nokartuasuransi)',strtolower($this->nokartuasuransi),true);
		$criteria->compare('LOWER(nopeserta)',strtolower($this->nopeserta),true);
		$criteria->compare('LOWER(namapemilikasuransi)',strtolower($this->namapemilikasuransi),true);
		$criteria->compare('LOWER(tglcetakkartuasuransi)',strtolower($this->tglcetakkartuasuransi),true);
		if(!empty($this->kelastanggunganasuransi_id)){
			$criteria->addCondition('kelastanggunganasuransi_id = '.$this->kelastanggunganasuransi_id);
		}
		$criteria->compare('LOWER(kodefeskestk1)',strtolower($this->kodefeskestk1),true);
		$criteria->compare('LOWER(nama_feskestk1)',strtolower($this->nama_feskestk1),true);
		$criteria->compare('LOWER(kodefeskesgigi)',strtolower($this->kodefeskesgigi),true);
		$criteria->compare('LOWER(namafeskesgigi)',strtolower($this->namafeskesgigi),true);
		$criteria->compare('LOWER(namaperusahaan)',strtolower($this->namaperusahaan),true);
		$criteria->compare('LOWER(nomorpokokperusahaan)',strtolower($this->nomorpokokperusahaan),true);
		$criteria->compare('LOWER(masaberlakukartu)',strtolower($this->masaberlakukartu),true);
		$criteria->compare('LOWER(nokartukeluarga)',strtolower($this->nokartukeluarga),true);
		$criteria->compare('LOWER(nopassport)',strtolower($this->nopassport),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		$criteria->compare('LOWER(tgl_konfirmasi)',strtolower($this->tgl_konfirmasi),true);
		$criteria->compare('asuransipasien_aktif',$this->asuransipasien_aktif);

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
