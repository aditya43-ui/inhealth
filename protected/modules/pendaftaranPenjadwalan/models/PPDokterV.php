<?php

/**
 * This is the model class for table "dokter_v".
 *
 * The followings are the available columns in table 'dokter_v':
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $jeniskelamin
 * @property string $nama_keluarga
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $alamat_pegawai
 * @property boolean $pegawai_aktif
 */
class PPDokterV extends DokterV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DokterV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchPegawai()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = 'DISTINCT pegawai_id, nama_pegawai, tempatlahir_pegawai, tgl_lahirpegawai, alamat_pegawai, jeniskelamin, nomorindukpegawai';
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 			
			}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id); 			
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
		$criteria->order = 'pegawai_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        
		));
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 'DISTINCT pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, alamat_pegawai, jeniskelamin, nomorindukpegawai';
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 			
			}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id); 			
		}
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('pegawai_aktif', isset($this->pegawai_aktif)?$this->pegawai_aktif:true);                
		$criteria->order = 'nama_pegawai';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        
		));
	}
        
        public function searchDialogPegawai()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = 'DISTINCT pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, alamat_pegawai, jeniskelamin, nomorindukpegawai, jabatan_id';
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 			
			}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id); 			
		}
                if(!empty($this->jabatan_id)){
			$criteria->addCondition("jabatan_id = ".$this->jabatan_id); 			
		}
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('pegawai_aktif', isset($this->pegawai_aktif)?$this->pegawai_aktif:true);                
		$criteria->order = 'nama_pegawai';
                $criteria->group = "pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, alamat_pegawai, jeniskelamin, nomorindukpegawai, jabatan_id";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        
		));
	}

	
}