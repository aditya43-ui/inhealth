<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php

$dpjp1 = null;
$dpjp2 = null;
$dpjp3 = null;

if (!empty($model->pegawai_id)) {
    $peg = PegawaiM::model()->findByPk($model->pegawai_id);
    $dpjp1 = $peg->namaLengkap;
}
if (!empty($model->dpjp2_id)) {
    $peg = PegawaiM::model()->findByPk($model->dpjp2_id);
    $dpjp2 = $peg->namaLengkap;
}
if (!empty($model->dpjp3_id)) {
    $peg = PegawaiM::model()->findByPk($model->dpjp3_id);
    $dpjp3 = $peg->namaLengkap;
}

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash("success", "Transaksi berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<!-- <div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fa fa-user-md"></i> DPJP Rawat Inap
        </div>
    </div>
    <div class="panel-body"> -->
<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'ubahKelPenyakit-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this)'),
    )
);
?>
<p class="help-block">
    <?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($model, $modUbahDokter)); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true)); ?>
<div class="control-group">
    <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('no_pendaftaran', $model->pendaftaran->no_pendaftaran, array('readonly' => true)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Nama Pasien', 'np', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('np', $model->pasien->nama_pasien, array('readonly' => true)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Nama Ruangan', 'ruangan_nama', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('ruangan_nama', $model->ruangan->ruangan_nama, array('readonly' => true)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('DPJP 1 <span class="required">*</span>', 'db', array('class' => 'control-label required')) ?>
    <div class="controls">
        <?php

        echo $form->hiddenField($model, 'pegawai_id', array('id' => 'dpjp1_id'));
        $this->widget('MyJuiAutoComplete', array(
            'name' => 'dpjp1',
            'value' => $dpjp1,
            'source' => 'js: function(request, response) {
                            $.ajax({
                            url: "' . $this->createUrl('pendaftaranRawatInap/getDokterDPJP') . '",
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
                'minLength' => 2,
                'focus' => 'js:function( event, ui ) {
                             $(this).val( ui.item.label);
                             return false;
                         }',
                'select' => 'js:function( event, ui ) {
                             $("#dpjp1_id").val(ui.item.value); 
                             return false;
                         }',
            ),
            'tombolDialog' => array('idDialog' => 'dialogDokterDPJP'),
            'htmlOptions' => array('placeholder' => 'DPJP 1', 'class' => 'span3'),
            //                    'tombolDialog'=>array(
            //                        'idDialog'=>'dialogDokterDPJP',
            //                        'jsFunction'=>'admisi_dokter_id = "#dpjp1_id"; admisi_dokter_label = "#dpjp1"; tampilTabDokter(true);',
            //                    ),
        ));
        /*
			echo $form->dropDownList($model,'pegawai_id',
					CHtml::listData(
						$model->getDokterItems($model->ruangan_id), 'pegawai_id', 'namaLengkap'
					),
					array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")
				);
             * 
             */
        ?>

    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('DPJP 2', 'db', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php

        echo $form->hiddenField($model, 'dpjp2_id', array('id' => 'dpjp2_id'));
        $this->widget('MyJuiAutoComplete', array(
            'name' => 'dpjp2',
            'value' => $dpjp2,
            'source' => 'js: function(request, response) {
                            $.ajax({
                            url: "' . $this->createUrl('pendaftaranRawatInap/getDokterDPJP') . '",
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
                'minLength' => 2,
                'focus' => 'js:function( event, ui ) {
                             $(this).val( ui.item.label);
                             return false;
                         }',
                'select' => 'js:function( event, ui ) {
                             $("#dpjp2_id").val(ui.item.value); 
                             return false;
                         }',
            ),
            'tombolDialog' => array('idDialog' => 'dialogDokterDPJP2'),
            'htmlOptions' => array('placeholder' => 'DPJP 2', 'class' => 'span3'),
            //                    'tombolDialog'=>array(
            //                        'idDialog'=>'dialogDokterDPJP',
            //                        'jsFunction'=>'admisi_dokter_id = "#dpjp2_id"; admisi_dokter_label = "#dpjp2"; tampilTabDokter(true);',
            //                    ),
        ));
        /*
			echo $form->dropDownList($model,'pegawai_id',
					CHtml::listData(
						$model->getDokterItems($model->ruangan_id), 'pegawai_id', 'namaLengkap'
					),
					array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")
				);
             * 
             */
        ?>

    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('DPJP 3', 'db', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php

        echo $form->hiddenField($model, 'dpjp3_id', array('id' => 'dpjp3_id'));
        $this->widget('MyJuiAutoComplete', array(
            'name' => 'dpjp3',
            'value' => $dpjp3,
            'source' => 'js: function(request, response) {
                            $.ajax({
                            url: "' . $this->createUrl('pendaftaranRawatInap/getDokterDPJP') . '",
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
                'minLength' => 2,
                'focus' => 'js:function( event, ui ) {
                             $(this).val( ui.item.label);
                             return false;
                         }',
                'select' => 'js:function( event, ui ) {
                             $("#dpjp3_id").val(ui.item.value); 
                             return false;
                         }',
            ),
            'tombolDialog' => array('idDialog' => 'dialogDokterDPJP3'),
            'htmlOptions' => array('placeholder' => 'DPJP 3', 'class' => 'span3'),
            //                    'tombolDialog'=>array(
            //                        'idDialog'=>'dialogDokterDPJP',
            //                        'jsFunction'=>'admisi_dokter_id = "#dpjp3_id"; admisi_dokter_label = "#dpjp3"; tampilTabDokter(true);',
            //                    ),
        ));
        /*
			echo $form->dropDownList($model,'pegawai_id',
					CHtml::listData(
						$model->getDokterItems($model->ruangan_id), 'pegawai_id', 'namaLengkap'
					),
					array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")
				);
             * 
             */
        ?>

    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Alasan Perubahan <span class="required">*</span>', 'ap', array('class' => 'control-label required')) ?>
    <div class="controls">
        <?php echo $form->textArea(
            $modUbahDokter,
            'alasanperubahandokter',
            array('placeholder' => 'Alasan Perubahan', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rows' => 2, 'cols' => 60, 'class' => 'span3 ', 'style' => 'float:left; width:220px')
        ); ?>

    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Keterangan', 'k', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->hiddenField($modUbahDokter, 'dokterlama_id', array('class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);", 'value' => $model->pegawai_id)); ?>
        <?php echo $form->textArea($modUbahDokter, 'keterangan', array('placeholder' => 'Keterangan Perubahan Dokter', 'rows' => 2, 'cols' => 60, 'class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/ubahDokterPeriksaRI&id=' . $_GET['id']),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
</div>
<?php $this->endWidget(); ?>
<!-- </div>
</div> -->

<?php
//=============================== Ganti Data Kelas Pelayanan Dialog =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogDokterDPJP',
        'options' => array(
            'title' => 'Dokter DPJP',
            'autoOpen' => false,
            'width' => 450,
            'height' => 560,
            'modal' => true,
        ),
    )
);

//    $format = new MyFormatter();
$modDPJP = new PegawaiV('search');
$modDPJP->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modDPJP->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $modDPJP->searchDokterDPJP(),
    //        'htmlOptions'=>array('hidden' => true),
    'filter' => $modDPJP,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " $('#dpjp1_id').val($data->pegawai_id); $('#dpjp1').val('$data->namaLengkap');  $('#dialogDokterDPJP').dialog('close'); return false; "
                ));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
//=============================== Ganti Data Kelas Pelayanan Dialog =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogDokterDPJP3',
        'options' => array(
            'title' => 'Dokter DPJP',
            'autoOpen' => false,
            'width' => 450,
            'height' => 560,
            'modal' => true,
        ),
    )
);

//    $format = new MyFormatter();
$modDPJP3 = new PegawaiV('search');
$modDPJP3->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modDPJP3->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp3-m-grid',
    'dataProvider' => $modDPJP3->searchDokterDPJP(),
    //        'htmlOptions'=>array('hidden' => true),
    'filter' => $modDPJP3,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " $('#dpjp3_id').val($data->pegawai_id); $('#dpjp3').val('$data->namaLengkap');  $('#dialogDokterDPJP3').dialog('close'); return false; "
                ));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
//=============================== Ganti Data Kelas Pelayanan Dialog =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogDokterDPJP2',
        'options' => array(
            'title' => 'Dokter DPJP',
            'autoOpen' => false,
            'width' => 450,
            'height' => 560,
            'modal' => true,
        ),
    )
);

//    $format = new MyFormatter();
$modDPJP2 = new PegawaiV('search');
$modDPJP2->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modDPJP2->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp2-m-grid',
    'dataProvider' => $modDPJP2->searchDokterDPJP(),
    //        'htmlOptions'=>array('hidden' => true),
    'filter' => $modDPJP2,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " $('#dpjp2_id').val($data->pegawai_id); $('#dpjp2').val('$data->namaLengkap');  $('#dialogDokterDPJP2').dialog('close'); return false; "
                ));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php

//$format = new MyFormatter();
//	$modDPJP=new PegawaiV('search');
//	$modDPJP->unsetAttributes();
//	if(isset($_GET['PegawaiV'])){
//		$modDPJP->attributes=$_GET['PegawaiV'];
//	}
//	$this->widget('ext.bootstrap.widgets.BootGridView',array(
//		'id'=>'dialog-dpjp-m-grid',
//		'dataProvider'=>$modDPJP->searchDokterDPJP(),
//        'htmlOptions'=>array('hidden' => true),
//		'filter'=>$modDPJP,
//			'template'=>"{items}\n{pager}",
//			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//		'columns'=>array(
//			array(
//				'header'=>'Pilih',
//				'type'=>'raw',
//                'value'=>function($data) {
//                    return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
//								"onclick" => " setDokterAdmisi('".$data->namaLengkap."',".$data->pegawai_id."); return false; "));
//                },
//			),
//			array(
//                'name'=>'nama_pegawai',
//                // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
//                'value'=>'$data->namaLengkap',
//            ),
//		),
//			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//	));

?>

<script type="text/javascript">
    var admisi_dokter_id = null;
    var admisi_dokter_label = null;

    function tampilTabDokter(status) {
        if (status) {
            $("#dialog-dpjp-m-grid").show();
            $("#ubahKelPenyakit-form").hide();
        } else {
            $("#dialog-dpjp-m-grid").hide();
            $("#ubahKelPenyakit-form").show();
        }
    }

    function setDokterAdmisi(label, value) {
        $(admisi_dokter_id).val(value);
        $(admisi_dokter_label).val(label);
        tampilTabDokter(false);
    }

    function loadDataPendaftaran() {
        var pendaftaran_id = $('#temp_idPendaftaranDP').val();
        $.post("<?php echo $this->createUrl('getDataPendaftaranRI'); ?>", {
                pendaftaran_id: pendaftaran_id
            },
            function(data) {
                $('#no_pendaftaran').val(data.no_pendaftaran);
                $('#PasienadmisiT_pendaftaran_id').val(data.pendaftaran_id);
                $('#np').val(data.nama_pasien);
                $('#ruangan_nama').val(data.ruangan_nama);
                var dokter = (data.gelardepan == null ? "dr." : data.gelardepan) + " " + data.nama_pegawai + " " + data.gelarbelakang_nama;
                $('#dp').val(dokter);
                $('#PPUbahdokterR_dokterlama_id').val(data.pegawai_id);
                listDokterRuangan(data.ruangan_id);
            },
            "json");
    }
    //    loadDataPendaftaran();

    function listDokterRuangan(idRuangan) {
        $.post("<?php echo $this->createUrl('listDokterRuangan') ?>", {
                idRuangan: idRuangan
            },
            function(data) {
                $('#PasienadmisiT_pegawai_id').html(data.listDokter);
            }, "json");
    }

    function closeDialog() {
        window.parent.$('#editDokterPeriksa').dialog('close');
    }
</script>