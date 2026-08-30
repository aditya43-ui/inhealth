<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogLokasi',
        'options' => array(
            'title' => 'Daftar Lokasi Aset',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    echo $this->renderPartial($this->path_view.'informasi/grid/_lokasi',['model'=>$model], true);

    $this->endWidget();

?>

<script>
    var setLokasi = (data) => {
        $(".lokasi_id").val(data.lokasi_id);
        $(".lokasi_aset").val(data.lokasiaset_namalokasi);
        
        $("#dialogLokasi").dialog('close');
    }
</script>