<?php
$this->breadcrumbs = array(
    'Pasien Sudah Bayar' => array('/billingKasir/Laporan/retur'),
    'PasienKarcis',
); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'cariretur-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));

Yii::app()->clientScript->registerScript('cariPasien', "
$('#cariretur-form').submit(function(){
	$.fn.yiiGridView.update('semua_pencarianretur_grid', {
            data: $(this).serialize()
	});
	return false;
});
");
?>
<?php echo $this->renderPartial('retur/_formKriteriaPencarian', array('model' => $model, 'form' => $form), true); ?>
<div class="form-actions">
    <div style="float:left;margin-right:6px;">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset', 'onClick' => 'onReset()')); ?>
    </div>
    <div style="clear:both;"></div>
</div>

<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs',
    'stacked' => false,
    'htmlOptions' => array('id' => 'tabmenu'),
    'items' => array(
        // array('label'=>'Semua','url'=>'javascript:tab(0);','active'=>true),
        // array('label'=>'P3','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
        // array('label'=>'Umum','url'=>'javascript:tab(2);', 'itemOptions'=>array("index"=>2)),
    ),
))
?>
<div id="div_semua">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Retur</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <div>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'semua_pencarianretur_grid',
                    'dataProvider' => $model->searchPrint(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                        ),
                        array(
                            'header' => 'Tgl. Retur',
                            'name' => 'tglreturpelayanan',
                            'type' => 'raw',
                            'value' => '$data->tglreturpelayanan',
                        ),
                        'noreturbayar',
                        'nama_pasien',
                        array(
                            'header' => 'No. RM',
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        'no_pendaftaran',
                        'ruanganakhir_nama',
                        'totalbiayaretur',
                        'keteranganretur',
                        'user_nm_otorisasi',
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_tab'); ?>
<iframe src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
<div style="float:left;">
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printretur');
    $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'type' => 'primary',
        'buttons' => array(
            array('label' => 'Print', 'icon' => 'entypo-print', 'url' => $urlPrint, 'htmlOptions' => array('onclick' => 'print(\'PRINT\');return false;')),
            array(
                'label' => '',
                'items' => array(
                    array('label' => 'PDF', 'icon' => 'icon-book', 'url' => $urlPrint, 'itemOptions' => array('onclick' => 'print(\'PDF\');return false;')),
                    array('label' => 'Excel', 'icon' => 'icon-pdf', 'url' => $urlPrint, 'itemOptions' => array('onclick' => 'print(\'EXCEL\');return false;')),
                )
            ),
        ),
    ));

    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&"+$('#cariretur-form').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>

<?php

$url = Yii::app()->createUrl('billingKasir/laporan/frameGrafikLaporanRetur&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('semua_pencarianretur_grid', {
            data: $(this).serialize()
    });
    return false;
});
");
?>
<?php
$js = <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
        $("#div_semua").show();
        $("#div_penjamin").hide();
        $("#div_umum").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('all');
            $("#div_semua").show();
            $("#div_penjamin").hide();
            $("#div_umum").hide();        
        }
   }
function onReset()
{
    setTimeout(
        function(){
            $.fn.yiiGridView.update('semua_pencarianretur_grid', {
                data: $("#caripasien-form").serialize()
            });        
        }, 2000
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat', $js, CClientScript::POS_HEAD);
?>