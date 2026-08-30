<?php

/**
 * This is the model class for table "laporansetoranharian_v".
 *
 * The followings are the available columns in table 'laporansetoranharian_v':
 * @property integer $pasien_id
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $pendaftaran_id
 * @property integer $pekerjaan_id
 * @property string $pekerjaan_nama
 * @property integer $pendidikan_id
 * @property string $pendidikan_nama
 * @property integer $suku_id
 * @property string $suku_nama
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property string $transportasi
 * @property string $keadaanmasuk
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property string $kunjungan
 * @property boolean $alihstatus
 * @property boolean $byphone
 * @property boolean $kunjunganrumah
 * @property string $statusmasuk
 * @property string $umur
 * @property integer $pembayaranpelayanan_id
 * @property integer $tandabuktibayar_id
 * @property string $nobuktibayar
 * @property string $tgl_pembayaran
 * @property double $totalbiayapelayanan
 * @property double $totalsubsidiasuransi
 * @property double $totalsubsidipemerintah
 * @property double $totalsubsidirs
 * @property double $totaliurbiaya
 * @property double $totaldiscount
 * @property double $totalpembebasan
 * @property double $totalbayartindakan
 * @property string $tgl_closingkasir
 * @property string $closingdari
 * @property string $sampaidengan
 * @property string $keterangan_closing
 * @property integer $bayaruangmuka_id
 * @property integer $tandabuktibayaruangmuka_id
 * @property string $tandabuktibayaruangmuka_nobuktibayar
 * @property string $tgluangmuka
 * @property double $jumlahuangmuka
 * @property string $tglpemakaianuangmuka
 * @property double $pemakaianuangmuka
 * @property integer $shift_id
 * @property string $shift_nama
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $instalasiakhir_id
 * @property string $instalasiakhir_nama
 * @property integer $ruanganakhir_id
 * @property string $ruanganakhir_nama
 * @property integer $ruangankasir_id
 * @property string $kasir_nama
 * @property integer $kasir_id
 * @property string $kasir_nama
 */
class BKLaporansetoranharianV extends LaporansetoranharianV
{
        public $jumlahsetoran;
        public $nobuktibayar, $data, $jumlah, $tick;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporansetoranharianV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        protected function functionCriteria() {
            $criteria = new CDbCriteria();
            if(is_array($this->ruangankasir_id)){
                $criteria->addInCondition('ruangankasir_id', $this->ruangankasir_id);
            }else{
				if(!empty($this->ruangankasir_id)){
					$criteria->addCondition("ruangankasir_id = ".$this->ruangankasir_id);					
				}
            }
            $criteria->addCondition('totalbayartindakan > 0');
            if(!empty($this->shift_id)){
                if (is_array($this->shift_id)){
                    $criteria->addInCondition("shift_id",$this->shift_id);					
                }else{
                    $criteria->addCondition("shift_id = ".$this->shift_id);					
                }
            }
            
            if(!empty($this->kasir_id)){
                if (is_array($this->kasir_id)){
                    $criteria->addInCondition("kasir_id",$this->kasir_id);					
                }else{
                    $criteria->addCondition("kasir_id = ".$this->kasir_id);					
                }
            }
            
            $criteria->compare('LOWER(shift_nama)', strtolower($this->shift_nama), true);
            $criteria->addBetweenCondition('DATE(tgl_closingkasir)', $this->tgl_awal, $this->tgl_akhir);

            return $criteria;
        }
        
        protected function functionCriteriaDP() {
            $criteria = new CDbCriteria();
            if(is_array($this->ruangankasir_id)){
                $criteria->addInCondition('ruangankasir_id', $this->ruangankasir_id);
            }else{
				if(!empty($this->ruangankasir_id)){
					$criteria->addCondition("ruangankasir_id = ".$this->ruangankasir_id);					
				}
            }
            $criteria->addCondition('pemakaianuangmuka > 0');
            if(!empty($this->shift_id)){
                if (is_array($this->shift_id)){
                    $criteria->addInCondition("shift_id",$this->shift_id);					
                }else{
                    $criteria->addCondition("shift_id = ".$this->shift_id);					
                }
            }
             if(!empty($this->kasir_id)){
                if (is_array($this->kasir_id)){
                    $criteria->addInCondition("kasir_id",$this->kasir_id);					
                }else{
                    $criteria->addCondition("kasir_id = ".$this->kasir_id);					
                }
            }
            
            $criteria->addBetweenCondition('DATE(tgl_closingkasir)', $this->tgl_awal, $this->tgl_akhir);

            return $criteria;
        }
        
        public function searchGrafik() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        
        // $criteria->select = 'count(tandabuktibayar_id) as jumlah, ruangan_nama as data';
        // $criteria->group = 'ruangan_nama';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
        }
        
        public function searchTable() {

            $criteria = new CDbCriteria;
    //        $criteria->select = 'no_rekam_medik, nobuktibayar, nama_pasien, ruangan_nama, kelaspelayanan_nama, totalsetoran, keterangan_closing ';
    //                .', \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir, ';
            $criteria = $this->functionCriteria();

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }
        
        public function searchLimit1() {

            $criteria = new CDbCriteria;
    //        $criteria->select = 'no_rekam_medik, nobuktibayar, nama_pasien, ruangan_nama, kelaspelayanan_nama, totalsetoran, keterangan_closing ';
    //                .', \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir, ';
            $criteria = $this->functionCriteria();
            $criteria->limit = 1;

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }
        
        public function searchTableDP() {

            $criteria = new CDbCriteria;
    //        $criteria->select = 'no_rekam_medik, nobuktibayar, nama_pasien, ruangan_nama, kelaspelayanan_nama, totalsetoran, keterangan_closing ';
    //                .', \''.$this->tgl_awal.'\' as tgl_awal, \''.$this->tgl_akhir.'\' as tgl_akhir, ';
            $criteria = $this->functionCriteriaDP();

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        public function searchPrint() {

            $criteria = new CDbCriteria;

            $criteria = $this->functionCriteria();

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination'=>false,    
                    ));
        }
        
        public function searchPrintDP() {

            $criteria = new CDbCriteria;

            $criteria = $this->functionCriteriaDP();

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination'=>false,    
                    ));
        }

        

        public function getTotalSetoran(){
            $criteria = new CDbCriteria;
            $criteria->select = 'SUM(totalbayartindakan) as totalbayartindakan';
            if(is_array($this->ruangankasir_id)){
                $criteria->addInCondition('ruangankasir_id', $this->ruangankasir_id);
            }else{
				if(!empty($this->ruangankasir_id)){
					$criteria->addCondition("ruangankasir_id = ".$this->ruangankasir_id);					
				}
            }
            if(!empty($this->shift_id)){
                if (is_array($this->shift_id)){
                    $criteria->addInCondition("shift_id",$this->shift_id);					
                }else{
                    $criteria->addCondition("shift_id = ".$this->shift_id);					
                }
            }
             if(!empty($this->kasir_id)){
                if (is_array($this->kasir_id)){
                    $criteria->addInCondition("kasir_id",$this->kasir_id);					
                }else{
                    $criteria->addCondition("kasir_id = ".$this->kasir_id);					
                }
            }
            
            
            $criteria->addBetweenCondition('DATE(tgl_closingkasir)', $this->tgl_awal, $this->tgl_akhir);
            $jumlah = BKLaporansetoranharianV::model()->find($criteria);
            if (isset($jumlah)){
                $jumlah = $jumlah->totalbayartindakan;
            } else {
                $jumlah = 0;
            }
            return $jumlah;
        }

        public function getTotalDP(){
            $criteria = new CDbCriteria;
            $criteria->select = 'SUM(pemakaianuangmuka) as pemakaianuangmuka';
            if(is_array($this->ruangankasir_id)){
                $criteria->addInCondition('ruangankasir_id', $this->ruangankasir_id);
            }else{
				if(!empty($this->ruangankasir_id)){
					$criteria->addCondition("ruangankasir_id = ".$this->ruangankasir_id);					
				}
            }
            if(!empty($this->shift_id)){
                if (is_array($this->shift_id)){
                    $criteria->addInCondition("shift_id",$this->shift_id);					
                }else{
                    $criteria->addCondition("shift_id = ".$this->shift_id);					
                }
            }
             if(!empty($this->kasir_id)){
                if (is_array($this->kasir_id)){
                    $criteria->addInCondition("kasir_id",$this->kasir_id);					
                }else{
                    $criteria->addCondition("kasir_id = ".$this->kasir_id);					
                }
            }
            
            $criteria->addBetweenCondition('DATE(tgl_closingkasir)', $this->tgl_awal, $this->tgl_akhir);
            $jumlah = BKLaporansetoranharianV::model()->find($criteria);
            if (isset($jumlah)){
                $jumlah = $jumlah->pemakaianuangmuka;
            } else {
                $jumlah = 0;
            }
            return $jumlah;
        }
	
}