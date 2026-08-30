<?php
class RKInformasipengirimanrmV extends InformasipengirimanrmV
{
	public $tgl_awal;
	public $tgl_akhir;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tglpengirimanrm)',$this->tgl_awal,$this->tgl_akhir);
		
		if(!empty($this->pengirimanrm_id)){
			$criteria->addCondition('pengirimanrm_id = '.$this->pengirimanrm_id);
		}
		if(!empty($this->peminjamanrm_id)){
			$criteria->addCondition('peminjamanrm_id = '.$this->peminjamanrm_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->dokrekammedis_id)){
			$criteria->addCondition('dokrekammedis_id = '.$this->dokrekammedis_id);
		}
		if(!empty($this->ruangantujuan_id)){
			$criteria->addCondition('ruangantujuan_id = '.$this->ruangantujuan_id);
		}
		$criteria->compare('LOWER(ruangantujuan_nama)',strtolower($this->ruangantujuan_nama),true);
		if(!empty($this->instalasitujuan_id)){
			$criteria->addCondition('instalasitujuan_id = '.$this->instalasitujuan_id);
		}
		$criteria->compare('LOWER(instalasitujuan_nama)',strtolower($this->instalasitujuan_nama),true);
		if(!empty($this->ruanganpengirim_id)){
			$criteria->addCondition('ruanganpengirim_id = '.$this->ruanganpengirim_id);
		}
		$criteria->compare('LOWER(ruanganpengirim_nama)',strtolower($this->ruanganpengirim_nama),true);
		if(!empty($this->instalasipengirim_id)){
			$criteria->addCondition('instalasipengirim_id = '.$this->instalasipengirim_id);
		}
		$criteria->compare('LOWER(instalasipengirim_nama)',strtolower($this->instalasipengirim_nama),true);
		$criteria->compare('LOWER(nourut_keluar)',strtolower($this->nourut_keluar),true);		
		$criteria->compare('kelengkapandokumen',$this->kelengkapandokumen);
		$criteria->compare('LOWER(petugaspengirim)',strtolower($this->petugaspengirim),true);
		$criteria->compare('printpengiriman',$this->printpengiriman);
		if(!empty($this->ruanganpengirim_id)){
			$criteria->addCondition('ruanganpengirim_id = '.$this->ruanganpengirim_id);
		}
                if (!empty($this->create_loginpemakai_id)){
                    $criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
                }
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		//$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->kembalirm_id)){
			$criteria->addCondition('kembalirm_id = '.$this->kembalirm_id);
		}
		$criteria->compare('LOWER(tglkembali)',strtolower($this->tglkembali),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(statusdokrm)',strtolower($this->statusdokrm),true);

		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
}