
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogSubJenis',
    'options' => array(
        'title' => 'Pencarian Data Sub Jenis Obat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 550,
        'resizable' => false,
    ),
));

echo $this->renderPartial($this->path_view.'grid/_daftarSubJenisObat',[], true);
        
$this->endWidget();
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogSigna',
    'options'=>array(
        'title'=>'Pencarian Signa',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));
    
echo $this->renderPartial($this->path_view.'grid/_daftarSignaOa',[], true);
    
$this->endWidget();
?>

<script type="text/javascript">
    const setSigna = (data) => {
        $(".signaoa").val(data.value);
        
        if (typeof loadJadwal === 'function'){
            loadJadwal();
        }
        
        $("#dialogSigna").dialog("close")
    }
    
    const setSubjenis = (data) => {
        $(".subjenis_id").val(data.id);
        $(".subjenis_nama").val(data.name);
        
        if (typeof loadJadwal === 'function'){
            loadJadwal();
        }
        
        $("#dialogSubJenis").dialog("close");
    }
    
    const refreshGridSigna = () => {
        $.fn.yiiGridView.update('signa-oa-grid',{
            data: {
                'LookupM[default]':''
            }
        })
    }
    
    const refreshGridSubjenis = () => {
        $.fn.yiiGridView.update('subjenis-oa-grid',{
            data: {
                'SubjenisM[default]':''
            }
        })
    }
</script>