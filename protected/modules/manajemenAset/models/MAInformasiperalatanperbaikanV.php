<?php

class MAInformasiperalatanperbaikanV extends InformasiperalatanperbaikanV
{
     
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }		
    
    public function searchInformasi(){
        $load = $this->search();
        
        $res = [];
        foreach($load->getData() as $det){
            $init = $det->id.$det->invperalatan_id.$det->barang_id.$det->status.$det->jenis_perbaikan.$det->status;
            
            $res[$init] = [
                'id' => $det->id,
                'invperalatan_namabrg' => $det->invperalatan_namabrg,
                'invperalatan_id' => $det->invperalatan_id,
                'invperalatan_kode' => $det->invperalatan_kode,
                'jenis_perbaikan' => $det->jenis_perbaikan,
                'status' => $det->status
            ];
            
            $res[$init]['lokasi'][$det->lokasi_id] = $det->lokasiaset_namalokasi;
        }
        
        
        $temp = $res;
        $res = [];
        $i = 0;
        foreach($temp as $key => $val){
            $res[$i] = $val;
            $res[$i]['no'] = $i;            
            $i++;
        }
        
        return new CArrayDataProvider($res, array(
            'keyField'=>'no',			
            'id'=>'data_laporan',
            'totalItemCount'=>count($res),
            'pagination' => array(
                'pageSize' => isset($_GET['_items'])?$_GET['_items']:10,
                'pageVar' => 'page'
            ),			
            'sort' => [
                'defaultOrder' => 'invperalatan_namabrg ASC'
            ]
        )); 
    }
}
?>
