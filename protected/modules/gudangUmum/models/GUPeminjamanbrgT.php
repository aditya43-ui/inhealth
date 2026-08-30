<?php
/** 
 * model ini digunakan untuk mengakses tabel peminjamanbrg_t, hanya di modul gudang umum saja
 *
 * @package      application.modules.gudangUmum
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Aida Rahmawati <aidarahmawati@.com>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class GUPeminjamanbrgT extends PeminjamanbrgT
{
    public $kelompok_nama, $tgl_awal, $tgl_akhir,
           $nama_pegawai, $ruangan_nama, $pengembali;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JeniskasuspenyakitM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
     * Load data informasi
     * @return \CActiveDataProvider
     */
    public function searchInformasi(){
        $criteria=new CDbCriteria;
        
        $criteria->select = 'peminjamanbrg_nomor, p.nama_pegawai, pegpengembali_id, '
                            . ' r.ruangan_nama, tanggal_awal, tanggal_akhir, peminjamanbrg_tanggal, '
                            . 'status_pengembalian, peminjamanbrg_keperluan, pengembalian_tanggal';
        $criteria->join = 'LEFT JOIN pegawai_m p ON t.pegpeminjam_id = p.pegawai_id '
                        . 'LEFT JOIN ruangan_m r ON t.ruangan_id = r.ruangan_id ';
        $criteria->group = 'peminjamanbrg_nomor, p.nama_pegawai, '
                            . 'r.ruangan_nama, tanggal_awal, tanggal_akhir, peminjamanbrg_tanggal, status_pengembalian, '
                            . 'peminjamanbrg_keperluan, pengembalian_tanggal, pegpengembali_id';
        $criteria->addBetweenCondition('DATE(t.peminjamanbrg_tanggal)', $this->tgl_awal, $this->tgl_akhir);     
        $criteria->compare("LOWER(p.nama_pegawai)", strtolower($this->pegpeminjam_nama),true);
        $criteria->compare("LOWER(r.ruangan_nama)", strtolower($this->ruangan_nama),true);
        $criteria->compare('peminjamanbrg_nomor',$this->peminjamanbrg_nomor,true);
        $criteria->compare('tanggal_awal',$this->tanggal_awal,true);
        $criteria->compare('tanggal_akhir',$this->tanggal_akhir,true);
        $criteria->compare('peminjamanbrg_tanggal',$this->peminjamanbrg_tanggal,true);
        $criteria->compare('status_pengembalian',$this->status_pengembalian,true);
        $criteria->compare('peminjamanbrg_keperluan',$this->peminjamanbrg_keperluan,true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    /**
     * Load data dialog peminjaman barang
     * @return \CActiveDataProvider
     */
    public function searchDialog(){
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('peminjamanbrg_id',$this->peminjamanbrg_id);
        $criteria->compare('peminjamanbrg_nomor',$this->peminjamanbrg_nomor,true);
        $criteria->compare('peminjamanbrg_tanggal',$this->peminjamanbrg_tanggal,true);
        $criteria->compare('pegpeminjam_id',$this->pegpeminjam_id);
        $criteria->compare('invperalatan_id',$this->invperalatan_id);
        $criteria->compare('ruangan_id',$this->ruangan_id);
        $criteria->compare('tanggal_awal',$this->tanggal_awal,true);
        $criteria->compare('tanggal_akhir',$this->tanggal_akhir,true);
        $criteria->compare('peminjamanbrg_keperluan',$this->peminjamanbrg_keperluan,true);
        $criteria->compare('pegpengembali_id',$this->pegpengembali_id);
        $criteria->compare('pengembalian_catatan',$this->pengembalian_catatan,true);
        $criteria->compare('pengembalian_tanggal',$this->pengembalian_tanggal,true);
        $criteria->compare('status_pengembalian',$this->status_pengembalian,true);
        $criteria->compare('create_time',$this->create_time,true);
        $criteria->compare('update_time',$this->update_time,true);
        $criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
        $criteria->compare('create_ruangan',$this->create_ruangan);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
            
}
?>
