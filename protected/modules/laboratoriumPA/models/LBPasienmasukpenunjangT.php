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
class LBPasienmasukpenunjangT extends PasienmasukpenunjangT{
    
    public $is_pilihpenunjang = 0;
    public $is_adakarcis = 0;
    public $is_adasample = 0;
    public $perawat_id = null; //untuk tindakanpelayanan_t (analis lab)
	public $pegawai_nama;
	public $perawat_nama;
	
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
		$loadTindakan = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$this->pasienmasukpenunjang_id),"perawat_id IS NOT NULL");
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
}
?>

