<div class="white-container">
    <legend class="rim2">Informasi Permohonan <b>Bantuan Obat Alkes</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('#divSearch-form form').submit(function(){
            $('#permohonanoa-m-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('permohonanoa-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Permohonan <b>Bantuan Obat Alkes</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'permohonanoa-m-grid',
            'dataProvider'=>$model->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'name'=>'permohonanoa_tgl',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->permohonanoa_tgl)',
                    ),
                    'permohonanoa_nomor',
                    'pemohon_nama',
                    'pemohon_jenisidentitas',
                    'pemohon_noidentitas',
                    array(
                        'name'=>'pegawaimengetahui_id',
                        'type'=>'raw',
                        'value'=>'$data->PegawaimengetahuiLengkap',
                    ),
                    array(
                        'name'=>'pegawaimenyetujui_id',
                        'type'=>'raw',
                        'value'=>'$data->PegawaimenyetujuiLengkap',
                    ),
                    'permohonan_alasan',
                    'permohonan_keterangan',
                    array(
                        'header'=>'Rincian',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("PermohonanBantuanObat/print",array("permohonanoa_id"=>$data->permohonanoa_id,"frame"=>true)),
                                     array("class"=>"", 
                                           "target"=>"permohonan",
                                           "onclick"=>"$(\"#dialogPermohonan\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk melihat rincian permohonan bantuan obat alkes",
                                     ))',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                    ),
                    array(
                        'header'=>'Pengeluaran Obat Alkes',
                        'type'=>'raw',
                        'value'=>'(($data->permohonanoa_isapproved == FALSE) ? CHtml::Link("<i class=\"btn btn-danger\">BELUM DI-APPROVED</i>",Yii::app()->controller->createUrl("informasiPermohonanBantuanObat/ubahStatusApproved",array("permohonanoa_id"=>$data->permohonanoa_id,"frame"=>1)),
                            array("class"=>"", 
                                 "target"=>"iframeStatusApproved",
                                 "onclick"=>"$(\"#dialogUbahStatusApproved\").dialog(\"open\");",
                                 "rel"=>"tooltip",
                                 "title"=>"Klik untuk ubah status approved",
                            )) 
                            : CHtml::Link("<i class=\"icon-form-keluarobalkes\"></i>","'.$this->createUrl("PenjualanSosial/Index").'&permohonanoa_id=$data->permohonanoa_id",
                                array("class"=>"", 
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk melanjutkan ke pengeluaran obat alkes",
                                )))',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial('_search',array('model'=>$model,'format'=>$format)); ?>
    <?php 
    // ===========================Dialog Details=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id'=>'dialogPermohonan',
                            // additional javascript options for the dialog plugin
                            'options'=>array(
                            'title'=>'Rincian Permohonan Bantuan Obat',
                            'autoOpen'=>false,
                            'minWidth'=>900,
                            'minHeight'=>100,
                            'resizable'=>false,
                             ),
                        ));
    ?>
    <iframe src="" name="permohonan" width="100%" height="500">
    </iframe>
    <?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Details================================

    ?>
    <?php 
    // Dialog untuk ubah status konfirmasi booking =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogUbahStatusApproved',
        'options'=>array(
            'title'=>'Ubah Status Approved',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1200,
            'resizable'=>true,
            'close'=>'js:function(){$.fn.yiiGridView.update(\'permohonanoa-m-grid\', {})}'
        ),
    ));
    ?>
    <iframe src="" name="iframeStatusApproved" width="100%" id="iframeStatusApproved">
    </iframe>
    <?php
    $this->endWidget();
    //========= end ubah status konfirmasibooking dialog =============================
    ?>
</div>