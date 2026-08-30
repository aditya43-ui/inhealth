<?php

/**
 * This is the model class for table "informasireseptur_v".
 *
 * The followings are the available columns in table 'informasireseptur_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $reseptur_id
 * @property string $tglreseptur
 * @property string $noreseptur
 * @property integer $instalasireseptur_id
 * @property string $instalasireseptur_nama
 * @property integer $ruanganreseptur_id
 * @property string $ruanganreseptur_nama
 * @property string $fileresep
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $pasien_jenisidentitas
 * @property string $pasien_noidentitas
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $anakke
 * @property integer $jumlah_bersaudara
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $alamatemail
 * @property string $nama_ibu
 * @property string $nama_ayah
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $pasienadmisi_id
 * @property string $tgladmisi
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $pegawai_jenisidentitas
 * @property string $pegawai_noidentitas
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $penjualanresep_id
 * @property string $tglresep
 * @property string $noresep
 * @property string $tglpenjualan
 * @property integer $unitdosis_id
 * @property integer $instalasiunitdosis_id
 * @property string $instalasiunitdosis_nama
 * @property integer $ruanganunitdosis_id
 * @property string $ruanganunitdosis_nama
 * @property string $tgluntidosis
 * @property string $nounitdosis
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $alergiobat
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property string $umur
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 */
class InformasiresepturV extends CActiveRecord
{
        public $statusperiksa;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiresepturV the static model class
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
		return 'informasireseptur_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, reseptur_id, instalasireseptur_id, ruanganreseptur_id, pasien_id, rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, anakke, jumlah_bersaudara, pendaftaran_id, pasienadmisi_id, pegawai_id, penjualanresep_id, unitdosis_id, instalasiunitdosis_id, ruanganunitdosis_id, carabayar_id, penjamin_id, jeniskasuspenyakit_id', 'numerical', 'integerOnly'=>true),
			array('beratbadan_kg, tinggibadan_cm', 'numerical'),
			array('instalasi_nama, ruangan_nama, noreseptur, instalasireseptur_nama, ruanganreseptur_nama, nama_pasien, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, nama_ibu, nama_ayah, nama_pegawai, noresep, instalasiunitdosis_nama, ruanganunitdosis_nama, carabayar_nama, penjamin_nama', 'length', 'max'=>50),
			array('fileresep', 'length', 'max'=>200),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('pasien_jenisidentitas, namadepan, jeniskelamin, statusperkawinan, agama, rhesus, no_mobile_pasien, no_pendaftaran, pegawai_jenisidentitas, nounitdosis', 'length', 'max'=>20),
			array('pasien_noidentitas, nama_bin, nomorindukpegawai, umur', 'length', 'max'=>30),
			array('tempat_lahir, warga_negara', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('no_telepon_pasien, gelarbelakang_nama', 'length', 'max'=>15),
			array('alamatemail, pegawai_noidentitas, jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('isbatal, tglreseptur, tanggal_lahir, alamat_pasien, tgl_pendaftaran, tgladmisi, tglresep, tglpenjualan, tgluntidosis, alergiobat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, ispasienbaru, isterapipulang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, reseptur_id, tglreseptur, noreseptur, instalasireseptur_id, instalasireseptur_nama, ruanganreseptur_id, ruanganreseptur_nama, fileresep, pasien_id, no_rekam_medik, pasien_jenisidentitas, pasien_noidentitas, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, statusperkawinan, agama, golongandarah, rhesus, anakke, jumlah_bersaudara, no_telepon_pasien, no_mobile_pasien, warga_negara, alamatemail, nama_ibu, nama_ayah, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, pasienadmisi_id, tgladmisi, pegawai_id, nomorindukpegawai, pegawai_jenisidentitas, pegawai_noidentitas, gelardepan, nama_pegawai, gelarbelakang_nama, penjualanresep_id, tglresep, noresep, tglpenjualan, unitdosis_id, instalasiunitdosis_id, instalasiunitdosis_nama, ruanganunitdosis_id, ruanganunitdosis_nama, tgluntidosis, nounitdosis, beratbadan_kg, tinggibadan_cm, alergiobat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, umur, ispasienbaru, isterapipulang', 'safe', 'on'=>'search'),
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Nama Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'reseptur_id' => 'Reseptur',
			'tglreseptur' => 'Tanggal Resep',
			'noreseptur' => 'No. Resep',
			'instalasireseptur_nama' => 'Instalasireseptur Nama',
			'ruanganreseptur_id' => 'Ruangan',
			'ruanganreseptur_nama' => 'Ruanganreseptur Nama',
			'fileresep' => 'Fileresep',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'pasien_jenisidentitas' => 'Pasien Jenisidentitas',
			'pasien_noidentitas' => 'Pasien Noidentitas',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Panggilan',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'statusperkawinan' => 'Statusperkawinan',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'anakke' => 'Anakke',
			'jumlah_bersaudara' => 'Jumlah Bersaudara',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'warga_negara' => 'Warga Negara',
			'alamatemail' => 'Alamatemail',
			'nama_ibu' => 'Nama Ibu',
			'nama_ayah' => 'Nama Ayah',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tgladmisi' => 'Tgladmisi',
			'pegawai_id' => 'Dokter',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'pegawai_jenisidentitas' => 'Pegawai Jenisidentitas',
			'pegawai_noidentitas' => 'Pegawai Noidentitas',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'penjualanresep_id' => 'Penjualanresep',
			'tglresep' => 'Tglresep',
			'noresep' => 'No Resep',
			'tglpenjualan' => 'Tglpenjualan',
			'unitdosis_id' => 'Unitdosis',
			'instalasiunitdosis_id' => 'Instalasiunitdosis',
			'instalasiunitdosis_nama' => 'Instalasiunitdosis Nama',
			'ruanganunitdosis_id' => 'Ruanganunitdosis',
			'ruanganunitdosis_nama' => 'Ruanganunitdosis Nama',
			'tgluntidosis' => 'Tgluntidosis',
			'nounitdosis' => 'Nounitdosis',
			'beratbadan_kg' => 'Beratbadan Kg',
			'tinggibadan_cm' => 'Tinggibadan Cm',
			'alergiobat' => 'Alergiobat',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jenis Kasus Penyakit',
			'umur' => 'Umur',
			'statusperiksa' => 'Status Periksa',
			'instalasireseptur_id' => 'Instalasi'
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

		$criteria->compare('t.instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(t.instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('t.reseptur_id',$this->reseptur_id);
		$criteria->compare('LOWER(t.tglreseptur)',strtolower($this->tglreseptur),true);
		$criteria->compare('LOWER(t.noreseptur)',strtolower($this->noreseptur),true);
		$criteria->compare('t.instalasireseptur_id',$this->instalasireseptur_id);
		$criteria->compare('LOWER(t.instalasireseptur_nama)',strtolower($this->instalasireseptur_nama),true);
		$criteria->compare('t.ruanganreseptur_id',$this->ruanganreseptur_id);
		$criteria->compare('LOWER(t.ruanganreseptur_nama)',strtolower($this->ruanganreseptur_nama),true);
		$criteria->compare('LOWER(t.fileresep)',strtolower($this->fileresep),true);
		$criteria->compare('t.pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(t.pasien_jenisidentitas)',strtolower($this->pasien_jenisidentitas),true);
		$criteria->compare('LOWER(t.pasien_noidentitas)',strtolower($this->pasien_noidentitas),true);
		$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('t.rt',$this->rt);
		$criteria->compare('t.rw',$this->rw);
		$criteria->compare('t.kelurahan_id',$this->kelurahan_id);
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('t.kecamatan_id',$this->kecamatan_id);
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('t.kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('t.propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(t.statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(t.golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(t.rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('t.anakke',$this->anakke);
		$criteria->compare('t.jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('LOWER(t.no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(t.no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(t.warga_negara)',strtolower($this->warga_negara),true);
		$criteria->compare('LOWER(t.alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(t.nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('LOWER(t.nama_ayah)',strtolower($this->nama_ayah),true);
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(t.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('t.pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(t.tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(t.pegawai_jenisidentitas)',strtolower($this->pegawai_jenisidentitas),true);
		$criteria->compare('LOWER(t.pegawai_noidentitas)',strtolower($this->pegawai_noidentitas),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('t.penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('LOWER(t.tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
		$criteria->compare('LOWER(t.tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('t.unitdosis_id',$this->unitdosis_id);
		$criteria->compare('t.instalasiunitdosis_id',$this->instalasiunitdosis_id);
		$criteria->compare('LOWER(t.instalasiunitdosis_nama)',strtolower($this->instalasiunitdosis_nama),true);
		$criteria->compare('t.ruanganunitdosis_id',$this->ruanganunitdosis_id);
		$criteria->compare('LOWER(t.ruanganunitdosis_nama)',strtolower($this->ruanganunitdosis_nama),true);
		$criteria->compare('LOWER(t.tgluntidosis)',strtolower($this->tgluntidosis),true);
		$criteria->compare('LOWER(t.nounitdosis)',strtolower($this->nounitdosis),true);
		$criteria->compare('t.beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('t.tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('LOWER(t.alergiobat)',strtolower($this->alergiobat),true);
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('t.carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('t.jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('LOWER(t.umur)',strtolower($this->umur),true);

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
		
		public function getStatus($status){
            $status = trim($status);
            if($status == "ANTRIAN"){
                $status = '<a  class="btn btn-primary nohover" name="yt1">'.$status.'</a>';

            }else if($status == "SEDANG PERIKSA"){
                $status = '<a  class="btn btn-danger nohover" name="yt1">'.$status.'</a>';
            }else if($status == "SUDAH PULANG"){
                $status = '<a  class="btn btn-danger-yellow nohover" name="yt1">'.$status.'</a>';
            }else if($status == "SUDAH DI PERIKSA"){
                $status = '<a class="btn btn-danger-red nohover" name="yt1" >'.$status.'</a>';
            }else{
                $status = '<a  class="btn btn-danger-blue nohover"  name="yt1">'.$status.'</a>';
            }
            return $status;
        }
}