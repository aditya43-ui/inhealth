<div class="white-container">
    <legend class="rim2">Informasi Riwayat <b>Pasien Bank Darah</b></legend>
    <?php

        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('#search').submit(function(){
                $.fn.yiiGridView.update('informasiriwayatpasien-v-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");

    $this->widget('bootstrap.widgets.BootAlert'); 
    ?>

    <?php 
        $module  = $this->module->name; 
        $controller = $this->id;
        $format = new MyFormatter();
    ?>
    <div class="block-tabel">
        <h6>Tabel Riwayat <b>Pasien Bank Darah</b></h6>
        <?php $this->widget('bootstrap.widgets.BootAlert');	?>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'informasiriwayatpasien-v-grid',
                'dataProvider'=>$model->searchRiwayatPemeriksaan(),
        //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                array(
                    'header' => 'No. Urut',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                ),

                array(
                    'header'=>'Nama Pasien / Alias',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien."  ".$data->nama_bin',
                ),

                array(
                    'header'=>'Tanggal Lahir',
                    'type'=>'raw',
                    'value'=>'$data->tanggal_lahir',
                ),

                array(
                    'header'=>'Alamat',
                    'type'=>'raw',
                    'value'=>'$data->alamat_pasien',
                ),

                array(
                    'header'=>'Riwayat <br> Pemeriksaan',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-riwayatperiksa\"></i>",Yii::app()->controller->createUrl("informasiRiwayatPasien/rincian",array("id"=>$data->pasien_id,"frame"=>true)),
                            array("class"=>"", 
                                  "target"=>"iframeRiwayatPasien",
                                  "onclick"=>"$(\"#dialogRiwayat\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk melihat riwayat pemeriksaan",
                            ))',  'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                ),

                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box search-form">
        <?php 
            $this->renderPartial('bankDarah.views.informasiRiwayatPasien._search',array(
                'model'=>$model,
            ));
        ?>
    </fieldset>

    <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
            'id' => 'dialogRiwayat',
            'options' => array(
                'title' => 'Informasi Riwayat Pemeriksaan Pasien',
                'autoOpen' => false,
                'modal' => true,
                'width' => 900,
                'height' => 550,
                'resizable' => false,
            ),
        ));
    ?>
    <iframe name='iframeRiwayatPasien' style="width: 100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>
</div>