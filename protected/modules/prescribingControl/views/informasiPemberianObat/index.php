<div class="white-container">
    <legend class="rim2">Informasi <b>Pemberian Obat</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
            $('#daftarPasien-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pemberian Obat</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$model->searchRI(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                                    array(
                                            'header'=>'No.',
                                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                            : ($row+1)',
                                            'type'=>'raw',
                                            'htmlOptions'=>array('style'=>'text-align:right;'),
                                    ),
                    array(
                       'header'=>'Tanggal Pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->tgl_pendaftaran'
                    ),
                    array(
                       'header'=>'No. Pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->no_pendaftaran',
                    ),
                    array(
                       'header'=>'No. Rekam Medis / Nama Pasien',
                        'type'=>'raw',
                        'value'=>'$data->NoRmNamaPasien',
                    ),
                    array(
                        'header'=>'Instalasi / Ruangan',
                        'value'=>'$data->InstalasiRuangan'
                    ),
                    array(
                        'name'=>'Pemberian Obat',
                        'type'=>'raw',
                        'value'=>'(CHtml::link("<i class=\'icon-pencil-alt\'></i> ", Yii::app()->controller->createUrl("/prescribingControl/PemberianObatPasien/index",array("pendaftaran_id"=>$data->pendaftaran_id)),array("rel"=>"tooltip","title"=>"Klik untuk Pemberian Obat")))',
                        'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),
                ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <?php echo $this->renderPartial('_formPencarian', array('model'=>$model,'format'=>$format)); ?>
</div>