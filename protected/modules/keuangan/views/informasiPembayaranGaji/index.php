<div class="white-container">
    <legend class="rim2">Informasi Pembayaran <b>Gaji Pegawai</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#kupembgajipeg-t-search').submit(function(){
            $.fn.yiiGridView.update('kupembgajipeg-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel Pembayaran <b>Gaji Pegawai</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'kupembgajipeg-t-grid',
            'dataProvider'=>$model->search(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        ),
                    array(
                        'name'=>'nokaskeluar',
                        'value'=>'$data->nokaskeluar',
                    ),
                    array(
                        'name'=>'periodegaji',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->periodegaji)',
                    ),
                    array(
                        'header'=>'Jumlah Pembayaran Gaji',
                        'name'=>'totalterima',
                        'value'=>'number_format($data->totalterima)',
                    ),
                    array(
                        'header'=>'Detail Pembayaran',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("InformasiPembayaranGaji/detail",array("id"=>$data->penggajianpeg_id,"frame"=>true)),
                                     array("class"=>"", 
                                           "target"=>"detailPembayaran",
                                           "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk melihat detail Pembayaran Gaji",
                                 ))',
                    ),
                    array(
                        'header'=>'Batal',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-silang\"></i>",Yii::app()->controller->createUrl("InformasiPembayaranGaji/batalPembayaran",array("id"=>$data->pengeluaranumum_id,"frame"=>true)),
                                     array("class"=>"", 
                                           "target"=>"batalPembayaran",
                                           "onclick"=>"$(\"#dialogPembatalan\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk membatalkan Pembayaran Gaji",
                                 ))',
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_search',array('model'=>$model,'format'=>$format)); ?>
    </fieldset>
</div>
<?php 
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogDetail',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Detail Pembayaran Gaji',
                        'autoOpen'=>false,
                        'width'=>900,
                        'resizable'=>false,
                         ),
                    ));
?>
<iframe src="" name="detailPembayaran" style="width: 100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Detail================================
?>
<?php 
// ===========================Dialog Pembatalan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogPembatalan',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Pembatalan Pembayaran Gaji',
                        'autoOpen'=>false,
                        'width'=>550,
                        'resizable'=>false,
                         ),
                    ));
?>
<iframe src="" name="batalPembayaran" style="width: 100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Pembatalan================================
?>
