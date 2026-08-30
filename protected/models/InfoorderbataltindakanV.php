<?php

/**
 * This is the model class for table "infoorderbataltindakan_v".
 *
 * The followings are the available columns in table 'infoorderbataltindakan_v':
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property string $umur
 * @property string $alamat_pasien
 * @property integer $dokter_id
 * @property string $dokter_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $nopelayanan
 * @property string $noverifikasi_batal
 * @property string $tglverifikasibatal
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property integer $petugasbatal_id
 * @property string $petugasbatal_nama
 */
class InfoorderbataltindakanV extends CActiveRecord
{
	public $tgl_awal, $tgl_akhir, $nama_pemakai, $tglverifikasi, $noverifikasi, $verifikasitagihan_id, $keterangan;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'infoorderbataltindakan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, dokter_id, ruangan_id, carabayar_id, penjamin_id, tindakanpelayanan_id, daftartindakan_id, petugasbatal_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, ruangan_nama, penjamin_nama', 'length', 'max'=>100),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('umur', 'length', 'max'=>30),
			array('dokter_nama, carabayar_nama, noverifikasi_batal, petugasbatal_nama', 'length', 'max'=>50),
			array('daftartindakan_nama', 'length', 'max'=>400),
			array('tgl_pendaftaran, alamat_pasien, nopelayanan, tglverifikasibatal', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pendaftaran_id, tgl_pendaftaran, no_pendaftaran, pasien_id, nama_pasien, no_rekam_medik, umur, alamat_pasien, dokter_id, dokter_nama, ruangan_id, ruangan_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, nopelayanan, noverifikasi_batal, tglverifikasibatal, tindakanpelayanan_id, daftartindakan_id, daftartindakan_nama, petugasbatal_id, petugasbatal_nama', 'safe', 'on'=>'search'),
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
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'umur' => 'Umur',
			'alamat_pasien' => 'Alamat Pasien',
			'dokter_id' => 'Dokter',
			'dokter_nama' => 'Dokter Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'nopelayanan' => 'Nopelayanan',
			'noverifikasi_batal' => 'Noverifikasi Batal',
			'tglverifikasibatal' => 'Tgl Verifikasi Batal',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'petugasbatal_id' => 'Petugasbatal',
			'petugasbatal_nama' => 'Verifikator',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien),true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('dokter_id',$this->dokter_id);
		$criteria->compare('dokter_nama',$this->dokter_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('nopelayanan',$this->nopelayanan,true);
		$criteria->compare('noverifikasi_batal',$this->noverifikasi_batal,true);
		$criteria->compare('tglverifikasibatal',$this->tglverifikasibatal,true);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('petugasbatal_id',$this->petugasbatal_id);
		$criteria->compare('LOWER(petugasbatal_nama)',strtolower($this->petugasbatal_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchInformasi()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = 'tglverifikasibatal, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, pasien_id, nama_pasien,
							 carabayar_nama, penjamin_nama, petugasbatal_id, petugasbatal_nama, isverif, petugas_verif_id';
		
		$criteria->group = $criteria->select;

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien),true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('dokter_id',$this->dokter_id);
		$criteria->compare('dokter_nama',$this->dokter_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('nopelayanan',$this->nopelayanan,true);
		$criteria->compare('noverifikasi_batal',$this->noverifikasi_batal,true);

		if(!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$criteria->addBetweenCondition('tglverifikasibatal',$this->tgl_awal, $this->tgl_akhir);
		}

		// $criteria->addCondition('isverifbataltindakan = true');
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('petugasbatal_id',$this->petugasbatal_id);
		$criteria->compare('LOWER(petugasbatal_nama)',strtolower($this->petugasbatal_nama),true);
		$criteria->order = 'tglverifikasibatal desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InfoorderbataltindakanV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
