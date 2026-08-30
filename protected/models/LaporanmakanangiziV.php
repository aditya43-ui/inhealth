<?php

/**
 * This is the model class for table "laporanmakanangizi_v".
 *
 * The followings are the available columns in table 'laporanmakanangizi_v':
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $kirimmenudiet_id
 * @property string $tglkirimmenu
 * @property string $jenispesanmenu
 * @property string $keterangan_kirim
 * @property integer $jenisdiet_id
 * @property string $jenisdiet_nama
 * @property integer $menudiet_id
 * @property double $jml_kirim
 * @property string $satuanjml_urt
 * @property integer $jeniswaktu_id
 * @property string $jeniswaktu_nama
 * @property string $menudiet_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $ruangan_lokasi
 * @property string $jeniswaktu_jam
 * @property double $hargasatuan
 */
class LaporanmakanangiziV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanmakanangiziV the static model class
	 */
        public $tgl_awal,$tgl_akhir,$bulan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanmakanangizi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, kirimmenudiet_id, jenisdiet_id, menudiet_id, jeniswaktu_id, ruangan_id, kelaspelayanan_id', 'numerical', 'integerOnly'=>true),
			array('jml_kirim, hargasatuan', 'numerical'),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, no_pendaftaran, jeniswaktu_jam', 'length', 'max'=>20),
			array('nama_pasien, jenispesanmenu, jenisdiet_nama, satuanjml_urt, jeniswaktu_nama, ruangan_nama, kelaspelayanan_nama, ruangan_lokasi', 'length', 'max'=>50),
			array('nama_bin', 'length', 'max'=>30),
			array('menudiet_nama', 'length', 'max'=>200),
			array('alamat_pasien, tgl_pendaftaran, tglkirimmenu, keterangan_kirim', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, alamat_pasien, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, kirimmenudiet_id, tglkirimmenu, jenispesanmenu, keterangan_kirim, jenisdiet_id, jenisdiet_nama, menudiet_id, jml_kirim, satuanjml_urt, jeniswaktu_id, jeniswaktu_nama, menudiet_nama, ruangan_id, ruangan_nama, kelaspelayanan_id, kelaspelayanan_nama, ruangan_lokasi, jeniswaktu_jam, hargasatuan,tgl_awal,tgl_akhir,bulan', 'safe', 'on'=>'search'),
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
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'kirimmenudiet_id' => 'Kirimmenudiet',
			'tglkirimmenu' => 'Tglkirimmenu',
			'jenispesanmenu' => 'Jenispesanmenu',
			'keterangan_kirim' => 'Keterangan Kirim',
			'jenisdiet_id' => 'Jenisdiet',
			'jenisdiet_nama' => 'Jenisdiet Nama',
			'menudiet_id' => 'Menudiet',
			'jml_kirim' => 'Jml Kirim',
			'satuanjml_urt' => 'Satuanjml Urt',
			'jeniswaktu_id' => 'Jeniswaktu',
			'jeniswaktu_nama' => 'Jeniswaktu Nama',
			'menudiet_nama' => 'Menudiet Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'ruangan_lokasi' => 'Ruangan Lokasi',
			'jeniswaktu_jam' => 'Jeniswaktu Jam',
			'hargasatuan' => 'Hargasatuan',
                        'tgl_awal'=>'Sampai Dengan',
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
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('LOWER(tglkirimmenu)',strtolower($this->tglkirimmenu),true);
		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
		$criteria->compare('LOWER(keterangan_kirim)',strtolower($this->keterangan_kirim),true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('jml_kirim',$this->jml_kirim);
		$criteria->compare('LOWER(satuanjml_urt)',strtolower($this->satuanjml_urt),true);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('LOWER(jeniswaktu_nama)',strtolower($this->jeniswaktu_nama),true);
		$criteria->compare('LOWER(menudiet_nama)',strtolower($this->menudiet_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('LOWER(jeniswaktu_jam)',strtolower($this->jeniswaktu_jam),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);

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
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('LOWER(tglkirimmenu)',strtolower($this->tglkirimmenu),true);
		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
		$criteria->compare('LOWER(keterangan_kirim)',strtolower($this->keterangan_kirim),true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('jml_kirim',$this->jml_kirim);
		$criteria->compare('LOWER(satuanjml_urt)',strtolower($this->satuanjml_urt),true);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('LOWER(jeniswaktu_nama)',strtolower($this->jeniswaktu_nama),true);
		$criteria->compare('LOWER(menudiet_nama)',strtolower($this->menudiet_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('LOWER(jeniswaktu_jam)',strtolower($this->jeniswaktu_jam),true);
		$criteria->compare('hargasatuan',$this->hargasatuan);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}