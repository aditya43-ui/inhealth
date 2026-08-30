<?php

class MALaporanrekapkondisiasetV extends LaporanrekapkondisiasetV
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
        
        $look = LookupM::getItemsUrutan('kondisi_barang');
        
        $sel = [];        
        $sel_tot = [];
        foreach($look as $key => $val){
            $init = strtolower(str_replace(' ', '', $key)).'_medik';
            $sel[] = 'sum('.$init.') as '.$init;
            
            $init_non = strtolower(str_replace(' ', '', $key)).'_nonmedik';
            $sel[] = 'sum('.$init_non.') as '.$init_non;
            
            $sel_tot[] = $init.'+'.$init_non;
        }
        
        $sel = array_merge($sel,[
            'sum('.implode('+',$sel_tot).') as total_semua'
        ]);
        
        $sel[] = '(ROW_NUMBER () OVER (
                PARTITION BY ruangan_nama
                ORDER BY
                lokasiaset_namalokasi
                )) as no';
        $sel[] = 'lokasiaset_namalokasi';
        $sel[] = 'ruangan_nama';
        
        $criteria=new CDbCriteria;
        $criteria->select = $sel;
        $criteria->group = "lokasiaset_namalokasi,ruangan_nama";
        
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
        $criteria = $this->criteriaSearch();
        $load = self::model()->findAll($criteria);
        
        $data = [];
        $r = [];
                        
        foreach($load as $key => $val){                    
            $init = $val->ruangan_nama;
            $init2 = $val->lokasiaset_namalokasi;
            
            $data[$init]['lok'][$init2]['no'] = $key+1;
            $data[$init]['lok'][$init2]['lokasiaset_namalokasi'] = $val->lokasiaset_namalokasi;
            $data[$init]['lok'][$init2]['ruangan_nama'] = $val->ruangan_nama;
            
            $att = $val->attributes;
            unset($att['gedung_nama']);
            unset($att['gedung_id']);
            unset($att['ruangan_id']);
            unset($att['ruangan_nama']);
            unset($att['lokasiaset_namalokasi']);
            unset($att['lokasi_id']);
            
            foreach($att as $key2 => $val2){            
                $r[$init][$key2] = (isset($r[$init][$key2])?$r[$init][$key2]:0)+$val->$key2;
                                
                $data[$init]['lok'][$init2]['total_'.$key2] = $val->$key2;                
            }
            $data[$init]['lok'][$init2]['total_total_semua'] = $val->total_semua;
        }
        
        $res = [];
        $i = 0;
        foreach($r as $key => $val){
            $temp_no = $i;
            $res[$temp_no]['lokasiaset_namalokasi'] = '<b>'.$key.'</b>';
            $res[$temp_no]['ruangan_nama'] = $key;
            
            foreach($att as $key2 => $val2){
                $res[$temp_no]['total_'.$key2] = 0;
            }            
            
            $res[$temp_no]['no'] = '';
            $res[$temp_no]['total_total_semua'] = 0;
            
            
            $a = 1;
            $i++;
            foreach($data[$key]['lok'] as $det){
                $res[$i]['lokasiaset_namalokasi'] = $det['lokasiaset_namalokasi'];
                $res[$i]['ruangan_nama'] = $key;
                $res[$i]['no'] = $a;
                
                foreach($att as $key2 => $val2){
                    $res[$i]['total_'.$key2] = $det['total_'.$key2];

                    $res[$temp_no]['total_'.$key2] += $det['total_'.$key2];
                }
                
                $res[$i]['total_total_semua'] = $det['total_total_semua'];
                $res[$temp_no]['total_total_semua'] = $det['total_total_semua'];
                
                $a++;
                $i++;
            }
            
            foreach($att as $key2 => $val2){
                $res[$temp_no]['total_'.$key2] = '<b>'.$res[$temp_no]['total_'.$key2].'</b>';            
            }
            $res[$temp_no]['total_total_semua'] = '<b>'.$res[$temp_no]['total_total_semua'].'</b>';         
            
            $i++;
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
        $load = self::model()->findAll($criteria);
        
        $total = 0;
        foreach($load as $det){
            $total += $det->$init;
        }
        
        return $total;
    }
    
    public function loadGrafik(){
        $tipe = $this->tipe;
        $load_set = $this->criteriaSearch();
        $load_set->group = null;
        $load_set->order = null;
        
        $look = LookupM::getItemsUrutan('kondisi_barang');
        
        $sel = [];        
        $lbl = [];
        foreach($look as $key => $val){
            $init = strtolower(str_replace(' ', '', $key)).'_medik';
            $sel[] = 'sum('.$init.') as '.$init;
            $lbl_medik[$init] = $key.' - Medik';
            
            $init_non = strtolower(str_replace(' ', '', $key)).'_nonmedik';
            $sel[] = 'sum('.$init_non.') as '.$init_non;
            $lbl_medik[$init_non] = $key.' - Non Medik';
            
            $sel_tot[] = $init.'+'.$init_non;
        }
        
        $sel = array_merge($sel,[
            'sum('.implode('+',$sel_tot).') as total_semua'
        ]);
        
        $load_set->select = $sel;

        $load = self::model()->find($load_set);
        $grafik = [];

        if (!empty($load)){
            
            $att = $load->attributes;
            unset($att['gedung_nama']);
            unset($att['gedung_id']);
            unset($att['ruangan_id']);
            unset($att['ruangan_nama']);
            unset($att['lokasiaset_namalokasi']);
            unset($att['lokasi_id']);
            
            if ($tipe != 'pie'){
                $grafik['labels'] = [
                  '','Data',''  
                ];
                
                
                
                $i = 0;
                foreach($att as $key => $val){
                    $grafik['datasets'][$i]['data'] = [
                        'NaN',$load->$key,'Nan'
                    ];                
                    $grafik['datasets'][$i]['backgroundColor'] = self::set_warna($i); 
                    $grafik['datasets'][$i]['label'] = $lbl_medik[$key];   
                    $i++;
                }
                   
            }else{
                $labels = [];
                $data_sets = [];
                $color = [];
                $i = 0;
                foreach($att as $key => $val){
                    $labels[] = $lbl_medik[$key];
                    $data_sets[] = $load->$key;
                    $color[] = self::set_warna($i);
                    $i++;
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
