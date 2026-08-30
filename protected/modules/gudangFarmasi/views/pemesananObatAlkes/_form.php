<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->hiddenField($model, 'pesanobatalkes_id', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'tglpemesanan', array('readonly' => true, 'class' => 'span4 realtime', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php
        if (isset($_GET['pesanobatalkes_id'])) {
            echo $form->textFieldRow($model, 'nopemesanan', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20));
        }
        ?>
        <div class="control-group">
            <?php echo CHtml::label('Instalasi Tujuan <span style = "color:red;">*</span>', 'instalasitujuan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'instalasitujuan_id',
                    $instalasiTujuans,
                    array(
                        'class' => 'span4 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                            'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                        )
                    )
                ); ?>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'ruangan_id', $ruanganTujuans, array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'onchange' => 'refreshDialogOA();')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'statuspesan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'statuspesan', LookupM::getItems('statuspesan'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglmintadikirim', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tglmintadikirim = (!empty($model->tglmintadikirim) ? MyFormatter::formatDateTimeForUser($model->tglmintadikirim) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglmintadikirim',
                    'mode' => 'datetime',
                    'options' => array(
                        'showOn' => false,
                        'dateFormat' => Params::DATE_FORMAT,
                        //                                'maxDate' => 'd',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'class' => 'dtPicker3 span4', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("Pegawai Pemesan <span style='color:red'>*</span>", 'pegawaipemesan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawaipemesan_id'); ?>
                <?php echo $form->textField(
                    $model,
                    'pegawaipemesan_nama',
                    array('readonly' => true, 'class' => 'required span4')
                ); ?>
                <?php
                /*    $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'pegawaipemesan_nama',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePegawai') . '",
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
                            $("#'.Chtml::activeId($model, 'pegawaipemesan_id') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                                            'placeholder'=>'Pegawai Pemesanan',
                        'class'=>'pegawaipemesan_nama',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegawaipemesan_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                ));*/
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Pegawai Mengetahui <span style='color:red;'>*</span>", 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawaimengetahui_id', array('class' => 'required')); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegawaimengetahui_nama',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePegawai') . '",
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
                            $("#' . Chtml::activeId($model, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Pegawai Mengetahui',
                        'class' => 'pegawaimengetahui_nama required hurufs-only span4',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pegawaimengetahui_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'keterangan_pesan', array('rows' => 3, 'cols' => 50, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan Pesan')); ?>
    </div>
</div>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new GFPegawaiV('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState("ruangan_id");
if (isset($_GET['GFPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['GFPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchDialogMengetahui(),
    'filter' => $modPegawaiMengetahui,
    //        'template'=>"{items}\n{pager}",
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
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengetahui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'name' => 'gelardepan',
                    'value'=>'$data->gelardepan',
                ), */
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai', array('class' => 'hurufs-only')),
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'name' => 'gelarbelakang_nama',
                    'value'=>'$data->gelarbelakang_nama',
                ), */
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Pemesan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMenyetujui',
    'options' => array(
        'title' => 'Pencarian Pegawai Pemesan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawaiPemesanan = new GFPegawaiV('searchDialog');
$modPegawaiPemesanan->unsetAttributes();
$modPegawaiPemesanan->ruangan_id = Yii::app()->user->getState("ruangan_id");
if (isset($_GET['GFPegawaiV'])) {
    $modPegawaiPemesanan->attributes = $_GET['GFPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPegawaiPemesanan->searchDialog(),
    'filter' => $modPegawaiPemesanan,
    //'template'=>"{items}\n{pager}",
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
                                                  $(\"#' . CHtml::activeId($model, 'pegawaipemesan_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaipemesan_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ), /*
                array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiPemesanan, 'gelardepan'),
                    'name' => 'gelardepan',
                    'value'=>'$data->gelardepan',
                ), */
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiPemesanan, 'nama_pegawai'),
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ), /*
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiPemesanan, 'gelarbelakang_nama'),
                    'name' => 'gelarbelakang_nama',
                    'value'=>'$data->gelarbelakang_nama',
                ), */

    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>