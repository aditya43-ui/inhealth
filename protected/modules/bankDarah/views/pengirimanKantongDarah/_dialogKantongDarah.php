<?php 
/* ========= Dialog buat cari Kantong Darah ========================= */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogKantongDarah',
    'options' => array(
        'title' => 'Daftar Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));

$modKantong = new InfokantongdarahV('searchDialog');
$modKantong->unsetAttributes();
if (isset($_GET['InfokantongdarahV'])){
    $modKantong->attributes = $_GET['InfokantongdarahV'];
    $modKantong->create_ruangan =  Yii::app()->user->getState('ruangan_id');
    $modKantong->no_penggunaan_coolbox = isset($_GET['InfokantongdarahV']['no_penggunaan_coolbox'])?$_GET['InfokantongdarahV']['no_penggunaan_coolbox']:null;
    $modKantong->coolboxdarah_nama = isset($_GET['InfokantongdarahV']['coolboxdarah_nama'])?$_GET['InfokantongdarahV']['coolboxdarah_nama']:null;
    $modKantong->coolboxdarah_id = isset($_GET['InfokantongdarahV']['coolboxdarah_id'])?$_GET['InfokantongdarahV']['coolboxdarah_id']:null;    
    $modKantong->nomorbarcode_utama = isset($_GET['InfokantongdarahV']['nomorbarcode_utama'])?$_GET['InfokantongdarahV']['nomorbarcode_utama']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modKantong->searchDialogKirim(),
    'filter'=>$modKantong,
    'template'=>"{summary}\n{items}{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
                'header'=>CHtml::checkBox('pilihSemua', false, array(
                        'class'=>'check_all_produk', 'onchange'=>'setSemuaKantong(this);'
                )).' Pilih Semua',
                'type'=>'raw',
                'value'=>function($data){
                        return CHtml::checkBox('check', false, array(                                
                                'onchange'=>'setKantong(this);',
                                'class'=>'pilih',
                                'nomorbarcode_utama' => $data['nomorbarcode_utama'],
                                'no_penggunaan_coolbox'=>empty($data["no_penggunaan_coolbox"])?"":$data["no_penggunaan_coolbox"], 
                        ));
                },
                'htmlOptions'=>array(
                        'style'=>'text-align: center',
                ),
                'footer' => CHtml::htmlButton('OK', array('class'=>'btn btn-green', 'onclick'=>'inputKantong();'))
        ),
        // array(
        //     'header' => 'No. Penggunaan Coolbox',
        //     'name' => 'no_penggunaan_coolbox',
        //     'value' => '$data["no_penggunaan_coolbox"]'
        // ),
        array(
            'header' => 'No. Kantong Pabrik',
            'name' => 'no_kantongpabrik',
            'value' => '$data["no_kantongpabrik"]'
        ),
        // array(
        //     'header' => 'Jenis Coolbox',
        //     'name' => 'coolboxdarah_nama',
        //     'filter' => CHtml::activeHiddenField($modKantong, 'coolboxdarah_id',array('class'=>'dialog_coolboxdarah_id')),
        //     'value' => '$data["coolboxdarah_nama"]'
        // ),
        array(
            'header'=>' No. Kantong Utama / No. Sample',
            'name'=>'nomorbarcode_utama',
             'value'=>function($data){
                    
                    foreach($data['sampel'] as $d){
                        echo $d['nomorbarcode_utama']."<br/>";
                    }                                            
            },
        ),
        array(
            'header'=>'Golongan Darah',
            'name'=>'gol_darah',
             'value'=>function($data){                    
                    foreach($data['sampel'] as $d){
                        echo $d['gol_darah']."<br/>";
                    }                                            
            },
        ),
        array(
            'header'=>'Rhesus',
            'name'=>'rhesus',
            'value'=>function($data){                    
                    foreach($data['sampel'] as $d){
                        echo $d['rhesus']."<br/>";
                    }                                            
            },
        ),
        array(
            'header'=>'Jenis Kantong',
            'name'=>'nama_jenis',
            'value'=>function($data){                    
                    foreach($data['sampel'] as $d){
                        echo $d['nama_jenis']."<br/>";
                    }                    
                        
            },
        ),
        // array(
        //     'header' => 'No Kantong Darah',
        //     'filter' => false,
        //     'value' => function($data){
        //         if (!empty($data['det'])){
        //             echo "<ul>";
        //             foreach($data['det'] as $d){
        //                 echo "<li>".$d['no_kantongdarah']."</li>";
        //             }
        //             echo "</ul>";
        //         }
        //     }
        // )
        
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});setCeklisKantong();}',
));
$this->endWidget();
?>