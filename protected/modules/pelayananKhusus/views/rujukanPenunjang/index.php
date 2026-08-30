<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Informasi <b>Pasien Rujukan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Tabel <b>Pasien Rujukan</b>
                </div>
            </div>
            <div class="panel-body">
        
                    <?php 
                    $this->widget('ext.bootstrap.widgets.BootGridView',array(
                        'id'=>'pasienpenunjangrujukan-m-grid',
                        'dataProvider'=>$dataProvider,
                        'template'=>"{summary}\n{items}\n{pager}",
                        'itemsCssClass'=>'table table-striped table-condensed',
                        'columns'=>array(
                                'tgl_pendaftaran',
                                'tgl_kirimpasien',
                                array(
                                    'header'=>'Instalasi / Ruangan Asal',
                                    'value'=>'$data->InstalasiNamaRuanganNama',
                                ),
                                'no_pendaftaran',
                                'no_rekam_medik',
                                array(
                                    'header'=>'Nama Pasien / Alias',
                                    'value'=>'$data->NamaPasienNamaBin',
                                ),
                                array(
                                    'header'=>'Jenis Penjamin / Penjamin',
                                    'value'=>'$data->CaraBayarPenjaminNama',
                                ),
                                'jeniskasuspenyakit_nama',
                //                'umur',
                                'alamat_pasien',
                //                'pemeriksaanrad_nama',
                                array(
                                    'header'=>'&nbsp;&nbsp;Pemeriksaan&nbsp;&nbsp;',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                    'value'=>'CHtml::Link("<i class=\'icon-form-periksa\'></i>",Yii::app()->controller->createUrl("pendaftaranRehabilitasiMedisRujukanRS/index",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id)),
                                                    array("class"=>"icon-form-periksa", 
                                                          "id" => "selectPasien",
                                                          "rel"=>"tooltip",
                                                          "title"=>"Klik untuk rencana operasi pasien",
                                                          "target"=>"blank",
                                                    ))',
                                ),
                                                    array(
                                                            'header'=>'Batal Rujukan',
                                                            'type'=>'raw',
                                                            'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:dialogBatalPeriksa(\'$data->pendaftaran_id\',\'$data->pasienkirimkeunitlain_id\')",array("id"=>"$data->pendaftaran_id","rel"=>"tooltip","title"=>"Klik untuk membatalkan rujukan"))',
                                                            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                                                     ),
                        ),
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    ));
                    ?>
            </div>
        </div>
    
        <?php $this->renderPartial('_formSearch',array());  ?>
    
</div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'DialogBatalperiksa',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
		'autoOpen'=>false,
		'zIndex'=>1002,
		'minWidth'=>500,
		'minHeight'=>100,
		'resizable'=>false,
		'modal'=>true,    
		 ),
	));
$this->renderPartial('_formBatalPeriksaDialog');                    

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php echo $this->renderPartial('_jsFunctions',array());?>

