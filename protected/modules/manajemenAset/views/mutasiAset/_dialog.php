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

    echo $this->renderPartial($this->path_view.'grid/_lokasi',['model'=>$model], true);

    $this->endWidget();
    
    //========= Dialog buat cari aset peralatan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPeralatan',
        'options' => array(
            'title' => 'Aset Peralatan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'height' => 600,
            'resizable' => false,
        ),
    ));  

    echo $this->renderPartial($this->path_view.'grid/_aset',['model'=>$model], true);

    $this->endWidget();
    
     //========= Dialog buat cari aset peralatan =========================

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPegawaiMenyerahkan',
        'options' => array(
            'title' => 'Pegawai yang Menyerahkan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'height' => 600,
            'resizable' => false,
        ),
    ));


    echo $this->renderPartial($this->path_view.'grid/_peg_menyerahkan',['model'=>$model], true);

    $this->endWidget();
    
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPegawaiTerima',
        'options' => array(
            'title' => 'Pegawai Penerima',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'height' => 600,
            'resizable' => false,
        ),
    ));  
    
    echo $this->renderPartial($this->path_view.'grid/_peg_penerima',['model'=>$model], true);

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
            $(".ruanganasal_id").val(data.ruangan_id);
            $(".ruanganasal_nama").val(data.ruangan_nama);
            
            var a = 1;
            $("#tableDetailBarang > tbody > tr").each(function(){
                if (a != 1){
                    $(this).remove();
                }else{            
                    $(this).find('input,select,textarea').val("");
                    $(this).find('.lbl').html("");
                }
                a++;
            })
            
            setTimeout(function(){
                renameInputRow($("#tableDetailBarang"));
            },500)            
        }else if (jenis == 'tujuan'){
            $(".lokasitujuan_id").val(data.lokasi_id);
            $(".lokasitujuan_nama").val(data.lokasiaset_namalokasi);
            $(".ruangantujuan_id").val(data.ruangan_id);
            $(".ruangantujuan_nama").val(data.ruangan_nama);
        }
        
        $("#dialogLokasi").dialog('close');
    }
</script>