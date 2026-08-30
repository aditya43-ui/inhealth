<?php
class PIDokterpegawaiV extends DokterpegawaiV
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchByDokterDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->join = " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id ";

		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(t.tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(t.tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('t.pegawai_aktif',$this->pegawai_aktif);
		$criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(t.golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(t.alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(t.notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(t.nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(t.photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('t.pendidikan_id',$this->pendidikan_id);
		$criteria->compare('LOWER(t.pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('t.pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('LOWER(t.pendkualifikasi_nama)',strtolower($this->pendkualifikasi_nama),true);
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('t.pangkat_id',$this->pangkat_id);
		$condition = 't.kelompokpegawai_id = 1';
		$criteria->addCondition($condition);
		$criteria->compare('t.jabatan_id',$this->jabatan_id);
		$criteria->compare('p.tglditerima',$this->tglditerima,true);
		$criteria->compare('p.npwp',$this->npwp,true);
		$criteria->limit = 5;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}