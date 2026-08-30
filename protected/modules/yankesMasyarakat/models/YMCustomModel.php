<?php
/**
 * custom model, tidak mengambil data dari tabel tertentu
 * issue RSST-2633
 * @package application.modules.yankesMasyarakat
 * @subpackage models  
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class YMCustomModel extends CFormModel
{	
    public $tgl_awal;
    public $tgl_akhir;   
    
    
    public function rules()
    {
        return array(
            //array('smf_nama, nama_pegawai, tgl_awal, tgl_akhir','safe','on'=>'search')
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
    public function generateBerandaDefault(){                
        $addCon = '';
        $bln = date('Y-m-');
        if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_KMKP){
            $addCon = " AND grading.tglverifikasi_unit IS not null AND t.lokasikejadian_id = ".Yii::app()->user->getState('ruangan_id')." ";
        }        
        $sql = " 
                SELECT
                    grading.tgl_kirimpelaporan,
                    grading.tglverifikasi_unit,
                    grading.tingkatrisiko_id,
                    grading.gradinginsidenrs_id,
                    DATE(grading.tgl_gradingunit) as tgl_gradingunit,
                    t.insidenrs_tgllapor,
                    t.insidenrs_tglinsiden,
                    t.insidenrs_id,
                    ting.tingkatrisiko_nama,
                    ting.tingkatrisiko_warna
                FROM insidenrs_t t
                JOIN gradinginsidenrs_t grading ON grading.insidenrs_id = t.insidenrs_id                 
                LEFT JOIN tingkatrisiko_riskregister_m ting ON ting.tingkatrisiko_riskregister_id = grading.tingkatrisiko_id
                WHERE 
                    insidenrs_tgllapor::text ilike '".$bln."%' ".$addCon."
               ";        
        $modInsiden = Yii::app()->db->createCommand($sql)->queryAll();        
        $sql= "  
                SELECT 
                    t.identifikasiresiko_id,
                    t.tingkatrisiko_id,
                    t.tiperesiko_id,
                    t.status_riskregister,
                    tipe.tiperesiko_nama,              
                    ting.tingkatrisiko_nama,
                    ting.tingkatrisiko_warna,
                    t.tgl_tinjauan                   
                FROM laporanriskregister_v t
                JOIN perioderiskregister_m per ON per.perioderiskregister_id = t.perioderiskregister_id                 
                LEFT JOIN tiperesiko_m tipe ON tipe.tiperesiko_id = t.tiperesiko_id 
                LEFT JOIN tingkatrisiko_riskregister_m ting ON ting.tingkatrisiko_riskregister_id = t.tingkatrisiko_id
                WHERE 
                    date_part('year',t.tgl_tinjauan) = '".date('Y')."' 
               ";//
               //date_part('year',per.periode_awal) = '".date('Y')."' AND date_part('year',per.periode_akhir) = '".date('Y')."'
        $modRiskRegister = Yii::app()->db->createCommand($sql)->queryAll();
        
        $tileLaporanInsiden = array();    
        
        $load_tingkatresiko = array();
        $load_24jam = array();
        $load_24jam_donut = array();
        foreach($modInsiden as $det){
            if (!empty($det['tglverifikasi_unit']) && (date("Y-m-d", strtotime($det['insidenrs_tgllapor'])) == date('Y-m-d')) ){
                $tileLaporanInsiden[$det['insidenrs_id']] = $det['insidenrs_id'];                            
            }
            
            if (!empty($det['tgl_kirimpelaporan'])){
                $selisih = strtotime($det['tgl_kirimpelaporan']) - strtotime($det['insidenrs_tglinsiden']);

                $jam = round($selisih/60);
                
                $status = 'lebih';
                if ( $jam <= 48){
                    $status = 'kurang';
                }
                
                $hari = date('d', strtotime($det['insidenrs_tgllapor']));
                                                                                                    
                $load_24jam[$hari]['status'][$status]['det'][$det['gradinginsidenrs_id']] = $det['gradinginsidenrs_id'];
                
                $load_24jam_donut[$status]['det'][$det['gradinginsidenrs_id']] = $det['gradinginsidenrs_id'];
            }
                                    
            $load_tingkatresiko[$det['tingkatrisiko_id']]['nama'] = $det['tingkatrisiko_nama'];
            $load_tingkatresiko[$det['tingkatrisiko_id']]['warna'] = strtolower($det['tingkatrisiko_warna']);
            $load_tingkatresiko[$det['tingkatrisiko_id']]['det'][$det['gradinginsidenrs_id']] = $det['gradinginsidenrs_id'];            
        }
                
        
        $tileRiskRegister = array();
        $load_riskregister = array();
        $load_tiperesiko = array();
        $load_statusregister = array();
        
        foreach($modRiskRegister as $det){
            $bulan = (int)date("m", strtotime($det['tgl_tinjauan']));
            if ($bulan <= 6){
                $st = 'triwulan1';
            }else{
                $st = 'triwulan2';
            }
            
            $tileRiskRegister[$det['identifikasiresiko_id']] = $det['identifikasiresiko_id'];
            
            $load_riskregister[$det['tingkatrisiko_id']]['nama'] = $det['tingkatrisiko_nama'];
            $load_riskregister[$det['tingkatrisiko_id']]['det'][$st][$det['identifikasiresiko_id']] = $det['identifikasiresiko_id'];
            $load_riskregister[$det['tingkatrisiko_id']]['warna'] = strtolower($det['tingkatrisiko_warna']);
            
            $load_tiperesiko[$det['tiperesiko_id']]['nama'] = $det['tiperesiko_nama'];
            $load_tiperesiko[$det['tiperesiko_id']]['det'][$st][$det['identifikasiresiko_id']] = $det['identifikasiresiko_id'];
            
            $load_statusregister[$det['status_riskregister']]['nama'] = $det['status_riskregister'];
            $load_statusregister[$det['status_riskregister']]['det'][$st][$det['identifikasiresiko_id']] = $det['identifikasiresiko_id'];
        }
       
        
        $tile = array();                                
        
        $tile['laporaninsiden'] = count($tileLaporanInsiden);
        $tile['riskregister'] = count($tileRiskRegister);                
                        
        $data['tile'] = $tile;
               
        $tingkatresikobulan_grafik = array();        
        $tingkatresikotriwulan_grafik = array();
        $tiperesikotriwulan_grafik = array();    
        $statusregistertriwulan_grafik = array();            
        
        $tigaGrafik = array();
        
        
        for($i=1;$i<=date('d');$i++){
            $iden = $i;
            if ($i<10){
                $iden = '0'.$iden;
            }            
            
            $tigaGrafik['area']['labels'][] = $i;            
            $tigaGrafik['area']['datasets'][0]['data'][$i-1] = 0;     
            $tigaGrafik['area']['datasets'][0]['label'] = 'lebih dari 2x24jam';
            $tigaGrafik['area']['datasets'][0]['backgroundColor'] = '#f39c12';        
            $tigaGrafik['area']['datasets'][0]['borderColor'] = '#f39c12'; 
            $tigaGrafik['area']['datasets'][1]['data'][$i-1] = 0;    
            $tigaGrafik['area']['datasets'][1]['label'] = 'kurang dari 2x24jam';
            $tigaGrafik['area']['datasets'][1]['backgroundColor'] = '#d35400';        
            $tigaGrafik['area']['datasets'][1]['borderColor'] = '#d35400'; 
            
            $tigaGrafik['garis']['labels'][] = $i;            
            $tigaGrafik['garis']['datasets'][0]['data'][$i-1] = 0;                            
            $tigaGrafik['garis']['datasets'][0]['label'] = 'lebih dari 2x24jam';
            $tigaGrafik['garis']['datasets'][0]['backgroundColor'] = '#f39c12';        
            $tigaGrafik['garis']['datasets'][0]['borderColor'] = '#f39c12'; 
            $tigaGrafik['garis']['datasets'][1]['data'][$i-1] = 0;  
            $tigaGrafik['garis']['datasets'][1]['label'] = 'kurang dari 2x24jam';
            $tigaGrafik['garis']['datasets'][1]['backgroundColor'] = '#d35400';        
            $tigaGrafik['garis']['datasets'][1]['borderColor'] = '#d35400';                         
            
            
            $tigaGrafik['doughnut']['labels'][0] = 'lebih dari 2x24jam';
            $tigaGrafik['doughnut']['labels'][1] = 'kurang dari 2x24jam';
            
            $tigaGrafik['doughnut']['datasets'][0]['data'][0] = 0;  
            $tigaGrafik['doughnut']['datasets'][0]['label'] = 'lebih dari 2x24jam';
            $tigaGrafik['doughnut']['datasets'][0]['backgroundColor'][0] = '#f39c12';        
            $tigaGrafik['doughnut']['datasets'][0]['borderColor'][0] = '#f39c12';                         
            
            $tigaGrafik['doughnut']['datasets'][0]['data'][1] = 0;  
            $tigaGrafik['doughnut']['datasets'][0]['label'] = 'kurang dari 2x24jam';
            $tigaGrafik['doughnut']['datasets'][0]['backgroundColor'][1] = '#d35400';        
            $tigaGrafik['doughnut']['datasets'][0]['borderColor'][1] = '#d35400';                         
        }
        
        foreach($load_24jam as $key => $val){               
            $iden = $key;                                               
            
            foreach($val['status'] as $key2 => $val2){
                if ($key2 == 'lebih'){
                    $i = 0;                    
                    $color = '#f39c12';
                    $key2 = 'lebih dari 2x24jam';
                }else{
                    $i = 1;                    
                    $color = '#d35400';
                    $key2 = 'kurang dari 2x24jam';
                }
                $tigaGrafik['area']['datasets'][$i]['data'][$iden-1] = count($val2['det']);                
                
                $tigaGrafik['area']['datasets'][$i]['label'] = $key2;
                $tigaGrafik['area']['datasets'][$i]['fill'] = true;

                $tigaGrafik['garis']['datasets'][$i]['data'][$iden-1] = count($val2['det']);                                
                $tigaGrafik['garis']['datasets'][$i]['label'] = $key2;                    
                $tigaGrafik['garis']['datasets'][$i]['fill'] = false;               
            }            
        }
                
        foreach ($load_24jam_donut as $key => $val){
            
            if ($key == 'lebih'){   
                $i = 0;                  
            }else{       
                $i = 1;                  
            }
            
            
            $tigaGrafik['doughnut']['datasets'][0]['data'][$i] = count($val['det']);                                                                                             
        }    
                
        //echo "<pre>";
        //var_dump($tigaGrafik['doughnut']);die;
        $arrKodeWarna = CustomFunction::kodeWarna();
        $i = 0;
        ksort($load_tingkatresiko);
        foreach($load_tingkatresiko as $key => $val){              
            $color = isset($arrKodeWarna[$val['warna']])?$arrKodeWarna[$val['warna']]:'#333';            
            $tingkatresikobulan_grafik['datasets'][$i]['data'][] = count($val['det']);                
            $tingkatresikobulan_grafik['datasets'][$i]['backgroundColor'][] = $color;
            $tingkatresikobulan_grafik['datasets'][$i]['label'] = $val['nama'];                                
            $i++;
        }
        
        $i = 0;
        ksort($load_riskregister);
        foreach($load_riskregister as $key => $val){                                                        
            $triwlan1 = isset($val['det']['triwulan1'])?count($val['det']['triwulan1']):0;
            $triwulan2 = isset($val['det']['triwulan2'])?count($val['det']['triwulan2']):0;
            
            $color = isset($arrKodeWarna[$val['warna']])?$arrKodeWarna[$val['warna']]:'#333';            
            
            $tingkatresikotriwulan_grafik['labels'][] = array('  ',$val['nama']);            
            $tingkatresikotriwulan_grafik['color'][] = $color;            
            
            $tingkatresikotriwulan_grafik['datasets'][0]['data'][] = $triwlan1;
            $tingkatresikotriwulan_grafik['datasets'][0]['backgroundColor'][] = $color;
            $tingkatresikotriwulan_grafik['datasets'][0]['label'] = 'I';            
            
            
            $tingkatresikotriwulan_grafik['datasets'][1]['data'][] = $triwulan2;
            $tingkatresikotriwulan_grafik['datasets'][1]['backgroundColor'][] = $color;
            $tingkatresikotriwulan_grafik['datasets'][1]['label'] = 'II';                                                
            
            $i++;
        }
        
        $i = 0;
        foreach($load_tiperesiko as $key => $val){
               
            $triwulan1 = isset($val['det']['triwulan1'])?count($val['det']['triwulan1']):0;
            $triwulan2 = isset($val['det']['triwulan2'])?count($val['det']['triwulan2']):0;
            
            $tiperesikotriwulan_grafik['labels'][] = array('  ',$val['nama']);            
            
            $tiperesikotriwulan_grafik['datasets'][0]['data'][] = $triwulan1;              
            $tiperesikotriwulan_grafik['datasets'][0]['backgroundColor'] = '#1f4e79';
            $tiperesikotriwulan_grafik['datasets'][0]['label'] = 'I';                                
            
            $tiperesikotriwulan_grafik['datasets'][1]['data'][] = $triwulan2;
            $tiperesikotriwulan_grafik['datasets'][1]['backgroundColor'] = '#1f4e79';
            $tiperesikotriwulan_grafik['datasets'][1]['label'] = 'II';                                
            $i++;
        }  
        
        $i = 0;
        foreach($load_statusregister as $key => $val){
            
            $triwulan1 = isset($val['det']['triwulan1'])?count($val['det']['triwulan1']):0;
            $triwulan2 = isset($val['det']['triwulan2'])?count($val['det']['triwulan2']):0;
            
            $statusregistertriwulan_grafik['labels'][] = array('  ',$val['nama']);            
            
            $statusregistertriwulan_grafik['datasets'][0]['data'][] = $triwulan1;
            $statusregistertriwulan_grafik['datasets'][0]['backgroundColor'] = '#548235';
            $statusregistertriwulan_grafik['datasets'][0]['label'] = 'I';                         
            
            $statusregistertriwulan_grafik['datasets'][1]['data'][] = $triwulan2;
            $statusregistertriwulan_grafik['datasets'][1]['backgroundColor'] = '#548235';
            $statusregistertriwulan_grafik['datasets'][1]['label'] = 'II';      
            
            $i++;
        }
               
        
        $data['grafik']['tingkatresiko_bulanini'] = $tingkatresikobulan_grafik;
        $data['grafik']['tingkatresiko_triwulan'] = $tingkatresikotriwulan_grafik;
        $data['grafik']['tiperesiko_triwulan'] = $tiperesikotriwulan_grafik;
        $data['grafik']['statusregister_triwulan'] = $statusregistertriwulan_grafik;
        $data['grafik']['tigagrafik'] = $tigaGrafik;        
        
        return $data;
        
    }        
        
}
