<?php

class RKPegawaiV extends PegawaiV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiV the static model class
	 */
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
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		if(!empty($this->pendidikan_id)){
			$criteria->addCondition('pendidikan_id = '.$this->pendidikan_id);
		}
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		if(!empty($this->pendkualifikasi_id)){
			$criteria->addCondition('pendkualifikasi_id = '.$this->pendkualifikasi_id);
		}
		$criteria->compare('LOWER(pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		if(!empty($this->pangkat_id)){
			$criteria->addCondition('pangkat_id = '.$this->pangkat_id);
		}
		if(!empty($this->kelompokpegawai_id)){
			$criteria->addCondition('kelompokpegawai_id = '.$this->kelompokpegawai_id);
		}
		if(!empty($this->jabatan_id)){
			$criteria->addCondition('jabatan_id = '.$this->jabatan_id);
		}
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				//'pagination'=>false,
		));
	}

	
}