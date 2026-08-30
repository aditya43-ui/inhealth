<?php

class MALaporanrekappemeliharaanasetV extends LaporanrekappemeliharaanasetV
{
    public $no;
    public $tipe;
    public $tgl_awal, $tgl_akhir, $jumlah, $data;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function criteriaSearch(){
        $criteria=new CDbCriteria;
        $criteria->select = [
            'sum(total_cm) as total_cm',
            'sum(total_pm) as total_pm',
            '(ROW_NUMBER () OVER (
                PARTITION BY ruangan_nama
                ORDER BY
                lokasiaset_namalokasi
                )) as no',
            'lokasiaset_namalokasi',
            'ruangan_nama'
        ];
        $criteria->group = "lokasiaset_namalokasi,ruangan_nama";
        $criteria->addBetweenCondition('DATE(tanggal_pemeliharaan)',$this->tgl_awal,$this->tgl_akhir);
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
            
            $r[$init]['pm'] = (isset($r[$val->ruangan_nama]['pm'])?$r[$val->ruangan_nama]['pm']:0)+$val->total_pm;
            $r[$init]['cm'] = (isset($r[$val->ruangan_nama]['cm'])?$r[$val->ruangan_nama]['cm']:0)+$val->total_cm;
            
            $data[$init]['lok'][$init2]['no'] = $key+1;
            $data[$init]['lok'][$init2]['lokasiaset_namalokasi'] = $val->lokasiaset_namalokasi;
            $data[$init]['lok'][$init2]['ruangan_nama'] = $val->ruangan_nama;
            $data[$init]['lok'][$init2]['total_pm'] = $val->total_pm;
            $data[$init]['lok'][$init2]['total_cm'] = $val->total_cm;
        }
        
        $res = [];
        $i = 0;
        foreach($r as $key => $val){
            $temp_no = $i;
            $res[$temp_no]['lokasiaset_namalokasi'] = '<b>'.$key.'</b>';
            $res[$temp_no]['ruangan_nama'] = $key;
            $res[$temp_no]['total_pm'] = 0;
            $res[$temp_no]['total_cm'] = 0;
            $res[$temp_no]['no'] = '';
            
            $a = 1;
            $i++;
            foreach($data[$key]['lok'] as $det){
                $res[$i]['lokasiaset_namalokasi'] = $det['lokasiaset_namalokasi'];
                $res[$i]['ruangan_nama'] = $key;
                $res[$i]['no'] = $a;
                $res[$i]['total_pm'] = $det['total_pm'];
                $res[$i]['total_cm'] = $det['total_cm'];
                
                $res[$temp_no]['total_cm'] += $det['total_cm'];
                $res[$temp_no]['total_pm'] += $det['total_pm'];
                
                $a++;
                $i++;
            }
            $res[$temp_no]['total_cm'] = '<b>'.$res[$temp_no]['total_cm'].'</b>';
            $res[$temp_no]['total_pm'] = '<b>'.$res[$temp_no]['total_pm'].'</b>';
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
            'SUM(total_cm) as total_cm',
            'SUM(total_pm) as total_pm',
        ];

        $load = MALaporanrekappemeliharaanasetV::model()->find($load_set);
        $grafik = [];

        if (!empty($load)){
            if ($tipe != 'pie'){
                $grafik['labels'] = [
                  '','Data',''  
                ];
                $grafik['datasets'][0]['data'] = [
                    'NaN',$load->total_cm,'Nan'
                ];                
                $grafik['datasets'][0]['backgroundColor'] = '#01b8aa'; 
                $grafik['datasets'][0]['label'] = 'CM';   

                $grafik['datasets'][1]['data'] = [
                    'NaN',$load->total_pm,'Nan'
                ];                
                $grafik['datasets'][1]['backgroundColor'] = '#c49e6d'; 
                $grafik['datasets'][1]['label'] = 'PM';   
            }else{
                $grafik['labels'] = [
                    'CM','PM'
                ];
                $grafik['datasets'][0]['data'] = [
                    $load->total_cm, $load->total_pm
                ];                
                $grafik['datasets'][0]['backgroundColor'] = [
                    '#01b8aa', '#c49e6d'
                ];                       

            }       
        }
        
        return $grafik;
    }
}

?>
