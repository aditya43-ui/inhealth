<?php

class MALaporanrekapumurasetV extends LaporanrekapumurasetV
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
            'sum(range1) as range1',
            'sum(range2) as range2',
            'sum(range3) as range3',
            'sum(range4) as range4',
            'sum(range5) as range5',
            'sum(range5+range4+range3+range2+range1) as total_semua',
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
            
            $r[$init]['range1'] = (isset($r[$val->ruangan_nama]['range1'])?$r[$val->ruangan_nama]['range1']:0)+$val->range1;
            $r[$init]['range2'] = (isset($r[$val->ruangan_nama]['range2'])?$r[$val->ruangan_nama]['range2']:0)+$val->range2;
            $r[$init]['range3'] = (isset($r[$val->ruangan_nama]['range3'])?$r[$val->ruangan_nama]['range3']:0)+$val->range3;
            $r[$init]['range4'] = (isset($r[$val->ruangan_nama]['range4'])?$r[$val->ruangan_nama]['range4']:0)+$val->range4;
            $r[$init]['range5'] = (isset($r[$val->ruangan_nama]['range5'])?$r[$val->ruangan_nama]['range5']:0)+$val->range5;
            $r[$init]['total_semua'] = (isset($r[$val->ruangan_nama]['total_semua'])?$r[$val->ruangan_nama]['total_semua']:0)+$val->total_semua;
            
            $data[$init]['lok'][$init2]['no'] = $key+1;
            $data[$init]['lok'][$init2]['lokasiaset_namalokasi'] = $val->lokasiaset_namalokasi;
            $data[$init]['lok'][$init2]['ruangan_nama'] = $val->ruangan_nama;
            $data[$init]['lok'][$init2]['total_range1'] = $val->range1;
            $data[$init]['lok'][$init2]['total_range2'] = $val->range2;
            $data[$init]['lok'][$init2]['total_range3'] = $val->range3;
            $data[$init]['lok'][$init2]['total_range4'] = $val->range4;
            $data[$init]['lok'][$init2]['total_range5'] = $val->range5;
            $data[$init]['lok'][$init2]['total_total_semua'] = $val->total_semua;
        }
        
        $res = [];
        $i = 0;
        foreach($r as $key => $val){
            $temp_no = $i;
            $res[$temp_no]['lokasiaset_namalokasi'] = '<b>'.$key.'</b>';
            $res[$temp_no]['ruangan_nama'] = $key;
            $res[$temp_no]['total_range1'] = 0;
            $res[$temp_no]['total_range2'] = 0;
            $res[$temp_no]['total_range3'] = 0;
            $res[$temp_no]['total_range4'] = 0;
            $res[$temp_no]['total_range5'] = 0;
            $res[$temp_no]['total_total_semua'] = 0;
            $res[$temp_no]['no'] = '';
            
            $a = 1;
            $i++;
            foreach($data[$key]['lok'] as $det){
                $res[$i]['lokasiaset_namalokasi'] = $det['lokasiaset_namalokasi'];
                $res[$i]['ruangan_nama'] = $key;
                $res[$i]['no'] = $a;
                $res[$i]['total_range1'] = $det['total_range1'];
                $res[$i]['total_range2'] = $det['total_range2'];
                $res[$i]['total_range3'] = $det['total_range3'];
                $res[$i]['total_range4'] = $det['total_range4'];
                $res[$i]['total_range5'] = $det['total_range5'];
                $res[$i]['total_total_semua'] = $det['total_total_semua'];
                
                $res[$temp_no]['total_range1'] += $det['total_range1'];
                $res[$temp_no]['total_range2'] += $det['total_range2'];
                $res[$temp_no]['total_range3'] += $det['total_range3'];
                $res[$temp_no]['total_range4'] += $det['total_range4'];
                $res[$temp_no]['total_range5'] += $det['total_range5'];
                $res[$temp_no]['total_total_semua'] += $det['total_total_semua'];
                
                $a++;
                $i++;
            }
            $res[$temp_no]['total_range1'] = '<b>'.$res[$temp_no]['total_range1'].'</b>';
            $res[$temp_no]['total_range2'] = '<b>'.$res[$temp_no]['total_range2'].'</b>';
            $res[$temp_no]['total_range3'] = '<b>'.$res[$temp_no]['total_range3'].'</b>';
            $res[$temp_no]['total_range4'] = '<b>'.$res[$temp_no]['total_range4'].'</b>';
            $res[$temp_no]['total_range5'] = '<b>'.$res[$temp_no]['total_range5'].'</b>';
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
            'SUM(range1) as range1',
            'SUM(range2) as range2',
            'SUM(range3) as range3',
            'SUM(range4) as range4',
            'SUM(range5) as range5',
        ];

        $load = self::model()->find($load_set);
        $grafik = [];

        if (!empty($load)){            
            if ($tipe != 'pie'){
                $grafik['labels'] = [
                  '','Data',''  
                ];
                $grafik['datasets'][0]['data'] = [
                    'NaN',$load->range1,'Nan'
                ];                
                $grafik['datasets'][0]['backgroundColor'] = self::set_warna(0); 
                $grafik['datasets'][0]['label'] = '0 s/d 4 tahun';   

                $grafik['datasets'][1]['data'] = [
                    'NaN',$load->range2,'Nan'
                ];                
                $grafik['datasets'][1]['backgroundColor'] = self::set_warna(1); 
                $grafik['datasets'][1]['label'] = '5 s/d 8 tahun';    
                
                $grafik['datasets'][2]['data'] = [
                    'NaN',$load->range3,'Nan'
                ];                
                $grafik['datasets'][2]['backgroundColor'] = self::set_warna(2); 
                $grafik['datasets'][2]['label'] = '9 s/d 16 tahun';    
                
                $grafik['datasets'][3]['data'] = [
                    'NaN',$load->range4,'Nan'
                ];                
                $grafik['datasets'][3]['backgroundColor'] = self::set_warna(3); 
                $grafik['datasets'][3]['label'] = '17 s/d 20 tahun';    
                
                $grafik['datasets'][4]['data'] = [
                    'NaN',$load->range5,'Nan'
                ];                
                $grafik['datasets'][4]['backgroundColor'] = self::set_warna(4); 
                $grafik['datasets'][4]['label'] = '> 20 tahun';  
            }else{
                $grafik['labels'] = [
                    '0 s/d 4 tahun','5 s/d 8 tahun','9 s/d 16 tahun','17 s/d 20 tahun','> 20 tahun'
                ];
                $grafik['datasets'][0]['data'] = [
                    $load->range1, $load->range2, $load->range3, $load->range4, $load->range5
                ];                
                $grafik['datasets'][0]['backgroundColor'] = [
                    self::set_warna(0),
                    self::set_warna(1),
                    self::set_warna(2),
                    self::set_warna(3),
                    self::set_warna(4)
                ];                       

            }       
        }
        
        return $grafik;
    }
    
    /**
     * 
     * @param type $counter
     * @return string
     */
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
