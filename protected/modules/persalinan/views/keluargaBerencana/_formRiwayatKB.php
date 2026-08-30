<fieldset>
    <legend>
        <?php echo CHtml::checkBox('isRiwayatKB',false,array('onClick'=>'slideDiv()')) ?>
        Riwayat Keluarga Berencana
    </legend>
    <div id="divRiwayatKB" style="display: none;">    
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'riwayatkehamilan-grid',
                    'dataProvider'=>$modRiwayatPasienKB->searchRiwayat(),
            //                'filter'=>$model,
                            'template'=>"{summary}\n{items}\n{pager}",

                            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                     'columns'=>array(
                                array(
                                   'name'=>'tglpelayanankb',
                                   'type'=>'raw',
                                   'value'=>'$data->tglPelayananNoPendaftaran'
                                ),
                                array(
                                   'name'=>'metodekb',
                                ),
                                array(
                                   'name'=>'jeniskb',
                                ),
                                array(
                                   'name'=>'lama_waktu',
                                ),
                                array(
                                   'name'=>'efeksamping',
                                ),
                                array(
                                   'name'=>'catatan_kb',
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
    $('#divRiwayatKB').slideToggle(500);
}
JS;
Yii::app()->clientScript->registerScript('TOOGLE',$js,CClientScript::POS_HEAD);
?>
