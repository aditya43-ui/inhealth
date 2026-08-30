<div class="white-container">
    <legend class="rim2">Informasi Pembayaran <b>Klaim Piutang</b></legend>
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
        <h6>Tabel Pembayaran <b>Klaim Piutang</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'kupembklaimpiutang-t-grid',
            'dataProvider'=>$model->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        ),
                    array(
                        'name'=>'tglpembayaranklaim',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglpembayaranklaim)',
                    ),
                    array(
                        'name'=>'nopembayaranklaim',
                        'value'=>'$data->nopembayaranklaim',
                    ),
                    array(
                        'name'=>'totalbayar',
                        'value'=>'number_format($data->totalbayar)',
                    ),
                    array(
                        'header'=>'Detail Pembayaran',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("InformasiPembayaranKlaimPiutang/detail",array("id"=>$data->pembayarklaim_id,"frame"=>true)),
                                     array("class"=>"", 
                                           "target"=>"detailPembayaran",
                                           "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk melihat detail Pembayaran Klaim Piutang",
                                 ))',
                    ),
                    array(
                        'header'=>'Batal',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-silang\"></i>",Yii::app()->controller->createUrl("InformasiPembayaranKlaimPiutang/batalPembayaran",array("id"=>$data->pembayarklaim_id,"frame"=>true)),
                                     array("class"=>"", 
                                           "target"=>"batalPembayaran",
                                           "onclick"=>"deleteRecord($data->pembayarklaim_id);",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk membatalkan Pembayaran Klaim Piutang",
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
                        'title'=>'Detail Pembayaran Klaim Piutang',
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
<script>
	function deleteRecord(id){
        var id = id;
        var url = '<?php echo Yii::app()->controller->createUrl("InformasiPembayaranKlaimPiutang/batalPembayaran"); ?>';
        myConfirm("Yakin Akan Menghapus Data ini?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('kupembklaimpiutang-t-grid');
						}else{
							myAlert('Data gagal dihapus!')
						}
                },"json");
           }
        });
    }
</script>
