<fieldset>
    <legend>
        <?php echo CHtml::checkBox('isRiwayatKelahiran',false,array('onClick'=>'slideDiv()')) ?>
        Riwayat Kehamilan
    </legend>
    <div id="divRiwayatKehamilan" style="display: none;">    
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'riwayatkehamilan-grid',
                    'dataProvider'=>$modRiwayatKehamilan->searchRiwayat(),
            //                'filter'=>$model,
                            'template'=>"{summary}\n{items}\n{pager}",

                            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                     'columns'=>array(
                                array(
                                   'name'=>'tglpemeriksaaan',
                                   'type'=>'raw',
                                   'value'=>'$data->TglPeriksaNoPendaftaran', 
                                ),
                                array(
                                   'name'=>'tglkehamilan',
                                ),
                                array(
                                   'name'=>'tglakhirmenstruasi',
                                ),
                                array(
                                   'name'=>'jmlpartusimaturus',
                                ),
                                array(
                                   'name'=>'jmlpartusmaturus',
                                ),
                                array(
                                   'name'=>'jmlpartuspostmaturus',
                                ),
                                array(
                                   'name'=>'jmlabortus',
                                ),
                                array(
                                   'name'=>'posisijanin',
                                ),
                                array(
                                   'name'=>'tglperkiraankelahiran',
                                ),
                        ),
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    ));
            ?>
</fieldset>
<?php
$js = <<< JS
function slideDiv()
{
    $('#divRiwayatKehamilan').slideToggle(500);
}
JS;
Yii::app()->clientScript->registerScript('ceklistRujukan',$js,CClientScript::POS_HEAD);
?>
