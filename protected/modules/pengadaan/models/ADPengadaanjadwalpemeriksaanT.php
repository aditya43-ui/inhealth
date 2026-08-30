<?php
/**
* model yang digunakan untuk mengakses tabel Pengadaanjadwalpemeriksaan_t, pada modul pengadaan
* @package      application.modules.pengadaan
* @subpackage   models  
* @category     model
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @author       Aida Rahmawati<aidarahmawati@.com>
* @version     2.0.0
* @link      <http://piindonesia.co.id>
* @link      <http://172.9.1.15/simpp/docs/>
*/
class ADPengadaanjadwalpemeriksaanT extends PengadaanjadwalpemeriksaanT
{       
    public $supplier_nama, $tanggal_awal, $tanggal_akhir, $namapekerjaan;
    
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
     * Pencarian riwayat penjadwalan pemeriksaan
     * @return \CArrayDataProvider
     */
    public function searchRiwayat(){
        $cri = new CDbCriteria();//pegpemeriksa_id
        $cri->select = " t.*, det.pegpemeriksa_id,  CONCAT(peg.gelardepan,' ',peg.nama_pegawai,', ',glr.gelarbelakang_nama) as nama_lengkap, spk.nosuratperjanjiankerja ";
        $cri->join =  " JOIN suratperjanjiankerja_t spk ON spk.suratperjanjiankerja_id = t.suratperjanjiankerja_id "
                    . " JOIN pengadaanjadwalpemeriksaandet_t det ON det.pengadaanjadwalpemeriksaan_id = t.pengadaanjadwalpemeriksaan_id "
                    . " JOIN pegawai_m peg ON peg.pegawai_id = det.pegpemeriksa_id "
                    . " LEFT JOIN gelarbelakang_m glr ON glr.gelarbelakang_id = peg.gelarbelakang_id ";
        if (!empty($this->default)){
            $cri->addCondition(" t.pengadaanjadwalpemeriksaan_id IS NULL ");
        }
        
        if (!empty($this->suratperjanjiankerja_id)){
            $cri->addCondition("t.suratperjanjiankerja_id = ".$this->suratperjanjiankerja_id." ");
        }
        
        $cri->order = " pengadaanjadwalpemeriksaan_tanggal DESC ";
        $model = ADPengadaanjadwalpemeriksaanT::model()->findAll($cri);
        
        $data = array();
        
        foreach($model as $det){
            $data[$det->pengadaanjadwalpemeriksaan_id]['pengadaanjadwalpemeriksaan_id'] = $det->pengadaanjadwalpemeriksaan_id;
            $data[$det->pengadaanjadwalpemeriksaan_id]['nosuratperjanjiankerja'] = $det->nosuratperjanjiankerja;
            $data[$det->pengadaanjadwalpemeriksaan_id]['pengadaanjadwalpemeriksaan_tanggal'] = MyFormatter::formatDateTimeForUser($det->pengadaanjadwalpemeriksaan_tanggal);
            $data[$det->pengadaanjadwalpemeriksaan_id]['tanggal_pemeriksaan'] = MyFormatter::formatDateTimeForUser($det->tanggal_pemeriksaan);
            $data[$det->pengadaanjadwalpemeriksaan_id]['pengadaanjadwalpemeriksaan_status'] = $det->pengadaanjadwalpemeriksaan_status;
            $data[$det->pengadaanjadwalpemeriksaan_id]['pengadaanjadwalpemeriksaan_nomor'] = $det->pengadaanjadwalpemeriksaan_nomor;
            $data[$det->pengadaanjadwalpemeriksaan_id]['det_pemeriksa'][$det->pegpemeriksa_id]['namaLengkap'] = $det->nama_lengkap;
        }
        
        return new CArrayDataProvider($data, array(
                'keyField'=>'pengadaanjadwalpemeriksaan_id',			
                'id'=>'data_laporan',
                    'totalItemCount'=>count($data),
                    'pagination' => array(
                        'pageSize' => 10,
                        'pageVar' => 'page'
                    ),			
            ));      
    }
    
    /**
     * Load data informasi penjadwalan pemeriksaan
     * @return \CActiveDataProvider
     * @author Aida Rahmawati<aidarahmawati@.com>
     */
    public function searchInformasi(){
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->select = " t.*, spk.nosuratperjanjiankerja, sup.supplier_nama, spk.namapekerjaan";
        $criteria->join =  " JOIN suratperjanjiankerja_t spk ON spk.suratperjanjiankerja_id = t.suratperjanjiankerja_id "
                    . " LEFT JOIN supplier_m sup ON spk.supplier_id = sup.supplier_id ";
        $criteria->addBetweenCondition("DATE(t.pengadaanjadwalpemeriksaan_tanggal)", $this->tanggal_awal, $this->tanggal_akhir);
        $criteria->addCondition(" t.pengadaanjadwalpemeriksaan_id IS NOT NULL ");
        $criteria->compare('pengadaanjadwalpemeriksaan_status',$this->pengadaanjadwalpemeriksaan_status,true);
        $criteria->compare("LOWER(sup.supplier_nama)", strtolower($this->supplier_nama), true);
        $criteria->compare("LOWER(t.pengadaanjadwalpemeriksaan_nomor)", strtolower($this->pengadaanjadwalpemeriksaan_nomor), true);
        $criteria->compare("LOWER(spk.nosuratperjanjiankerja)", strtolower($this->nosuratperjanjiankerja), true);
        $criteria->compare("LOWER(spk.namapekerjaan)", strtolower($this->nama_pekerjaan), true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    /**
     * Load data cetak
     * @return \CActiveDataProvider
     * @author Aida Rahmawati<aidarahmawati@.com>
     */
    public function searchPrint(){
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->select = " t.*, spk.nosuratperjanjiankerja, sup.supplier_nama, spk.namapekerjaan";
        $criteria->join =  " JOIN suratperjanjiankerja_t spk ON spk.suratperjanjiankerja_id = t.suratperjanjiankerja_id "
                    . " LEFT JOIN supplier_m sup ON spk.supplier_id = sup.supplier_id ";
        $criteria->addBetweenCondition("DATE(t.pengadaanjadwalpemeriksaan_tanggal)", $this->tanggal_awal, $this->tanggal_akhir);
        $criteria->addCondition(" t.pengadaanjadwalpemeriksaan_id IS NOT NULL ");
        $criteria->compare('pengadaanjadwalpemeriksaan_status',$this->pengadaanjadwalpemeriksaan_status,true);
        $criteria->compare("LOWER(sup.supplier_nama)", strtolower($this->supplier_nama), true);
        $criteria->compare("LOWER(t.pengadaanjadwalpemeriksaan_nomor)", strtolower($this->pengadaanjadwalpemeriksaan_nomor), true);
        $criteria->compare("LOWER(spk.nosuratperjanjiankerja)", strtolower($this->nosuratperjanjiankerja), true);
        $criteria->compare("LOWER(spk.namapekerjaan)", strtolower($this->nama_pekerjaan), true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination' => false,
        ));
    }
}