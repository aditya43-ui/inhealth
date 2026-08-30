<?php

/**
 * This is the model class for table "informasipinjamanpegawai_v".
 *
 * The followings are the available columns in table 'informasipinjamanpegawai_v':
 * @property integer $profilrs_id
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property string $kelas_rumahsakit
 * @property string $namadirektur_rumahsakit
 * @property string $alamatlokasi_rumahsakit
 * @property string $nomor_suratizin
 * @property string $tgl_suratizin
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $no_kartupegawainegerisipil
 * @property string $no_karis_karsu
 * @property string $no_taspen
 * @property string $no_askes
 * @property string $jenisidentitas
 * @property string $noidentitas
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property string $alamatemail
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $warganegara_pegawai
 * @property string $jeniswaktukerja
 * @property string $kelompokjabatan
 * @property string $kategoripegawai
 * @property string $kategoripegawaiasal
 * @property string $photopegawai
 * @property string $nofingerprint
 * @property double $tinggibadan
 * @property double $beratbadan
 * @property string $kemampuanbahasa
 * @property string $warnakulit
 * @property string $nip_lama
 * @property string $no_rekening
 * @property string $bank_no_rekening
 * @property string $npwp
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $kelompokpegawai_id
 * @property string $kelompokpegawai_nama
 * @property string $suratizinpraktek
 * @property boolean $pegawai_aktif
 * @property string $unit_perusahaan
 * @property string $deskripsi
 * @property integer $pinjamanpeg_id
 * @property string $tglpinjampeg
 * @property string $nopinjam
 * @property string $untukkeperluan
 * @property string $keterangan
 * @property double $jumlahpinjaman
 * @property integer $lamapinjambln
 * @property double $persenpinjaman
 * @property double $sisapinjaman
 * @property string $tgljatuhtempo
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 */
class InformasipinjamanpegawaiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipinjamanpegawaiV the static model class
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
		return 'informasipinjamanpegawai_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, pegawai_id, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, golonganpegawai_id, pangkat_id, jabatan_id, kelompokpegawai_id, pinjamanpeg_id, lamapinjambln, tandabuktikeluar_id', 'numerical', 'integerOnly'=>true),
			array('tinggibadan, beratbadan, jumlahpinjaman, persenpinjaman, sisapinjaman', 'numerical'),
			array('nokode_rumahsakit, gelardepan', 'length', 'max'=>10),
			array('nama_rumahsakit, noidentitas, alamatemail, kemampuanbahasa, nip_lama, no_rekening, bank_no_rekening, jabatan_nama, suratizinpraktek', 'length', 'max'=>100),
			array('kelas_rumahsakit', 'length', 'max'=>1),
			array('namadirektur_rumahsakit, nama_pegawai, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, notelp_pegawai, nomobile_pegawai, kategoripegawaiasal, golonganpegawai_nama, pangkat_nama, nopinjam, nokaskeluar', 'length', 'max'=>50),
			array('nomor_suratizin, jenisidentitas, jeniskelamin, statusperkawinan, agama, rhesus, jeniswaktukerja, nofingerprint', 'length', 'max'=>20),
			array('nomorindukpegawai, no_kartupegawainegerisipil, no_karis_karsu, no_taspen, no_askes, tempatlahir_pegawai, kelompokjabatan, kelompokpegawai_nama', 'length', 'max'=>30),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('golongandarah', 'length', 'max'=>2),
			array('warganegara_pegawai, npwp', 'length', 'max'=>25),
			array('kategoripegawai', 'length', 'max'=>128),
			array('photopegawai', 'length', 'max'=>200),
			array('unit_perusahaan', 'length', 'max'=>70),
			array('alamatlokasi_rumahsakit, tgl_suratizin, tgl_lahirpegawai, alamat_pegawai, warnakulit, pegawai_aktif, deskripsi, tglpinjampeg, untukkeperluan, keterangan, tgljatuhtempo, tglkaskeluar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('profilrs_id, nokode_rumahsakit, nama_rumahsakit, kelas_rumahsakit, namadirektur_rumahsakit, alamatlokasi_rumahsakit, nomor_suratizin, tgl_suratizin, pegawai_id, nomorindukpegawai, no_kartupegawainegerisipil, no_karis_karsu, no_taspen, no_askes, jenisidentitas, noidentitas, gelardepan, nama_pegawai, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, statusperkawinan, alamat_pegawai, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, agama, golongandarah, rhesus, alamatemail, notelp_pegawai, nomobile_pegawai, warganegara_pegawai, jeniswaktukerja, kelompokjabatan, kategoripegawai, kategoripegawaiasal, photopegawai, nofingerprint, tinggibadan, beratbadan, kemampuanbahasa, warnakulit, nip_lama, no_rekening, bank_no_rekening, npwp, golonganpegawai_id, golonganpegawai_nama, pangkat_id, pangkat_nama, jabatan_id, jabatan_nama, kelompokpegawai_id, kelompokpegawai_nama, suratizinpraktek, pegawai_aktif, unit_perusahaan, deskripsi, pinjamanpeg_id, tglpinjampeg, nopinjam, untukkeperluan, keterangan, jumlahpinjaman, lamapinjambln, persenpinjaman, sisapinjaman, tgljatuhtempo, tandabuktikeluar_id, tglkaskeluar, nokaskeluar', 'safe', 'on'=>'search'),
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
			'profilrs_id' => 'Profilrs',
			'nokode_rumahsakit' => 'Nokode Rumahsakit',
			'nama_rumahsakit' => 'Nama Rumahsakit',
			'kelas_rumahsakit' => 'Kelas Rumahsakit',
			'namadirektur_rumahsakit' => 'Namadirektur Rumahsakit',
			'alamatlokasi_rumahsakit' => 'Alamatlokasi Rumahsakit',
			'nomor_suratizin' => 'Nomor Suratizin',
			'tgl_suratizin' => 'Tgl. Suratizin',
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'Nomor Induk Pegawai',
			'no_kartupegawainegerisipil' => 'No Kartupegawainegerisipil',
			'no_karis_karsu' => 'No Karis Karsu',
			'no_taspen' => 'No Taspen',
			'no_askes' => 'No. Askes',
			'jenisidentitas' => 'Jenisidentitas',
			'noidentitas' => 'Noidentitas',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'statusperkawinan' => 'Statusperkawinan',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'alamatemail' => 'Alamatemail',
			'notelp_pegawai' => 'Notelp Pegawai',
			'nomobile_pegawai' => 'Nomobile Pegawai',
			'warganegara_pegawai' => 'Warganegara Pegawai',
			'jeniswaktukerja' => 'Jeniswaktukerja',
			'kelompokjabatan' => 'Kelompokjabatan',
			'kategoripegawai' => 'Kategoripegawai',
			'kategoripegawaiasal' => 'Kategoripegawaiasal',
			'photopegawai' => 'Photopegawai',
			'nofingerprint' => 'Nofingerprint',
			'tinggibadan' => 'Tinggibadan',
			'beratbadan' => 'Beratbadan',
			'kemampuanbahasa' => 'Kemampuanbahasa',
			'warnakulit' => 'Warnakulit',
			'nip_lama' => 'Nip Lama',
			'no_rekening' => 'No. Rekening',
			'bank_no_rekening' => 'Bank No Rekening',
			'npwp' => 'Npwp',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'kelompokpegawai_id' => 'Kelompokpegawai',
			'kelompokpegawai_nama' => 'Kelompokpegawai Nama',
			'suratizinpraktek' => 'Suratizinpraktek',
			'pegawai_aktif' => 'Pegawai Aktif',
			'unit_perusahaan' => 'Unit Perusahaan',
			'deskripsi' => 'Deskripsi',
			'pinjamanpeg_id' => 'Pinjamanpeg',
			'tglpinjampeg' => 'Tanggal Pinjam Pegawai',
			'nopinjam' => 'Nomor Pinjaman',
			'untukkeperluan' => 'Untukkeperluan',
			'keterangan' => 'Keterangan',
			'jumlahpinjaman' => 'Jumlahpinjaman',
			'lamapinjambln' => 'Lamapinjambln',
			'persenpinjaman' => 'Persenpinjaman',
			'sisapinjaman' => 'Sisapinjaman',
			'tgljatuhtempo' => 'Tanggal Jatuh Tempo',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
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

		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(nokode_rumahsakit)',strtolower($this->nokode_rumahsakit),true);
		$criteria->compare('LOWER(nama_rumahsakit)',strtolower($this->nama_rumahsakit),true);
		$criteria->compare('LOWER(kelas_rumahsakit)',strtolower($this->kelas_rumahsakit),true);
		$criteria->compare('LOWER(namadirektur_rumahsakit)',strtolower($this->namadirektur_rumahsakit),true);
		$criteria->compare('LOWER(alamatlokasi_rumahsakit)',strtolower($this->alamatlokasi_rumahsakit),true);
		$criteria->compare('LOWER(nomor_suratizin)',strtolower($this->nomor_suratizin),true);
		$criteria->compare('LOWER(tgl_suratizin)',strtolower($this->tgl_suratizin),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(nip_lama)',strtolower($this->nip_lama),true);
		$criteria->compare('LOWER(no_rekening)',strtolower($this->no_rekening),true);
		$criteria->compare('LOWER(bank_no_rekening)',strtolower($this->bank_no_rekening),true);
		$criteria->compare('LOWER(npwp)',strtolower($this->npwp),true);
		if(!empty($this->golonganpegawai_id)){
			$criteria->addCondition('golonganpegawai_id = '.$this->golonganpegawai_id);
		}
		$criteria->compare('LOWER(golonganpegawai_nama)',strtolower($this->golonganpegawai_nama),true);
		if(!empty($this->pangkat_id)){
			$criteria->addCondition('pangkat_id = '.$this->pangkat_id);
		}
		$criteria->compare('LOWER(pangkat_nama)',strtolower($this->pangkat_nama),true);
		if(!empty($this->jabatan_id)){
			$criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		}
		$criteria->compare('LOWER(jabatan_nama)',strtolower($this->jabatan_nama),true);
		if(!empty($this->kelompokpegawai_id)){
			$criteria->addCondition('kelompokpegawai_id = '.$this->kelompokpegawai_id);
		}
		$criteria->compare('LOWER(kelompokpegawai_nama)',strtolower($this->kelompokpegawai_nama),true);
		$criteria->compare('LOWER(suratizinpraktek)',strtolower($this->suratizinpraktek),true);
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('LOWER(unit_perusahaan)',strtolower($this->unit_perusahaan),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		if(!empty($this->pinjamanpeg_id)){
			$criteria->addCondition('pinjamanpeg_id = '.$this->pinjamanpeg_id);
		}
		$criteria->compare('LOWER(tglpinjampeg)',strtolower($this->tglpinjampeg),true);
		$criteria->compare('LOWER(nopinjam)',strtolower($this->nopinjam),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('jumlahpinjaman',$this->jumlahpinjaman);
		if(!empty($this->lamapinjambln)){
			$criteria->addCondition('lamapinjambln = '.$this->lamapinjambln);
		}
		$criteria->compare('persenpinjaman',$this->persenpinjaman);
		$criteria->compare('sisapinjaman',$this->sisapinjaman);
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition('tandabuktikeluar_id = '.$this->tandabuktikeluar_id);
		}
		$criteria->compare('LOWER(tglkaskeluar)',strtolower($this->tglkaskeluar),true);
		$criteria->compare('LOWER(nokaskeluar)',strtolower($this->nokaskeluar),true);

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