<?php

/**
 * This is the model class for table "laporanpejulanresepdokter_v".
 *
 * The followings are the available columns in table 'laporanpejulanresepdokter_v':
 * @property string $tglpenjualan
 * @property string $jenispenjualan
 * @property string $tglresep
 * @property string $noresep
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $pasienadmisi_id
 * @property integer $reseptur_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $nomorindukpegawai
 * @property double $totharganetto
 * @property double $totalhargajual
 * @property double $totaltarifservice
 * @property double $biayaadministrasi
 * @property double $biayakonseling
 * @property double $pembulatanharga
 * @property double $jasadokterresep
 * @property string $instalasiasal_nama
 * @property string $ruanganasal_nama
 * @property double $discount
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirs
 * @property double $iurbiaya
 * @property integer $lamapelayanan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $penjualanresep_id
 * @property integer $obatalkes_id
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_nama
 * @property integer $sumberdana_id
 * @property string $sumberdana_nama
 * @property double $qty_oa
 * @property double $hargasatuan_oa
 * @property double $hargajual_oa
 * @property integer $oasudahbayar_id
 * @property integer $racikan_id
 * @property string $r
 * @property integer $rke
 */
class LaporanpejulanresepdokterV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpejulanresepdokterV the static model class
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
		return 'laporanpejulanresepdokter_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, pendaftaran_id, carabayar_id, penjamin_id, pasienadmisi_id, reseptur_id, ruangan_id, pegawai_id, lamapelayanan, penjualanresep_id, obatalkes_id, satuankecil_id, jenisobatalkes_id, sumberdana_id, oasudahbayar_id, racikan_id, rke', 'numerical', 'integerOnly'=>true),
			array('totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, qty_oa, hargasatuan_oa, hargajual_oa', 'numerical'),
			array('jenispenjualan, instalasiasal_nama, ruanganasal_nama', 'length', 'max'=>100),
			array('noresep, nama_pasien, carabayar_nama, penjamin_nama, nama_pegawai, obatalkes_golongan, obatalkes_kategori, satuankecil_nama, jenisobatalkes_nama, sumberdana_nama', 'length', 'max'=>50),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, no_pendaftaran, obatalkes_kadarobat', 'length', 'max'=>20),
			array('nama_bin, umur, nomorindukpegawai', 'length', 'max'=>30),
			array('tempat_lahir', 'length', 'max'=>25),
			array('obatalkes_kode, obatalkes_nama', 'length', 'max'=>200),
			array('r', 'length', 'max'=>2),
			array('tglpenjualan, tglresep, tanggal_lahir, alamat_pasien, tgl_pendaftaran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglpenjualan, jenispenjualan, tglresep, noresep, pasien_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, umur, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, pasienadmisi_id, reseptur_id, ruangan_id, pegawai_id, gelardepan, nama_pegawai, nomorindukpegawai, totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, instalasiasal_nama, ruanganasal_nama, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, lamapelayanan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, penjualanresep_id, obatalkes_id, obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, satuankecil_id, satuankecil_nama, jenisobatalkes_id, jenisobatalkes_nama, sumberdana_id, sumberdana_nama, qty_oa, hargasatuan_oa, hargajual_oa, oasudahbayar_id, racikan_id, r, rke', 'safe', 'on'=>'search'),
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
			'tglpenjualan' => 'Tglpenjualan',
			'jenispenjualan' => 'Jenispenjualan',
			'tglresep' => 'Tglresep',
			'noresep' => 'Noresep',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'umur' => 'Umur',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'pasienadmisi_id' => 'Pasienadmisi',
			'reseptur_id' => 'Reseptur',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'totharganetto' => 'Totharganetto',
			'totalhargajual' => 'Totalhargajual',
			'totaltarifservice' => 'Totaltarifservice',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayakonseling' => 'Biayakonseling',
			'pembulatanharga' => 'Pembulatanharga',
			'jasadokterresep' => 'Jasadokterresep',
			'instalasiasal_nama' => 'Instalasiasal Nama',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'discount' => 'Keringanan',
			'subsidiasuransi' => 'Subsidiasuransi',
			'subsidipemerintah' => 'Subsidipemerintah',
			'subsidirs' => 'Subsidirs',
			'iurbiaya' => 'Iurbiaya',
			'lamapelayanan' => 'Lamapelayanan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'penjualanresep_id' => 'Penjualanresep',
			'obatalkes_id' => 'Obatalkes',
			'obatalkes_kode' => 'Obatalkes Kode',
			'obatalkes_nama' => 'Obatalkes Nama',
			'obatalkes_golongan' => 'Obatalkes Golongan',
			'obatalkes_kategori' => 'Obatalkes Kategori',
			'obatalkes_kadarobat' => 'Obatalkes Kadarobat',
			'satuankecil_id' => 'Satuankecil',
			'satuankecil_nama' => 'Satuankecil Nama',
			'jenisobatalkes_id' => 'Jenisobatalkes',
			'jenisobatalkes_nama' => 'Jenisobatalkes Nama',
			'sumberdana_id' => 'Sumberdana',
			'sumberdana_nama' => 'Sumberdana Nama',
			'qty_oa' => 'Qty Oa',
			'hargasatuan_oa' => 'Hargasatuan Oa',
			'hargajual_oa' => 'Hargajual Oa',
			'oasudahbayar_id' => 'Oasudahbayar',
			'racikan_id' => 'Racikan',
			'r' => 'R',
			'rke' => 'Rke',
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

		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->rt)){
			$criteria->addCondition('rt = '.$this->rt);
		}
		if(!empty($this->rw)){
			$criteria->addCondition('rw = '.$this->rw);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->reseptur_id)){
			$criteria->addCondition('reseptur_id = '.$this->reseptur_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('totharganetto',$this->totharganetto);
		$criteria->compare('totalhargajual',$this->totalhargajual);
		$criteria->compare('totaltarifservice',$this->totaltarifservice);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayakonseling',$this->biayakonseling);
		$criteria->compare('pembulatanharga',$this->pembulatanharga);
		$criteria->compare('jasadokterresep',$this->jasadokterresep);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);
		if(!empty($this->lamapelayanan)){
			$criteria->addCondition('lamapelayanan = '.$this->lamapelayanan);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition('penjualanresep_id = '.$this->penjualanresep_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('sumberdana_id = '.$this->sumberdana_id);
		}
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		if(!empty($this->oasudahbayar_id)){
			$criteria->addCondition('oasudahbayar_id = '.$this->oasudahbayar_id);
		}
		if(!empty($this->racikan_id)){
			$criteria->addCondition('racikan_id = '.$this->racikan_id);
		}
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		if(!empty($this->rke)){
			$criteria->addCondition('rke = '.$this->rke);
		}

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
        
        public function getGelarBelakang($pegawai_id){
            $gelar = FAPegawaiM::model()->findByPk($pegawai_id);
            
            return (count((array)$gelar)>0)?!empty($gelar->gelarbelakang->gelarbelakang_nama)?$gelar->gelarbelakang->gelarbelakang_nama:'':'';
        }
}