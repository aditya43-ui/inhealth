<?php

/**
 * This is the model class for table "rekapitulasipasienpulang_v".
 *
 * The followings are the available columns in table 'rekapitulasipasienpulang_v':
 * @property integer $pasien_id
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $no_rekam_medik
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property string $umur
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $pasienadmisi_id
 * @property string $tgladmisi
 * @property string $tglpulang
 * @property string $ruanganakhir_id
 * @property string $ruangan_nama
 * @property double $tarif_tindakan
 * @property double $subsidiasuransi_tindakan
 * @property double $iurbiaya_tindakan
 * @property integer $pembayaranpelayanan_id
 */
class RekapitulasipasienpulangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekapitulasipasienpulangV the static model class
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
		return 'rekapitulasipasienpulang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, carabayar_id, penjamin_id, instalasi_id, pasienadmisi_id, pembayaranpelayanan_id', 'numerical', 'integerOnly'=>true),
			array('tarif_tindakan, subsidiasuransi_tindakan, iurbiaya_tindakan', 'numerical'),
			array('namadepan, jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, carabayar_nama, penjamin_nama, instalasi_nama, ruangan_nama', 'length', 'max'=>50),
			array('nama_bin, umur', 'length', 'max'=>30),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('tgl_pendaftaran, tgladmisi, tglpulang, ruanganakhir_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, namadepan, nama_pasien, nama_bin, jeniskelamin, no_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, umur, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, instalasi_id, instalasi_nama, pasienadmisi_id, tgladmisi, tglpulang, ruanganakhir_id, ruangan_nama, tarif_tindakan, subsidiasuransi_tindakan, iurbiaya_tindakan, pembayaranpelayanan_id', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'no_rekam_medik' => 'No. Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'no_urutantri' => 'No. Urutantri',
			'umur' => 'Umur',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tgladmisi' => 'Tgladmisi',
			'tglpulang' => 'Tglpulang',
			'ruanganakhir_id' => 'Ruanganakhir',
			'ruangan_nama' => 'Ruangan Nama',
			'tarif_tindakan' => 'Nominal Tarif',
			'subsidiasuransi_tindakan' => 'Subsidiasuransi Tindakan',
			'iurbiaya_tindakan' => 'Iurbiaya Tindakan',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(ruanganakhir_id)',strtolower($this->ruanganakhir_id),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('subsidiasuransi_tindakan',$this->subsidiasuransi_tindakan);
		$criteria->compare('iurbiaya_tindakan',$this->iurbiaya_tindakan);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(ruanganakhir_id)',strtolower($this->ruanganakhir_id),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('subsidiasuransi_tindakan',$this->subsidiasuransi_tindakan);
		$criteria->compare('iurbiaya_tindakan',$this->iurbiaya_tindakan);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}