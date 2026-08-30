<?php

class ADPegawaiM extends PegawaiM
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);			
		}
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);			
		}
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);			
		}
		if(!empty($this->profilrs_id)){
			$criteria->addCondition("profilrs_id = ".$this->profilrs_id);			
		}
		if(!empty($this->gelarbelakang_id)){
			$criteria->addCondition("gelarbelakang_id = ".$this->gelarbelakang_id);			
		}
		if(!empty($this->suku_id)){
			$criteria->addCondition("suku_id = ".$this->suku_id);			
		}
		if(!empty($this->kelompokpegawai_id)){
			$criteria->addCondition("kelompokpegawai_id = ".$this->kelompokpegawai_id);			
		}
		if(!empty($this->pendkualifikasi_id)){
			$criteria->addCondition("pendkualifikasi_id = ".$this->pendkualifikasi_id);			
		}
		if(!empty($this->jabatan_id)){
			$criteria->addCondition("jabatan_id = ".$this->jabatan_id);			
		}
		if(!empty($this->pendidikan_id)){
			$criteria->addCondition("pendidikan_id = ".$this->pendidikan_id);			
		}
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);			
		}
		if(!empty($this->pangkat_id)){
			$criteria->addCondition("pangkat_id = ".$this->pangkat_id);			
		}
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);			
		}
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
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
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
		$criteria->limit = 10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination'=>false,
		));
	}
        
        public function searchMengetahui(){
            $criteria=new CDbCriteria;
            $criteria->join = "JOIN ruanganpegawai_m rp ON rp.pegawai_id = t.pegawai_id";
            $criteria->compare("LOWER(t.nama_pegawai)", strtolower($this->nama_pegawai), TRUE);
            $criteria->compare("LOWER(t.nomorindukpegawai)", strtolower($this->nomorindukpegawai), TRUE);
            if (!empty($this->jabatan_id)){
                $criteria->addCondition("t.jabatan_id = '".$this->jabatan_id."' ");
            }
            $criteria->addCondition(" rp.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            $criteria->limit = 10;
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination'=>false,
		));
        }
}