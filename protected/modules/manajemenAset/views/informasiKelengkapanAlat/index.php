<?php
Yii::app()->clientScript->registerScript('search', "
    $('#informasisampel-r-search').submit(function(){
        $.fn.yiiGridView.update('sajenis-kelas-m-grid', {
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
                <div class="panel-title"><i class="entypo-info-circled"></i> Informasi <strong>Kelengkapan Alat</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <strong>Kelengkapan Alat</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                          <?= $this->renderPartial('grid/_tabel',['model'=>$model],true) ?>                        
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial('_search',array(
                                    'model'=>$model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>  
<?= $this->renderPartial('_dialog',['model'=>$model],true) ?>

<?php
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
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);