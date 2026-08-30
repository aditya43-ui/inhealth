<fieldset>
    <legend class="rim2">Informasi Kas Masuk</legend>
    <?php
        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
            'id'=>'pencarianpasien-grid',
            'dataProvider'=>$model->search(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                    'name'=>'tglbuktibayar',
                    'type'=>'raw',
                    'value'=>'$data->tglbuktibayar',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'name'=>'nobuktibayar',
                    'type'=>'raw',
                    'value'=>'$data->nobuktibayar',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'name'=>'darinama_bkm',
                    'type'=>'raw',
                    'value'=>'$data->darinama_bkm',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'name'=>'carapembayaran',
                    'type'=>'raw',
                    'value'=>'$data->carapembayaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
    ?>    
</fieldset>
<?php echo $this->renderPartial('__formPencarian', array('model'=>$model, 'action_url'=>$action_url),true); ?> 