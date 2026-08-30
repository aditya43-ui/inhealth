
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong><i class="glyphicon glyphicon-briefcase"></i> Usulan Penghapusan Aset</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'Usulan Penghapusan Aset'
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form',array(
            'model'=>$model,
            'modDet'=>$modDet,                     
        )); ?>
    </div>
</div>
<?= $this->renderPartial($this->path_view.'_dialog',['model'=>$model], true) ?>
<?= $this->renderPartial($this->path_view.'_jsFunction',['model'=>$model], true) ?>

<?php
$cucibj = !empty($modCuciDet)?'ada':'tidak';
$js = <<< JS
    
    var cuci = '${cucibj}';
        
    setTimeout(function(){
    
        if (cuci == 'ada'){
            $("#tabel-daftar-aset > tbody > tr").find("input,textarea,select").attr("readonly",true);            
            $("#tabel-daftar-aset > tbody > tr").find("a,button,.add-on").hide();
            $(".btn-ulang").hide();
        }
                
        
    },500); 
        
    
JS;

Yii::app()->clientScript->registerScript('usulan-penghapusan-aset-bj',$js, CClientScript::POS_END);
?>


