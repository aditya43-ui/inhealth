<?php

/**
 * This is the model class for table "infokunjungan_rj".
 *
 * The followings are the available columns in table 'infokunjungan_rj':
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $statusperiksa
 * @property string $statusmasuk
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $alamat_pasien
 * @property string $kelompokumur_nama
 * @property string $ruangan_nama
 * @property string $penjamin_nama
 * @property string $nama_pegawai
 * @property string $jeniskasuspenyakit_nama
 * @property integer $rujukan_id
 */
class FAInformasikasirrawatjalanV extends InformasikasirrawatjalanV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganRj the static model class
	 */
        public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRJ()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->join = 'left join pendaftaran_t on pendaftaran_t.pendaftaran_id = t.pendaftaran_id';
                
                                $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
                //                $criteria->addCondition('t.pembayaranpelayanan_id IS NULL');
		$criteria->compare('LOWER(t.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id);						
		}
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id);						
		}
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("t.kecamatan_id = ".$this->kecamatan_id);						
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("t.kelurahan_id = ".$this->kelurahan_id);						
		}
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);						
		}
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id);						
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id);						
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		//$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
   		$criteria->order = 't.tgl_pendaftaran DESC';
                $criteria->compare('t.ruangan_id', $this->ruangan_id);
                $criteria->compare('pendaftaran_t.pegawai_id', $this->pegawai_id);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getStatusFarmasi($id){
            $criteria = new CDbCriteria();
			if(!empty($id)){
				$criteria->addCondition("pendaftaran_id = ".$id);						
			}
            $criteria->addCondition('oasudahbayar_id is null and qty_oa > 0');
            $criteria->order = 'jenisobatalkes_nama, tglpenjualan';
            $modRincian = BKInformasipenjualanaresepV::model()->findAll($criteria);
            
            $jmlObat = count((array)$modRincian);
            
            return $jmlObat;
        }
        
        public function getFarmasiStatus($id){
                $modPendaftaran = PendaftaranT::model()->findByPK($id);
                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

                $true = 'APPROVE';
                $false = 'VERIFIKASI';
                if($modPendaftaran->statusfarmasi == true){
                    $status = '<button id="green" class="btn btn-danger" name="yt1">'.$true.'</button>';
                }else{
                    $status = '<button id="red" class="btn btn-primary" name="yt1" onclick="ubahStatusFarmasi('.$id.')">'.$false.'</button>';
                }
            return $status;
        }
        
}