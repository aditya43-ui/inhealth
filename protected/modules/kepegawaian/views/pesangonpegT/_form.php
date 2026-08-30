<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pesangonpeg-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php $this->renderPartial($this->path_view . '_pegawai', array('model' => $modPegawai, 'form' => $form)); ?>
        <?php echo $form->errorSummary($model); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-money-bill"></i> Pesangon
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglpesangon', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $model->tglpesangon = MyFormatter::formatDateTimeForUser($model->tglpesangon);

                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpesangon',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'dtPicker3 span3',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'Periode Pesangon', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyMonthPicker', array(
                            'model' => $model,
                            'attribute' => 'periodegaji',
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                                'yearRange' => "-100y:+0y",
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => "span3 periode_gaji",
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onchange' => 'getTanggalPeriode(); setKomponenGaji(null);',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <!--<div class="control-group">
                    <?php //echo CHtml::label('Tgl. Periode Gaji', '', array('class' => 'control-label inline')); 
                    ?>
                    <div class="controls">
                        <?php //echo CHtml::textField('tglgaji_awal', '', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => TRUE)); 
                        ?>
                    </div>
                </div>-->
                <div class="control-group">
                    <?php echo $form->label($model, 'kode_objekpajakpes', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'kode_objekpajakpes', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => TRUE)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->label($model, 'Nomor Pesangon', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'nopesangon', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <?php echo $form->textField($model, 'no_temp', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => TRUE)); ?>
                    </div>
                </div>
                <!--<div class="control-group">    
                    <?php //echo $form->label($model, 'Hari Kerja', array('class' => 'control-label inline')); 
                    ?>
                    <div class="controls">
                        <?php //echo $form->textField($model, 'harikerja', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only harikerja', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => FALSE, 'onkeyup' => 'hitungHariKerjaUntukTunjanganTidakTetap();')); 
                        ?>
                    </div>
                </div>	-->
                <!--<div class="control-group">
                    <?php //echo CHtml::label('Sampai dengan', '', array('class' => 'control-label inline')); 
                    ?>
                    <div class="controls">
                        <?php //echo CHtml::textField('tglgaji_akhir', '', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => TRUE)); 
                        ?>
                    </div>
                </div>-->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped table-condensed" id="komponen_gaji">
                    <thead>
                        <tr>
                            <th>Deskripsi</th>
                            <th width="50">Qty</th>
                            <th width="100">Satuan</th>
                            <th width="100">Gaji</th>
                            <th width="100">Potongan</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align: right" colspan="3">Total</th>
                            <th><?php echo $form->textField($model, 'totalterima', array('style' => 'text-align: right; ', 'class' => 'span2 integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> </th>
                            <th><?php echo $form->textField($model, 'totalpotongan', array('style' => 'text-align: right; ', 'class' => 'span2 integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'totalpajak', array('class' => 'span2 integer2', 'onblur' => 'setPenerimaanBersih();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'potongan_lainlain', array('class' => 'span2 integer2', 'onblur' => 'setPenerimaanBersih();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'pengurangan', array('class' => 'span2 integer2', 'onblur' => 'setPenerimaanBersih();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'penerimaanbersih', array('class' => 'span2 integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($model, 'keterangan', array('rows' => 3, 'cols' => 20, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'mengetahui', array('class' => 'control-label', 'label' => 'Mengetahui (RS)')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'mengetahui_id', array('readonly' => true)) ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            //                                        'name'=>'namapegawai',
                            'attribute' => 'mengetahui',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 4,
                                'focus' => 'js:function( event, ui ) {
									$("#' . CHtml::activeId($model, 'mengetahui') . '").val(ui.item.nama_pegawai);
									return false;
								}',
                                'select' => 'js:function( event, ui ) {
									$("#' . CHtml::activeId($model, 'mengetahui') . '").val(ui.item.nama_pegawai);
                                                                        $("#' . CHtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id);    
									return false;
								}',
                            ),
                            'htmlOptions' => array('placeholder' => 'Mengetahui (RS)', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 '),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai2', 'idTombol' => 'tombolPasienDialog'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'mengetahuipt', array('class' => 'control-label', 'label' => 'Mengetahui (PT)')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'mengetahuipt_id', array('readonly' => true)) ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            //                                        'name'=>'namapegawai',
                            'attribute' => 'mengetahuipt',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 4,
                                'focus' => 'js:function( event, ui ) {
									$("#' . CHtml::activeId($model, 'mengetahui') . '").val(ui.item.nama_pegawai);
									return false;
								}',
                                'select' => 'js:function( event, ui ) {
									$("#' . CHtml::activeId($model, 'mengetahui') . '").val(ui.item.nama_pegawai);
                                                                        $("#' . CHtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id);    
									return false;
								}',
                            ),
                            'htmlOptions' => array('placeholder' => 'Mengetahui (PT)', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3'),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai4', 'idTombol' => 'tombolMengetahuiPTDialog'),
                        ));
                        ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'menyetujui',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'menyetujui', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'menyetujui_id', array('readonly' => true)) ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            //                                        'name'=>'namapegawai',
                            'attribute' => 'menyetujui',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 4,
                                'focus' => 'js:function( event, ui ) {
										$("#' . CHtml::activeId($model, 'menyetujui') . '").val(ui.item.nama_pegawai);
										return false;
									}',
                                'select' => 'js:function( event, ui ) {
										$("#' . CHtml::activeId($model, 'menyetujui') . '").val(ui.item.nama_pegawai);
                                                                                $("#' . CHtml::activeId($model, 'menyetujui_id') . '").val(ui.item.pegawai_id);     
										return false;
									}',
                            ),
                            'htmlOptions' => array('placeholder' => 'Menyetujui', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3'),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai3', 'idTombol' => 'tombolPasienDialog'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-pesangon',
                    'content' => array(
                        'content-pesangon' => array(
                            'header' => '<b>Perhitungan Pajak Pesangon</b>',
                            'isi' => $this->renderPartial(
                                $this->path_view . '_perhitunganPesangon',
                                array(
                                    'form' => $form,
                                    'model' => $model,
                                ),
                                true
                            ),
                            'active' => false,
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    if (isset($_GET['id'])) {
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => 'disabled'));
    } else {
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    }
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])) . '";}); return false;'
        )
    ); ?>
    <?php
    //    if (isset($_GET['id'])) {
    //        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="'.MyIcon::getIcons('cetak').'"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    //    } else {
    //        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="'.MyIcon::getIcons('cetak').'"></i>')), array('class' => 'btn btn-info', 'disabled' => 'disabled'));
    //    }
    ?>
    <?php
    $tips = array(
        '0' => 'waktutime',
        '1' => 'autocomplete-search',
        '2' => 'simpan',
        '3' => 'ulang',
        '4' => 'print',
        '5' => 'status_print',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'create', 'content' => $content));
    ?>
</div>

<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai4',
    'options' => array(
        'title' => 'Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJRegistrasifingerprint();
$modPegawai->jabatan_id = Params::JABATAN_ID_KASI_PERSONALIA;
if (isset($_GET['GJRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['GJRegistrasifingerprint'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai5-m-grid',
    'dataProvider' => $modPegawai->search(),
    //    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#' . CHtml::activeId($model, 'mengetahuipt') . '\").val(\"$data->nama_pegawai\");
                                                      $(\"#' . CHtml::activeId($model, 'mengetahuipt_id') . '\").val(\"$data->pegawai_id\");    
                                                      $(\"#dialogPegawai4\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            //            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . ' $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . '}',
));

$this->endWidget();
?>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai2',
    'options' => array(
        'title' => 'Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJRegistrasifingerprint();
$modPegawai->jabatan_id = Params::JABATAN_ID_DIREKTUR;
if (isset($_GET['GJRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['GJRegistrasifingerprint'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai4-m-grid',
    'dataProvider' => $modPegawai->search(),
    //    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#' . CHtml::activeId($model, 'mengetahui') . '\").val(\"$data->nama_pegawai\");
                                                      $(\"#' . CHtml::activeId($model, 'mengetahui_id') . '\").val(\"$data->pegawai_id\");    
                                                      $(\"#dialogPegawai2\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            //            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . ' $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . '}',
));

$this->endWidget();
?>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai3',
    'options' => array(
        'title' => 'Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJRegistrasifingerprint();
$modPegawai->jabatan_id = Params::JABATAN_ID_DIREKTUR_RS;
if (isset($_GET['GJRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['GJRegistrasifingerprint'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai5-m-grid',
    'dataProvider' => $modPegawai->search(),
    //    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#' . CHtml::activeId($model, 'menyetujui') . '\").val(\"$data->nama_pegawai\");
                                                      $(\"#' . CHtml::activeId($model, 'menyetujui_id') . '\").val(\"$data->pegawai_id\");    
                                                      $(\"#dialogPegawai3\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            //            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . ' $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . '}',
));
$this->endWidget();

Yii::app()->clientScript->registerScript('onheadfunction', '

    function setPotongan(){
        var totalPotongan = 0;
        $(".potongan").each(function(){
        value = unformatNumber($(this).val());
            if (jQuery.isNumeric(value)){
                totalPotongan += value;
            }
        });
        $("#' . CHtml::activeId($model, 'totalpotongan') . '").val(formatNumber(totalPotongan));
        setHarga();
    }
    function setHarga(){
        var pajak = unformatNumber($("#' . CHtml::activeId($model, 'totalpajak') . '").val());
        var gaji = unformatNumber($("#' . CHtml::activeId($model, 'totalterima') . '").val());
        var potongan_lainlain = unformatNumber($("#' . CHtml::activeId($model, 'potongan_lainlain') . '").val());
        var potongan = unformatNumber($("#' . CHtml::activeId($model, 'totalpotongan') . '").val()) + potongan_lainlain;
        var pengurangan = unformatNumber($("#' . CHtml::activeId($model, 'pengurangan') . '").val());
        value = (gaji - (potongan)) - pengurangan;

    }
', CClientScript::POS_HEAD);

$this->endWidget(); ?>

<script>
    function hitungHariKerjaUntukTunjanganTidakTetap() {

        var harikerja = $(".harikerja").val();
        $("#komponen_gaji tbody tr").each(function() {
            if ($(this).find(".unit").val() == "HARI") {
                $(this).find(".qty").val(harikerja);
            }
        });

        hitungGaji();
    }

    function hitungGaji() {

        $("#komponen_gaji tbody tr").each(function() {
            var qty = parseFloat(unformatNumber($(this).find(".qty").val()));
            var satuan = parseFloat(unformatNumber($(this).find(".satuan").val()));

            $(this).find(".subtotal").val(formatNumber(qty * satuan));
        });

        hitungBonusPegawai();
        hitungTunjangan_BPJS_Naker();
        hitungKeterlambatan();

        setGaji();

        setPotongan();
        hitungpph();

        setTunjanganMakanTransport();
    }

    function hitungBonusPegawai() {
        var qty_bonus = $("#PesangonkompT_103_qty").val();
        var fungsional = parseFloat(unformatNumber($("#PesangonkompT_4_jumlah").val()));
        var jabatan = parseFloat(unformatNumber($("#PesangonkompT_2_jumlah").val()));
        var gapok = parseFloat(unformatNumber($("#PesangonkompT_1_jumlah").val()));

        if (qty_bonus != undefined) {
            var total = qty_bonus * (gapok + (fungsional + jabatan));
            $('#PesangonkompT_103_satuan').val(formatNumber(total));
            $('#PesangonkompT_103_jumlah').val(formatNumber(total));
        }

    }

    function hitungTunjangan_BPJS_Naker() {
        var bpjs_kerja_JHT = parseFloat(unformatNumber($("#PesangonkompT_100_satuan").val()));
        var bpjs_kerja_JKK = parseFloat(unformatNumber($("#PesangonkompT_97_satuan").val()));
        var bpjs_kerja_JK = parseFloat(unformatNumber($("#PesangonkompT_98_satuan").val()));
        var bpjs_kerja_JP = parseFloat(unformatNumber($("#PesangonkompT_99_satuan").val()));
        var total = bpjs_kerja_JHT + bpjs_kerja_JKK + bpjs_kerja_JK + bpjs_kerja_JP;
        $("#PesangonkompT_94_satuan").val(formatNumber(total));
    }

    function hitungKeterlambatan() {
        var var_pegawai_id = $("#pegawai_id").val();
        var periodegaji = $("#KPPesangonpegT_periodegaji").val();
        var hrg_satuan = parseFloat(unformatNumber($('#PesangonkompT_74_satuan').val()));
        var jmlPotongan = 0;
        var potongan15 = 0;
        var potongan60 = 0;
        var jumlahawal = parseFloat(unformatNumber($('#PesangonkompT_74_jumlah').val()));
        $.post('<?php echo $this->createUrl('HitungKeterlambatan'); ?>', {
            pegawai_id: var_pegawai_id,
            periodegaji: periodegaji
        }, function(data) {

            if (data.lama15 != 0) {
                potongan15 = data.lama15 * (0.5 * hrg_satuan);
            }

            if (data.lama60 != 0) {
                potongan60 = data.lama60 * hrg_satuan;
            }

            jmlPotongan = jumlahawal - (potongan15 + potongan60);

            $('#PesangonkompT_74_jumlah').val(formatNumber(jmlPotongan));

        }, 'json');
    }

    function rumusPph21Pertahap(valuePesangon) {
        var pesangon = valuePesangon;

        var totPph21 = 0;
        var hslPengurangan = 0;

        if (pesangon >= 0) {
            if (pesangon >= 50000000) {
                //                 console.log('tahap 1');
                hslPengurangan = pesangon - 50000000;
                hslp = pesangon - hslPengurangan;

                totPph21 += ((0 / 100) * hslp);
                totalsemula = hslPengurangan + hslp;

                //                  console.log('===hasil pengurangan==  ' + hslp);
                //                  console.log('pph 21 ' + ((0 / 100 ) * hslp));

                if (hslPengurangan >= 50000000) {
                    //                      console.log('tahap 2');
                    afterhsl = hslPengurangan;
                    afterhslp = hslp;
                    hslPengurangan = hslPengurangan - 50000000;
                    hslp = afterhsl - hslPengurangan;
                    totPph21 += ((5 / 100) * hslp);

                    //                  console.log('===hasil pengurangan==  ' + hslp);
                    //                  console.log('pph 21 ' + ((5 / 100 ) * hslp));

                    if (hslPengurangan >= 400000000) {
                        //                           console.log('tahap 3');
                        afterhsl = afterhslp + hslp;
                        afterhslp = hslPengurangan;
                        hslp = 400000000;
                        sisapesangon = pesangon - hslp - afterhsl;
                        totPph21 += ((15 / 100) * hslp);
                        //                          
                        //                          console.log('===hasil pengurangan==  ' + hslp);
                        //                  console.log('pph 21 ' + ((15 / 100 ) * hslp));

                        if (sisapesangon > 0) {
                            //                                console.log('tahap 4');
                            //                                console.log(' ===finis========= '+ sisapesangon);
                            totPph21 += ((25 / 100) * sisapesangon);
                            //                                console.log('totPph21 '+ ((25 / 100 ) * sisapesangon));
                            //                                 console.log('hasil tahapan 4 '+ sisapesangon);
                        } else {
                            if (sisapesangon == 0) {
                                //                                     console.log('tahap 3 berakhir');
                                //                                     console.log(' ===finis 3========= '+ sisapesangon);
                                totPph21 += ((15 / 100) * sisapesangon);
                                //                            console.log('totPph21 '+ ((15 / 100 ) * sisapesangon));
                            }
                        }

                    } else {
                        //                          console.log('tahap 3 berakhir');
                        //                      console.log(' ===finis 3========= '+ hslPengurangan);
                        totPph21 += ((15 / 100) * hslPengurangan);
                        //                     console.log('totPph21 '+ ((15 / 100 ) * hslPengurangan)); 
                    }

                } else {
                    //                      console.log('tahap 2 berakhir');
                    //                      console.log(' ===finis 2========= '+ hslPengurangan);
                    totPph21 += ((5 / 100) * hslPengurangan);
                    //                     console.log('totPph21 '+ ((5 / 100 ) * hslPengurangan));
                }
            } else {
                //                      console.log('tahap 1 berakhir');
                //                      console.log(' ===finis 1========= '+ hslPengurangan);
                totPph21 += ((0 / 100) * hslPengurangan);
                //                     console.log('totPph21 '+ ((0 / 100 ) * hslPengurangan));
            }
        }
        return totPph21;

    }

    function hitungpph() {
        var pkp = parseFloat(unformatNumber($('#KPPesangonpegT_ptkp').val()));
        var pesangon = parseFloat(unformatNumber($('#KPPesangonpegT_gajipokok').val()));

        var totPph21 = rumusPph21Pertahap(pesangon);

        //        if(pesangon >=0){
        //            if(pesangon > 50000000){
        //                hslPph1 = pesangon - 50000000;
        //                totPph21 = (0.05 * 50000000); 
        //                if(hslPph1 > 100000000){
        //                    hslPph2 = hslPph1 - 50000000;
        //                    if(hslPph2 > 400000000){
        //                        hslPph3 = hslPph2 - 400000000;
        //                        totPphLapis3 = totPph21 + (0.15 * 400000000) + (0.25 * hslPph3);
        //                        totPph21 = totPphLapis3;
        ////                        console.log('lapis3:'+hslPph2+":"+hslPph3);
        //                    }
        //                    else{
        //                        totPphLapis2 = totPph21 + (0.15 * hslPph2);
        //                        totPph21 = totPphLapis2;
        ////                        console.log('lapis2:');
        //                    }
        //                }
        //                else{
        //                    totPphLapis1 = totPph21 + 0;
        //                    totPph21 = totPphLapis1;
        ////                    console.log('lapis1');
        //                }
        //            }
        //        }
        $('#KPPesangonpegT_totalpajak').val(formatNumber(totPph21));
        $('#KPPesangonpegT_pph21').val(formatNumber(totPph21));

        $.post('<?php echo $this->createUrl('AmbilPph'); ?>', {
            pkp: pkp
        }, function(data) {
            var persen = data.percent / 100;
            var persenpertahun = persen * pkp;
            var persenperbulan = persenpertahun / 12;
            var pembulatan = Math.round(persenperbulan * Math.pow(10, 0)) / Math.pow(10, 0);
            //            console.log('OKG:'+pembulatan);
            //            $('#KPPesangonpegT_totalpajak').val(formatNumber(pembulatan));
            //            $('#KPPesangonpegT_pph21').val(formatNumber(pembulatan));
            $('#KPPesangonpegT_persentasepph21').val(data.percent);
            var statuskawin = $('#statusperkawinan').val();
            if (statuskawin == 'KAWIN') {
                var kodekawin = 'K';
            } else {
                var kodekawin = 'TK';
            }
            var jmlanak = $('#jml_tanggungan').val();
            if (jmlanak > 3) {
                jmlanak = 3;
            }
            var kdptkp = kodekawin + "/" + jmlanak;
            $('#KPPesangonpegT_kodeptkp').val(kdptkp);
            //            hitungTunjanganPPH();
            setGaji();
        }, 'json');
    }

    function setTunjanganMakanTransport() {
        var kom_tunjanganmakan = $('#PenggajiankompT_5_jumlah').val();
        var kom_tunjangantransport = $('#PenggajiankompT_74_jumlah').val();
        if (typeof kom_tunjanganmakan != "undefined") {
            $('#tunjanganmakan').val(kom_tunjanganmakan);
        }
        if (typeof kom_tunjanganmakan != "undefined") {
            $('#tunjangantransportasi').val(kom_tunjangantransport);
        }
    }

    function setGaji() {
        var totalGaji = 0;
        $(".gaji").each(function() {
            value = unformatNumber($(this).val());
            if (value > 0) {
                totalGaji += parseInt(value);
            }
        });

        $("#<?php echo CHtml::activeId($model, 'totalterima') ?>").val(formatNumber(totalGaji));
        $("#<?php echo CHtml::activeId($model, 'gajipokok') ?>").val(formatNumber(totalGaji));

        setPenerimaanBersih();
    }

    function setPenerimaanBersih() {
        var totalterima = parseFloat(unformatNumber($("#KPPesangonpegT_totalterima").val()));
        var pengurangan = parseFloat(unformatNumber($("#KPPesangonpegT_pengurangan").val()));
        var potLainlain = parseFloat(unformatNumber($("#KPPesangonpegT_potongan_lainlain").val()));
        var potongan = parseFloat(unformatNumber($("#KPPesangonpegT_totalpotongan").val()));
        var total_pajak = parseFloat(unformatNumber($("#KPPesangonpegT_totalpajak").val()));

        penerimaan = (totalterima - pengurangan - potLainlain - potongan - total_pajak);
        $("#KPPesangonpegT_penerimaanbersih").val(formatNumber(penerimaan));
    }

    function setKomponenGaji(pegawai_id) {

        var var_pegawai_id = $("#pegawai_id").val();
        var var_periode = $(".periode_gaji").val();
        var tglgaji_awal = $("#tglgaji_awal").val();
        var tglgaji_akhir = $("#tglgaji_akhir").val();
        if (var_pegawai_id.trim() == "") {
            return false;
        }
        $('#komponen_gaji').find("tbody").empty();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetKomponenGaji'); ?>',
            data: {
                pegawai_id: var_pegawai_id,
                periode: var_periode
            },
            dataType: "json",
            success: function(data) {

                if (data.sukses == 1) {

                    if (data.sudah_ada == 1) {
                        myAlert(data.sudah_ada_msg);
                        return false;
                    }

                    var tr = $('#komponen_gaji').find("tbody > tr");

                    $('#komponen_gaji').find("tbody").html(data.row);

                    $("#komponen_gaji .integer2").maskMoney({
                        "symbol": "",
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ",",
                        "thousands": ".",
                        "precision": 0
                    });
                    setPtkp(var_pegawai_id);
                    hitungHariKerjaUntukTunjanganTidakTetap();
                    hitungGaji();

                    //                    setGaji();
                    //                    setPotongan();
                    //                    setPinjamanKoperasi(var_pegawai_id);

                    //
                    $(".harikerja").val(data.harikerja);

                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function getTanggalPeriode() {
        var var_periode = $(".periode_gaji").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetTanggalPeriode'); ?>',
            data: {
                periode: var_periode
            },
            dataType: "json",
            success: function(data) {

                $('#tglgaji_awal').val(data.tgl_awal);
                $('#tglgaji_akhir').val(data.tgl_akhir);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function() {
        getTanggalPeriode();
    });
</script>