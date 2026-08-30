<div class="white-container">
    <legend class="rim2">Informasi <b>Daftar Dokter</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('dokter-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Daftar Dokter</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dokter-grid',
            'dataProvider'=>$modDokter->searchDokter(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'No. Pegawai',
                            'name'=>'nomorindukpegawai',
                            'type'=>'raw',
                            'value'=>'$data->nomorindukpegawai',
                    ),
                    array(
                            'header'=>'Nama Dokter',
                            'name'=>'nama_pegawai',
                            'type'=>'raw',
                            'value'=>'$data->NamaLengkap',  
                            'htmlOptions'=>array('style'=>'text-align: left')
                    ),
                    array(
                            'header'=>'Alamat',
                            'name'=>'alamat_pegawai',
                            'type'=>'raw',
                            'value'=>'$data->alamat_pegawai',  
                    ),           
                    array(
                            'header'=>'No. Telepon/<br>No. Handphone',
                            'name'=>'notelp_pegawai',
                            'type'=>'raw',
                            'value'=>'$data->notelp_pegawai." / ".$data->nomobile_pegawai',  
                    ),           
                    array(
                            'header'=>'Status Aktif',
                            'type'=>'raw',
                            'value'=>'($data->pegawai_aktif == 1) ? "Aktif" : "Tidak Aktif"',  
                            'htmlOptions'=>array('style'=>'text-align: left')
                    ),           
                    array(
                            'header'=>'Ubah',
                            'type'=>'raw',
                            'value'=>'CHtml::link("<icon class=\'icon-form-ubah\' ></icon> ", Yii::app()->createUrl("/pendaftaranPenjadwalan/informasiDaftarDokter/ubahStatusDokter", array("pegawai_id"=>$data->pegawai_id,"frame"=>true)), array("target"=>"frameUbahStatusDokter","rel"=>"tooltip", "title"=>"Klik untuk ubah status dokter", "onclick"=>"$(\'#dialogUbahStatusDokter\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: left;'),
                    ),           
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <div class="search-form">
            <?php $this->renderPartial('_search',array(
                            'modDokter'=>$modDokter,
            )); ?> 
    </div>	
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogUbahStatusDokter',
        'options' => array(
            'title' => 'Ubah Status Dokter',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 400,
            'resizable' => false,
                    'close'=>"js:function(){ $.fn.yiiGridView.update('dokter-grid', {
                            data: $(this).serialize()
                        }); }",
        ),
    ));
    ?>
    <iframe name='frameUbahStatusDokter' style="width: 100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>
</div>