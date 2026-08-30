
<?php
//========= Dialog daftar ruangan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRuangan',
    'options'=>array(
        'title'=>'Daftar Ruangan Aset',
        'autoOpen'=>false,
        'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

$this->renderPartial('manajemenAset.views.informasiWorkOrder.grid._grid_daftar_ruangan',[]);

$this->endWidget();

//========= Dialog daftar ruangan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogLokasiAset',
    'options'=>array(
        'title'=>'Daftar Lokasi Aset',
        'autoOpen'=>false,
        'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

$this->renderPartial('manajemenAset.views.informasiWorkOrder.grid._grid_lokasi_aset',['model'=>$model]);

$this->endWidget();
?>
<script>
    var setRuangan = (data) => {                
        
        $(".ruangan_id").val(data.ruangan_id);
        $(".ruangan_nama").val(data.ruangan_nama);
        
        $("#dialogRuangan").dialog('close');
    }
    
    var setLokasi = (data) => {
        $(".lokasi_id").val(data.lokasi_id);
        $(".lokasi_nama").val(data.lokasiaset_namalokasi);
        
        $("#dialogLokasiAset").dialog('close');
    }
           
    var refreshGridLokasi = () => {
        
        var ruangan_id = $(".ruangan_id").val();
        
        
        $.fn.yiiGridView.update('lokasi-grid', {
            data: {
                'LokasiasetM[ruangan_id]':ruangan_id,
            }
        });
    }
</script>