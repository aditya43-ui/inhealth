<fieldset>
    <legend>
        <?php echo CHtml::checkBox('isRiwayatImunisasi',false,array('onClick'=>'slideDiv()')) ?>
        Riwayat Imunisasi
    </legend>
    <div id="divRiwayatImunisasi" style="display: none;">    
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'riwayatkehamilan-grid',
                    'dataProvider'=>$modRiwayatImunisasi->searchRiwayat(),
            //                'filter'=>$model,
                            'template'=>"{summary}\n{items}\n{pager}",

                            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                     'columns'=>array(
                         array(
                           'name'=>'tglimunisasi',
                           'type'=>'raw',
                           'value'=>'$data->tglImunisaniNoPendaftaran',  
                         ),
                         
                         array(
                           'name'=>'pegawai_id',
                           'type'=>'raw',
                           'value'=>'$data->pegawai->nama_pegawai',  
                         ),
                         array(
                           'name'=>'paramedis_id',
                           'type'=>'raw',
                           'value'=>'$data->paramedis->nama_pegawai',  
                         ),
                          array(
                           'name'=>'jadwalttbumil_id',
                           'type'=>'raw',
                           'value'=>'$data->jadwalttbumil->jadwalttbumil_nama',  
                         ),
                          array(
                           'name'=>'statusimunisasi_id',
                           'type'=>'raw',
                           'value'=>'$data->statusimunisasi->statusimunisasi_nama',  
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
    $('#divRiwayatImunisasi').slideToggle(500);
}
JS;
Yii::app()->clientScript->registerScript('TOOGLE',$js,CClientScript::POS_HEAD);
?>
