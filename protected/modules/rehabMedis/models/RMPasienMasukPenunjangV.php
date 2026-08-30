<?php
/**
 * model utama untuk mengakses view PasienmasukpenunjangV, hanya untuk di modul rehab medis
 * 
 * @package application.modules.rehabMedis
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class RMPasienMasukPenunjangV extends PasienmasukpenunjangV
{
    public $bulan;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    /**
     * menampilkan data terakhir daftar
     */
    public function searchPendaftaranTerakhir()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
			$criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
            $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
			if (!empty($this->propinsi_id)){
				$criteria->addCondition('propinsi_id ='.$this->propinsi_id);
			}
            $criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if (!empty($this->kabupaten_id)){
				$criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
			}
            $criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if (!empty($this->kecamatan_id)){
				$criteria->addCondition('kecamatan_id ='.$this->kecamatan_id);
			}
            $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if (!empty($this->kelurahan_id)){
				$criteria->addCondition('kelurahan_id ='.$this->kelurahan_id);
			}
            $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if (!empty($this->instalasiasal_id)){
				$criteria->addCondition('instalasiasal_id ='.$this->instalasiasal_id);
			}
            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if (!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if (!empty($this->penjamin_id)){
				$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			/*
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
			if (!empty($ruangan_id)){
				$criteria->addCondition('ruangan_id ='.$ruangan_id);
			}
             * 
             */
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
     * menampilkan dialog kunjungan
     */
    public function searchDialogKunjungan()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria=new CDbCriteria;
			$format = new MyFormatter();
			$this->tglmasukpenunjang = empty($this->tglmasukpenunjang) ? date("Y-m-d") : $format->formatDateTimeForDb($this->tglmasukpenunjang); //filter grid
            $criteria->addBetweenCondition("DATE(tglmasukpenunjang)",$this->tglmasukpenunjang." 00:00:00",  $this->tglmasukpenunjang." 23:59:59");
			$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
            $criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
			if (!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
			}
			if (!empty($this->penjamin_id)){
				$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if (!empty($this->ruangan_id)){
				$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
			}
            $criteria->compare('LOWER(nama_pegawai)',($this->nama_pegawai));
            $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
            $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
            $criteria->limit = 5;
			$this->tglmasukpenunjang = $format->formatDateTimeForUser($this->tglmasukpenunjang);
			
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }

    /**
     * mengambil nama model ini
     * @return system
     */
    public function getNamaModel()
    {
        return __CLASS__;
    }
    
    /**
     * fungsi yang digunakan untuk mengenerate data pada dashboard rehab medis
     * @return \CActiveDataProvider
     */
    public function searchDashboardRM() {
		$criteria = new CDbCriteria();
		$criteria->select = 't.tglmasukpenunjang,t.no_masukpenunjang, pasien_m.no_rekam_medik,pendaftaran_t.no_pendaftaran,pasien_m.nama_pasien,pendaftaran_t.umur,pasien_m.jeniskelamin';
		$criteria->join = 'JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id=t.pendaftaran_id
                        JOIN pasien_m ON pasien_m.pasien_id=t.pasien_id
                        JOIN ruangan_m ON ruangan_m.ruangan_id=t.ruangan_id
                        JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id';
		$criteria->addCondition('instalasi_m.instalasi_id=8');
		$criteria->group = 'pendaftaran_t.no_pendaftaran,t.tglmasukpenunjang, t.no_masukpenunjang, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pendaftaran_t.umur,pasien_m.jeniskelamin';
		$criteria->order = 't.tglmasukpenunjang DESC';
		$criteria->limit = 10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		
	} 
}
?>
