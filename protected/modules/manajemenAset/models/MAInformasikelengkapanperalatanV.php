<?php

class MAInformasikelengkapanperalatanV extends InformasikelengkapanperalatanV
{
     
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
     * fungsi yang digunakan untuk menampilkan isi grid view, pada menu informasi kelengkapan peralatan
     * @return \CArrayDataProvider
     */
    public function searchInformasi(){
        $load = $this->search();
        
        $res = [];
        foreach($load->getData() as $det){
            $init = $det->id.$det->invperalatan_id.$det->barang_id.$det->jenis_kelengkapan.$det->jatuh_tempo;
            
            $res[$init] = [
                'id' => $det->id,
                'invperalatan_namabrg' => $det->invperalatan_namabrg,
                'invperalatan_id' => $det->invperalatan_id,
                'invperalatan_kode' => $det->invperalatan_kode,
                'jenis_kelengkapan' => $det->jenis_kelengkapan,
                'jatuh_tempo' => $det->jatuh_tempo
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
