<div class="row">
    <?php

    /**
     * - digunakan sebagai url utuk :
     * @author : Elham Budianto
     * @email : elhambudianto1@gmail.com
     * @wiki : ..
     **/

    if (!empty($_GET['sukses'])) {
        //var_dump($id);die();
    ?>

        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('No. Pengajuan Perawatan', 'pengperawatanlinen_no', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'pengperawatanlinen_no', array('class' => 'span3', 'readonly' => true)); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'nopenerimaanlinen', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tglpenerimaanlinen', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'tglpenerimaanlinen', array('class' => 'span3', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Instalasi Asal', 'instalasi_nama', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'instalasi_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Ruangan Asal', 'ruangan_nama', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'ruangan_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    <?php echo $form->textField($model, 'ruangan_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Berat', 'beratlinen', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'beratlinen', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo CHtml::label('Kg', 'beratlinen') ?>
                </div>
            </div>

        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'pegmenerima_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'pegmenerima_nama', array('readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Pegawai Pengirim', 'Pegawai Pengirim', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'pegmengetahui_nama', array('readonly' => true)); ?>
                </div>
            </div>
            <?php echo $form->textAreaRow($model, 'keterangan_penerimaanlinen', array('readonly' => true, 'disable' => true, 'rows' => 6, 'cols' => 100, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="clear"></div>
    <?php
    } else {
    ?>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('No. Pengajuan Perawatan', 'pengperawatanlinen_no', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'pengperawatanlinen_id', array('readonly' => true)); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'pengperawatanlinen_no',
                        'source' => 'js: function(request, response) {
                    $.ajax({
                        url: "' . $this->createUrl('AutocompletePengajuan') . '",
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
						$(this).val( ui.item.label);
						return false;
					}',
                            'select' => 'js:function( event, ui ) {
						$("#' . Chtml::activeId($model, 'pengperawatanlinen_id') . '").val(ui.item.pengperawatanlinen_id); 
                        resetLinen();
                        tambahLinen();
						return false;
					}',
                        ),
                        'htmlOptions' => array(
                            'class' => 'pengperawatanlinen_no span3',
                            'placeholder' => 'No. Pengajuan Perawatan',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pengperawatanlinen_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPengajuanLinen'),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'nopenerimaanlinen', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tglpenerimaanlinen', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $model->tglpenerimaanlinen = !empty($model->tglpenerimaanlinen) ? $format->formatDateTimeForUser($model->tglpenerimaanlinen) : date('d M Y');
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglpenerimaanlinen',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            //						'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                    ));
                    $model->tglpenerimaanlinen = !empty($model->tglpenerimaanlinen) ? $format->formatDateTimeForDb($model->tglpenerimaanlinen) : date('Y-m-d');
                    ?>
                    <?php echo $form->error($model, 'tglpenerimaanlinen'); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Instalasi Asal', 'instalasi_nama', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'instalasi_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Ruangan Asal', 'ruangan_nama', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'ruangan_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    <?php echo $form->textField($model, 'ruangan_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Berat', 'beratlinen', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'beratlinen', array('placeholder' => 'Berat', 'class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
                    <?php echo CHtml::label('Kg', 'beratlinen') ?>
                </div>
            </div>

        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'pegmenerima_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'pegmenerima_id', array('readonly' => true)); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'pegawaimenerima_nama',
                        'source' => 'js: function(request, response) {
								   $.ajax({
									   url: "' . $this->createUrl('AutocompletePegawaiMenerima') . '",
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
						$(this).val( ui.item.label);
						return false;
					}',
                            'select' => 'js:function( event, ui ) {
						$("#' . Chtml::activeId($model, 'pegmenerima_id') . '").val(ui.item.pegawai_id); 
						return false;
					}',
                        ),
                        'htmlOptions' => array(
                            'class' => 'pegawaimenerima_nama span3',
                            'placeholder' => 'Nama Pegawai',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pegmenerima_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPegawaiMenerima'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php // echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label')); 
                ?>
                <?php echo CHtml::label('Pegawai Pengirim', 'Pegawai Pengirim', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'pegmengetahui_id', array('readonly' => true)); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'pegawaimengetahui_nama',
                        'source' => 'js: function(request, response) {
								   $.ajax({
									   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
						$(this).val( ui.item.label);
						return false;
					}',
                            'select' => 'js:function( event, ui ) {
						$("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
						return false;
					}',
                        ),
                        'htmlOptions' => array(
                            'class' => 'pegawaimengetahui_nama span3',
                            'placeholder' => 'Nama Pegawai',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->textAreaRow($model, 'keterangan_penerimaanlinen', array('placeholder' => 'Keterangan Penerimaan', 'rows' => 6, 'cols' => 100, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
</div>

<?php
    }
?>
<?php
function getNamaPegawaiMengajukan($pegawai_id)
{
    $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
    return $modPegawai->namaLengkap;
}
?>

<?php
//========= Dialog buat cari data Pegawai Menerima =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMenerima',
    'options' => array(
        'title' => 'Pencarian Pegawai Menerima',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => true,
    ),
));

$modPegawaiMenerima = new LAPegawaiV('searchPegawaiMenerima');
$modPegawaiMenerima->unsetAttributes();
if (isset($_GET['LAPegawaiV'])) {
    $modPegawaiMenerima->attributes = $_GET['LAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengajukan-grid',
    'dataProvider' => $modPegawaiMenerima->searchPegawaiMenerima(),
    'filter' => $modPegawaiMenerima,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'pegmenerima_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimenerima_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenerima\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMenerima, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),/*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenerima, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),*/
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenerima, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),/*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenerima, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),*/
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenerima, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Menerima dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Pengirim',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => true,
    ),
));

$modPegawaiMengetahui = new LAPegawaiV('searchPegawaiMengetahui');
//$modPegawaiMengetahui = new LAPegawaiV('search');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['LAPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['LAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPegawaiMengetahui(),
    //'dataProvider'=>$modPegawaiMengetahui->search(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'pegmengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengetahui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        /*array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),*/
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),/*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),*/
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPengajuanLinen',
    'options' => array(
        'title' => 'Pencarian Pengajuan Perawatan Linen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => true,
    ),
));

$modPengajuanPerawatan = new LAPengperawatanlinenT('searchFilter');
$modPengajuanPerawatan->unsetAttributes();
if (isset($_GET['LAPengperawatanlinenT'])) {
    $modPengajuanPerawatan->attributes = $_GET['LAPengperawatanlinenT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pengajuanperawatan-grid',
    'dataProvider' => $modPengajuanPerawatan->searchFilter(),
    'filter' => $modPengajuanPerawatan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                $pegawai = PegawaiM::model()->findByPk($data->mengajukan_id);
                if (!empty($pegawai)) {
                    $namaPegawai = $pegawai->namaLengkap;
                } else {
                    $namaPegawai = '';
                }
                return CHtml::Link('<i class="icon-form-check"></i>', '', array(
                    'class' => 'btn-small',
                    'href' => '',
                    'id' => 'selectObat',
                    'onClick' => '
                                                  $("#LAPenerimaanlinenT_pengperawatanlinen_id").val("' . $data->pengperawatanlinen_id . '");
                                                  $("#LAPenerimaanlinenT_pengperawatanlinen_no").val("' . $data->pengperawatanlinen_no . '");
                                                  $("#LAPenerimaanlinenT_pegawaimengetahui_nama").val("' . $namaPegawai . '");
                                                  $("#LAPenerimaanlinenT_pegmengetahui_id").val("' . $data->mengetahui_id . '");
                                                  resetLinen();
                                                  tambahLinen();
                                                  $("#dialogPengajuanLinen").dialog("close"); 
                                                  return false;
                                        '
                ));
            },
        ),
        array(
            'header' => 'No. Pengajuan Perawatan',
            'value' => '$data->pengperawatanlinen_no',
        ),
        array(
            'header' => 'Tanggal Perawatan',
            'value' => 'Myformatter::formatDateTimeforUser($data->tglpengperawatanlinen)',
        ),
        array(
            'header' => 'Keterangan',
            'value' => '$data->keterangan_pengperawatanlinen',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>