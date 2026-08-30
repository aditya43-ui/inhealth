<?php

class KULaporanjasainstalasiV extends LaporanjasainstalasiV {
    
    public $tgl_awal;
    public $tgl_akhir;
    public $jns_periode;
    public $bln_awal, $bln_akhir;
    public $thn_awal, $thn_akhir;
    public $subtotal;
    public $nama_pegawia;
	public $pegawai_id;
    public $tglpembayaran, $nopembayaran;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        $criteria = $this->functionCriteria();
		$criteria->order = " b.tglpembayaran ASC ";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        $criteria = $this->functionCriteria();
		$criteria->order = " b.tglpembayaran  ASC ";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }
    
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        $criteria = $this->functionCriteria();		
	
        if (isset($_GET['tampilGrafik'])) {
            if ($_GET['tampilGrafik'] == 'statusbayar'){
                $criteria->select = "count(t.pendaftaran_id) as jumlah, case when t.tindakansudahbayar_id is null then 'BELUM LUNAS' else 'LUNAS' end as data";
                $criteria->group = 'data';
            }elseif ($_GET['tampilGrafik'] == 'carabayar'){
                $criteria->select = "count(t.pendaftaran_id) as jumlah, t.carabayar_nama as data";
                $criteria->group = 'data';
            }elseif ($_GET['tampilGrafik'] == 'dokter'){
                $criteria->select = "count(t.pendaftaran_id) as jumlah, (CONCAT(p.gelardepan, ' ', p.nama_pegawai,' ',gb.gelarbelakang_nama) ) as data";
                $criteria->group = 'data';
            }elseif ($_GET['tampilGrafik'] == 'instalasi'){
                $criteria->select = "count(t.pendaftaran_id) as jumlah, t.instalasi_nama as data";
                $criteria->group = 'data';
            }
        } else {
            $criteria->select = "count(t.pendaftaran_id) as jumlah, t.instalasi_nama as data";
            $criteria->group = 'data';
        }
        $criteria->order = 'jumlah DESC';
      /*  if (!empty($this->carabayar_id)){
            $criteria->select .= ', t.penjamin_nama as tick';
            $criteria->group .= ', t.penjamin_nama';
        }else{
            $criteria->select .= ', t.carabayar_nama as tick';
            $criteria->group .= ', t.carabayar_nama';
        }*/

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    protected function functionCriteria(){
        $criteria = new CDbCriteria;
        $format = new MyFormatter();
        
//        $criteria->select = 'no_rekam_medik, nama_pasien,no_pendaftaran, kelaspelayanan_nama,daftartindakan_nama,
//                qty_tindakan, tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, 
//                case when daftartindakan_karcis = true then daftartindakan_nama end as karcisnama, 
//                case when daftartindakan_karcis = true then qty_tindakan else 0 end as karcisqty, 
//                case when daftartindakan_karcis = true then tarif_rsakomodasi else 0 end as karcisrs, 
//                case when daftartindakan_karcis = true then tarif_medis else 0 end as karcisMedis, 
//                tgl_pendaftaran, ruangan_id, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama';
        
        $criteria->group = "b.nopembayaran, b.tglpembayaran, t.no_rekam_medik, t.namadepan, t.nama_pasien, "
            . "t.carabayar_id, t.carabayar_nama, t.penjamin_id, t.penjamin_nama, t.instalasi_nama, t.instalasi_id,"
            . "t.ruangan_id, t.ruangan_nama, t.daftartindakan_id, t.daftartindakan_nama, t.tarif_satuan, t.tarif_tindakan";
        
        $criteria->select = $criteria->group.', sum(t.qty_tindakan) as qty_tindakan, '
            . 'sum(t.tarif_medis2) as tarif_medis, '
            . 'sum(t.tarif_paramedis2) as tarif_paramedis, '
            . 'sum(t.tarif_akomodasi2) as tarif_rsakomodasi, '
            . 'sum(t.tarif_bhp2) as tarif_bhp';
        
        
        $criteria->join = " JOIN tindakanpelayanan_t tp ON t.tindakanpelayanan_id = tp.tindakanpelayanan_id "
                        . " JOIN tindakansudahbayar_t tsb ON tsb.tindakanpelayanan_id = t.tindakanpelayanan_id "
                        . " join pembayaranpelayanan_t b on b.pembayaranpelayanan_id = tsb.pembayaranpelayanan_id ";
                        // . " left join tindakankomponen_t tk on tk.tindakanpelayanan_id = tp.tindakanpelayanan_id "
                        // . " left join persenkelkomponentarif_m pkl on pkl.komponentarif_id = tk.komponentarif_id";
        //$criteria->compare('LOWER(p.nama_pegawai)', strtolower($this->nama_pegawai), true);        
		$criteria->addBetweenCondition('DATE(b.tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);		
		
        
		
        $criteria->compare('t.penjamin_id', $this->penjamin_id);
        $criteria->compare('t.carabayar_id', $this->carabayar_id);
        $criteria->compare('t.instalasi_id', $this->instalasi_id);
        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        $criteria->compare('p.pegawai_id', $this->pegawai_id);
        
       /*
        if (is_array($this->tindakansudahbayar_id)){
            $status = array();
            foreach ($this->tindakansudahbayar_id as $i=>$v){                
                if ($v == true){
                    $status[] = 't.tindakansudahbayar_id is not null';
                }
                else{
                    $status[] = 't.tindakansudahbayar_id is null';
                }
            }
            $criteria->addCondition('('.implode(' OR ',$status).')');
            //$criteria->addCondition('tindakansudahbayar_id is null');
        }
         * 
         */
        // var_dump($criteria); die;
        
        return $criteria;
    }   
    
    
    
    public function getNamaModel(){
        return __CLASS__;
    }

}