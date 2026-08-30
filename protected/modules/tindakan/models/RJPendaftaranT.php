<?php

/**
 * Model Pendaftaran di modul Rawat Jalan
 * 
 * @author     Deni <denihamdani@piindonesia.co.id>
 * @package    application.modules.rawatJalan
 * @subpackage controllers
 * @category   controller
 */
class RJPendaftaranT extends PendaftaranT
{    
    public $kelas_layanan, $jeniskasuspenyakit_nama;
    public $dokter_pemeriksa;
    public $is_bpjs=0,$is_adakarcis=1,$is_bayarkarcis=1;    
    public $carabayar_nama;
    public $penjamin_nama;
    public $no_rekam_medik;
    public $nama_pasien;
    public $jeniskelamin;
    public $instalasi_nama, $ruangan_nama, $kelaspelayanan_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
     * List Relasi untuk mempermudah pencarian data.
     * 
     * @returns mixed;
     */
    public function relations()
	{ 
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                        'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
                        'penanggungJawab'=>array(self::BELONGS_TO,'PenanggungjawabM','penanggungjawab_id'),
                        'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                        'jeniskasuspenyakit'=>array(self::BELONGS_TO,'JeniskasuspenyakitM','jeniskasuspenyakit_id'),
                        'dokter'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
                        'penjamin'=>array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
                        'instalasi'=>array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
                        'carabayar'=>array(self::BELONGS_TO,  'CarabayarM', 'carabayar_id'),
                        'kirimkeunitlain'=>array(self::HAS_MANY, 'PasienkirimkeunitlainT', 'pendaftaran_id'),
                        'anamnesa'=>array(self::HAS_ONE, 'AnamnesaT', 'pendaftaran_id'),
                        'pemeriksaanfisik'=>array(self::HAS_ONE, 'PemeriksaanfisikT', 'pendaftaran_id'),
                        'pasienmasukpenunjang'=>array(self::HAS_ONE, 'PasienmasukpenunjangT', 'pendaftaran_id'),
                        'diagnosa'=>array(self::HAS_MANY, 'PasienmorbiditasT', 'pendaftaran_id'),
                        'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                        'hasilpemeriksaanlab'=>array(self::HAS_ONE, 'HasilpemeriksaanlabT', 'pendaftaran_id'),
                        'pasienpulang'=>array(self::HAS_ONE, 'PasienpulangT', 'pasienpulang_id'),
                        'tindakanpelayanan'=>array(self::HAS_MANY, 'TindakanpelayananT', 'pendaftaran_id'),
                        'kelaspelayanan'=>array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
                        'resumemedis'=>array(self::HAS_MANY, 'ResumemedisR', 'pendaftaran_id'),
                        'ppds' => array(self::BELONGS_TO, 'PasienPpdsT', 'pendaftaran_id'),
                    
		);
	}
        
    /**
     * Pencarian Riwayat
     * 
     * @param type $data
     * @return \CActiveDataProvider
     */
    public function searchRiwayat($data)
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);		
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);		
			}
			if(!empty($this->caramasuk_id)){
				$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id);		
			}
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);		
			}
			if(!empty($data)){
				$criteria->addCondition("pasien_id = ".$data);		
			}
			if(!empty($this->shift_id)){
				$criteria->addCondition("shift_id = ".$this->shift_id);		
			}
			if(!empty($this->golonganumur_id)){
				$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id);		
			}
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);		
			}
			if(!empty($this->rujukan_id)){
				$criteria->addCondition("rujukan_id = ".$this->rujukan_id);		
			}
			if(!empty($this->penanggungjawab_id)){
				$criteria->addCondition("penanggungjawab_id = ".$this->penanggungjawab_id);		
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);		
			}
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);		
			}
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);		
			}
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    /**
     * List Kelas Pelayanan aktif
     * 
     * @return mixed
     */
    public function getKelasPelayananItems()
	{
            return KelaspelayananM::model()->findAll('kelaspelayanan_aktif=true ORDER BY kelaspelayanan_nama');
	}
	
	/**
	   * Mengambil daftar semua ruangan
	   * @return CActiveDataProvider 
	*/
	public function getRuanganItems($instalasi_id=null)
	{
		$criteria = new CDbCriteria();
		if(!empty($instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$instalasi_id);		
		}
		$criteria->addCondition('ruangan_aktif = true');
		$criteria->order = "ruangan_nama";
		
		return RuanganM::model()->findAll($criteria);
	}
	
	/**
		* mengambil data jenis kasus penyakit berdasarkan ruangan
		* @param type $ruangan_id
    */
	public function getJenisKasusPenyakitItems($ruangan_id = null)
	{            
       if($ruangan_id == ''){
           $ruangan_id = Yii::app()->user->getState('ruangan_id');
       }
       $criteria = new CdbCriteria();
       $criteria->addCondition('kasuspenyakitruangan_m.ruangan_id = '.$ruangan_id);
       $criteria->addCondition('t.jeniskasuspenyakit_aktif = true');
       $criteria->order = "t.jeniskasuspenyakit_nama";
       $criteria->join = "JOIN kasuspenyakitruangan_m ON t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id";
       return JeniskasuspenyakitM::model()->findAll($criteria);
	}
	
	/**
		* menampilkan dokter 
		* @param type $ruangan_id
		* @return type
    */
	public function getDokterItems($ruangan_id='')
	{
		$criteria = new CdbCriteria();
		if(!empty($ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$ruangan_id);		
		}
		$criteria->addCondition('pegawai_aktif = true');
		$criteria->order = "nama_pegawai, gelardepan";
		$modDokter = DokterV::model()->findAll($criteria);
		return $modDokter;
	}
	
	/**
		* Mengambil daftar semua carabayar
		* @return CActiveDataProvider 
    */
	public function getCaraBayarItems()
	{
       return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
	}
	
	/**
		* Mengambil daftar semua penjamin
		* @return CActiveDataProvider 
    */
	public function getPenjaminItems($carabayar_id=null)
	{
       if(!empty($carabayar_id))
               return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
       else
               return array();
	}
    
    /**
     * Menyusun data JSON kunjungan pasien untuk Transaksi Surveilans
     * 
     * @return mixec
     */
    public function getJSONKunjunganPasienUntukSurveilance() {
        
        $pasien = PasienM::model()->findByPk($this->pasien_id);
        
        $sub = $this->attributes;
        $sub['nama_pasien'] = $pasien->namadepan.$pasien->nama_pasien;
        $sub['tgl_pendaftaran'] = MyFormatter::formatDateTimeForUser($this->tgl_pendaftaran);
        $sub['no_rekam_medik'] = $pasien->no_rekam_medik;
        $sub['jeniskelamin'] = $pasien->jeniskelamin;
        $sub['carabayar_nama'] = $this->carabayar->carabayar_nama;
        $sub['penjamin_nama'] = $this->penjamin->penjamin_nama;
        $sub['dokter_pemeriksa'] = $this->pegawai->namaLengkap;
        $sub['jeniskasuspenyakit_nama'] = $this->jeniskasuspenyakit->jeniskasuspenyakit_nama; 
        
        return $sub;
    }
}
?>
