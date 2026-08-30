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


    public function rules()
    {
        return array(
            array('obatprb, berdasarkantgl, jenissurat, tgl_awal, tgl_akhir','safe','on'=>'search')
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
        $arr = [
            'tglAwal' => $this->tgl_awal,
            'tglAkhir' => $this->tgl_akhir,            
            'tglBerdasarkan' => $this->berdasarkantgl
        ];
        
        $load = json_decode($bpjs->list_rencana_kontrol($arr));
       
        $this->message = '';
        if (!empty($load->response)){
            $i = 0;            
            foreach($load->response->list as $rep){
                $init = $i;
                $res[$init]['no'] = $i+1;
                foreach($rep as $key => $val){                              
                    $res[$init][$key] = $val;                               
                }
                if (!empty($this->jenissurat)){                    
                    if ($res[$init]['jnsKontrol'] != $this->jenissurat){
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
            [
                'header' => '<center>Detail</center>',
                'type' => 'raw',
                'value' => function($data){
                    return CHtml::link("<i class='icon-form-lihat'></i>", 'javascript:;',['onclick'=>'toastr.info("under construction","Perhatian!")']);
                },
                'htmlOptions' => [
                    'style' => 'text-align:center;'
                ]
            ]
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
}
