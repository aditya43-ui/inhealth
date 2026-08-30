<?php
// dialog id lab
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugasRuangan',
    'options' => array(
        'title' => 'Daftar <span class="judul-petugas-ruangan"></span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));
$this->renderPartial('rawatInap.views.asesmenPraBedah.grid/_daftarPetugasRuangan',[]);
$this->endWidget();


$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Pencarian Data Penyakit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));
$this->renderPartial('rawatInap.views.asesmenPraBedah.grid/_daftarDiagnosa',[]);
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogObat',
    'options' => array(
        'title' => 'Pencarian Data Obat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));
$this->renderPartial('rawatInap.views.asesmenPraBedah.grid/_daftarObat',[]);
$this->endWidget();

$paramModul = Params::MODUL_ID_ANESTESI;
$paramRuanganLogin = Yii::app()->user->getState('ruangan_id');
$paramRuanganAnestesi = Params::RUANGAN_ID_ANASTESI;
$jscript = <<< JS
        
          
    const setPetugasRuangan = (data, obj, jenis) => {
        
        if (jenis == ''){
            jenis = $("#jnsDialog").val();
        }
       
        if (jenis == 'bedah'){            
            $(".dokterbedah_id").val(data.pegawai_id);
            $(".dokterbedah_nama").val(data.namaLengkap);
        
            $(".judul-petugas-ruangan").html("Dokter Bedah");
        }else if (jenis == 'anestesi'){
            $(".dokteranestesi_id").val(data.pegawai_id);
            $(".dokteranestesi_nama").val(data.namaLengkap);
        
            $(".judul-petugas-ruangan").html("Dokter Anestesi");
        }
        
        $("#dialogPetugasRuangan").dialog("close");
    }
        
    const refreshGridPetugasRuangan = (jenis) => {
                
        let ruangId = '';
        let modulId = '';
        
        if (typeof jenis === 'undefined'){
            jenis = $("#jnsDialog").val();
        }
        
        if (jenis == 'bedah'){
            ruangId = '${paramRuanganLogin}';
        }else if (jenis == 'anestesi'){            
            ruangId = '${paramRuanganAnestesi}';
        }
        
        $.fn.yiiGridView.update('daftar-petugas-ruangan-grid', {
            data: {
                'PegawairuanganV[default]':'',
                'PegawairuanganV[ruangan_id]':ruangId,                
            }
        });
    }
        
    const setDiagnosa = (data) => {                
        const riwayat = $(".riwayatpenyakit").val();
        $(".riwayatpenyakit").val((riwayat != '')?riwayat+', '+data.diagnosa_nama:data.diagnosa_nama);
        
        $("#dialogDiagnosa").dialog("close");
    }
        
    const refreshGridDiagnosa = () => {              
        $.fn.yiiGridView.update('daftar-diagnosa-grid', {
            data: {
                'DiagnosaM[default]':'',
            }
        });
    }
            
    const setObat = (data) => {        
        const riwayat = $(".riwayatpengobatan").val();
        $(".riwayatpengobatan").val((riwayat != '')?riwayat+', '+data.obatalkes_nama:data.obatalkes_nama);               
        
        $("#dialogObat").dialog("close");
    }
        
    const refreshGridObat = () => {              
        $.fn.yiiGridView.update('daftar-obat-grid', {
            data: {
                'ObatalkesM[default]':'',
            }
        });
    }
        
JS;

Yii::app()->clientScript->registerScript('asesmen-pra-bedah-dialog',$jscript, CClientScript::POS_HEAD);
?>


