<fieldset>
    <legend>
        <?php echo CHtml::checkBox('isRiwayatBayiTabung',false,array('onClick'=>'slideDiv()')) ?>
        Riwayat Bayi Tabung
    </legend>
    <div id="divRiwayatBayiTabung" style="display: none;">    
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'riwayatkehamilan-grid',
                    'dataProvider'=>$modRiwayatBayiTabung->searchRiwayat(),
            //                'filter'=>$model,
                            'template'=>"{summary}\n{items}\n{pager}",

                            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                     'columns'=>array(
                                array(
                                   'name'=>'tglkegbayitabung',
                                   'type'=>'raw',
                                   'value'=>'$data->TglKegNoPendaftaran', 
                                ),
                                array(
                                   'name'=>'tglkehamilan',
                                ),
                                array(
                                   'name'=>'sikluskegiatan',
                                ),
                                array(
                                   'name'=>'metodebt',
                                ),
                                array(
                                   'name'=>'catatankegiatan',
                                ),
                                 array(
                                        'name'=>'positivekehamilan',
                                        'type'=>'raw',
                                        'value'=>'($data->positivekehamilan==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                                ),

                        ),
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    ));
            ?>
    </div>
</fieldset>
<?php
$js = <<< JS
function slideDiv()
{
    $('#divRiwayatBayiTabung').slideToggle(500);
}
JS;
Yii::app()->clientScript->registerScript('TOOGLE',$js,CClientScript::POS_HEAD);
?>
