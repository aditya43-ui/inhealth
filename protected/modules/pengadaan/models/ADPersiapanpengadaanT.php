<?php
/**
* model yang digunakan untuk mengakses tabel Persiapanpengadaan_t, pada modul pengadaan
* @package      application.modules.pengadaan
* @subpackage   models  
* @category     model
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @author      Aida Rahmawati <aidarahmawati@.com>
* @version     2.0.0
* @link      <http://piindonesia.co.id>
* @link      <http://172.9.1.15/simpp/docs/>
*/
class ADPersiapanpengadaanT extends PersiapanpengadaanT
{
    public $tgl_awal , $tgl_akhir , $instalasi_nama,$rencanaumumpengadaan_kategori,
            $program_nama,
            $rencanaumumpengadaan_nomor,$jenispengadaan_id,$nama_pekerjaan, $total_pagu, $pemanfaatan, $pelaksanaanKontrak, $pemilihanPenyedia;
    /**
     * untuk mengenerate fungsi - fungsi active provider yii
     * @param type $className
     * @return type
     */    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }    
    
    /**
     * digunakan untuk menampilkan data informasi persiapan pengadaan
     * @return \CActiveDataProvider
     */
    public function searchInformasi()
    {
        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('DATE(t.persiapanpengadaan_tanggal)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(instalasi.instalasi_nama)',strtolower($this->instalasi_nama),true);
        $criteria->compare('LOWER(t.persiapanpengadaan_nomor)',strtolower($this->persiapanpengadaan_nomor),true);
        $criteria->compare('LOWER(rencana.rencanaumumpengadaan_nomor)',strtolower($this->rencanaumumpengadaan_nomor),true);
        $criteria->compare('LOWER(t.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
        $criteria->compare('LOWER(rencana.rencanaumumpengadaan_kategori)',strtolower($this->rencanaumumpengadaan_kategori),true);
        $criteria->compare('LOWER(t.swakelola_tipe)',strtolower($this->swakelola_tipe),true);
        $criteria->compare('LOWER(t.persiapanpengadaan_status)',strtolower($this->persiapanpengadaan_status),true);
        if(!empty($this->periodeanggaran_id)){
            $criteria->addCondition('t.periodeanggaran_id ='.$this->periodeanggaran_id);
        }
        if(!empty($this->metodepengadaan_id)){
            $criteria->addCondition('t.metodepengadaan_id ='.$this->metodepengadaan_id);
        }
        if(!empty($this->jenispengadaan_id)){
            $criteria->addCondition('jenis.jenispengadaan_id ='.$this->jenispengadaan_id);
        }
        $criteria->select = 't.*,t.persiapanpengadaan_id,'
                            .'rencana.rencanaumumpengadaan_nomor,rencana.rencanaumumpengadaan_id,'
                            . 'rencana.rencanaumumpengadaan_kategori,rencana.total_pagu,rencana.nama_pekerjaan,'
                            .'jenis.jenispengadaan_id,'
                            . 'instalasi.instalasi_nama';
        $criteria->join = ' LEFT JOIN instalasi_m as instalasi ON t.instalasi_id=instalasi.instalasi_id '
                         .' LEFT JOIN rencanaumumpengadaan_t as rencana ON t.rencanaumumpengadaan_id=rencana.rencanaumumpengadaan_id '
                         . ' LEFT JOIN pengadaanjenis_t as pengadaanjenis ON rencana.rencanaumumpengadaan_id=pengadaanjenis.rencanaumumpengadaan_id '
                         .' LEFT JOIN jenispengadaan_m as jenis ON pengadaanjenis.jenispengadaan_id=jenis.jenispengadaan_id ';
        $criteria->group = $criteria->select;
        $criteria->limit=10;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    /**
     * digunakan untuk mencetak data informasi persiapan pengadaan
     * @return \CActiveDataProvider
     */
    public function searchInformasiPrint()
    {
        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('DATE(t.persiapanpengadaan_tanggal)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(instalasi.instalasi_nama)',strtolower($this->instalasi_nama),true);
        $criteria->compare('LOWER(t.persiapanpengadaan_nomor)',strtolower($this->persiapanpengadaan_nomor),true);
        $criteria->compare('LOWER(rencana.rencanaumumpengadaan_nomor)',strtolower($this->rencanaumumpengadaan_nomor),true);
        $criteria->compare('LOWER(t.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
        $criteria->compare('LOWER(rencana.rencanaumumpengadaan_kategori)',strtolower($this->rencanaumumpengadaan_kategori),true);
        $criteria->compare('LOWER(t.swakelola_tipe)',strtolower($this->swakelola_tipe),true);
        $criteria->compare('LOWER(t.persiapanpengadaan_status)',strtolower($this->persiapanpengadaan_status),true);
        if(!empty($this->periodeanggaran_id)){
            $criteria->addCondition('t.periodeanggaran_id ='.$this->periodeanggaran_id);
        }
        if(!empty($this->metodepengadaan_id)){
            $criteria->addCondition('t.metodepengadaan_id ='.$this->metodepengadaan_id);
        }
        if(!empty($this->jenispengadaan_id)){
            $criteria->addCondition('jenis.jenispengadaan_id ='.$this->jenispengadaan_id);
        }
        $criteria->select = 't.*,t.persiapanpengadaan_id,'
                            .'rencana.rencanaumumpengadaan_nomor,rencana.rencanaumumpengadaan_id,'
                            . 'rencana.rencanaumumpengadaan_kategori,rencana.total_pagu,rencana.nama_pekerjaan,'
                            .'jenis.jenispengadaan_id,'
                            . 'instalasi.instalasi_nama';
        $criteria->join = ' LEFT JOIN instalasi_m as instalasi ON t.instalasi_id=instalasi.instalasi_id '
                         .' LEFT JOIN rencanaumumpengadaan_t as rencana ON t.rencanaumumpengadaan_id=rencana.rencanaumumpengadaan_id '
                         . ' LEFT JOIN pengadaanjenis_t as pengadaanjenis ON rencana.rencanaumumpengadaan_id=pengadaanjenis.rencanaumumpengadaan_id '
                         .' LEFT JOIN jenispengadaan_m as jenis ON pengadaanjenis.jenispengadaan_id=jenis.jenispengadaan_id ';
        $criteria->group = $criteria->select;
        $criteria->limit=-1;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
    
    /**
     * Load data untuk Informasi Pengadaan bagi Penyedia
     * @return \CActiveDataProvider
     */
    public function searchInformasiPengadaanPenyedia(){
        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('DATE(t.diumumkan_tanggal)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(t.persiapanpengadaan_nomor)',strtolower($this->persiapanpengadaan_nomor),true);
        $criteria->compare('LOWER(rencana.rencanaumumpengadaan_nomor)',strtolower($this->rencanaumumpengadaan_nomor),true);
        $criteria->compare('LOWER(rencana.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
        
        $criteria->addCondition(" t.persiapanpengadaan_status = '".Params::VERIFIKASI_DISETUJUI."'");
        $criteria->addCondition("t.isumumkanpengadaan IS TRUE");
        $criteria->select = 't.*,t.persiapanpengadaan_id,'
                            .'rencana.rencanaumumpengadaan_nomor,rencana.rencanaumumpengadaan_id,'
                            . 'rencana.rencanaumumpengadaan_kategori,rencana.total_pagu,rencana.nama_pekerjaan,'
                            .'jenis.jenispengadaan_id,'
                            . 'instalasi.instalasi_nama';
        $criteria->join = ' LEFT JOIN instalasi_m as instalasi ON t.instalasi_id=instalasi.instalasi_id '
                         .' LEFT JOIN rencanaumumpengadaan_t as rencana ON t.rencanaumumpengadaan_id=rencana.rencanaumumpengadaan_id '
                         . ' LEFT JOIN pengadaanjenis_t as pengadaanjenis ON rencana.rencanaumumpengadaan_id=pengadaanjenis.rencanaumumpengadaan_id '
                         .' LEFT JOIN jenispengadaan_m as jenis ON pengadaanjenis.jenispengadaan_id=jenis.jenispengadaan_id ';
        $criteria->group = $criteria->select;
        $criteria->limit=10;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    /**
     * Load data untuk Informasi Pengadaan Lelang
     * @return \CActiveDataProvider
     */
    public function searchInformasiPengadaanLelang()
    {
        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('DATE(t.persiapanpengadaan_tanggal)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(t.persiapanpengadaan_nomor)',strtolower($this->persiapanpengadaan_nomor),true);
        $criteria->compare('LOWER(t.nama_pekerjaan)',strtolower($this->nama_pekerjaan),true);
        $criteria->compare('LOWER(t.swakelola_tipe)',strtolower($this->swakelola_tipe),true);
        $criteria->compare('LOWER(t.persiapanpengadaan_status)',strtolower($this->persiapanpengadaan_status),true);

        $criteria->select = 't.*,t.persiapanpengadaan_id,'
                            .'rencana.rencanaumumpengadaan_nomor,rencana.rencanaumumpengadaan_id,'
                            . 'rencana.rencanaumumpengadaan_kategori,rencana.total_pagu,rencana.nama_pekerjaan';
        $criteria->join = ' LEFT JOIN rencanaumumpengadaan_t as rencana ON t.rencanaumumpengadaan_id=rencana.rencanaumumpengadaan_id ';
        $criteria->group = $criteria->select;
        $criteria->limit=10;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}