<?php

class MALaporanrekapsumberdanaasetV extends LaporanrekapsumberdanaasetV
{
    public $no;
    public $tipe;
    public $tgl_awal, $tgl_akhir, $jumlah, $data;
    public $total_semua;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function criteriaSearch(){                                      
        
        $criteria=new CDbCriteria;
        $criteria->select = [            
            'lokasiaset_namalokasi',
            'ruangan_nama',
            'sumberdana',
            'sum(total_aset) as total_aset'
        ];
        $criteria->group = "lokasiaset_namalokasi,ruangan_nama,sumberdana";
        
        if (!empty($this->lokasi_id)){
            $criteria->addCondition('lokasi_id ='.$this->lokasi_id);
        }
        if (!empty($this->ruangan_id)){
            $criteria->addCondition('ruangan_id ='.$this->ruangan_id);
        }
        if (!empty($this->gedung_id)){
            $criteria->addCondition('gedung_id ='.$this->gedung_id);
        }
        $criteria->order = " ruangan_nama ASC, lokasiaset_namalokasi ASC ";
        
        return $criteria;
    }
	
    /**
    * Retrieves a list of models based on the current search/filter conditions.
    * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
    */
    public function searchLaporan()
    {                   
        $sumberdana = SumberdanaM::model()->findAll(" sumberdana_aktif = true ORDER BY sumberdana_nama ASC ");
        
        $sel = [];
        foreach($sumberdana as $d){
            $init = str_replace(' ','_',strtolower($d->sumberdana_nama));
            $sel[$init] = $d->sumberdana_nama;
        }
        
        $criteria = $this->criteriaSearch();
        $load = self::model()->findAll($criteria);
        
        $data = [];
        $r = [];
                        
        foreach($load as $key => $val){                 
            $init = $val->ruangan_nama;
            $init2 = $val->lokasiaset_namalokasi;
            $init3 = str_replace(' ','_',strtolower($val->sumberdana));           
            $data[$init]['lok'][$init2]['no'] = $key+1;
            $data[$init]['lok'][$init2]['lokasiaset_namalokasi'] = $val->lokasiaset_namalokasi;
            $data[$init]['lok'][$init2]['ruangan_nama'] = $val->ruangan_nama;
                        
            $data[$init]['lok'][$init2]['sumberdana'][$init3] = (!empty($data[$init]['lok'][$init2]['sumberdana'][$init3])?$data[$init]['lok'][$init2]['sumberdana'][$init3]:0)+$val->total_aset;                                    
            
        }                        
        
        $res = [];        
        $a = 0;
        foreach($data as $key => $val){
            $temp_no = $a;
            
            $res[$temp_no]['no'] = null;
            $res[$temp_no]['lokasiaset_namalokasi'] = '<b>'.$key.'</b>';
            $res[$temp_no]['ruangan_nama'] = $key;   
            $res[$temp_no]['total_semua'] = 0;
                        
            $i = 1;
            $a++;
            
            $tot_semua = 0;
            foreach($val['lok'] as $key2 => $val2){
                $res[$a]['lokasiaset_namalokasi'] = $val2['lokasiaset_namalokasi'];
                $res[$a]['ruangan_nama'] = $key;
                $res[$a]['no'] = $i;
                
                $tot_sd = 0;
                foreach($sel as $key3 => $det){
                    $res[$a][$key3] = isset($val2['sumberdana'][$key3])?$val2['sumberdana'][$key3]:0;
                    $tot_sd += $res[$a][$key3];
                    
                    $res[$temp_no][$key3] = (!empty($res[$temp_no][$key3])?$res[$temp_no][$key3]:0)+$res[$a][$key3];
                    
                    $tot_semua += $res[$a][$key3];
                }
                
                $res[$a]['total_semua'] = $tot_sd;
                
                $a++;
                $i++;
            }                           
                     
            $res[$temp_no]['total_semua'] = $tot_semua;
            
            $a++;
        }
               
        
        
        
        return new CArrayDataProvider($res, array(
            'keyField'=>'no',			
            'id'=>'data_laporan',
            'totalItemCount'=>count($res),
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'page'
            ),	            
        ));             
    }
    
    public function getTotal($init){
        $criteria = $this->criteriaSearch();       
        $criteria->order = null;
        $criteria->group = null;
        $criteria->select = [
            'sum(total_aset) as total_aset'
        ];
        if (!empty($init)){
            $criteria->addCondition(" sumberdana = '".$init."' ");
        }else{
            $criteria->addCondition(" sumberdana IN (SELECT sumberdana_nama FROM sumberdana_m WHERE sumberdana_aktif = TRUE) ");
        }
        $load = self::model()->find($criteria);
                    
        
        return !empty($load->total_aset)?$load->total_aset:0;
    }
    
    public function loadGrafik(){
        $tipe = $this->tipe;
        $criteria = $this->criteriaSearch();       
        $criteria->order = null;
        $criteria->group = 'sumberdana';
        $criteria->select = [
            'sumberdana',
            'sum(total_aset) as total_aset'
        ];        
        $load = self::model()->findAll($criteria);
        
        $sumberdana = SumberdanaM::model()->findAll(" sumberdana_aktif = true ORDER BY sumberdana_nama ASC ");
        
        $sel = [];
        $grafik = [];
        $gr = [];
        
        $tot = 0;
        
        foreach($load as $det){
            $init = str_replace(' ','_',strtolower($det->sumberdana));
            $gr[$init] = $det->total_aset;
        }                                          
        
        if (!empty($gr)){                       
            
            if ($tipe != 'pie'){
                $grafik['labels'] = [
                  '','Data',''  
                ];
                                                                
                foreach($sumberdana as $i => $val){
                    $init = str_replace(' ','_',strtolower($val->sumberdana_nama));
                    $grafik['datasets'][$i]['data'] = [
                        'NaN',(!empty($gr[$init])?$gr[$init]:0),'Nan'
                    ];                
                    $grafik['datasets'][$i]['backgroundColor'] = self::set_warna($i); 
                    $grafik['datasets'][$i]['label'] = $val->sumberdana_nama;                       
                }
                   
            }else{
                $labels = [];
                $data_sets = [];
                $color = [];                
                foreach($sumberdana as $i => $val){
                    $init = str_replace(' ','_',strtolower($val->sumberdana_nama));
                    $labels[] = $val->sumberdana_nama;      
                    $data_sets[] = (!empty($gr[$init])?$gr[$init]:0);
                    $color[] = self::set_warna($i);                    
                }
                
                $grafik['labels'] = $labels;
                $grafik['datasets'][0]['data'] = $data_sets;                
                $grafik['datasets'][0]['backgroundColor'] = $color;                       

            }       
        }
        
        return $grafik;
    }
    
    public static function set_warna($counter){
        $warna = '#333';
        switch ($counter) {
            case 0:
                $warna = '#13b7b4';
                break;
            case 1:
                $warna = '#f1d427';
                break;
            case 2:
                $warna = '#EDF2FE';
                break;
            case 3:
                $warna = '#ff4558';
                break;
            case 4:
                $warna = '#28d094';
                break;
            case 5:
                $warna = '#626e82';
                break;
            case 6:
                $warna = '#ff7d4d';
                break;
            case 7:
                $warna = '#774533';
                break;
            case 8:
                $warna = '#39912b';
                break;
            case 9:
                $warna = '#414891';
                break;
            case 10:
                $warna = '#ad37a1';
                break;
            default:
                break;
        }
        
        return $warna;
    }
}

?>
