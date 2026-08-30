<?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'pencarianjadwal-grid',
	'dataProvider'=>$model->searchInformasi(),
//                'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",

                'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                    array(
                        'name'=>'jadwaldokter_hari',
                        'value'=>array($this,'gridHari'),
                    ),
                    
                    array(
                        'name'=>'pegawai_id',
                        'value'=>array($this,'gridDokter'),
                    ),
                    'jadwaldokter_mulai',
                    'jadwaldokter_tutup',
                    array(
                        'name'=>'ruangan_id',
                        'value'=>'$data->ruangan->ruangan_nama',
                    ),
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
     

?>