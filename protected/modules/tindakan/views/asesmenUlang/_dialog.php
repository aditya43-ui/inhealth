<?php
// dialog petugas
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Daftar <span class="judul-dialog-petugas"></span>',
        'autoOpen' => false,
        //'position'=>['top',20] ,
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));
$this->renderPartial('grid/_daftar_petugas',[]);
$this->endWidget();

$jscript = <<< JS
       
       
    const setPetugas = (data, obj, jenis) => {
        
        if (jenis == ''){
            jenis = $("#jenis_dialog").val();
        }
        
        $(".petugaspengkaji_id").val(data.pegawai_id);
        $(".petugaspengkaji_nama").val(data.namaLengkap);
        
        
        $("#dialogPetugas").dialog("close");
    }
        
    const refreshGridPetugas = () => {
        $.fn.yiiGridView.update('daftar-petugas-grid', {
            data: {
                'PegawaiV[default]':''
            }
        });
    }
        
JS;

Yii::app()->clientScript->registerScript('cpis-pasien-dialog',$jscript, CClientScript::POS_HEAD);
?>


