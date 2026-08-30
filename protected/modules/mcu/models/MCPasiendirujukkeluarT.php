<?php
class MCPasiendirujukkeluarT extends PasiendirujukkeluarT
{
	public $is_pasienrujukankeluar = 1;
	public $tgl_awal,$tgl_akhir;
	public $no_pendaftaran,$no_rekam_medik,$nama_pasien,$statusperiksa,$nama_pegawai;
	public $rumahsakitrujukan;
	public $namadepan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasiendirujukkeluarT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
     * Mengambil daftar semua rujukan keluar
     * @return CActiveDataProvider 
     */

    public function getRujukanKeluarItems()
    {
        return RujukankeluarM::model()->findAllByAttributes(array('rujukankeluar_aktif'=>true),array('order'=>'rumahsakitrujukan'));
    }
	
	public function searchDaftarPasienRujukan(){
		
		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(t.tgldirujuk)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pasiendirujukkeluar_id)){
			$criteria->addCondition('t.pasiendirujukkeluar_id = '.$this->pasiendirujukkeluar_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('t.pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->rujukankeluar_id)){
			$criteria->addCondition('t.rujukankeluar_id = '.$this->rujukankeluar_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('t.pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('t.pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(t.nosuratrujukan)',strtolower($this->nosuratrujukan),true);		
		$criteria->compare('LOWER(t.kepadayth)',strtolower($this->kepadayth),true);
		$criteria->compare('LOWER(t.dirujukkebagian)',strtolower($this->dirujukkebagian),true);
		$criteria->compare('LOWER(t.alasandirujuk)',strtolower($this->alasandirujuk),true);
		$criteria->compare('LOWER(t.hasilpemeriksaan_ruj)',strtolower($this->hasilpemeriksaan_ruj),true);
		$criteria->compare('LOWER(t.diagnosasementara_ruj)',strtolower($this->diagnosasementara_ruj),true);
		$criteria->compare('LOWER(t.pengobatan_ruj)',strtolower($this->pengobatan_ruj),true);
		$criteria->compare('LOWER(t.lainlain_ruj)',strtolower($this->lainlain_ruj),true);
		$criteria->compare('LOWER(t.catatandokterperujuk)',strtolower($this->catatandokterperujuk),true);
		if(!empty($this->ruanganasal_id)){
			$criteria->addCondition('t.ruanganasal_id = '.$this->ruanganasal_id);
		}
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(t.tglberlakusurat)',strtolower($this->tglberlakusurat),true);
		$criteria->compare('LOWER(t.sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('LOWER(t.lampiransurat)',strtolower($this->lampiransurat),true);
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(pendaftaran.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->with = array('pendaftaran','pegawai','pasien');
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function getRTRW(){
		return isset($this->pendaftaran->pasien->rt) ? $this->pendaftaran->pasien->rt : ""."/".isset($this->pendaftaran->pasien->rw) ? $this->pendaftaran->pasien->rw : "";
	}
	
	public function getStatus($status,$id){
        if($status == "SEDANG PERIKSA"){
            $status = '<button id="red" class="btn btn-primary" name="yt1">'.$status.'</button>';

        }else if($status == "ANTRIAN"){
            $status = '<button id="green" class="btn btn-danger" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
        }else if($status == "SUDAH PULANG"){
            $status = '<button id="blue" class="btn btn-danger-yellow" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
        }else{
            $status = '<button id="orange" class="btn btn-danger-blue"  name="yt1">'.$status.'</button>';
        }
        return $status;
    }
	
	/**
		 * kriteria pencarian untuk dashboard
		 * @return \CActiveDataProvider
		 */
		public function searchDashboard()
		{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->compare('DATE(tgldirujuk)', date("Y-m-d"));
			$criteria->with=array('pendaftaran','rujukankeluar','pasien');
			$criteria->order = 'tgldirujuk ASC';
			$criteria->limit = 10;
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false
			));
		}
		
		/**
		 * kriteria pencarian untuk dashboard
		 * @return \CActiveDataProvider
		 */
		public function searchDashboardMC()
		{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->select = 'pendaftaran_t.no_pendaftaran,tgldirujuk,pasien_m.no_rekam_medik,pasien_m.nama_pasien,rujukankeluar_m.rumahsakitrujukan,alasandirujuk';
			$criteria->join = 'JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id=t.pendaftaran_id
JOIN pasien_m ON pasien_m.pasien_id=t.pasien_id
JOIN rujukankeluar_m ON rujukankeluar_m.rujukankeluar_id=t.rujukankeluar_id';
			$criteria->order = 't.tgldirujuk DESC';
			$criteria->limit = 10;
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false
			));
		}

}
