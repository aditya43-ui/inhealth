<?php 
/* ========= Dialog buat cari Kantong Darah ========================= */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKantongDarah',
    'options' => array(
        'title' => 'Daftar Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 700,
        'resizable' => false,
    ),
));

$modKantong = new BDKantongdarahT('searchDialog');
$modKantong->unsetAttributes();
if (isset($_GET['BDKantongdarahT'])){
    $modKantong->attributes = $_GET['BDKantongdarahT'];
    $modKantong->nomorbarcode_utama = isset($_GET['BDKantongdarahT']['nomorbarcode_utama'])?$_GET['BDKantongdarahT']['nomorbarcode_utama']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modKantong->searchKantongBaru(),
    'filter'=>$modKantong,
    'template'=>"{summary}\n{items}{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data){
                $rhesus_positif = false;
                $rhesus_negatif = false;
                if ($data['rhesus'] == 'Positif') {
                    $rhesus_positif = true;
                }elseif ($data['rhesus'] == 'Negatif') {
                    $rhesus_negatif = true;
                }
                
                
    
                return CHtml::Link("<span style='font-size:20px;'><i class='icon-form-check'></i></span>","javascript:void(0)",array("class"=>"btn-small", 
				"id" => "selectBarang",
				"onClick" => "				
                                        $('#nomorbarcode_utama').val('".$data['nomorbarcode_utama']."');
                                        $('#daftardonasi_id').val('".$data['daftarpendonor_id']."');
                                        $('#nomorbarcode').val('".$data['nomorbarcode_utama']."');  
                                        $('#PenggunaanCoolboxdetT_jeniskantong').val('".$data['nama_jenis']."');  
                                        $('#PenggunaanCoolboxdetT_gol_darah').val('".$data['gol_darah']."');  
                                        $('#PenggunaanCoolboxdetT_rhesus_0').prop('checked',".$rhesus_positif.");  
                                        $('#PenggunaanCoolboxdetT_rhesus_1').prop('checked',".$rhesus_negatif.");  
                                        cekData('".$data['nomorbarcode_utama']."');                                                                          
					$('#dialogKantongDarah').dialog('close');
					return false;"));
            },
        ),
        array(
            'header'=>'No. Kantong Utama',
            'name'=>'nomorbarcode_utama',
             'value'=>function($data){
                    
                    foreach($data['sampel'] as $d){
                        echo $d['nomorbarcode_utama']."<br/>";
                    }                                            
            },
        ),
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>