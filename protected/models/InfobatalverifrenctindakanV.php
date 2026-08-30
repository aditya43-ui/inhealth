<?php

/**
 * This is the model class for table "infobatalverifrenctindakan_v".
 *
 * The followings are the available columns in table 'infobatalverifrenctindakan_v':
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property double $umur
 * @property string $alamat_pasien
 * @property integer $dpjp_id
 * @property string $dpjp_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $verifrenctindakan_id
 * @property string $noverifikasi_renc
 * @property string $tglverifikasirenc
 * @property integer $petugasverif_id
 * @property string $petugasverif_nama
 * @property string $tglbataltindakanpelayanan
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property integer $pegawaibatal_id
 * @property string $pegawaibatal_nama
 */
class InfobatalverifrenctindakanV extends CActiveRecord
{

	public $tgl_awal, $tgl_akhir;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'infobatalverifrenctindakan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, dpjp_id, instalasi_id, ruangan_id, carabayar_id, penjamin_id, verifrenctindakan_id, petugasverif_id, tindakanpelayanan_id, daftartindakan_id, pegawaibatal_id', 'numerical', 'integerOnly'=>true),
			array('umur', 'numerical'),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, ruangan_nama, penjamin_nama', 'length', 'max'=>100),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('dpjp_nama, carabayar_nama, noverifikasi_renc, petugasverif_nama, pegawaibatal_nama', 'length', 'max'=>50),
			array('daftartindakan_nama', 'length', 'max'=>400),
			array('tgl_pendaftaran, alamat_pasien, tglverifikasirenc, tglbataltindakanpelayanan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tgl_pendaftaran, no_pendaftaran, pendaftaran_id, pasien_id, nama_pasien, no_rekam_medik, umur, alamat_pasien, dpjp_id, dpjp_nama, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, verifrenctindakan_id, noverifikasi_renc, tglverifikasirenc, petugasverif_id, petugasverif_nama, tglbataltindakanpelayanan, tindakanpelayanan_id, daftartindakan_id, daftartindakan_nama, pegawaibatal_id, pegawaibatal_nama', 'safe', 'on'=>'search'),
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
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'umur' => 'Umur',
			'alamat_pasien' => 'Alamat Pasien',
			'dpjp_id' => 'Dpjp',
			'dpjp_nama' => 'Dpjp Nama',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'verifrenctindakan_id' => 'Verifrenctindakan',
			'noverifikasi_renc' => 'Noverifikasi Renc',
			'tglverifikasirenc' => 'Tglverifikasirenc',
			'petugasverif_id' => 'Petugasverif',
			'petugasverif_nama' => 'Petugasverif Nama',
			'tglbataltindakanpelayanan' => 'Tglbataltindakanpelayanan',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'pegawaibatal_id' => 'Pegawaibatal',
			'pegawaibatal_nama' => 'Petugas',
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

		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('dpjp_nama',$this->dpjp_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('verifrenctindakan_id',$this->verifrenctindakan_id);
		$criteria->compare('noverifikasi_renc',$this->noverifikasi_renc,true);
		$criteria->compare('tglverifikasirenc',$this->tglverifikasirenc,true);
		$criteria->compare('petugasverif_id',$this->petugasverif_id);
		$criteria->compare('petugasverif_nama',$this->petugasverif_nama,true);
		$criteria->compare('tglbataltindakanpelayanan',$this->tglbataltindakanpelayanan,true);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('pegawaibatal_id',$this->pegawaibatal_id);
		$criteria->compare('pegawaibatal_nama',$this->pegawaibatal_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchInformasi() {
		$cr = new CDbCriteria;

		$cr->select = 'pendaftaran_id, no_pendaftaran, nama_pasien, no_rekam_medik, umur, alamat_pasien, dpjp_nama,
						ruangan_nama, carabayar_nama, penjamin_nama, pegawaibatal_nama';
		
		$cr->group = $cr->select;
		
		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$cr->addBetweenCondition('tgl_pendaftaran::date', $this->tgl_awal, $this->tgl_akhir);
		}


		$cr->compare('lower(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$cr->compare('lower(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$cr->compare('lower(nama_pasien)', strtolower($this->nama_pasien), true);
		$cr->compare('lower(pegawaibatal_nama)', strtolower($this->pegawaibatal_nama), true);

		$cr->compare('carabayar_id', $this->carabayar_id);
		$cr->compare('penjamin_id', $this->penjamin_id);
		$cr->compare('instalasi_id', $this->instalasi_id);
		$cr->compare('ruangan_id', $this->ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$cr,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InfobatalverifrenctindakanV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
