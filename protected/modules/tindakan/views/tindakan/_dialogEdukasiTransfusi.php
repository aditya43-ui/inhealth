<?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialog-edukasi-transfusi',
        'options'=>array(
            'title'=>'Dialog Edukasi Transfusi',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>960,
            'minHeight'=>580,
            'resizable'=>false,
        ),
    ));

    $is_setuju = $modPendaftaran->isbacaedukasitransfusi;
    
    $modPersetujuan = EdukasitransfusiitemM::model()->findAll('edukasitransfusiitem_aktif = true order by edukasitransfusiitem_urutan');
    
    echo "<ol>";
    foreach ($modPersetujuan as $item) {
        echo '<li style="margin-bottom: 20px;">';
        echo strtoupper($item->edukasitransfusiitem_nama)." ".CHtml::checkBox('ceklis_edukasi['.$item->edukasitransfusiitem_id.']',$is_setuju, array(
            'class'=>'ceklis_edukasi',
            'disabled'=>$is_setuju,
            'onclick'=>'setCeklisBacaEdukasi()',
        ))."<br>";
        echo $item->edukasitransfusiitem_deskripsi;
        echo "</li>";
    }
    echo "</ol>";
    
    echo CHtml::button('Sudah dibacakan kepada pasien?', array(
        'class'=>'btn btn-primary', 'id'=>'btn_edukasi_sudah_dibaca',
        'onclick'=>'setBacaSemua()',
        'disabled'=>true,
    ));
    
    $this->endWidget();
?>

<script>
    
    function setCeklisBacaEdukasi() {
        if ($(".ceklis_edukasi:checked").length == $(".ceklis_edukasi").length) {
            $("#btn_edukasi_sudah_dibaca").prop("disabled", false);
        } else {
            $("#btn_edukasi_sudah_dibaca").prop("disabled", true);
        }
    }
    
    function setBacaSemua() {
        $(".ceklis_edukasi").prop("disabled", true);
        $("#btn_edukasi_sudah_dibaca").prop("disabled", true);
        $.post('<?php echo $this->createUrl('sudahBacaEdukasi'); ?>', {id: <?php echo $modPendaftaran->pendaftaran_id; ?>}, function(data) {
            $("#dialog-edukasi-transfusi").dialog('close');
            myAlert("Edukasi Transfusi sudah dibacakan");
        });
    }
    
</script>