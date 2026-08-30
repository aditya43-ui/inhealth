<?php

/**
 * This is the model class for table "laporantindaklanjut_v".
 *
 * The followings are the available columns in table 'laporantindaklanjut_v':
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
 * @property integer $pendaftaran_id
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
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $shift_id
 * @property string $no_rujukan
 * @property string $nama_perujuk
 * @property string $tanggal_rujukan
 * @property string $diagnosa_rujukan
 * @property integer $asalrujukan_id
 * @property string $asalrujukan_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property integer $pasienmorbiditas_id
 * @property integer $pasienpulang_id
 * @property string $carakeluar
 * @property string $kondisipulang
 * @property string $tglpasienpulang
 */
class RKLaporanpasienpulang extends LaporantindaklanjutV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporantindaklanjutV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = "namadepan, nama_pasien, no_rekam_medik, tglpasienpulang, ruangan_nama, carakeluar, kondisipulang";
        if (!empty($this->carakeluar)){
            if (is_array($this->carakeluar)){
                $criteria->addInCondition("carakeluar",$this->carakeluar);
            }
        }
        
        if (!empty($this->kondisipulang)){
            if (is_array($this->kondisipulang)){
                $criteria->addInCondition("kondisipulang",$this->kondisipulang);
            }
        }
        
        if (!empty($this->ruangan_id)){
            if (is_array($this->ruangan_id)){
                $criteria->addInCondition('ruangan_id', $this->ruangan_id);
            }            
        }else{
            if (!empty($this->instalasi_id)){
                if (is_array($this->instalasi_id)){
                    $criteria->addInCondition('instalasi_id', $this->instalasi_id);
                }else{
                    $criteria->addCondition('instalasi_id ='.$this->instalasi_id);
                }
            }
        }
        
        $criteria->addBetweenCondition('date(tglpasienpulang)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $criteria->addCondition('pasienpulang_id is not null');
        $criteria->group = "namadepan, nama_pasien, no_rekam_medik, tglpasienpulang, ruangan_nama, carakeluar, kondisipulang, pendaftaran_id";
        $criteria->order = "nama_pasien ASC";        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
	
	public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        //$criteria->select = "count(pasienpulang_id) as jumlah,namadepan, nama_pasien, no_rekam_medik, tglpasienpulang, ruangan_nama, carakeluar, kondisipulang as data";
        $criteria->select = "count(pasienpulang_id) as jumlah, carakeluar as data";
       if (!empty($this->carakeluar)){
            if (is_array($this->carakeluar)){
                $criteria->addInCondition("carakeluar",$this->carakeluar);
            }
        }
        
        if (!empty($this->kondisipulang)){
            if (is_array($this->kondisipulang)){
                $criteria->addInCondition("kondisipulang",$this->kondisipulang);
            }
        }

        
        

        $criteria->addBetweenCondition('tglpasienpulang', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        if (!empty($this->ruangan_id)){
            if (is_array($this->ruangan_id)){
                $criteria->addInCondition('ruangan_id', $this->ruangan_id);
            }            
        }else{
            if (!empty($this->instalasi_id)){
                $criteria->addCondition('instalasi_id ='.$this->instalasi_id);
            }
        }
        $criteria->addCondition('pasienpulang_id is not null');
        $criteria->group = 'carakeluar';
       // $criteria->group = "namadepan, nama_pasien, no_rekam_medik, tglpasienpulang, ruangan_nama, carakeluar, kondisipulang, pendaftaran_id";
       // $criteria->order = "nama_pasien ASC";
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = "namadepan, nama_pasien, no_rekam_medik, tglpasienpulang, ruangan_nama, carakeluar, kondisipulang";
        if (!empty($this->carakeluar)){
            if (is_array($this->carakeluar)){
                $criteria->addInCondition("carakeluar",$this->carakeluar);
            }
        }
        
        if (!empty($this->kondisipulang)){
            if (is_array($this->kondisipulang)){
                $criteria->addInCondition("kondisipulang",$this->kondisipulang);
            }
        }
        
        $criteria->addBetweenCondition('date(tglpasienpulang)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        if (!empty($this->ruangan_id)){
            if (is_array($this->ruangan_id)){
                $criteria->addInCondition('ruangan_id', $this->ruangan_id);
            }            
        }else{
            if (!empty($this->instalasi_id)){
                $criteria->addCondition('instalasi_id ='.$this->instalasi_id);
            }
        }
        $criteria->addCondition('pasienpulang_id is not null');
        $criteria->group = "namadepan, nama_pasien, no_rekam_medik, tglpasienpulang, ruangan_nama, carakeluar, kondisipulang,pendaftaran_id";
        $criteria->order = "nama_pasien ASC";
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                    'sort' => false,
                ));
    }
	
}