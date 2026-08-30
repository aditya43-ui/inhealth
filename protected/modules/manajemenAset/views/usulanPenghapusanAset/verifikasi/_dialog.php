<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogLokasi',
        'options' => array(
            'title' => 'Daftar Lokasi Sementara',
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
        $(".lokasisementara_id").val(data.lokasi_id);
        $(".lokasisementara_nama").val(data.lokasiaset_namalokasi);
        
        $("#dialogLokasi").dialog('close');
    }
</script>