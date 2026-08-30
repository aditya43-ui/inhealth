<?php

class GZPasienMasukPenunjangV extends PasienmasukpenunjangV {

    public $pembayaranpelayanan_id;
    public $bulan;
    public $statusBayar;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchKonsulGizi()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->select = 't.*,pendaftaran_t.*';
        $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
        $criteria->compare('LOWER(t.statusperiksa)',  strtolower($this->statusperiksa),TRUE);
        $criteria->compare('t.ruangan_id',Yii::app()->user->getState('ruangan_id'));
        $criteria->addBetweenCondition('DATE(t.tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->carabayar_id)){
            $criteria->addCondition("t.carabayar_id = ".$this->carabayar_id);
        }
        if ($this->statusBayar == "LUNAS"){
            $criteria->addCondition("t.pembayaranpelayanan_id IS NOT NULL");
        }elseif ($this->statusBayar == "BELUM LUNAS"){
            $criteria->addCondition("t.pembayaranpelayanan_id IS NULL");
        }
//        $criteria->addCondition('pendaftaran_t.pembayaranpelayanan_id is null');
        $criteria->join = 'LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id';
        $criteria->order='t.tglmasukpenunjang DESC';

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    /**
    * menampilkan data terakhir daftar
    */
    public function searchPendaftaranTerakhir()
    {
           // Warning: Please modify the following code to remove attributes that
           // should not be searched.

           $criteria=new CDbCriteria;
//                $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
           $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
           $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
           $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
           $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
           $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
           $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
           $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
           $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
           $criteria->compare('propinsi_id',$this->propinsi_id);
           $criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
           $criteria->compare('kabupaten_id',$this->kabupaten_id);
           $criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
           $criteria->compare('kecamatan_id',$this->kecamatan_id);
           $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
           $criteria->compare('kelurahan_id',$this->kelurahan_id);
           $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
           $criteria->compare('instalasiasal_id',$this->instalasiasal_id);
           $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
           $criteria->compare('carabayar_id',$this->carabayar_id);
           $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
           $criteria->compare('penjamin_id',$this->penjamin_id);
           $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
           $criteria->compare('DATE_PART(MONTH,tgl_pendaftaran)',($this->bulan));
           $criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));
           $criteria->compare('LOWER(nama_pegawai)',($this->nama_pegawai));
           $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
           $criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
           $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
           $criteria->order = 'tgl_pendaftaran DESC';
           $criteria->limit = 10;
           return new CActiveDataProvider($this, array(
                   'criteria'=>$criteria,
                   'pagination'=>false,
           ));
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
	   $criteria->compare('DATE(tglmasukpenunjang)', date("Y-m-d"));
	   $criteria->order = 'tglmasukpenunjang ASC';
	   $criteria->limit = 10;
	   return new CActiveDataProvider($this, array(
		   'criteria'=>$criteria,
		   'pagination'=>false
	   ));
	}
    
}
