<?php

/**
 * This is the model class for table "laporanpenggajian_v".
 *
 * The followings are the available columns in table 'laporanpenggajian_v':
 * @property integer $penggajianpeg_id
 * @property string $periodegaji
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $nama_keluarga
 * @property string $tglpenggajian
 * @property string $nopenggajian
 * @property string $statusperkawinan
 * @property string $jeniskelamin
 * @property string $keterangan
 * @property string $mengetahui
 * @property string $menyetujui
 * @property integer $pengeluaranumum_id
 * @property string $nomorindukpegawai
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $photopegawai
 * @property string $alamatemail
 * @property string $tgl_lahirpegawai
 * @property string $tempatlahir_pegawai
 * @property string $noidentitas
 * @property string $jenisidentitas
 * @property double $gajibersih
 * @property string $statusbayar
 */
class LaporanpenggajianV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpenggajianV the static model class
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
		return 'laporanpenggajian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penggajianpeg_id, pegawai_id, pengeluaranumum_id', 'numerical', 'integerOnly'=>true),
			array('gajibersih', 'numerical'),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, nama_keluarga, nopenggajian, notelp_pegawai, nomobile_pegawai', 'length', 'max'=>50),
			array('statusperkawinan, jeniskelamin, jenisidentitas', 'length', 'max'=>20),
			array('mengetahui, menyetujui, alamatemail, noidentitas', 'length', 'max'=>100),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('photopegawai', 'length', 'max'=>200),
			array('periodegaji, tglpenggajian, keterangan, tgl_lahirpegawai, statusbayar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penggajianpeg_id, periodegaji, pegawai_id, gelardepan, nama_pegawai, nama_keluarga, tglpenggajian, nopenggajian, statusperkawinan, jeniskelamin, keterangan, mengetahui, menyetujui, pengeluaranumum_id, nomorindukpegawai, notelp_pegawai, nomobile_pegawai, photopegawai, alamatemail, tgl_lahirpegawai, tempatlahir_pegawai, noidentitas, jenisidentitas, gajibersih, statusbayar,tglAwal,tglAkhir', 'safe', 'on'=>'search'),
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
                       'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penggajianpeg_id' => 'ID Penggajian ',
			'periodegaji' => 'Periode Gaji',
			'pegawai_id' => 'Karyawan',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Nama Karyawan',
			'nama_keluarga' => 'Nama Keluarga',
			'tglpenggajian' => 'Tgl. Penggajian',
			'nopenggajian' => 'No. Penggajian',
			'statusperkawinan' => 'Status Perkawinan',
			'jeniskelamin' => 'Jenis Kelamin',
			'keterangan' => 'Keterangan',
			'mengetahui' => 'Mengetahui',
			'menyetujui' => 'Menyetujui',
			'pengeluaranumum_id' => 'Pengeluaran Umum',
			'nomorindukpegawai' => 'NRK',
			'notelp_pegawai' => 'No. Telp Pegawai',
			'nomobile_pegawai' => 'No. Mobile Pegawai',
			'photopegawai' => 'Photo Pegawai',
			'alamatemail' => 'Alamat Email',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'tempatlahir_pegawai' => 'Tempat Lahir Pegawai',
			'noidentitas' => 'No. Identitas',
			'jenisidentitas' => 'Jenis Identitas',
			'gajibersih' => 'Gaji Bersih',
			'statusbayar' => 'Status Bayar',
                      'tglAwal'=>'Periode Penggajian',
                        'tglAkhir'=>'Sampai Dengan',
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
                                      $criteria->addBetweenCondition('periodegaji',$this->tglAwal, $this->tglAkhir); 
		$criteria->compare('penggajianpeg_id',$this->penggajianpeg_id);
		//$criteria->compare('LOWER(periodegaji)',strtolower($this->periodegaji),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('tglpenggajian',$this->tglpenggajian);
		$criteria->compare('LOWER(nopenggajian)',strtolower($this->nopenggajian),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(mengetahui)',strtolower($this->mengetahui),true);
		$criteria->compare('LOWER(menyetujui)',strtolower($this->menyetujui),true);
		$criteria->compare('pengeluaranumum_id',$this->pengeluaranumum_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('gajibersih',$this->gajibersih);
		$criteria->compare('LOWER(statusbayar)',strtolower($this->statusbayar),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                                  $criteria->addBetweenCondition('periodegaji',$this->tglAwal, $this->tglAkhir); 
		$criteria->compare('penggajianpeg_id',$this->penggajianpeg_id);
		//$criteria->compare('LOWER(periodegaji)',strtolower($this->periodegaji),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('tglpenggajian',$this->tglpenggajian);
		$criteria->compare('LOWER(nopenggajian)',strtolower($this->nopenggajian),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(mengetahui)',strtolower($this->mengetahui),true);
		$criteria->compare('LOWER(menyetujui)',strtolower($this->menyetujui),true);
		$criteria->compare('pengeluaranumum_id',$this->pengeluaranumum_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('gajibersih',$this->gajibersih);
		$criteria->compare('LOWER(statusbayar)',strtolower($this->statusbayar),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}