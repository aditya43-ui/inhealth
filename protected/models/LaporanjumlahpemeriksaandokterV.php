<?php

/**
 * This is the model class for table "laporanjumlahpemeriksaandokter_v".
 *
 * The followings are the available columns in table 'laporanjumlahpemeriksaandokter_v':
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property string $dokter_id
 * @property string $gelardepan
 * @property string $dokter_nama
 * @property string $gelarbelakang_nama
 * @property string $penjamin_nama
 * @property double $tarif_satuan
 * @property integer $qty_tindakan
 * @property double $tarif_tindakan
 * @property string $tgl_tindakan
 * @property integer $penjamin_id
 * @property string $statusdokter
 */
class LaporanjumlahpemeriksaandokterV extends CActiveRecord
{
        public $tglAwal, $tglAkhir;
		
		public $bulan;
		public $tahun;
		
		


		/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanjumlahpemeriksaandokterV the static model class
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
		return 'laporanjumlahpemeriksaandokter_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, daftartindakan_id, qty_tindakan, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('tarif_satuan, tarif_tindakan', 'numerical'),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('nama_pasien, instalasi_nama, ruangan_nama, dokter_nama, penjamin_nama', 'length', 'max'=>50),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('dokter_id, tgl_tindakan, statusdokter', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('no_pendaftaran, no_rekam_medik, nama_pasien, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, daftartindakan_id, daftartindakan_nama, dokter_id, gelardepan, dokter_nama, gelarbelakang_nama, penjamin_nama, tarif_satuan, qty_tindakan, tarif_tindakan, tgl_tindakan, penjamin_id, statusdokter', 'safe', 'on'=>'search'),
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
			'no_pendaftaran' => 'No. Pendaftaran',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'dokter_id' => 'Dokter',
			'gelardepan' => 'Gelardepan',
			'dokter_nama' => 'Dokter Nama',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'penjamin_nama' => 'Penjamin Nama',
			'tarif_satuan' => 'Tarif Satuan',
			'qty_tindakan' => 'Qty Tindakan',
			'tarif_tindakan' => 'Nominal Tarif',
			'tgl_tindakan' => 'Tgl. Tindakan',
			'penjamin_id' => 'Penjamin',
			'statusdokter' => 'Statusdokter',
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

		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('dokter_id',$this->dokter_id,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('dokter_nama',$this->dokter_nama,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('tgl_tindakan',$this->tgl_tindakan,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('statusdokter',$this->statusdokter,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getDokterItems($ruangan_id='')
    {
        if(!empty($ruangan_id)):
            return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id), array(
                'order'=>'nama_pegawai',
            ));//, 'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK
        else:
            return array();
        endif;
    }
}