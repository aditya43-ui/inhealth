<?php

/**
 * This is the model class for table "laporanpph21_v".
 *
 * The followings are the available columns in table 'laporanpph21_v':
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
 * @property string $nama_keluarga
 * @property string $gelarbelakang_nama
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property string $kode_pos
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property string $alamatemail
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $warganegara_pegawai
 * @property string $jeniswaktukerja
 * @property integer $suku_id
 * @property string $suku_nama
 * @property integer $statuskepemilikanrumah_id
 * @property string $statuskepemilikanrumah_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $profilrs_id
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $kelompokjabatan
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $esselon_id
 * @property string $esselon_nama
 * @property integer $kelompokpegawai_id
 * @property string $kelompokpegawai_nama
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
 * @property string $tglditerima
 * @property string $tglberhenti
 * @property integer $penggajianpeg_id
 * @property string $tglpenggajian
 * @property string $nopenggajian
 * @property string $keterangan
 * @property string $mengetahui
 * @property string $menyetujui
 * @property double $totalterima
 * @property double $totalpajak
 * @property double $totalpotongan
 * @property double $penerimaanbersih
 * @property string $periodegaji
 * @property double $gajipertahun
 * @property double $biayajabatan
 * @property double $potonganpensiun
 * @property double $gajikotor
 * @property string $kodeptkp
 * @property double $ptkppertahun
 * @property double $ptkpperbulan
 * @property double $pkp
 * @property double $persentasepph21
 * @property double $pph21pertahun
 * @property double $pph21perbulan
 */
class Laporanpph21V extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Laporanpph21V the static model class
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
		return 'laporanpph21_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, kelurahan_id, kecamatan_id, kabupaten_id, suku_id, statuskepemilikanrumah_id, propinsi_id, profilrs_id, instalasi_id, ruangan_id, golonganpegawai_id, pangkat_id, jabatan_id, esselon_id, kelompokpegawai_id, penggajianpeg_id, jmltanggunan', 'numerical', 'integerOnly'=>true),
			array('tinggibadan, beratbadan, totalterima, totalpajak, totalpotongan, penerimaanbersih, gajipertahun, biayajabatan, potonganpensiun, gajikotor, ptkppertahun, ptkpperbulan, pkp, persentasepph21, pph21pertahun, pph21perbulan', 'numerical'),
			array('nomorindukpegawai, no_kartupegawainegerisipil, no_karis_karsu, no_taspen, no_askes, tempatlahir_pegawai, kelompokjabatan, kelompokpegawai_nama', 'length', 'max'=>30),
			array('jenisidentitas, jeniskelamin, statusperkawinan, agama, rhesus, jeniswaktukerja, nofingerprint', 'length', 'max'=>20),
			array('noidentitas, alamatemail, nama_rumahsakit, jabatan_nama, kemampuanbahasa, nip_lama, no_rekening, bank_no_rekening, mengetahui, menyetujui', 'length', 'max'=>100),
			array('gelardepan, statuskepemilikanrumah_nama, nokode_rumahsakit, kodeptkp_pegawai', 'length', 'max'=>10),
			array('nama_pegawai, nama_keluarga, kelurahan_nama, kecamatan_nama, kabupaten_nama, notelp_pegawai, nomobile_pegawai, suku_nama, propinsi_nama, instalasi_nama, ruangan_nama, golonganpegawai_nama, pangkat_nama, kategoripegawaiasal, nopenggajian', 'length', 'max'=>50),
			array('gelarbelakang_nama, kode_pos, esselon_nama', 'length', 'max'=>15),
			array('golongandarah', 'length', 'max'=>2),
			array('warganegara_pegawai, npwp', 'length', 'max'=>25),
			array('kategoripegawai', 'length', 'max'=>128),
			array('photopegawai', 'length', 'max'=>200),
			array('tgl_lahirpegawai, alamat_pegawai, warnakulit, tglditerima, tglberhenti, tglpenggajian, keterangan, periodegaji, kodeptkp, kodeptkp_pegawai, jmltanggunan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, no_kartupegawainegerisipil, no_karis_karsu, no_taspen, no_askes, jenisidentitas, noidentitas, gelardepan, nama_pegawai, nama_keluarga, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, statusperkawinan, alamat_pegawai, kelurahan_id, kelurahan_nama, kode_pos, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, agama, golongandarah, rhesus, alamatemail, notelp_pegawai, nomobile_pegawai, warganegara_pegawai, jeniswaktukerja, suku_id, suku_nama, statuskepemilikanrumah_id, statuskepemilikanrumah_nama, propinsi_id, propinsi_nama, profilrs_id, nokode_rumahsakit, nama_rumahsakit, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, kelompokjabatan, golonganpegawai_id, golonganpegawai_nama, pangkat_id, pangkat_nama, jabatan_id, jabatan_nama, esselon_id, esselon_nama, kelompokpegawai_id, kelompokpegawai_nama, kategoripegawai, kategoripegawaiasal, photopegawai, nofingerprint, tinggibadan, beratbadan, kemampuanbahasa, warnakulit, nip_lama, no_rekening, bank_no_rekening, npwp, tglditerima, tglberhenti, penggajianpeg_id, tglpenggajian, nopenggajian, keterangan, mengetahui, menyetujui, totalterima, totalpajak, totalpotongan, penerimaanbersih, periodegaji, gajipertahun, biayajabatan, potonganpensiun, gajikotor, kodeptkp, ptkppertahun, ptkpperbulan, pkp, persentasepph21, pph21pertahun, pph21perbulan, kodeptkp_pegawai, jmltanggunan', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'No. Induk Pegawai',
			'no_kartupegawainegerisipil' => 'No Kartupegawainegerisipil',
			'no_karis_karsu' => 'No Karis Karsu',
			'no_taspen' => 'No Taspen',
			'no_askes' => 'No. Askes',
			'jenisidentitas' => 'Jenisidentitas',
			'noidentitas' => 'Noidentitas',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'nama_keluarga' => 'Nama Keluarga',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'statusperkawinan' => 'Statusperkawinan',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kode_pos' => 'Kode Pos',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'alamatemail' => 'Alamatemail',
			'notelp_pegawai' => 'Notelp Pegawai',
			'nomobile_pegawai' => 'Nomobile Pegawai',
			'warganegara_pegawai' => 'Warganegara Pegawai',
			'jeniswaktukerja' => 'Jeniswaktukerja',
			'suku_id' => 'Suku',
			'suku_nama' => 'Suku Nama',
			'statuskepemilikanrumah_id' => 'Statuskepemilikanrumah',
			'statuskepemilikanrumah_nama' => 'Statuskepemilikanrumah Nama',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'profilrs_id' => 'Profilrs',
			'nokode_rumahsakit' => 'Nokode Rumahsakit',
			'nama_rumahsakit' => 'Nama Rumahsakit',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelompokjabatan' => 'Kelompokjabatan',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'esselon_id' => 'Esselon',
			'esselon_nama' => 'Esselon Nama',
			'kelompokpegawai_id' => 'Kelompokpegawai',
			'kelompokpegawai_nama' => 'Kelompokpegawai Nama',
			'kategoripegawai' => 'Kategori Pegawai',
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
			'tglditerima' => 'Tglditerima',
			'tglberhenti' => 'Tglberhenti',
			'penggajianpeg_id' => 'Penggajianpeg',
			'tglpenggajian' => 'Tglpenggajian',
			'nopenggajian' => 'Nopenggajian',
			'keterangan' => 'Keterangan',
			'mengetahui' => 'Mengetahui',
			'menyetujui' => 'Menyetujui',
			'totalterima' => 'Totalterima',
			'totalpajak' => 'Totalpajak',
			'totalpotongan' => 'Totalpotongan',
			'penerimaanbersih' => 'Penerimaanbersih',
			'periodegaji' => 'Periodegaji',
			'gajipertahun' => 'Gajipertahun',
			'biayajabatan' => 'Biayajabatan',
			'potonganpensiun' => 'Potonganpensiun',
			'gajikotor' => 'Gajikotor',
			'kodeptkp' => 'Kodeptkp',
			'ptkppertahun' => 'Ptkppertahun',
			'ptkpperbulan' => 'Ptkpperbulan',
			'pkp' => 'Pkp',
			'persentasepph21' => 'Persentasepph21',
			'pph21pertahun' => 'Pph21pertahun',
			'pph21perbulan' => 'Pph21perbulan',
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
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
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
		$criteria->compare('LOWER(kode_pos)',strtolower($this->kode_pos),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		if(!empty($this->suku_id)){
			$criteria->addCondition('suku_id = '.$this->suku_id);
		}
		$criteria->compare('LOWER(suku_nama)',strtolower($this->suku_nama),true);
		if(!empty($this->statuskepemilikanrumah_id)){
			$criteria->addCondition('statuskepemilikanrumah_id = '.$this->statuskepemilikanrumah_id);
		}
		$criteria->compare('LOWER(statuskepemilikanrumah_nama)',strtolower($this->statuskepemilikanrumah_nama),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(nokode_rumahsakit)',strtolower($this->nokode_rumahsakit),true);
		$criteria->compare('LOWER(nama_rumahsakit)',strtolower($this->nama_rumahsakit),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
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
		if(!empty($this->esselon_id)){
			$criteria->addCondition('esselon_id = '.$this->esselon_id);
		}
		$criteria->compare('LOWER(esselon_nama)',strtolower($this->esselon_nama),true);
		if(!empty($this->kelompokpegawai_id)){
			$criteria->addCondition('kelompokpegawai_id = '.$this->kelompokpegawai_id);
		}
		$criteria->compare('LOWER(kelompokpegawai_nama)',strtolower($this->kelompokpegawai_nama),true);
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
		$criteria->compare('LOWER(tglditerima)',strtolower($this->tglditerima),true);
		$criteria->compare('LOWER(tglberhenti)',strtolower($this->tglberhenti),true);
		if(!empty($this->penggajianpeg_id)){
			$criteria->addCondition('penggajianpeg_id = '.$this->penggajianpeg_id);
		}
		$criteria->compare('LOWER(tglpenggajian)',strtolower($this->tglpenggajian),true);
		$criteria->compare('LOWER(nopenggajian)',strtolower($this->nopenggajian),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(mengetahui)',strtolower($this->mengetahui),true);
		$criteria->compare('LOWER(menyetujui)',strtolower($this->menyetujui),true);
		$criteria->compare('totalterima',$this->totalterima);
		$criteria->compare('totalpajak',$this->totalpajak);
		$criteria->compare('totalpotongan',$this->totalpotongan);
		$criteria->compare('penerimaanbersih',$this->penerimaanbersih);
		$criteria->compare('LOWER(periodegaji)',strtolower($this->periodegaji),true);
		$criteria->compare('gajipertahun',$this->gajipertahun);
		$criteria->compare('biayajabatan',$this->biayajabatan);
		$criteria->compare('potonganpensiun',$this->potonganpensiun);
		$criteria->compare('gajikotor',$this->gajikotor);
		$criteria->compare('LOWER(kodeptkp)',strtolower($this->kodeptkp),true);
		$criteria->compare('ptkppertahun',$this->ptkppertahun);
		$criteria->compare('ptkpperbulan',$this->ptkpperbulan);
		$criteria->compare('pkp',$this->pkp);
		$criteria->compare('persentasepph21',$this->persentasepph21);
		$criteria->compare('pph21pertahun',$this->pph21pertahun);
		$criteria->compare('pph21perbulan',$this->pph21perbulan);

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