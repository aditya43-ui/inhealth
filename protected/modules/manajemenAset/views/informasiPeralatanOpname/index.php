<?php
Yii::app()->clientScript->registerScript('search', "
    $('#informasisampel-r-search').submit(function(){
        $.fn.yiiGridView.update('informasi-peralatan-opname-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php 
    $module  = $this->module->name; 
    $controller = $this->id;
    $format = new MyFormatter();
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-info-circled"></i> Informasi <strong>Peralatan dan Mesin Opname</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <strong>Peralatan dan Mesin Opname</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                          <?= $this->renderPartial($this->path_view.'grid/_tabel',['model'=>$model],true) ?>                        
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial($this->path_view.'_search',array(
                                    'model'=>$model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>  
<?= $this->renderPartial($this->path_view.'_dialog',['model'=>$model],true) ?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogVerifikasi',    
    'options'=>array(
    'title'=>'Verifikasi Aset Opname',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>550,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('informasi-peralatan-opname-grid', {
            data: $('#informasisampel-r-search').serialize()
        }); }",
     ),
));
?>
<iframe src="" name="frameAset" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');



$urlPrint = $this->createUrl('printInfo');
$js = <<< JSCRIPT
                       
    function print(caraPrint){
            window.open("${urlPrint}/"+$('#informasisampel-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
            
            
    var setBarang = (data) => {
        
        $(".barang_id").val(data.barang_id);
        $(".invperalatan_namabrg").val(data.barang_nama);
   
        $("#dialogBarang").dialog("close");
    }
            
    var setRuangan = (data) => {
        
        $(".ruangan_id").val(data.ruangan_id);
        $(".ruangan_nama").val(data.ruangan_nama);
   
        $("#dialogRuangan").dialog("close");
    }
            
    var setLokasi = (data) => {
        
        $(".lokasi_id").val(data.lokasi_id);
        $(".lokasiaset_namalokasi").val(data.lokasiaset_namalokasi);
   
        $("#dialogLokasi").dialog("close");
    }

    var refreshGridLokasi = () => {
        var ruangan_id = $(".ruangan_id").val();
        $.fn.yiiGridView.update('lokasi-grid', {
            data: {
                'LokasiasetM[ruangan_id]':ruangan_id
            }
        });
    }



JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);