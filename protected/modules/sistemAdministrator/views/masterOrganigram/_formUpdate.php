<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kporganigram-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'atasan'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
}
echo $form->errorSummary($model);
?>

<div class="row" id="form-pegawai">
    <?php echo $form->hiddenField($model, 'organigram_id', array('readonly' => true)); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'organigramasal_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->atasan = isset($model->organigramasal->organigram_unitkerja) ? $model->organigramasal->organigram_unitkerja : "";
                echo CHtml::activeHiddenField($model, 'organigramasal_id', array('readonly' => true));
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'atasan',
                    'source' => 'js: function(request, response) {
												var organigram_id = $("#' . CHtml::activeId($model, 'organigram_id') . '").val();
												$.ajax({
													url: "' . $this->createUrl('AutocompleteAtasan') . '",
													dataType: "json",
													data: {
														term: request.term,
														organigram_id: organigram_id,
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
											$("#' . CHtml::activeId($model, 'organigramasal_id') . '").val("");
											$("#' . CHtml::activeId($model, 'atasan') . '").val("");
											return false;
										}',
                        'select' => 'js:function( event, ui ) {
											$("#' . CHtml::activeId($model, 'organigramasal_id') . '").val(ui.item.value);
											$("#' . CHtml::activeId($model, 'atasan') . '").val(ui.item.label);
											return false;
										}',

                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama / NIP / Unit Kerja',
                        'onblur' => 'if($(this).val()=="") $("#' . CHtml::activeId($model, 'organigramasal_id') . '").val("")',
                        'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'
                    ),
                    'tombolDialog' => false,
                )); ?>
            </div>
            <div class="controls">
                <label><i class="<?php echo MyIcon::getIcons('info2') ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Kosongkan, jika pegawai berada di level paling atas"></i></label>
            </div>
        </div>

        <?php echo $form->dropDownListRow($model, 'organigram_unitkerja', Chtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'namaunitkerja', 'namaunitkerja'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("Formasi", 'organigram_formasi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'organigram_formasi', array('class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')) . '<label> orang</label>'; ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo CHtml::activeHiddenField($model, 'pegawai_id', array());
                $model->nama_pegawai = (isset($model->pegawai->nama_pegawai) ? $model->pegawai->nama_pegawai : "");
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'nama_pegawai',
                    'sourceUrl' => $this->createUrl('AutocompletePegawai'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
											$("#' . CHtml::activeId($model, 'pegawai_id') . '").val("");
											$("#' . CHtml::activeId($model, 'nama_pegawai') . '").val("");
											$("#' . CHtml::activeId($model, 'jabatan_id') . '").val("");
											$("#' . CHtml::activeId($model, 'organigram_kode') . '").val("");	
											$("#jabatan_nama").val("");
											return false;
										}',
                        'select' => 'js:function( event, ui ) {
											$("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.value);
											$("#' . CHtml::activeId($model, 'nama_pegawai') . '").val(ui.item.label);
											$("#' . CHtml::activeId($model, 'jabatan_id') . '").val(ui.item.jabatan_id);
											$("#' . CHtml::activeId($model, 'organigram_kode') . '").val(ui.item.organigram_kode);	
											$("#jabatan_nama").val(ui.item.jabatan_nama);
											return false;
										}',

                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Pegawai / NIP',
                        'onblur' => 'if($(this).val()=="") $("#' . CHtml::activeId($model, 'pegawai_id') . '").val("")',
                        'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                )); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'organigram_keterangan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
        <?php echo $form->textFieldRow($model, 'organigram_kode', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
    </div>
    <div class="col-sm-6">

        <div class="control-group">
            <?php echo $form->labelEx($model, 'jabatan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'jabatan_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo CHtml::textField('jabatan_nama', '', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'organigram_pelaksanakerja', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'organigram_urutan', array('class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'organigram_periode', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->organigram_periode = (!empty($model->organigram_periode) ? date("d/m/Y", strtotime($model->organigram_periode)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'organigram_periode',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'showOn' => false,
                        //											'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'span3 dtPicker3 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                )); ?>
                <?php echo $form->error($model, 'organigram_periode'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'organigram_sampaidengan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->organigram_sampaidengan = (!empty($model->organigram_sampaidengan) ? date("d/m/Y", strtotime($model->organigram_sampaidengan)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'organigram_sampaidengan',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'showOn' => false,
                        //											'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'span3 dtPicker3 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                )); ?>
                <?php echo $form->error($model, 'organigram_sampaidengan'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'organigram_aktif', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'organigram_aktif'); ?>
            </div>
        </div>
    </div>

</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    if (strtolower($this->id) == 'index') {
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('index'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        );
    } else {
        $action = 'index';
        //if(isset($_GET['from'])){
        //	$action = $_GET['from'];
        //}
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($action, array('modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ulang', 'class' => 'btn btn-default')
        );
    }

    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Tabel Organigram', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl(($from == null) ? 'admin' : 'index', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'master4', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
// Dialog buat nambah data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pilih Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 400,
        'resizable' => true,
    ),
));

$modPegawai = new SAPegawaiM();
if (isset($_GET['SAPegawaiM'])) {
    $modPegawai->attributes = $_GET['SAPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sapegawai-m-grid',
    'dataProvider' => $modPegawai->searchDialog(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
						"onClick"=>"
						  $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'jabatan_id') . '\").val(\"$data->jabatan_id\");    
                                                  $(\"#jabatan_nama\").val(\"$data->Jabatan\");    
						  $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->NamaLengkap\");
						  $(\"#' . CHtml::activeId($model, 'organigram_kode') . '\").val(\"$data->NoKeputusan\");							  
						  $(\"#dialogPegawai\").dialog(\"close\");    
						  "
				   ))',
        ),
        array(
            'header' => 'Jabatan',
            'value' => 'isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-"',
            'filter' =>  CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(SAJabatanM::model()->getJabatanItems(), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
        ),
        'nomorindukpegawai',
        'gelardepan',
        'nama_pegawai',
        array(
            'name' => 'jeniskelamin',
            'filter' =>  CHtml::activeDropDownList($modPegawai, 'jeniskelamin', LookupM::getItems(Params::LOOKUPTYPE_JENIS_KELAMIN), array('empty' => '-- Pilih --')),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget(); ?>