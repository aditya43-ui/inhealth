<?php

class MALaporanperizinanperalatandanmesinV extends LaporanperizinanperalatandanmesinV
{
    public $no;
    public $tipe;
    public $total_semua;
    public $tgl_awal, $tgl_akhir;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function criteriaSearch(){
        $criteria=new CDbCriteria;
        $criteria->select = [
            'sum(sudahperizinan_medik) as sudahperizinan_medik',
            'sum(jatuhtempo_medik) as jatuhtempo_medik',
            'sum(lewatjatuhtempo_medik) as lewatjatuhtempo_medik',
            'sum(sudahperizinan_nonmedik) as sudahperizinan_nonmedik',
            'sum(jatuhtempo_nonmedik) as jatuhtempo_nonmedik',
            'sum(lewatjatuhtempo_nonmedik) as lewatjatuhtempo_nonmedik',
            'sum(lewatjatuhtempo_nonmedik+jatuhtempo_nonmedik+sudahperizinan_nonmedik+lewatjatuhtempo_medik+jatuhtempo_medik+sudahperizinan_medik) as total_semua',
            '(ROW_NUMBER () OVER (
                PARTITION BY ruangan_nama
                ORDER BY
                lokasiaset_namalokasi
                )) as no',
            'lokasiaset_namalokasi',
            'ruangan_nama'
        ];
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
            
            $r[$init]['sudahperizinan_medik'] = (isset($r[$val->ruangan_nama]['sudahperizinan_medik'])?$r[$val->ruangan_nama]['sudahperizinan_medik']:0)+$val->sudahperizinan_medik;
            $r[$init]['jatuhtempo_medik'] = (isset($r[$val->ruangan_nama]['jatuhtempo_medik'])?$r[$val->ruangan_nama]['jatuhtempo_medik']:0)+$val->jatuhtempo_medik;
            $r[$init]['lewatjatuhtempo_medik'] = (isset($r[$val->ruangan_nama]['lewatjatuhtempo_medik'])?$r[$val->ruangan_nama]['lewatjatuhtempo_medik']:0)+$val->lewatjatuhtempo_medik;
            $r[$init]['sudahperizinan_nonmedik'] = (isset($r[$val->ruangan_nama]['sudahperizinan_nonmedik'])?$r[$val->ruangan_nama]['sudahperizinan_nonmedik']:0)+$val->sudahperizinan_nonmedik;
            $r[$init]['jatuhtempo_nonmedik'] = (isset($r[$val->ruangan_nama]['jatuhtempo_nonmedik'])?$r[$val->ruangan_nama]['jatuhtempo_nonmedik']:0)+$val->jatuhtempo_nonmedik;
            $r[$init]['lewatjatuhtempo_nonmedik'] = (isset($r[$val->ruangan_nama]['lewatjatuhtempo_nonmedik'])?$r[$val->ruangan_nama]['lewatjatuhtempo_nonmedik']:0)+$val->lewatjatuhtempo_nonmedik;
            $r[$init]['total_semua'] = (isset($r[$val->ruangan_nama]['total_semua'])?$r[$val->ruangan_nama]['total_semua']:0)+$val->total_semua;
            
            $data[$init]['lok'][$init2]['no'] = $key+1;
            $data[$init]['lok'][$init2]['lokasiaset_namalokasi'] = $val->lokasiaset_namalokasi;
            $data[$init]['lok'][$init2]['ruangan_nama'] = $val->ruangan_nama;            
            $data[$init]['lok'][$init2]['total_sudahperizinan_medik'] = $val->sudahperizinan_medik;
            $data[$init]['lok'][$init2]['total_jatuhtempo_medik'] = $val->jatuhtempo_medik;
            $data[$init]['lok'][$init2]['total_lewatjatuhtempo_medik'] = $val->lewatjatuhtempo_medik;
            $data[$init]['lok'][$init2]['total_sudahperizinan_nonmedik'] = $val->sudahperizinan_nonmedik;
            $data[$init]['lok'][$init2]['total_jatuhtempo_nonmedik'] = $val->jatuhtempo_nonmedik;
            $data[$init]['lok'][$init2]['total_lewatjatuhtempo_nonmedik'] = $val->lewatjatuhtempo_nonmedik;
            $data[$init]['lok'][$init2]['total_total_semua'] = $val->total_semua;
            
        }
        
        $res = [];
        $i = 0;
        foreach($r as $key => $val){
            $temp_no = $i;
            $res[$temp_no]['lokasiaset_namalokasi'] = '<b>'.$key.'</b>';
            $res[$temp_no]['ruangan_nama'] = $key;
            $res[$temp_no]['total_sudahperizinan_medik'] = 0;
            $res[$temp_no]['total_jatuhtempo_medik'] = 0;
            $res[$temp_no]['total_lewatjatuhtempo_medik'] = 0;
            $res[$temp_no]['total_sudahperizinan_nonmedik'] = 0;
            $res[$temp_no]['total_jatuhtempo_nonmedik'] = 0;
            $res[$temp_no]['total_lewatjatuhtempo_nonmedik'] = 0;
            $res[$temp_no]['total_total_semua'] = 0;
            $res[$temp_no]['no'] = '';
            
            $a = 1;
            $i++;
            foreach($data[$key]['lok'] as $det){
                $res[$i]['lokasiaset_namalokasi'] = $det['lokasiaset_namalokasi'];
                $res[$i]['ruangan_nama'] = $key;
                $res[$i]['no'] = $a;
                $res[$i]['total_sudahperizinan_medik'] = $det['total_sudahperizinan_medik'];
                $res[$i]['total_jatuhtempo_medik'] = $det['total_jatuhtempo_medik'];
                $res[$i]['total_lewatjatuhtempo_medik'] = $det['total_lewatjatuhtempo_medik'];
                $res[$i]['total_sudahperizinan_nonmedik'] = $det['total_sudahperizinan_nonmedik'];
                $res[$i]['total_jatuhtempo_nonmedik'] = $det['total_jatuhtempo_nonmedik'];
                $res[$i]['total_lewatjatuhtempo_nonmedik'] = $det['total_lewatjatuhtempo_nonmedik'];
                $res[$i]['total_total_semua'] = $det['total_total_semua'];
                
                $res[$temp_no]['total_sudahperizinan_medik'] += $det['total_sudahperizinan_medik'];
                $res[$temp_no]['total_jatuhtempo_medik'] += $det['total_jatuhtempo_medik'];
                $res[$temp_no]['total_lewatjatuhtempo_medik'] += $det['total_lewatjatuhtempo_medik'];
                $res[$temp_no]['total_sudahperizinan_nonmedik'] += $det['total_sudahperizinan_nonmedik'];
                $res[$temp_no]['total_jatuhtempo_nonmedik'] += $det['total_jatuhtempo_nonmedik'];
                $res[$temp_no]['total_lewatjatuhtempo_nonmedik'] += $det['total_lewatjatuhtempo_nonmedik'];
                $res[$temp_no]['total_total_semua'] += $det['total_total_semua'];
                
                $a++;
                $i++;
            }
            $res[$temp_no]['total_sudahperizinan_medik'] = '<b>'.$res[$temp_no]['total_sudahperizinan_medik'].'</b>';
            $res[$temp_no]['total_jatuhtempo_medik'] = '<b>'.$res[$temp_no]['total_jatuhtempo_medik'].'</b>';
            $res[$temp_no]['total_lewatjatuhtempo_medik'] = '<b>'.$res[$temp_no]['total_lewatjatuhtempo_medik'].'</b>';
            $res[$temp_no]['total_sudahperizinan_nonmedik'] = '<b>'.$res[$temp_no]['total_sudahperizinan_nonmedik'].'</b>';
            $res[$temp_no]['total_jatuhtempo_nonmedik'] = '<b>'.$res[$temp_no]['total_jatuhtempo_nonmedik'].'</b>';
            $res[$temp_no]['total_lewatjatuhtempo_nonmedik'] = '<b>'.$res[$temp_no]['total_lewatjatuhtempo_nonmedik'].'</b>';
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
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            
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
        $load_set->select = [
            'sum(sudahperizinan_medik) as sudahperizinan_medik',
            'sum(jatuhtempo_medik) as jatuhtempo_medik',
            'sum(lewatjatuhtempo_medik) as lewatjatuhtempo_medik',
            'sum(sudahperizinan_nonmedik) as sudahperizinan_nonmedik',
            'sum(jatuhtempo_nonmedik) as jatuhtempo_nonmedik',
            'sum(lewatjatuhtempo_nonmedik) as lewatjatuhtempo_nonmedik',            
        ];

        $load = self::model()->find($load_set);
        $grafik = [];

        if (!empty($load)){
            if ($tipe != 'pie'){
                $grafik['labels'] = [
                  '','Data',''  
                ];
                $grafik['datasets'][0]['data'] = [
                    'NaN',$load->sudahperizinan_medik,'Nan'
                ];                
                $grafik['datasets'][0]['backgroundColor'] = '#13b7b4'; 
                $grafik['datasets'][0]['label'] = 'Sudah Perizinan - Alat Medik';   

                $grafik['datasets'][1]['data'] = [
                    'NaN',$load->jatuhtempo_medik,'Nan'
                ];                
                $grafik['datasets'][1]['backgroundColor'] = '#f1d427'; 
                $grafik['datasets'][1]['label'] = 'Jatuh Tempo - Alat Medik';   
                
                $grafik['datasets'][2]['data'] = [
                    'NaN',$load->lewatjatuhtempo_medik,'Nan'
                ];                
                $grafik['datasets'][2]['backgroundColor'] = '#EDF2FE'; 
                $grafik['datasets'][2]['label'] = 'Lewat Jatuh Tempo - Alat Medik';
                
                $grafik['datasets'][3]['data'] = [
                    'NaN',$load->sudahperizinan_nonmedik,'Nan'
                ];                
                $grafik['datasets'][3]['backgroundColor'] = '#ff4558'; 
                $grafik['datasets'][3]['label'] = 'Sudah Perizinan - Alat Non Medik';
                
                $grafik['datasets'][4]['data'] = [
                    'NaN',$load->jatuhtempo_nonmedik,'Nan'
                ];                
                $grafik['datasets'][4]['backgroundColor'] = '#28d094'; 
                $grafik['datasets'][4]['label'] = 'Jatuh Tempo - Alat Non Medik';
                
                $grafik['datasets'][5]['data'] = [
                    'NaN',$load->lewatjatuhtempo_nonmedik,'Nan'
                ];                
                $grafik['datasets'][5]['backgroundColor'] = '#626e82'; 
                $grafik['datasets'][5]['label'] = 'Lewat Jatuh Tempo - Alat Non Medik';
            }else{
                $grafik['labels'] = [
                    'Sudah Perizinan - Alat Medik',
                    'Jatuh Tempo - Alat Medik',
                    'Lewat Jatuh Tempo - Alat Medik',
                    'Sudah Perizinan - Alat Non Medik',
                    'Jatuh Tempo - Alat Non Medik',
                    'Lewat Jatuh Tempo - Alat Non Medik'
                ];
                $grafik['datasets'][0]['data'] = [
                    $load->sudahperizinan_medik, 
                    $load->jatuhtempo_medik,
                    $load->lewatjatuhtempo_medik,
                    $load->sudahperizinan_nonmedik, 
                    $load->jatuhtempo_nonmedik,
                    $load->lewatjatuhtempo_nonmedik
                ];                
                $grafik['datasets'][0]['backgroundColor'] = [
                    '#13b7b4', '#f1d427',
                    '#EDF2FE', '#ff4558',
                    '#28d094', '#626e82'
                ];                       

            }       
        }
        
        return $grafik;
    }
}

?>
