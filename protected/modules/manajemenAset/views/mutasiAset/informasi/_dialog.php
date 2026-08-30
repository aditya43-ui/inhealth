<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogRuangan',
        'options' => array(
            'title' => 'Daftar Ruangan',
            'autoOpen' => false,            
            'modal' => true,
            'width' => 550,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    echo $this->renderPartial($this->path_view.'grid/_ruangan',['model'=>$model], true);

    $this->endWidget();
        
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

    echo $this->renderPartial($this->path_view.'grid/_lokasi',['model'=>$model], true);

    $this->endWidget();
?>

<script>
    var setLokasi = (data,jenis) => {
        
        if (jenis == ''){
            jenis = $("#jenis").val();
        }
        
        if (jenis == 'asal'){
            $(".lokasiasal_id").val(data.lokasi_id);
            $(".lokasiasal_nama").val(data.lokasiaset_namalokasi);                                               
        }else if (jenis == 'tujuan'){
            $(".lokasitujuan_id").val(data.lokasi_id);
            $(".lokasitujuan_nama").val(data.lokasiaset_namalokasi);            
        }
        
        $("#dialogLokasi").dialog('close');
    }
    
    var setRuangan = (data,jenis) => {
        
        if (jenis == ''){
            jenis = $("#jenis").val();
        }
        
        if (jenis == 'asal'){
            $(".ruanganasal_id").val(data.ruangan_id);
            $(".ruanganasal_nama").val(data.ruangan_nama);                                               
        }else if (jenis == 'tujuan'){
            $(".ruangantujuan_id").val(data.ruangan_id);
            $(".ruangantujuan_nama").val(data.ruangan_nama);            
        }
        
        $("#dialogRuangan").dialog('close');
    }
    
    var refreshGridLokasi = (jenis) => {
        
        var ruangan_id = $(".ruanganasal_id").val();
        var is_pj = '<?= ($model->is_pj_aset)?'ya':'' ?>';
        if (jenis == 'tujuan'){
            ruangan_id = $(".ruangantujuan_id").val();
            is_pj = '';
        }
        
        $.fn.yiiGridView.update('lokasi-grid', {
            data: {
                'LokasiasetM[ruangan_id]':ruangan_id,
                'LokasiasetM[lokasi_aset_pj]':is_pj,
            }
        });
    }
</script>