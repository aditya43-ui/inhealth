<?php
class PPPegawaiV extends PegawaiV
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getNamaLengkap()
    {
         $dokter = $this->model()->findByAttributes(array('pegawai_id'=> $this->pegawai_id));
         return $dokter->gelardepan." ".$dokter->nama_pegawai.", ".$dokter->gelarbelakang_nama;
    }
    
    public function getGelarBelakangItems()
    {
        return GelarbelakangM::model()->findAll(array('order'=>'gelarbelakang_nama'));
    } 

    public function getSukuItems()
    {
        return SukuM::model()->findAll(array('order'=>'suku_nama'));
    }  

    public function getkelompokPegawaiItems()
    {
        return KelompokpegawaiM::model()->findAll("kelompokpegawai_aktif = TRUE ORDER BY kelompokpegawai_nama ASC");
    }  

    public function getPendidikanKualifikasiItems()
    {
        return PendidikankualifikasiM::model()->findAll(array('order'=>'pendkualifikasi_nama'));
    }  

    public function getJabatanItems()
    {
        return JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC");
    } 

    public function getPendidikanItems()
    {
        return PendidikanM::model()->findAll(array('order'=>'pendidikan_nama'));
    }

     public function getPangkatItems()
    {
        return PangkatM::model()->findAll("pangkat_aktif = TRUE ORDER BY pangkat_nama ASC");
    } 

    public function getPropinsiItems()
    {
        return PropinsiM::model()->findAll(array('order'=>'propinsi_nama'));
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
    
    /**
     * dialog yang menampilkan data pegawai, dan berelasi ke pasien
     * @return \CActiveDataProvider
     */
    public function searchPegawaiPasienDialog(){
        $cri = new CDbCriteria();
        $cri->join =    "   LEFT JOIN jabatan_m j ON j.jabatan_id = t.jabatan_id "                        
                    .   "   LEFT JOIN pasien_m pp ON pp.pegawai_id = t.pegawai_id "
                    .   "   LEFT JOIN gelarbelakang_m gelar ON gelar.gelarbelakang_id = t.gelarbelakang_id ";            
        $cri->select = " pp.pasien_id, j.jabatan_nama, gelar.gelarbelakang_nama as belakang, "
                . " t.*";

        if(!empty($this->jabatan_id)){
            $cri->addCondition('t.jabatan_id = '.$this->jabatan_id);
        }

        if(!empty($this->statusperkawinan)){
            $cri->addCondition("t.statusperkawinan = '".$this->statusperkawinan."' ");
        }

        $cri->compare("LOWER(t.nomorindukpegawai)", strtolower($this->nomorindukpegawai), true);
        $cri->compare("LOWER(t.nama_pegawai)", strtolower($this->nama_pegawai), true);
        $cri->compare("LOWER(t.tempatlahir_pegawai)", strtolower($this->tempatlahir_pegawai), true);
        $cri->compare("LOWER(t.alamat_pegawai)", strtolower($this->alamat_pegawai), true);
        if (!empty($this->tgl_lahirpegawai)){
            $cri->addCondition("t.tgl_lahirpegawai = '".$this->tgl_lahirpegawai."' ");
        }            

        $cri->limit = 10;

        return new CActiveDataProvider(new PegawaiM, array(
                'criteria'=>$cri,
                'pagination' => false
        ));
    }
    
}