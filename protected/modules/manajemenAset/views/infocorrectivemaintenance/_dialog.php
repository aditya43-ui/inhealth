
<?php
//========= Dialog daftar ruangan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRuangan',
    'options'=>array(
        'title'=>'Daftar Ruangan Aset',
        'autoOpen'=>false,        
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

$this->renderPartial($this->path_view.'grid._grid_daftar_ruangan',[]);

$this->endWidget();


//========= Dialog daftar lokasi  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogLokasi',
    'options'=>array(
        'title'=>'Daftar Lokasi Aset',
        'autoOpen'=>false,        
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));


$this->renderPartial($this->path_view.'grid._grid_lokasi_aset',['model'=>$model]);


$this->endWidget();


//========= Dialog daftar lokasi  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTeknisi',
    'options'=>array(
        'title'=>'Daftar Teknisi',
        'autoOpen'=>false,        
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));


$this->renderPartial($this->path_view.'grid._peg_penerima',['model'=>$model]);


$this->endWidget();


$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSetTeknisi',
    'options'=>array(
        'title'=>'Daftar Teknisi',
        'autoOpen'=>false,        
        'modal'=>true,
        'width'=>500,
        'height'=>350,
        'resizable'=>false,
    ),
));

echo '<div class="form-horizontal form-utama form-body" id="form-set-teknisi" del="teknisi"></div>';
?>
<div class="form-set-teknisi-btn form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary btn-sm', 'type'=>'button','onclick'=>'cekTeknisi();')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Batal',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger btn-sm', 'type'=>'button','onclick'=>'$("#dialogSetTeknisi").dialog("close");$("#form-set-teknisi").html("");')); ?>    
</div>
<?php

$this->endWidget();
?>

<script>
    var setRuangan = (data) => {                
        
        $(".ruangpemohon_id").val(data.ruangan_id);
        $(".ruangpemohon_nama").val(data.ruangan_nama);
        
        $("#dialogRuangan").dialog('close');
    }
    
    var setLokasi = (data) => {
        $(".lokasi_id").val(data.lokasi_id);
        $(".lokasiaset_namalokasi").val(data.lokasiaset_namalokasi);
        
        $("#dialogLokasi").dialog('close');
    }
    
    var setPegawai = (data) => {
        $(".teknisipemeliharaanaset_id").val(data.pegawai_id);
        $(".teknisipemeliharaanaset_nama").val(data.namaLengkap);
        
        $("#dialogTeknisi").dialog('close');
    }
    
    var refreshGridLokasi = () => {
        
        var ruangan_id = $(".ruangpemohon_id").val();
        
        
        $.fn.yiiGridView.update('lokasi-grid', {
            data: {
                'LokasiasetM[ruangan_id]':ruangan_id,
                'LokasiasetM[default]':'',
            }
        });
    }
</script>