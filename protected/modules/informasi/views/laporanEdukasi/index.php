<?php
$this->breadcrumbs = array(
    'penilaian-iku-t-form' => array('informasi'),
    'Informasi',
);

Yii::app()->clientScript->registerScript('search', "
$('#penilaian-alokasi-t-search').submit(function(){
    $.fn.yiiGridView.update('tableInformasi1', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableInformasi2', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableInformasi3', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableInformasi4', {
        data: $(this).serialize()
    });
    
 $.fn.yiiGridView.update('tableInformasi5', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableInformasi6', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableInformasi7', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableInformasi8', {
        data: $(this).serialize()
    });
    
 $.fn.yiiGridView.update('tableInformasi9', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableInformasi10', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableInformasi11', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableInformasi12', {
        data: $(this).serialize()
    });
    

 $.fn.yiiGridView.update('tableRekap1', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableRekap2', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableRekap3', {
        data: $(this).serialize()
    });
    $.fn.yiiGridView.update('tableRekap4', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Edukasi</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_search', array('model' => $model)) ?>
            </div>
        </div>

        <?php echo $this->renderPartial($this->path_view . '_table', array('model' => $model)) ?>

        <?php //$this->renderPartial('_footer_pisah', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
        ?>
    </div>
</div>