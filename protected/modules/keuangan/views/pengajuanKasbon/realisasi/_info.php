<div class="col-sm-6">  
    <div class="control-group">
        <?= $form->labelEx($model, 'no_pengajuan', ['class' => 'control-label']) ?>
        <div class="controls">
        <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'no_pengajuan',
                'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('getPengajuanKasbon') . '",
                                                dataType: "json",
                                                data: {
                                                    term: request.term,
                                                },
                                                success: function (data) {
                                                        response(data);
                                                }
                                            })
                                        }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                                $(this).val("");
                                                return false;
                                            }',
                    'select' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.label);
                                                $("#'.CHtml::activeId($model, 'no_pengajuan').'").val(ui.item.label);
                                                $("#'.CHtml::activeId($model, 'pengajuankasbon_id').'").val(ui.item.value);
                                                return false;
                                            }',
                ),
                'htmlOptions' => array(
                    'readonly' => false,
                    'placeholder' => 'Ketik Nama Pegawai',
                    'size' => 20,
                    'class' => 'span3',
                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pegawai_mengajukan_id') . '").val(""); ',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                ),
                'tombolDialog' => array('idDialog' => 'dialogPengajuanKasbon'),
            ));
            ?>
        </div>
    </div>


    <?= $form->textFieldRow($model,'tgl_pengajuan',['class'=>'span3','readonly'=>true]) ?>
    <?= $form->textFieldRow($model,'nominal_kasbon',['class'=>'span3 integer2','readonly'=>true]) ?>    
</div>

<div class="col-sm-6">
    <?= $form->hiddenField($model,'pegawai_mengajukan_id',['class'=>'span3','readonly'=>true]) ?>
    <?= $form->textFieldRow($model,'pegawai_mengajukan_nama',['class'=>'span3','readonly'=>true]) ?>
    <?php //echo $form->textFieldRow($model,'nip',['class'=>'span3','readonly'=>true]) ?>
    <?= $form->textFieldRow($model,'unitkerja_nama',['class'=>'span3','readonly'=>true]) ?>
</div>


<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPengajuanKasbon',
    'options'=>array(
        'title'=>'Daftar Pengajuan Kasbon',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));

$model = new PengajuankasbonT('searchInformasi');
$model->unsetAttributes();  // clear any default values
$model->status_persetujuan = "DISETUJUI";
$model->ada_pengeluaran = true;

$format = new MyFormatter();

if (isset($_GET['PengajuankasbonT'])) {
    $model->attributes = $_GET['PengajuankasbonT'];
}

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pengajuankasbon-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$model->searchInformasiUntukPenerimaanKas(),
	'filter'=>$model,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//        'mergeHeaders'=>array(
//            array(
//                'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
//                'start'=>1, //indeks kolom 3
//                'end'=>5, //indeks kolom 4
//            ),
//        ),
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
					"id" => "selectRekDebit",
					"onClick" =>"
                    $(\"#PengajuankasbonT_pengajuankasbon_id\").val(".$data->pengajuankasbon_id.");
                    $(\"#PengajuankasbonT_no_pengajuan\").val(\"".$data->no_pengajuan."\");
                    $(\"#dialogPengajuanKasbon\").dialog(\"close\");
                    window.location.replace(\"".Yii::app()->controller->createUrl("realisasi", array("id"=>$data->pengajuankasbon_id))."\");
					return false;
			"))',
		),
        [
            'header' => 'Tgl. Pengajuan',
            'name' => 'tgl_pengajuan',
            'type' => 'raw', 
            'filter' => false,
            'value' => function($data){
                return MyFormatter::formatDateTimeForUser($data->tgl_pengajuan);
            }
        ],
        [
            'header' => 'No. Pengajuan',
            'name' => 'no_pengajuan',
        ],
        [
            'header' => 'Nominal',
            'filter' => false,
            'value' => function ($data) {
                return MyFormatter::formatUang($data->nominal_kasbon); 
            } 
        ], 
        [
            'header' => 'Keperluan',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->keperluan; 
            } 
        ], 
        [
            'header' => 'Pegawai Mengetahui',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'type' => 'raw',
            'value' => function ($data) {
                return $data->pegawaimengetahui->namaLengkap; 
            } 
        ], 
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>