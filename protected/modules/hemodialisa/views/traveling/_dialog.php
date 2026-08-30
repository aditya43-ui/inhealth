<?php
// dialog diagnosa x
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Cari <span class="judul-petugas"></span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 420,
        'resizable' => false,
    ),
));

$this->renderPartial('grid/_daftarPetugas');

$this->endWidget();


$jscript = <<< JS
  
    const setPetugas = (data, obj, jenis) => {
        
        if (jenis == ''){
            jenis = $("#jenis_dialog").val();
        }
        
        if (jenis == 'dpjp'){
            $(".dpjp_id").val(data.pegawai_id);
            $(".dpjp_nama").val(data.namaLengkap);
        }else if (jenis == 'perawat1'){
            $(".perawat1_id").val(data.pegawai_id);
            $(".perawat1_nama").val(data.namaLengkap);
        }else if (jenis == 'perawat2'){
            $(".perawat2_id").val(data.pegawai_id);
            $(".perawat2_nama").val(data.namaLengkap);
        }
        
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

Yii::app()->clientScript->registerScript('traveling-dialog',$jscript, CClientScript::POS_HEAD);
?>


