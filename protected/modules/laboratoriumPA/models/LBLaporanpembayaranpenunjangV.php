<?php
class LBLaporanpembayaranpenunjangV extends LaporanpembayaranpenunjangV
{
        public $total,$totaldiscount,$totalsisatagihan,$totalbayartindakan,$administrasi,$nama_pasien,$jumlah,$totaluangmuka,$no_pendaftaran;
	public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchGrafik()
        {
            $criteria = new CDbCriteria();
            $criteria->join = " JOIN tindakanpelayanan_t tp ON tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
            $criteria->select = " COUNT(tp.tindakanpelayanan_id) AS jumlah, daftartindakan_nama as data ";
            $criteria->addBetweenCondition('t.tgl_tindakan', $this->tgl_awal, $this->tgl_akhir);
            $criteria->addCondition(" ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            $criteria->order =  " jumlah DESC ";
            $criteria->group = " daftartindakan_nama ";
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
            /*$format = new MyFormatter();
            
                        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
                        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
                        $cond = array(
                            "DATE(tindakanpelayanan_t.tgl_tindakan) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                            "pasienmasukpenunjang_t.ruangan_id = '".Params::RUANGAN_ID_LAB_KLINIK."'"
                        );//SUM(tindakanpelayanan_t.qty_tindakan*tindakanpelayanan_t.tarif_satuan) as total
                        $query = "
                            SELECT
                                    COUNT(tindakanpelayanan_t.daftartindakan_id) AS jumlah,
                                    daftartindakan_m.daftartindakan_nama AS data

                            FROM tindakanpelayanan_t
                            JOIN pasienmasukpenunjang_t ON tindakanpelayanan_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                            JOIN daftartindakan_m ON tindakanpelayanan_t.daftartindakan_id = daftartindakan_m.daftartindakan_id
                            JOIN tindakansudahbayar_t ON tindakanpelayanan_t.tindakansudahbayar_id = tindakansudahbayar_t.tindakansudahbayar_id
                            JOIN pembayaranpelayanan_t ON tindakansudahbayar_t.pembayaranpelayanan_id = pembayaranpelayanan_t.pembayaranpelayanan_id
                            JOIN loginpemakai_k ON pembayaranpelayanan_t.create_loginpemakai_id = loginpemakai_k.loginpemakai_id
                            JOIN pegawai_m ON loginpemakai_k.pegawai_id = pegawai_m.pegawai_id
                            ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."
                            GROUP BY daftartindakan_m.daftartindakan_nama
                            ORDER BY jumlah DESC
                        ";
                        $data = Yii::app()->db->createCommand($query)->queryAll();
                        return new CArrayDataProvider($data);*/
        }
        
        public function searchLaporanPembayaranPemeriksaan()
        {
            
            $format = new MyFormatter();
                    $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
                    $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        //            $criteria = new CDbCriteria;
        //
        //            $criteria = $this->functionCriteria();
        //
        //            return new CActiveDataProvider($this, array(
        //                        'criteria' => $criteria,
        //                    ));
                    $cond = array(
                        "DATE(a.tgl_tindakan) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                        "pasienmasukpenunjang_t.ruangan_id = '".Params::RUANGAN_ID_LAB_KLINIK."' ",
                        "pendaftaran_t.no_pendaftaran LIKE '%".$this->no_pendaftaran."'"
                    );
                    $cond2 = array(
                        "DATE(b.tgl_tindakan) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                        "pasienmasukpenunjang_t.ruangan_id = '".Params::RUANGAN_ID_LAB_KLINIK."' ",
                        "daftartindakan_m.daftartindakan_nama = 'Biaya Administrasi'",
                        "pendaftaran_t.no_pendaftaran LIKE '%".$this->no_pendaftaran."'",
                    );
                    $query = "
                        SELECT
                                pasien_m.pasien_id,pasien_m.nama_pasien, pasien_m.alamat_pasien,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran,
                                SUM(a.qty_tindakan*a.tarif_satuan) as total,
                                SUM(tindakansudahbayar_t.jmlbayar_tindakan) as totalbayartindakan,
                                SUM(a.discount_tindakan) as totaldiscount,
                                SUM(tindakansudahbayar_t.jmlsisabayar_tindakan) as totalsisatagihan,pegawai_m.nama_pegawai,
                                SUM(bayaruangmuka_t.jumlahuangmuka) as totaluangmuka,
                                (SELECT 
                                        SUM(b.qty_tindakan * b.tarif_satuan) as administrasi 
                                    FROM tindakanpelayanan_t b 
                                    LEFT JOIN pasienmasukpenunjang_t ON b.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                                    LEFT JOIN pasien_m ON b.pasien_id = pasien_m.pasien_id
                                    LEFT JOIN pendaftaran_t ON b.pendaftaran_id = pendaftaran_t.pendaftaran_id
                                    LEFT JOIN daftartindakan_m ON b.daftartindakan_id = daftartindakan_m.daftartindakan_id
                                    LEFT JOIN tindakansudahbayar_t ON b.tindakansudahbayar_id = tindakansudahbayar_t.tindakansudahbayar_id
                                    LEFT JOIN pembayaranpelayanan_t ON tindakansudahbayar_t.pembayaranpelayanan_id = pembayaranpelayanan_t.pembayaranpelayanan_id
                                    LEFT JOIN loginpemakai_k ON pembayaranpelayanan_t.create_loginpemakai_id = loginpemakai_k.loginpemakai_id
                                    LEFT JOIN tandabuktibayar_t ON pembayaranpelayanan_t.tandabuktibayar_id = tandabuktibayar_t.tandabuktibayar_id
                                    LEFT JOIN bayaruangmuka_t ON tandabuktibayar_t.bayaruangmuka_id = bayaruangmuka_t.bayaruangmuka_id
                                    JOIN pegawai_m ON loginpemakai_k.pegawai_id = pegawai_m.pegawai_id
                                    ". (count($cond2) > 0 ? " WHERE " . implode(" AND ", $cond2) : "" ) ."
                                    GROUP BY pasien_m.pasien_id,pegawai_m.nama_pegawai,pasien_m.nama_pasien,pasien_m.alamat_pasien,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran) as administrasi

                        FROM tindakanpelayanan_t a
                        LEFT JOIN pasienmasukpenunjang_t ON a.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                        LEFT JOIN pasien_m ON a.pasien_id = pasien_m.pasien_id
                        LEFT JOIN pendaftaran_t ON a.pendaftaran_id = pendaftaran_t.pendaftaran_id
                        LEFT JOIN daftartindakan_m ON a.daftartindakan_id = daftartindakan_m.daftartindakan_id
                        LEFT JOIN tindakansudahbayar_t ON a.tindakansudahbayar_id = tindakansudahbayar_t.tindakansudahbayar_id
                        LEFT JOIN pembayaranpelayanan_t ON tindakansudahbayar_t.pembayaranpelayanan_id = pembayaranpelayanan_t.pembayaranpelayanan_id
                        LEFT JOIN loginpemakai_k ON pembayaranpelayanan_t.create_loginpemakai_id = loginpemakai_k.loginpemakai_id
                        LEFT JOIN tandabuktibayar_t ON pembayaranpelayanan_t.tandabuktibayar_id = tandabuktibayar_t.tandabuktibayar_id
                        LEFT JOIN bayaruangmuka_t ON tandabuktibayar_t.bayaruangmuka_id = bayaruangmuka_t.bayaruangmuka_id
                        JOIN pegawai_m ON loginpemakai_k.pegawai_id = pegawai_m.pegawai_id
                        ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."
                        GROUP BY pasien_m.pasien_id,pegawai_m.nama_pegawai,pasien_m.nama_pasien,pasien_m.alamat_pasien,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran
                    ";
                    $data = Yii::app()->db->createCommand($query)->queryAll();
                    return new CArrayDataProvider($data);
        }
        
        public function searchPrintLaporanPembayaranPemeriksaan()
        {
            $format = new MyFormatter();
            $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
            
//            $criteria = new CDbCriteria;
//
//            $criteria = $this->functionCriteria();
//
//            return new CActiveDataProvider($this, array(
//                        'criteria' => $criteria,
//                    ));
             $cond = array(
                "DATE(a.tgl_tindakan) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                "pasienmasukpenunjang_t.ruangan_id = 18"
            );
            $cond2 = array(
                "DATE(b.tgl_tindakan) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                "pasienmasukpenunjang_t.ruangan_id = 18",
                "daftartindakan_m.daftartindakan_nama = 'Biaya Administrasi'"
            );
            $count ="SELECT count(tindakanpelayanan_t.pendaftaran_id) as pendaftaran_id FROM tindakanpelayanan_t";
//            CASE daftartindakan_m.daftartindakan_nama
//                           WHEN 'Biaya Administrasi' THEN SUM(tindakanpelayanan_t.qty_tindakan*tindakanpelayanan_t.tarif_satuan) END AS administrasi
            $dataCount = Yii::app()->db->createCommand($count)->queryAll();
            $query = "
                SELECT
                        pasien_m.pasien_id,pasien_m.nama_pasien, pasien_m.alamat_pasien,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran,
                        SUM(a.qty_tindakan*a.tarif_satuan) as total,
                        SUM(tindakansudahbayar_t.jmlbayar_tindakan) as totalbayartindakan,
                        SUM(a.discount_tindakan) as totaldiscount,
                        SUM(tindakansudahbayar_t.jmlsisabayar_tindakan) as totalsisatagihan,pegawai_m.nama_pegawai,
                        SUM(bayaruangmuka_t.jumlahuangmuka) as totaluangmuka,
                        (SELECT 
                                SUM(b.qty_tindakan * b.tarif_satuan) as administrasi 
                            FROM tindakanpelayanan_t b 
                            LEFT JOIN pasienmasukpenunjang_t ON b.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                            LEFT JOIN pasien_m ON b.pasien_id = pasien_m.pasien_id
                            LEFT JOIN pendaftaran_t ON b.pendaftaran_id = pendaftaran_t.pendaftaran_id
                            LEFT JOIN daftartindakan_m ON b.daftartindakan_id = daftartindakan_m.daftartindakan_id
                            LEFT JOIN tindakansudahbayar_t ON b.tindakansudahbayar_id = tindakansudahbayar_t.tindakansudahbayar_id
                            LEFT JOIN pembayaranpelayanan_t ON tindakansudahbayar_t.pembayaranpelayanan_id = pembayaranpelayanan_t.pembayaranpelayanan_id
                            LEFT JOIN loginpemakai_k ON pembayaranpelayanan_t.create_loginpemakai_id = loginpemakai_k.loginpemakai_id
                            LEFT JOIN tandabuktibayar_t ON pembayaranpelayanan_t.tandabuktibayar_id = tandabuktibayar_t.tandabuktibayar_id
                            LEFT JOIN bayaruangmuka_t ON tandabuktibayar_t.bayaruangmuka_id = bayaruangmuka_t.bayaruangmuka_id
                            JOIN pegawai_m ON loginpemakai_k.pegawai_id = pegawai_m.pegawai_id
                            ". (count($cond2) > 0 ? " WHERE " . implode(" AND ", $cond2) : "" ) ."
                            GROUP BY pasien_m.pasien_id,pegawai_m.nama_pegawai,pasien_m.nama_pasien,pasien_m.alamat_pasien,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran) as administrasi
                                
                FROM tindakanpelayanan_t a
                LEFT JOIN pasienmasukpenunjang_t ON a.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                LEFT JOIN pasien_m ON a.pasien_id = pasien_m.pasien_id
                LEFT JOIN pendaftaran_t ON a.pendaftaran_id = pendaftaran_t.pendaftaran_id
                LEFT JOIN daftartindakan_m ON a.daftartindakan_id = daftartindakan_m.daftartindakan_id
                LEFT JOIN tindakansudahbayar_t ON a.tindakansudahbayar_id = tindakansudahbayar_t.tindakansudahbayar_id
                LEFT JOIN pembayaranpelayanan_t ON tindakansudahbayar_t.pembayaranpelayanan_id = pembayaranpelayanan_t.pembayaranpelayanan_id
                LEFT JOIN loginpemakai_k ON pembayaranpelayanan_t.create_loginpemakai_id = loginpemakai_k.loginpemakai_id
                LEFT JOIN tandabuktibayar_t ON pembayaranpelayanan_t.tandabuktibayar_id = tandabuktibayar_t.tandabuktibayar_id
                LEFT JOIN bayaruangmuka_t ON tandabuktibayar_t.bayaruangmuka_id = bayaruangmuka_t.bayaruangmuka_id
                JOIN pegawai_m ON loginpemakai_k.pegawai_id = pegawai_m.pegawai_id
                ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."
                GROUP BY pasien_m.pasien_id,pegawai_m.nama_pegawai,pasien_m.nama_pasien,pasien_m.alamat_pasien,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran
            ";
            $data = Yii::app()->db->createCommand($query)->queryAll();
            return new CArrayDataProvider($data,array('pagination'=>false));
        }

        public function searchTableLaporan()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteria();
            $criteria->order ='t.tgl_pendaftaran ASC';

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        public function searchPrintLaporan() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;

            $criteria = $this->functionCriteria();
            $criteria->order ='t.tgl_pendaftaran ASC';

            return new CActiveDataProvider($this, array(
                        'pagination' => false,
                        'criteria' => $criteria,
                    ));
        }

        protected function functionCriteria() {
            $criteria = new CDbCriteria();
            $format = new MyFormatter();
            $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
            
            if($this->daftartindakan_nama == 'Biaya Administrasi'){
                $adm = 'Biaya Administrasi';
                $criteria->select = 't.pasien_id,t.nama_pasien,t.pendaftaran_id,t.alamat_pasien,t.tgl_pendaftaran,t.no_pendaftaran,pegawai_m.nama_pegawai,
                                sum(t.tarif_satuan * t.qty_tindakan) as administrasi,
                                sum(t.totaldiscount) as totaldiscount,
                                sum(t.totalsisatagihan) as totalsisatagihan,
                                sum(t.totalbayartindakan) as totalbayartindakan,
                                CASE daftartindakan_m.daftartindakan_nama
                               WHEN "Biaya Administrasi" THEN SUM(tindakanpelayanan_t.qty_tindakan*tindakanpelayanan_t.tarif_satuan) END AS administrasi';
                $criteria->compare('LOWER(daftartindakan_nama)',strtolower($adm));
            }
            $criteria->select = 't.pasien_id,t.nama_pasien,t.pendaftaran_id,t.alamat_pasien,t.tgl_pendaftaran,t.no_pendaftaran,pegawai_m.nama_pegawai,
                                sum(t.tarif_satuan * t.qty_tindakan) as total,
                                sum(t.totaldiscount) as totaldiscount,
                                sum(t.totalsisatagihan) as totalsisatagihan,
                                sum(t.totalbayartindakan) as totalbayartindakan';
            $criteria->group = 't.pasien_id,t.nama_pasien,t.pendaftaran_id,t.alamat_pasien,t.tgl_pendaftaran,t.no_pendaftaran,pegawai_m.nama_pegawai';
            $criteria->addBetweenCondition('DATE(tindakanpelayanan_t.tgl_tindakan)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->addCondition('tindakanpelayanan_t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            $criteria->join = 'JOIN tindakanpelayanan_t on t.tindakanpelayanan_id = tindakanpelayanan_t.tindakanpelayanan_id
                               JOIN daftartindakan_m on tindakanpelayanan_t.daftartindakan_id = daftartindakan_m.daftartindakan_id
                               JOIN pasienmasukpenunjang_t on tindakanpelayanan_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                               JOIN tindakansudahbayar_t on tindakanpelayanan_t.tindakansudahbayar_id = tindakansudahbayar_t.tindakansudahbayar_id
                               JOIN pembayaranpelayanan_t on tindakansudahbayar_t.pembayaranpelayanan_id = pembayaranpelayanan_t.pembayaranpelayanan_id
                               JOIN loginpemakai_k ON pembayaranpelayanan_t.create_loginpemakai_id = loginpemakai_k.loginpemakai_id
                               JOIN pegawai_m ON loginpemakai_k.pegawai_id = pegawai_m.pegawai_id
                              ';

            return $criteria;
        } 
        
        public function getTotal()
        {
            return $this->tarif_satuan * $this->qty_tindakan;
        }  
        
}
?>