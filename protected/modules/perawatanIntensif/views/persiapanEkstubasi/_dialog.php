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

$paramsKelompokDokter = Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK;
$jscript = <<< JS
       
       
    const setPetugas = (data, obj, jenis) => {        
        if (jenis == ''){
            jenis = $("#jns_dialog").val();
        }
        
        if (jenis == 'dokter-jaga'){
            $(".judul-dialog-petugas").html("Dokter Jaga");
        
            $(".dokterjaga_id").val(data.pegawai_id);
            $(".dokterjaga_nama").val(data.namaLengkap);
        }else if (jenis == 'dokter-anestesi'){
            $(".judul-dialog-petugas").html("Dokter Anestesi");
        
            $(".dokteranestesi_id").val(data.pegawai_id);
            $(".dokteranestesi_nama").val(data.namaLengkap);
        }else if (jenis == 'perawat-jaga'){
            $(".judul-dialog-petugas").html("Perawat Jaga");
        
            $(".perawatjaga_id").val(data.pegawai_id);
            $(".perawatjaga_nama").val(data.namaLengkap);
        }
                        
        $("#dialogPetugas").dialog("close");
    }
        
    const refreshGridPetugas = (jenis) => {
        const ruanganId = [
            46, 23, 20, 26
        ];
        let kelompokpegawai_id = '';
        
        if (jenis == 'dokter-jaga' || jenis == 'dokter-anestesi'){
            kelompokpegawai_id = '${paramsKelompokDokter}';
        }
        
        $.fn.yiiGridView.update('daftar-petugas-grid', {
            data: {
                'PegawairuanganV[default]':'',
                'PegawairuanganV[kelompokpegawai_id]':kelompokpegawai_id,
                'PegawairuanganV[ruangan_id]':ruanganId,
            }
        });
    }
        
JS;

Yii::app()->clientScript->registerScript('cpis-pasien-dialog',$jscript, CClientScript::POS_HEAD);
?>


