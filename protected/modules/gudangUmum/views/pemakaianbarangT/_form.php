<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gupemakaianbarang-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pemakaian Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <?php echo $form->errorSummary($model); ?>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Tgl. Pemakaian Barang', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $model->tglpemakaianbrg = !empty($model->tglpemakaianbrg) ? MyFormatter::formatDateTimeForUser($model->tglpemakaianbrg) : date('d M Y H:i:s');

                        echo $form->textField($model, 'tglpemakaianbrg', array('class' => 'span3 realtime', 'readonly' => TRUE));
                        $model->tglpemakaianbrg = !empty($model->tglpemakaianbrg) ? MyFormatter::formatDateTimeForDb($model->tglpemakaianbrg) : date('Y-m-d H:i:s');
                        ?>
                        <?php echo $form->error($model, 'tglpemakaianbrg'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nopemakaianbrg', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                <?php echo $form->textAreaRow($model, 'keteranganpakai', array('rows' => 4, 'cols' => 80, 'placeholder' => 'Keterangan Pakai', 'class' => 'span3 autogrow', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
            <div class="col-sm-6">
                <?php //echo $form->dropDownListRow($model,'pegawai_id',Chtml::listData(
                //PegawairuanganV::model()->findAllByAttributes(array(
                //	'pegawai_aktif'=>true,
                //	'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                //), array(
                //	'order'=>'nama_pegawai asc'
                //))
                //,'pegawai_id','nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'empty'=>'-- Pilih --')); 
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        //echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(LBPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); 
                        echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'required'));

                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'pegawai_nama',
                            'source' => 'js: function(request, response) {
									$.ajax({
									url: "' . $this->createUrl('/ActionAutoComplete/DropPetugasRuangan') . '",
									dataType: "json",
									data: {
										term: request.term,
										ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
									},
									success: function (data) {
										response(data);
									}
								})
							}',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 0,
                                'focus' => 'js:function( event, ui ) {
									$(this).val( ui.item.label);
									return false;
								 }',
                                'select' => 'js:function( event, ui ) {
									$("#' . CHtml::ActiveId($model, 'pegawai_id') . '").val(ui.item.value); 
									return false;
								 }',
                            ),
                            'htmlOptions' => array('placeholder' => 'Pegawai Mengetahui', 'class' => 'span3 required')
                        ));
                        ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($model, 'untukkeperluan', array('placeholder' => 'Untuk Keperluan', 'rows' => 4, 'cols' => 80, 'class' => 'span3 autogrow', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-credit-card"></i> Detail <b>Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_formDetailBarang', array('model' => $model, 'form' => $form,)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_tableDetailBarang', array('model' => $model, 'form' => $form, 'modDetails' => $modDetails,)); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
    $disableSave = false;
    $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
    ?>
    <?php $disablePrint = ($disableSave) ? false : true; ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekBarang();', 'onkeypress' => 'cekBarang();', 'disabled' => $disableSave)
    ); //formSubmit(this,event) 
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->module->id . '/Index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'
        )
    ); ?>
    <?php
    if (isset($_GET['sukses'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => false));
    } else {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
    }
    ?>
    <?php
    $content = $this->renderPartial('gudangUmum.views.pemakaianbarangT.tips.tipsPemakaianBarang', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modDetails' => $modDetails)); ?>