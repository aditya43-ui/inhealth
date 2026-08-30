<?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKantongDarah',
    'options' => array(
        'title' => 'Kantong Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'resizable' => false,
    ),
));
    
    
$modKantong = new BDKantongdarahT('search');
$modKantong->unsetAttributes();
if (isset($_GET['BDKantongdarahT'])) {
    $modKantong->attributes = $_GET['BDKantongdarahT'];
//    $modKantong->gol_darah = $_GET['BDKantongdarahT']['gol_darah'];
//    $modKantong->rhesus = $_GET['BDKantongdarahT']['rhesus'];
    $modKantong->singkatan_komp = $_GET['BDKantongdarahT']['singkatan_komp'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kantong-darah-grid',
    'dataProvider' => $modKantong->searchKantongDarahuntukPendonor(),
    'filter' => $modKantong,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',                                                
            'value'=>function($data) {                                                                

                return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
                            "id" => "selectBahan",
                            "onClick" => 
                                        'tambahKantongDarah('.$data->kantongdarah_id.', "auto"); '
                                        . '$(\'#dialogKantongDarah\').dialog(\'close\')'));
            },
        ), 
        'no_kantongdarah',
        array(
            'header'=>'Jenis Komponen Darah',
            'name'=>'komponendarah_id',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->komponendarah_id)) {
                    return "-";
                }
                $jenis = KomponendarahM::model()->findByPk($data->komponendarah_id);
                
                if (empty($jenis)) {
                    return "-";
                }
                
                return $jenis->singkatan_komp;
            },
            'filter'=>CHtml::activeDropDownList($modKantong, 'singkatan_komp',
                CHtml::listData(KomponendarahM::model()->findAll('komponendarah_aktif = true order by komponendarah_id'),
                    'singkatan_komp', 'singkatan_komp'),
                array('empty'=>'-- Pilih --')
            ),
        ),
        array(
            'name'=>'jeniskantongdarah_id',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->jeniskantongdarah_id)) {
                    return "-";
                }
                $jenis = JeniskantongdarahM::model()->findByPk($data->jeniskantongdarah_id);
                
                if (empty($jenis)) {
                    return "-";
                }
                
                return $jenis->nama_jenis;
            },
            'filter'=>CHtml::activeDropDownList($modKantong, 'jeniskantongdarah_id',
                CHtml::listData(JeniskantongdarahM::model()->findAll('jeniskantongdarah_aktif = true order by jeniskantongdarah_id'),
                    'jeniskantongdarah_id', 'nama_jenis'),
                array('empty'=>'-- Pilih --')
            ),
        ),
//        array(
//            'name'=>'gol_darah',
//            'header'=>'Golongan Darah',
//            'filter'=>CHtml::activeDropDownList($modKantong, 'gol_darah', LookupM::getItems('golongandarah'), array(
//                'empty'=>'-- Pilih --',
//            )),
//        ),
//        array(
//            'name'=>'rhesus',
//            'header'=>'Rhesus',
//            'filter'=>CHtml::activeDropDownList($modKantong, 'rhesus', array('Positif'=>'Positif', 'Negatif'=>'Negatif'), array(
//                'empty'=>'-- Pilih --',
//            )),
//        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); loadCeklisKantongDarah();}',
));
$this->endWidget();
?>