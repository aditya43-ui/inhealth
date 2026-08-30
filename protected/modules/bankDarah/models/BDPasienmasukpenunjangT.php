<?php
/**
 * This is the model class for table "pasienmasukpenunjang_t".
 *
 * The followings are the available columns in table 'pasienmasukpenunjang_t':
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasien_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $kelaspelayanan_id
 * @property integer $ruangan_id
 * @property integer $pasienadmisi_id
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property string $no_urutperiksa
 * @property string $kunjungan
 * @property string $statusperiksa
 * @property string $ruanganasal_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class BDPasienmasukpenunjangT extends PasienmasukpenunjangT{
    
    public $is_pilihpenunjang = 0;
    public $is_adakarcis = 0;
    public $is_adasample = 0;
    public $perawat_id = null; //untuk tindakanpelayanan_t (analis lab)
	public $pegawai_nama, $instalasi_id, $rhesus, $kesimpulan_uji, $ruangan_nama, $tgl_pendaftaran, $no_pendaftaran, $instalasi_nama, $nama_pegawai, $jeniskelamin, $alamat_pasien, $umur, $golongandarah, $jenis_permintaan, $permintaandarah_id, $is_progressgoldarah, $tgl_kirimpasien;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienmasukpenunjangT the static model class
     */
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchLab()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;


      		$criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->noRM),true);
                $criteria->compare('LOWER(pendaftaran.no_pendaftaran)',strtolower($this->noPendaftaran),true);
                $criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->namaPasien),true);
                $criteria->compare('LOWER(pendaftaran.nama_bin )',strtolower($this->namaBinPasien),true);
                $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
                //$criteria->addCondition('pendaftaran.tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
                
                $criteria->with=array('pasien','jeniskasuspenyakit','pendaftaran','jeniskasuspenyakit','pegawai','kelaspelayanan','ruangan','pasienadmisi','ruanganasal');
               
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * perawat_id tindakanpelayanan_t yg sudah ada
	 */
	public function getPerawatId(){
		$loadTindakan = BDTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$this->pasienmasukpenunjang_id),"perawat_id IS NOT NULL");
		if(isset($loadTindakan->perawat_id)){
			if(!empty($loadTindakan->perawat_id)){
				return $loadTindakan->perawat_id;
			}else{
				return null;
			}
		}else{
			return null;
		}
	}

	public function searchInformasiDaftarPengujianDarah()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria= new CDbCriteria;  
      
        $criteria->addBetweenCondition('DATE(t.tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
    
       // $criteria->group = "pen.*,daftar.*,pas.*";
        $criteria->select =  "t.*, ins.instalasi_nama, pen.*,daftar.*,pas.*,ru.*,car.*, peg.*";
        $criteria->join = ' JOIN pasienkirimkeunitlain_t pen ON pen.pasienkirimkeunitlain_id = t.pasienkirimkeunitlain_id '
        .' JOIN pendaftaran_t daftar ON daftar.pendaftaran_id = t.pendaftaran_id '
        .' JOIN pasien_m pas ON pas.pasien_id = t.pasien_id '
        .' JOIN ruangan_m ru ON ru.ruangan_id = t.ruangan_id '
        .' JOIN instalasi_m ins ON ins.instalasi_id = pen.instalasi_id '
        .' JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id '
       
        . 'JOIN carabayar_m car ON car.carabayar_id = daftar.carabayar_id ';

        $criteria->limit=10;           
        $criteria->order = 't.tglmasukpenunjang DESC';
        $criteria->compare("LOWER(pas.nama_pasien)", strtolower($this->nama_pasien),true);
        $criteria->compare("LOWER(pas.no_rekam_medik)", strtolower($this->no_rekam_medik),true);
        $criteria->compare("LOWER(pas.rhesus)", strtolower($this->rhesus),true);
        $criteria->compare("LOWER(ujidarahslide.kesimpulan_uji)", strtolower($this->kesimpulan_uji),true);
       
        if($this->no_masukpenunjang){
        $criteria->compare("LOWER(pen.no_masukpenunjang)", strtolower($this->no_masukpenunjang),true);
        }

      
        $criteria->addCondition("t.create_ruangan =". Params::RUANGAN_ID_BANK_DARAH);
      
       
       if($this->instalasi_id){
        $criteria->compare("ins.instalasi_id", $this->instalasi_id);
      
       }
        $criteria->compare("ru.ruangan_nama", strtolower($this->ruangan_nama),true);
        $criteria->compare("car.carabayar_id", $this->carabayar_id);
        $criteria->compare("daftar.penjamin_id", $this->penjamin_id);
       
        
        $criteria->compare("peg.pegawai_id", $this->pegawai_id);
         $criteria->compare("pas.pasien_id", $this->pasien_id);
        $criteria->compare("daftar.pendaftaran_id ", $this->pendaftaran_id);
        // echo '<pre>';var_dump($criteria);die;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }

	public function searchInformasiDaftarPengujianDarahDialog()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria= new CDbCriteria;  
      
        // $criteria->addBetweenCondition('DATE(t.tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
    
       // $criteria->group = "pen.*,daftar.*,pas.*";
        $criteria->select =  "t.*, ins.instalasi_nama, pen.*,daftar.*,pas.*,ru.*,car.*,penj.*, peg.*";
        $criteria->join = ' JOIN pasienkirimkeunitlain_t pen ON pen.pasienkirimkeunitlain_id = t.pasienkirimkeunitlain_id '
        .' JOIN pendaftaran_t daftar ON daftar.pendaftaran_id = t.pendaftaran_id '
        .' JOIN pasien_m pas ON pas.pasien_id = t.pasien_id '
        .' JOIN ruangan_m ru ON ru.ruangan_id = t.ruangan_id '
        .' JOIN instalasi_m ins ON ins.instalasi_id = pen.instalasi_id '
        .' JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id '
       
        . 'JOIN carabayar_m car ON car.carabayar_id = daftar.carabayar_id '
        . 'JOIN penjaminpasien_m penj ON penj.carabayar_id = car.carabayar_id ';

        $criteria->limit=10;           
        $criteria->order = 't.tglmasukpenunjang ASC';
        $criteria->compare("LOWER(pas.nama_pasien)", strtolower($this->nama_pasien),true);
        $criteria->compare("LOWER(pas.no_rekam_medik)", strtolower($this->no_rekam_medik),true);
        $criteria->compare("LOWER(pas.rhesus)", strtolower($this->rhesus),true);
        $criteria->compare("LOWER(ujidarahslide.kesimpulan_uji)", strtolower($this->kesimpulan_uji),true);
       
        if($this->no_masukpenunjang){
        $criteria->compare("LOWER(pen.no_masukpenunjang)", strtolower($this->no_masukpenunjang),true);
        }

      
        $criteria->addCondition("t.create_ruangan =". Params::RUANGAN_ID_BANK_DARAH);
      
       
       if($this->instalasi_id){
        $criteria->compare("ins.instalasi_id", $this->instalasi_id);
      
       }
        $criteria->compare("ru.ruangan_nama", strtolower($this->ruangan_nama),true);
        $criteria->compare("car.carabayar_id", $this->carabayar_id);
        $criteria->compare("penj.penjamin_id", $this->penjamin_id);
       
        
        $criteria->compare("peg.pegawai_id", $this->pegawai_id);
         $criteria->compare("pas.pasien_id", $this->pasien_id);
        $criteria->compare("daftar.pendaftaran_id ", $this->pendaftaran_id);
        $criteria->addCondition('pen.is_progressgoldarah is not true and pen.is_progressgoldarah is not null');
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
	
}
?>

