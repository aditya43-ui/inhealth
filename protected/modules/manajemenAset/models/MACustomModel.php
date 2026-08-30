<?php
/**
 * custom model, tidak mengambil data dari tabel tertentu
 * issue RSST-22271
 * @package application.modules.manajemenAset
 * @subpackage models  
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 */
class MACustomModel extends CFormModel
{	
    public $periodeasetopname_id;
    
    public function rules()
    {
        return array(
            array('periodeasetopname_id','safe')
        );
    }

    /**
     * menambahkan label pada attibutenya
     * @return type
     */
    public function attributeLabels()
    {
        return array(

        );
    }
    
    /**
     * untuk mengenerate data grafik
     */
    public function generateDashboardAsetOpname(){
        
        $periode = PeriodeasetopnameK::model()->findByPk($this->periodeasetopname_id);               
                            
        $sql = " 
                SELECT
                    COUNT(invperalatan_id) as jumlah
                FROM  invperalatan_t                
                WHERE tglpenghapusan IS NULL AND create_time < '".$periode->tanggal_awal."'                    
               ";        
        $tileTerInven = Yii::app()->db->createCommand($sql)->queryRow();
        
        $sql = " 
                SELECT
                    COUNT(invperalatan_id) as jumlah
                FROM  asetopname_t                
                WHERE periodeasetopname_id = ".$periode->periodeasetopname_id."
               ";        
        $tileSudahOp = Yii::app()->db->createCommand($sql)->queryRow();
                
        $sql = " 
                SELECT
                    COUNT(invperalatan_id) as jumlah
                FROM  invperalatan_t                
                WHERE create_time BETWEEN '".$periode->tanggal_awal."' AND '".$periode->tanggal_akhir."'
               ";        
        $tileTerInvenBlm = Yii::app()->db->createCommand($sql)->queryRow();
                
        $data['tile']['teriventarisasi'] = MyFormatter::formatNumberForPrint($tileTerInven['jumlah']);
        $data['tile']['sudah_opname'] = MyFormatter::formatNumberForPrint($tileSudahOp['jumlah']);
        $data['tile']['belum_opname'] = MyFormatter::formatNumberForPrint($tileTerInven['jumlah'] - $tileSudahOp['jumlah']);
        $data['tile']['teriventarisasi_baru'] = MyFormatter::formatNumberForPrint($tileTerInvenBlm['jumlah']);
        
        
        /**GRAFIK**/
        $sql = " 
                SELECT
                    SUM(inv.invperalatan_harga) as jumlah,
                    lok.lokasiaset_namalokasi as lokasi                  
                FROM  asetopname_t t
                JOIN invperalatan_t inv ON inv.invperalatan_id = t.invperalatan_id 
                JOIN lokasiaset_m lok ON lok.lokasi_id = t.lokasi_id 
                WHERE periodeasetopname_id = ".$periode->periodeasetopname_id." 
                GROUP BY lok.lokasiaset_namalokasi 
                ORDER BY jumlah DESC  LIMIT 10
                    
               ";        
        $aset_terbanyak = Yii::app()->db->createCommand($sql)->queryAll();
        
        $bar_10_aset_terbesar = [];
                
        $i = 0;
        foreach($aset_terbanyak as $det){
            $init = $det['lokasi'];
            $bar_10_aset_terbesar['labels'][] = $det['lokasi'];                
            $bar_10_aset_terbesar['datasets'][0]['data'][] = $det['jumlah'];                
            $bar_10_aset_terbesar['datasets'][0]['backgroundColor'][] = $this->setColor($i); 
            $bar_10_aset_terbesar['datasets'][0]['label'] = $init;                 
            $i++;
        }   
        
        $sql = " 
                SELECT
                    count(inv.invperalatan_id) as jumlah,
                    lok.lokasiaset_namalokasi as lokasi                   
                FROM  asetopname_t t
                JOIN invperalatan_t inv ON inv.invperalatan_id = t.invperalatan_id 
                JOIN lokasiaset_m lok ON lok.lokasi_id = t.lokasi_id 
                WHERE periodeasetopname_id = ".$periode->periodeasetopname_id." 
                GROUP BY lok.lokasiaset_namalokasi 
                ORDER BY jumlah DESC  LIMIT 10
               ";        
        $aset_jumlah_terbanyak = Yii::app()->db->createCommand($sql)->queryAll();
        
        $bar_10_aset_jumlah_terbanyak = [];
        $i = 0;
        foreach($aset_jumlah_terbanyak as  $det){
            $init = $det['lokasi'];            
            $bar_10_aset_jumlah_terbanyak['labels'][] = $det['lokasi'];                
            $bar_10_aset_jumlah_terbanyak['datasets'][0]['data'][] = $det['jumlah'];                
            $bar_10_aset_jumlah_terbanyak['datasets'][0]['backgroundColor'][] = $this->setColor($i); 
            $bar_10_aset_jumlah_terbanyak['datasets'][0]['label'][] = $init;                 
            $i++;
        }   
        
        $sql = " 
                SELECT
                    count(inv.invperalatan_id) as jumlah,
                    t.kondisi as kondisi                  
                FROM  asetopname_t t
                JOIN invperalatan_t inv ON inv.invperalatan_id = t.invperalatan_id 
                WHERE periodeasetopname_id = ".$periode->periodeasetopname_id." 
                GROUP BY t.kondisi 
                ORDER BY jumlah DESC  LIMIT 10
               ";        
        $hasil_opname = Yii::app()->db->createCommand($sql)->queryAll();
        
        $i = 0;
        $pie_kondisi = [];
        
        foreach($hasil_opname as $det){
            $init = $det['kondisi'];
            $pie_kondisi['labels'][] = $init;    
            $pie_kondisi['datasets'][0]['data'][] = $det['jumlah'];                
            $pie_kondisi['datasets'][0]['backgroundColor'][] = $this->setColor($i); 
            $pie_kondisi['datasets'][0]['label'][] = $init;                 
            $i++;
        }  

        $data['grafik']['aset_terbanyak'] = $bar_10_aset_terbesar;
        $data['grafik']['jumlah_aset_terbanyak'] = $bar_10_aset_jumlah_terbanyak;
        $data['grafik']['hasil_aset'] = $pie_kondisi;                       
        
        return $data;
        
    }        
    
    public function setColor($i){
        $color = [
            '#01b8aa',//ijo
            '#c49e6d',//orange
            '#fd625e',//pink
            '#eed771',//gold
            '#8bd4eb',//blue sky,
            '#f09293',//pink terang
            '#31ce3c',//hijau gelap
            '#a0994e',//coklat
            '#96bf3f',//kuning kehijaun
            '#d1c8c8',//menuju putih
        ];
        return isset($color[$i])?$color[$i]:'red';
    }
    
     /**
     * untuk mengenerate data grafik
     */
    public function generateDashboardPemeliharaanAset(){
        
        $grafik  = [];
        
        $sql = " 
                SELECT
                    COUNT(invperalatan_id) as jumlah
                FROM invperalatan_t t
                JOIN barang_m b ON b.barang_id = t.barang_id 
                WHERE tglpenghapusan IS NULL AND b.barang_kategori ilike '". ParamsConst::BARANG_KATEGORI_MEDIS."' 
               ";        
        $tile_jml_alatmedis = Yii::app()->db->createCommand($sql)->queryRow();
        
        $sql = " 
                SELECT
                    COUNT(invperalatan_id) as jumlah
                FROM invperalatan_t t
                JOIN barang_m b ON b.barang_id = t.barang_id 
                WHERE tglpenghapusan IS NULL AND b.barang_kategori ilike '".ParamsConst::BARANG_KATEGORI_NON_MEDIS."' 
               ";        
        $tile_jml_alatnonmedis = Yii::app()->db->createCommand($sql)->queryRow();
        
        $sql = " 
                SELECT
                    COUNT(invperalatan_id) as jumlah
                FROM invperalatan_t t
                JOIN barang_m b ON b.barang_id = t.barang_id 
                WHERE tglpenghapusan IS NULL AND b.barang_kalibrasi = true 
               ";        
        $tile_jml_bisakalibrasi = Yii::app()->db->createCommand($sql)->queryRow();
        
        $sql = " 
                SELECT
                    COUNT(t.invperalatan_id) as jumlah
                FROM invperalatan_t t
                JOIN invkalibarasi_t b ON b.invperalatan_id = t.invperalatan_id 
                WHERE date_part('year',b.tglkalibrasi) = '".date('Y')."'
               ";        
        $tile_jml_sudahkalibrasi = Yii::app()->db->createCommand($sql)->queryRow();
        
        $sql = " 
                SELECT
                    COUNT(t.invperalatan_id) as jumlah
                FROM invperalatan_t t
                JOIN workorder_t k ON k.invperalatan_id = t.invperalatan_id 
                WHERE date_part('year',k.workorder_tgl) = '".date('Y')."'
               ";        
        $tile_jml_preventive = Yii::app()->db->createCommand($sql)->queryRow();
        
        $sql = " 
                SELECT
                    COUNT(t.invperalatan_id) as jumlah
                FROM invperalatan_t t
                JOIN korektifmainten_t k ON k.invperalatan_id = t.invperalatan_id 
                WHERE date_part('year',k.korektifmainten_tgl) = '".date('Y')."'
               ";        
        $tile_jml_corrective = Yii::app()->db->createCommand($sql)->queryRow();
                
                
        $data['tile']['jml_alatmedis'] = MyFormatter::formatNumberForPrint($tile_jml_alatmedis['jumlah']);        
        $data['tile']['jml_alatnonmedis'] = MyFormatter::formatNumberForPrint($tile_jml_alatnonmedis['jumlah']);        
        $data['tile']['jml_bisakalibrasi'] = MyFormatter::formatNumberForPrint($tile_jml_bisakalibrasi['jumlah']);        
        $data['tile']['jml_sudahkalibrasi'] = MyFormatter::formatNumberForPrint($tile_jml_sudahkalibrasi['jumlah']);        
        $data['tile']['jml_belumkalibrasi'] = MyFormatter::formatNumberForPrint($tile_jml_bisakalibrasi['jumlah']-$tile_jml_sudahkalibrasi['jumlah']);        
        $data['tile']['jml_preventive'] = MyFormatter::formatNumberForPrint($tile_jml_preventive['jumlah']);        
        $data['tile']['jml_corrective'] = MyFormatter::formatNumberForPrint($tile_jml_corrective['jumlah']);
        
        
        /**GRAFIK**/
        $sql = " 
                SELECT
                    COUNT(t.invperalatan_id) as jumlah,
                    t.invperalatan_keadaan as kondisi                  
                FROM  invperalatan_t t       
                WHERE t.tglpenghapusan IS NULL
                GROUP BY t.invperalatan_keadaan 
                ORDER BY jumlah DESC  
                    
               ";        
        $peralatan_kondisi = Yii::app()->db->createCommand($sql)->queryAll();
        
               
        $i = 0;
        foreach($peralatan_kondisi as $det){
            $init = $det['kondisi'];
            $grafik['peralatan_kondisi']['labels'][] = $det['kondisi'];                
            $grafik['peralatan_kondisi']['datasets'][0]['data'][] = $det['jumlah'];                
            $grafik['peralatan_kondisi']['datasets'][0]['backgroundColor'][] = $this->setColor($i); 
            $grafik['peralatan_kondisi']['datasets'][0]['label'][] = $init;                 
            $i++;
        }   
        
        $sql = " 
                SELECT
                    COUNT(t.invperalatan_id) as jumlah,
                    b.barang_levelresiko as level                  
                FROM  invperalatan_t t  
                JOIN barang_m b ON b.barang_id = t.barang_id 
                WHERE t.tglpenghapusan IS NULL
                GROUP BY b.barang_levelresiko
                ORDER BY jumlah DESC  
                    
               ";        
        $level_resiko = Yii::app()->db->createCommand($sql)->queryAll();
        
               
        $i = 0;
        foreach($level_resiko as $det){
            $init = $det['level'];
            $grafik['level_resiko']['labels'][] = $det['level'];                
            $grafik['level_resiko']['datasets'][0]['data'][] = $det['jumlah'];                
            $grafik['level_resiko']['datasets'][0]['backgroundColor'][] = $this->setColor($i); 
            $grafik['level_resiko']['datasets'][0]['label'] = $init;                 
            $i++;
        }   
        
        
        //grafik garis preventive dan corrective
        $sql = "select 
                    count(workorder_id) as jumlah,
                    EXTRACT(month FROM workorder_tgl) as bulan,
                    EXTRACT(year FROM workorder_tgl) as tahun
                from workorder_t 
                where EXTRACT(YEAR FROM workorder_tgl) = EXTRACT(YEAR FROM CURRENT_DATE) 
                group by 
                    EXTRACT(month FROM workorder_tgl),
                    EXTRACT(year FROM workorder_tgl)
        ";
        $model = Yii::app()->db->createCommand($sql)->queryAll(); 
        
        $prev_dt = [];
        foreach($model as $det){
            $init = MyFormatter::formatMonthForUser($det['bulan'].'/'.$det['tahun']);  
            $prev_dt[$init] = $det['jumlah'];
        }
        
        
        $sql = "select 
                    count(korektifmainten_id) as jumlah,
                    EXTRACT(month FROM korektifmainten_tgl) as bulan,
                    EXTRACT(year FROM korektifmainten_tgl) as tahun
                from korektifmainten_t 
                where EXTRACT(YEAR FROM korektifmainten_tgl) = EXTRACT(YEAR FROM CURRENT_DATE) 
                group by 
                    EXTRACT(month FROM korektifmainten_tgl),
                    EXTRACT(year FROM korektifmainten_tgl)
        ";
        $model = Yii::app()->db->createCommand($sql)->queryAll(); 
        
        $corr_dt = [];
        foreach($model as $det){
            $init = MyFormatter::formatMonthForUser($det['bulan'].'/'.$det['tahun']);  
            $corr_dt[$init] = $det['jumlah'];
        }
        
        $tot_bln = (int)date('m');
        $label_gr = [];        
        for($i=1;$i<=$tot_bln;$i++){
            $init = MyFormatter::formatMonthForUser($i.'/'.date('Y'));            
            $label_gr[] = $init;
            
            //set nilai preventive
            $val = !empty($prev_dt[$init])?$prev_dt[$init]:0;
            $grafik['default']['datasets'][0]['data'][] = $val;

            //set nilai corrective
            $val = !empty($corr_dt[$init])?$corr_dt[$init]:0;
            $grafik['default']['datasets'][1]['data'][] = $val;                        
        }
        
        $grafik['default']['labels'] = $label_gr;
        $grafik['default']['datasets'][0]['backgroundColor'] = $this->setColor(0);
        $grafik['default']['datasets'][0]['borderColor'] = $this->setColor(0);
        $grafik['default']['datasets'][0]['label'] = 'Preventive maintenance';
        $grafik['default']['datasets'][0]['fill'] = false;   
        
        $grafik['default']['datasets'][1]['backgroundColor'] = $this->setColor(1);
        $grafik['default']['datasets'][1]['borderColor'] = $this->setColor(1);
        $grafik['default']['datasets'][1]['label'] = 'Corrective Maintenance';
        $grafik['default']['datasets'][1]['fill'] = false;
                

        $data['grafik'] = $grafik;        
        
        return $data;
        
    }   
        
}
