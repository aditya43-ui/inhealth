<?php

class BKRekapitulasipenerimaansejenisV extends RekapitulasipenerimaansejenisV
{
	public $carapembayaran;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekapitulasipenerimaansejenisV the static model class
	 */
        public $totalpenerimaan;
        public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchPenerimaanRI(){
            $criteria = new CDbCriteria();
            $criteria->group = 'instalasi_id,instalasi_nama,ruangan_id,ruangan_nama,instalasikasir_id,instalasikasir_nama,ruangankasir_id,ruangankasir_nama,pasien_id,jenisidentitas,no_identitas_pasien,namadepan,nama_pasien,nama_bin,jeniskelamin,tempat_lahir,tanggal_lahir,alamat_pasien,rt,rw,agama,golongandarah,photopasien,alamatemail,statusrekammedis,statusperkawinan,no_rekam_medik,tgl_rekam_medik,propinsi_id,propinsi_nama,kabupaten_id,kabupaten_nama,kelurahan_id,kelurahan_nama,kecamatan_id,kecamatan_nama,pekerjaan_id,pekerjaan_nama,pendidikan_id,pendidikan_nama,suku_id,suku_nama,pendaftaran_id,no_pendaftaran,tgl_pendaftaran,pegawai_id,nama_pegawai,tglclosingkasir,closingdari,sampaidengan,keterangan_closing';
            $criteria->select = $criteria->group.', \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir';
            $criteria->order = 'ruangan_nama, nama_pasien';
            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);
            $criteria->addBetweenCondition('date(tglclosingkasir)', $this->tgl_awal, $this->tgl_akhir);
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
        
        public function searchPrintPenerimaanRI(){
            $criteria = new CDbCriteria();
            $criteria->group = 'instalasi_id,instalasi_nama,ruangan_id,ruangan_nama,instalasikasir_id,instalasikasir_nama,ruangankasir_id,ruangankasir_nama,pasien_id,jenisidentitas,no_identitas_pasien,namadepan,nama_pasien,nama_bin,jeniskelamin,tempat_lahir,tanggal_lahir,alamat_pasien,rt,rw,agama,golongandarah,photopasien,alamatemail,statusrekammedis,statusperkawinan,no_rekam_medik,tgl_rekam_medik,propinsi_id,propinsi_nama,kabupaten_id,kabupaten_nama,kelurahan_id,kelurahan_nama,kecamatan_id,kecamatan_nama,pekerjaan_id,pekerjaan_nama,pendidikan_id,pendidikan_nama,suku_id,suku_nama,pendaftaran_id,no_pendaftaran,tgl_pendaftaran,pegawai_id,nama_pegawai,tglclosingkasir,closingdari,sampaidengan,keterangan_closing';
            $criteria->select = $criteria->group.', \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir';
            $criteria->order = 'ruangan_nama, nama_pasien';
            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);
            $criteria->addBetweenCondition('date(tglclosingkasir)', $this->tgl_awal, $this->tgl_akhir);
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
            ));
        }
        
        public function searchPenerimaanRJ(){
            $criteria = new CDbCriteria();
            $criteria->group = 'instalasi_id,instalasi_nama,ruangan_id,ruangan_nama,instalasikasir_id,instalasikasir_nama,ruangankasir_id,ruangankasir_nama,pasien_id,jenisidentitas,no_identitas_pasien,namadepan,nama_pasien,nama_bin,jeniskelamin,tempat_lahir,tanggal_lahir,alamat_pasien,rt,rw,agama,golongandarah,photopasien,alamatemail,statusrekammedis,statusperkawinan,no_rekam_medik,tgl_rekam_medik,propinsi_id,propinsi_nama,kabupaten_id,kabupaten_nama,kelurahan_id,kelurahan_nama,kecamatan_id,kecamatan_nama,pekerjaan_id,pekerjaan_nama,pendidikan_id,pendidikan_nama,suku_id,suku_nama,pendaftaran_id,no_pendaftaran,tgl_pendaftaran,pegawai_id,nama_pegawai,tglclosingkasir,closingdari,sampaidengan,keterangan_closing';
            $criteria->select = $criteria->group.', \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir';
            $criteria->order = 'ruangan_nama, nama_pasien';
            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
            $criteria->addBetweenCondition('date(tglclosingkasir)', $this->tgl_awal, $this->tgl_akhir);
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
        
        public function searchPrintPenerimaanRJ(){
            $criteria = new CDbCriteria();
            $criteria->group = 'instalasi_id,instalasi_nama,ruangan_id,ruangan_nama,instalasikasir_id,instalasikasir_nama,ruangankasir_id,ruangankasir_nama,pasien_id,jenisidentitas,no_identitas_pasien,namadepan,nama_pasien,nama_bin,jeniskelamin,tempat_lahir,tanggal_lahir,alamat_pasien,rt,rw,agama,golongandarah,photopasien,alamatemail,statusrekammedis,statusperkawinan,no_rekam_medik,tgl_rekam_medik,propinsi_id,propinsi_nama,kabupaten_id,kabupaten_nama,kelurahan_id,kelurahan_nama,kecamatan_id,kecamatan_nama,pekerjaan_id,pekerjaan_nama,pendidikan_id,pendidikan_nama,suku_id,suku_nama,pendaftaran_id,no_pendaftaran,tgl_pendaftaran,pegawai_id,nama_pegawai,tglclosingkasir,closingdari,sampaidengan,keterangan_closing';
            $criteria->select = $criteria->group.', \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir';
            $criteria->order = 'ruangan_nama, nama_pasien';
            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
            $criteria->addBetweenCondition('date(tglclosingkasir)', $this->tgl_awal, $this->tgl_akhir);
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false
            ));
        }
    
        public function searchPenerimaanRD(){
            $criteria = new CDbCriteria();
            $criteria->group = 'instalasi_id,instalasi_nama,ruangan_id,ruangan_nama,tglclosingkasir,kelaspelayanan_id,kelaspelayanan_nama';
            $criteria->select = $criteria->group.', \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir';
            $criteria->order = 'tglclosingkasir';
            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RD);
            $criteria->addBetweenCondition('date(tglclosingkasir)', $this->tgl_awal, $this->tgl_akhir);
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
                
        public function searchPrintPenerimaanRD(){
            $criteria = new CDbCriteria();
            $criteria->group = 'instalasi_id,instalasi_nama,ruangan_id,ruangan_nama,tglclosingkasir,kelaspelayanan_id,kelaspelayanan_nama';
            $criteria->select = $criteria->group.', \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir';
            $criteria->order = 'tglclosingkasir';
            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RD);
            $criteria->addBetweenCondition('date(tglclosingkasir)', $this->tgl_awal, $this->tgl_akhir);
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
            ));
        }
//  RND-5836 hanya ada untuk di tarakan saja
//        public function getTotalJasaRSRD(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(jasars) as jasars';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RD));
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->jasars;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        
//        public function getTotalPelayananRD(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(jasapelayanan) as jasapelayanan';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RD));
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->jasapelayanan;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalRFSRD(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(rfs) as rfs';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RD));
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->rfs;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalADMRD(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(adm) as adm';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RD);
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->adm;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalAMBRD(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(amb) as amb';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RD);
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->amb;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalKonsulRD(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(konsul) as konsul';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RD);
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->konsul;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalTotalRD(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'sum(konsul) as total';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RD);
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->total;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalJasaRS(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(jasars) as jasars';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->jasars;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalJasaRSRI(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(jasars) as jasars';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->jasars;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//
//        public function getTotalPelayanan(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(jasapelayanan) as jasapelayanan';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->jasapelayanan;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalPelayananRI(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(jasapelayanan) as jasapelayanan';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->jasapelayanan;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalRFS(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(rfs) as rfs';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->rfs;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalRFSRI(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(rfs) as rfs';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->rfs;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalADM(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(adm) as adm';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->adm;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalADMRI(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(adm) as adm';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->adm;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//         public function getTotalAMB(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(amb) as amb';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->amb;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalAMBRI(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(amb) as amb';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->amb;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalKonsul(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(konsul) as konsul';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->konsul;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalKonsulRI(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'SUM(konsul) as konsul';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->konsul;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalTotal(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'sum(konsul) as total';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD));
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->total;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
//        public function getTotalTotalRI(){
//            $criteria = new CDBCriteria;
//            $criteria->select = 'sum(konsul) as total';
//            $criteria->addCondition('carapembayaran = \'TUNAI\'');
//            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_RI);
//            $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal, $this->tgl_akhir);
//            $jumlah = BKRekapitulasipenerimaansejenisV::model()->find($criteria)->total;
//            
//            if (empty($jumlah)){
//                $jumlah = 0;
//            }
//            return $jumlah;
//        }
}