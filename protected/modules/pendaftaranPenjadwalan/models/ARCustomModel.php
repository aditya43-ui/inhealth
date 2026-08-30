<?php
/**
 * custom model, tidak mengambil data dari tabel tertentu
 * issue RSST-2633
 * @package application.modules.penelitianKesehatan
 * @subpackage models  
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class ARCustomModel extends CFormModel
{	
    public $tgl_awal, $tgl_akhir;
    public $berdasarkantgl;
    public $jenissurat;    
    public $message;
    public $obatprb;
    public $jnspelayanan, $tglsep, $kodespesialis;    
    public $kode, $nama, $isdokterrs;    

    public function rules()
    {
        return array(
            array('kode, nama, jnspelayanan, tglsep, kodespesialis, obatprb, berdasarkantgl, jenissurat, tgl_awal, tgl_akhir','safe','on'=>'search')
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
    public function listRencanaKontrol(){
        
        $res = [];
        
        $bpjs = new BpjsVklaim();
        $bpjs2 = new BpjsVklaim();
        $arr = [
            'tglAwal' => $this->tgl_awal,
            'tglAkhir' => $this->tgl_akhir,            
            'tglBerdasarkan' => $this->berdasarkantgl
        ];
        
        $load = json_decode($bpjs->list_rencana_kontrol($arr['tglBerdasarkan'], $arr['tglAwal'], $arr['tglAkhir']));
        
        
        $this->message = '';
        if (!empty($load->response)){
            var_dump($load);
            $i = 0;            
            foreach($load->response->list as $rep){
                $init = $i;
                $res[$init]['no'] = $i+1;
                
                foreach($rep as $key => $val){                              
                    $res[$init][$key] = $val; 
                    if($key == "noKartu"){
                        $fload = json_decode($bpjs->search_kartu($val));
                        // $load2 = json_decode($bpjs->search_no_surat_kontrol($val));
                        // $res[$init]['nio'] = $eload;
                        if(!empty($fload->response)){
                            $res[$init]['search_kartu'] = $fload->response;
                        }else{
                            $res[$init]['search_kartu'] = $fload;
                        }
                    }
                    
                    if($key == "noSuratKontrol"){
                        $eload = json_decode($bpjs->search_no_surat_kontrol($val));
                        // $load2 = json_decode($bpjs->search_no_surat_kontrol($val));
                        // $res[$init]['nio'] = $eload;
                        if(!empty($eload->response)){
                            $res[$init]['search_no_surat_kontrol'] = $eload->response;
                        }else{
                            $res[$init]['search_no_surat_kontrol'] = $eload;
                        }
                    }
                }
                if (!empty($this->jenissurat)){                    
                    if ($res[$init]['jnsKontrol'] != $this->jenissurat){
                        unset($res[$init]);
                    }
                }
                $i++;
            }
            // if(!empty($load2->response)){

            // }
        }else{
            if (!empty($load->metaData->message)){
                if ($load->metaData->message != 'Sukses'){
                    $this->message = $load->metaData->message;
                }
            }
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
    
    /**
     * 
     * @return type
     */
    public function getColumnListRencanaKontrol(){        
        return [
            [
                'header' => 'No. SEP Asal',
                'name' => 'noSepAsalKontrol',
                'headerHtmlOptions'=>[
                    'class'=>'message-bpjs',
                    'data-message' => $this->message
                ]
            ],
            [
                'header' => 'Tanggal SEP',
                'name' => 'tglSEP'
            ],
            [
                'header' => 'No. Kartu Pasien',
                'name' => 'noKartu'
            ],
            [
                'header' => 'Nama Peserta',
                'name' => 'nama'
            ],
            [
                'header' => 'Jenis Kontrol',
                'name' => 'namaJnsKontrol'
            ],
            [
                'header' => 'Tanggal Pembuatan',
                'name' => ' tglTerbitKontrol'
            ],
            [
                'header' => 'Tanggal RencanaKontrol/Inap',
                'name' => 'tglRencanaKontrol'
            ],
            [
                'header' => 'No. Surat Kontrol/Ina',
                'name' => 'noSuratKontrol'
            ],
            [
                'header' => 'Poli Asal',
                'name' => 'namaPoliAsal'
            ],
            [
                'header' => 'Poli Tujuan',
                'name' => 'namaPoliTujuan'
            ],
            [
                'header' => 'Dokter',
                'name' => 'namaDokter'
            ],
            // [
            //     'header' => 'Dokter',
            //     'name' => 'kodeDokter'
            // ],
            [
                'header' => '<center>Detail</center>',
                'type' => 'raw',
                'value' => function($data){
                    $res = json_encode($data);
                    
                    
                    return 
                    // $res. "" .
                    CHtml::link("<i class='icon-form-mata'></i>", 'javascript:;',[                        
                        'onclick' => 'print('.$res.')'
                    ]);
                },
                //     return CHtml::link("<i class='icon-form-print'></i>", 'javascript:;',['onclick'=>'toastr.info("under construction","Perhatian!")']);
                // },
                'htmlOptions' => [
                    'style' => 'text-align:center;'
                ]
            ],
            
        ];        
    }

    /**
     * untuk mengenerate data grafik
     */
    public function tabelObatPrb(){
        
        $res = [];
        
        $bpjs = new BpjsVklaim();
        $arr = [
            'obatprb' => $this->obatprb,            
        ];
        
        $load = json_decode($bpjs->tabel_obat_prb($arr));
       
        $this->message = '';
        if (!empty($load->response->list)){
            $i = 0;            
            foreach($load->response->list as $rep){
                $init = $i;
                $res[$init]['no'] = $i+1;
                foreach($rep as $key => $val){                              
                    $res[$init][$key] = $val;                               
                }                
                $i++;
            }
        }else{
            if (!empty($load->metaData->message)){
                if ($load->metaData->message != 'Sukses'){
                    $this->message = $load->metaData->message;
                }
            }
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
    
    /**
     * 
     * @return type
     */
    public function getColumnObatPrb($pilih=false){        
        return [
            [
                'header' => 'Pilih',
                'type' =>'raw',
                'value' => function($data){
                    $res = json_encode($data);
                    
                    return CHtml::link("<i class='icon-form-check'></i>", 'javascript:;',[                        
                        'onclick' => 'pilihObatPRB('.$res.')'
                    ]);
                },
                'visible' => $pilih
            ],
            [
                'header' => 'Kode',
                'name' => 'kode',
                'headerHtmlOptions'=>[
                    'class'=>'message-bpjs',
                    'data-message' => $this->message
                ]
            ],
            [
                'header' => 'Nama Obat Generik Program PRB',
                'name' => 'nama'
            ],           
        ];        
    }
    
    /**
     * untuk mengenerate data grafik
     */
    public function tabelDiagnosaPrb(){
        
        $res = [];
        
        $bpjs = new BpjsVklaim();        
        
        $load = json_decode($bpjs->list_diagnosa_prb());
       
        $this->message = '';
        if (!empty($load->response->list)){
            $i = 0;            
            foreach($load->response->list as $rep){
                $init = $i;
                $res[$init]['no'] = $i+1;
                foreach($rep as $key => $val){                              
                    $res[$init][$key] = $val;                               
                }                
                if (!empty($this->nama)){                    
                    if (strpos(strtolower($res[$init]['nama']),  strtolower($this->nama)) === false){
                        unset($res[$init]);
                    }
                }
                if (!empty($this->kode)){                    
                    if (strpos(strtolower($res[$init]['kode']),  strtolower($this->kode)) === false){
                        unset($res[$init]);
                    }
                }
                $i++;
            }
        }else{
            if (!empty($load->metaData->message)){
                if ($load->metaData->message != 'Sukses'){
                    $this->message = $load->metaData->message;
                }
            }
        }
        
        return new CArrayDataProvider($res, array(
            'keyField'=>'no',			
            'id'=>'diagnosa_prb',
                'totalItemCount'=>count($res),
                'pagination' => array(
                    'pageSize' => 10,
                    'pageVar' => 'page'
                ),			
        ));
        
    }
    
    /**
     * 
     * @return type
     */
    public function getColumnDiagnosaPrb($pilih=false){        
        return [
            [
                'header' => 'Pilih',
                'type' =>'raw',
                'value' => function($data){
                    $res = json_encode($data);
                    
                    return CHtml::link("<i class='icon-form-check'></i>", 'javascript:;',[                        
                        'onclick' => 'pilihDiagnosaPRB('.$res.')'
                    ]);
                },
                'visible' => $pilih
            ],
            [
                'header' => 'Kode',
                'name' => 'kode',
                'headerHtmlOptions'=>[
                    'class'=>'message-bpjs',
                    'data-message' => $this->message
                ]
            ],
            [
                'header' => 'Nama',
                'name' => 'nama'
            ],           
        ];        
    }
    
    /**
     * untuk mengenerate data grafik
     */
    public function tabelDokterDpjp(){
        
        $res = [];
        
        $bpjs = new BpjsVklaim();        
        $this->tglsep = date('Y-m-d');
        $query = $this->jnspelayanan ."/tglPelayanan/". $this->tglsep ."/Spesialis/" .$this->kodespesialis;
        $start = 1;
        $limit = 10;
        
        $load = json_decode($bpjs->search_dpjp($query,$start, $limit));
       
        $this->message = '';
        if (!empty($load->response->list)){
            $i = 0;           
            $kode = [];
            foreach($load->response->list as $rep){
                $init = $i;
                $res[$init]['no'] = $i+1;
                foreach($rep as $key => $val){                              
                    $res[$init][$key] = $val;                                                   
                }                                
                $kode[$rep->kode] = $rep->kode;                                
                
                $i++;
            }
            
            if ($this->isdokterrs){
                $cri = new CDbCriteria;
                $cri->select = " pegawai_id, kodedokter_bpjs ";
                $cri->addInCondition("kodedokter_bpjs",$kode);
                $peg = PegawaiM::model()->findAll($cri);

                $pegRs = [];
                foreach($peg as $v){
                    $pegRs[$v->kodedokter_bpjs] = $v->pegawai_id;
                }

                foreach($res as $key => $val){                              
                    $res[$key] = $val;   
                    if (isset($pegRs[$val['kode']])){
                        $res[$key]['dpjp_id'] = $pegRs[$val['kode']];
                        $res[$key]['dpjp_nama'] = $val['nama'];
                    }else{
                        unset($res[$key]);
                    }
                }  

                if (empty($res)){
                    $this->message = 'Pegawai belum di mapping berdasarkan kode bpjsnya';
                }                    
            }
            
        }else{
            if (!empty($load->metaData->message)){
                if ($load->metaData->message != 'Sukses'){
                    $this->message = $load->metaData->message;
                }
            }
        }
        
        return new CArrayDataProvider($res, array(
            'keyField'=>'no',			
            'id'=>'dokter_dpjp',
                'totalItemCount'=>count($res),
                'pagination' => array(
                    'pageSize' => 10,
                    'pageVar' => 'page'
                ),			
        ));
        
    }
    
    /**
     * 
     * @return type
     */
    public function getColumnDokterDpjp($pilih=false){        
        return [
            [
                'header' => 'Pilih',
                'type' =>'raw',
                'value' => function($data){
                    $res = json_encode($data);
                    
                    return CHtml::link("<i class='icon-form-check'></i>", 'javascript:;',[                        
                        'onclick' => 'pilihDokterDPJP('.$res.')'
                    ]);
                },
                'visible' => $pilih
            ],
            [
                'header' => 'Kode',
                'name' => 'kode',
                'headerHtmlOptions'=>[
                    'class'=>'message-bpjs',
                    'data-message' => $this->message
                ]
            ],
            [
                'header' => 'Nama',
                'name' => 'nama'
            ],           
        ];        
    }
}
?>


