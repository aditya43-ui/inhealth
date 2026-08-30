<?php
/** 
 * view ini digunakan untuk menampilkan data dialog
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */

/** Pegawai Pemeriksa Start **/
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPeg',
    'options'=>array(
            'title'=>'Pencarian Pemeriksa',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>800,
            'height'=>500,
            'resizable'=>false,
    ),
));
$modPA = new PejabatpengadaanM('search');
$modPA->jabatan_pengadaan = Params::JABATAN_PENGADAAN_TIM_TEKNIS;
if(isset($_GET['PejabatpengadaanM'])){
    $modPA->attributes = $_GET['PejabatpengadaanM'];
    $modPA->nomorindukpegawai = isset($_GET['PejabatpengadaanM']['nomorindukpegawai'])?$_GET['PejabatpengadaanM']['nomorindukpegawai']:null;
    $modPA->nama_pegawai = isset($_GET['PejabatpengadaanM']['nama_pegawai'])?$_GET['PejabatpengadaanM']['nama_pegawai']:null;
    $modPA->namaunitkerja = isset($_GET['PejabatpengadaanM']['namaunitkerja'])?$_GET['PejabatpengadaanM']['namaunitkerja']:null;
    $modPA->jabatan_nama = isset($_GET['PejabatpengadaanM']['jabatan_nama'])?$_GET['PejabatpengadaanM']['jabatan_nama']:null;
    $modPA->default = isset($_GET['PejabatpengadaanM']['default'])?$_GET['PejabatpengadaanM']['default']:null;    
    $modPA->jabatan_pengadaan = Params::JABATAN_PENGADAAN_TIM_TEKNIS;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pejabatpa-m-grid',
    'dataProvider'=>$modPA->searchDialogPejabat(),
    'filter'=>$modPA,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) {
                            $load = $data->attributes;
                            $load['namaLengkap'] = $data->nama_lengkap;
                            $res = json_encode($load);
    
                            return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                                    "onclick" => 'setPegPemeriksa('.$res.');$("#dialogPeg").dialog("close")'));
                        },
                ),               
                array(
                    'header'=>'NIP',
                    'name'=>'nomorindukpegawai',   
                    'filter'=> CHtml::activeHiddenField($modPA, 'jabatan_pengadaan').CHtml::activeTextField($modPA, 'nomorindukpegawai')
                ),
                array(
                    'header'=>'Nama',
                    'name'=>'nama_pegawai',                    
                    'value'=>'$data->nama_lengkap'
                ),
                array(
                    'header'=>'Jabatan',
                    'name'=>'jabatan_nama',                    
                ),
                array(
                    'header'=>'Unit Kerja',
                    'name'=>'namaunitkerja',                                       
                ),                
        ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
/** Pegawai Pemeriksa END **/

/** Data SPK START **/
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSPK',
    'options'=>array(
            'title'=>'Pencarian Penjadwalan Pemeriksaan Pekerjaan',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>800,
            'height'=>500,
            'resizable'=>false,
    ),
));
$modJadwal = new SuratperjanjiankerjaT('search');
if(isset($_GET['SuratperjanjiankerjaT'])){
    $modJadwal->attributes = $_GET['SuratperjanjiankerjaT'];    
    $modJadwal->supplier_nama = isset($_GET['SuratperjanjiankerjaT']['supplier_nama'])?$_GET['SuratperjanjiankerjaT']['supplier_nama']:null;    
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'spk-t-grid',
    'dataProvider'=>$modJadwal->searchDialog(),
    'filter'=>$modJadwal,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) {                               
                            
                            $res = json_encode($data->attributes);
                            return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                                    "onclick" => 'setJadwal('.$res.');$("#dialogSPK").dialog("close")'));
                        },
                ),               
                array(
                    'header' => 'Nomor Transaksi',
                    'name' => 'nomor_dokumen'
                ),
                array(
                    'header' => 'Nomor Dok. SPK',
                    'name' => 'nosuratperjanjiankerja'
                ),
                array(
                    'header' => 'Tanggal SPK',
                    'name' => 'tglsuratperjanjian'
                ),
                array(
                    'header' => 'Penyedia',
                    'name' => 'supplier_nama',
                    'value' => '$data->supplier_nama',
                ),
                array(
                    'header' => 'Nama Pekerjaan',
                    'name' => 'namapekerjaan',                    
                ),
        ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
/** Data SPK STOP **/