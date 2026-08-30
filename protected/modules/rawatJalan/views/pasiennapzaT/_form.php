<div class="white-container">
    <legend class="rim2">Transaksi <b>Pasien Napza</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'rjpasiennapza-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#',
    ));
    ?>
    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim">Data Kunjungan
            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
        </legend>
        <div class="row">
            <?php
            echo $this->renderPartial('_formInfoKunjungan', array(
                'model' => $model,
                'modPasien' => $modPasien,
                'modPeriksaFisik' => $modPeriksaFisik,
                'modAnamnesa' => $modAnamnesa, 'form' => $form
            ));
            ?>
        </div>
    </fieldset>

    <?php
    /**
      Diupdate oleh     : David Yanuar
      Tgl. update        : 15 April 2014
      Fungsi            : Memberikan efek detail panel ("well")
     */
    ?>
    <fieldset class="box">
        <legend class="rim">Data Napza</legend>
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <table>
            <?php echo $form->errorSummary($model); ?>
            <tr>
                <td width="550px">
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'Tanggal Pemeriksaan Napza', array('class' => 'control-label')) ?>
                        <div class='controls'>
                            <?php echo CHtml::activeTextField($model, 'tglperiksanapza', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>

                    <!--<div class="control-group">
                        <?php //echo CHtml::activeLabel($modPasien, 'nama_pegawai', array('class' => 'control-label'));  
                        ?>
                                 <div class="controls">
                        <?php //echo CHtml::activeTextField($modPasien, 'nama_pegawai', array('readonly' => true));  
                        ?>
                                 </div>
                         </div>-->
                    <div class="control-group">
                        <?php echo $form->labelEx($modPasien, 'nama_pegawai', array('class' => 'control-label')) ?>
                        <?php echo CHtml::activeHiddenField($model, 'pegawai_id'); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPasien,
                                'attribute' => 'nama_pegawai',
                                'value' => '',
                                'sourceUrl' => $this->createUrl('AutocompleteDokter'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                                                    $(this).val( ui.item.label);
                                                                    $(this).val(ui.item.nama_pegawai);
                                                                    return false;
                                                            }',
                                    'select' => 'js:function( event, ui ) {
                                                                                    $(this).val(ui.item.nama_pegawai);
                                                                                    $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                                                                            return false;
                                                                              }'
                                ),
                                'htmlOptions' => array(
                                    'readonly' => false,
                                    'placeholder' => 'Nama Dokter',
                                    'size' => 20,
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogDokter'), //'idTombol'=>'tombolPasienDialog'),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Nama Paramedis', array('class' => 'control-label')) ?>
                        <?php echo CHtml::activeHiddenField($model, 'paramedis_id'); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'paramedis_nama',
                                'value' => '',
                                'sourceUrl' => $this->createUrl('AutocompleteParamedis'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                                                    $(this).val( ui.item.label);
                                                                    $(this).val(ui.item.paramedis_nama);
                                                                    return false;
                                                            }',
                                    'select' => 'js:function( event, ui ) {
                                                                                    $(this).val(ui.item.paramedis_nama);
                                                                                    $("#' . CHtml::activeId($model, 'paramedis_id') . '").val(ui.item.paramedis_id);
                                                                                            return false;
                                                                              }'
                                ),
                                'htmlOptions' => array(
                                    'readonly' => false,
                                    'placeholder' => 'Nama Paramedis',
                                    'size' => 20,
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogParamedis'), //'idTombol'=>'tombolPasienDialog'),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'jenis napza', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'jenisnapza_id', CHtml::listData(JenisnapzaM::model()->findAll(), 'jenisnapza_id', 'jenisnapza_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Napza', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'napza_id', CHtml::listData(NapzaM::model()->findAll(), 'napza_id', 'napza_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Detail Napza', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'detailnapza_id', CHtml::listData(DetailnapzaM::model()->findAll(), 'detailnapza_id', 'detailnapza_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    <!--//echo $form->dropDownListRow($model,'napza_id',CHtml::listData(NapzaM::model()->findAll(), 'napza_id', 'napza_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                               //echo $form->dropDownListRow($model,'detailnapza_id',CHtml::listData(DetailnapzaM::model()->findAll(), 'detailnapza_id', 'detailnapza_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                               // echo $form->hiddenField($model,'pendaftaran_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                               // echo $form->hiddenField($model,'pasien_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                               //echo $form->textFieldRow($model,'tglperiksanapza',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>-->

                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'Kunjungan Ke', array('class' => 'control-label')) ?>
                        <div class='controls'>
                            <?php echo CHtml::activeTextField($model, 'jml_kunjungan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'metodenapza', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'metodenapza', CHtml::listData(LookupM::model()->findAll("lookup_type like '%metodenapza%'"), 'lookup_id', 'lookup_name'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                    <div class="control-label">Keterangan Metode</div>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'keteranganmetode', 'toolbar' => 'mini', 'height' => '100px')) ?>
                    </div>
                </td>
                <td>
                    <div class="control-label">Hasil Pemeriksaan Napza</div>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'hasilpemeriksaannapza', 'toolbar' => 'mini', 'height' => '100px')) ?>
                    </div>
                    <?php echo $form->textAreaRow($model, 'catatannapza', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'lamarehabilitasi', array('class' => 'control-label')) ?>
                        <div class='controls'>
                            <?php echo $form->textField($model, 'lamarehabilitasi', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->dropDownList($model, 'satuanlama', LookupM::getItems('satuanumum'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
        </table>
    </fieldset>
    <div class="form-actions">
        <?php
        $disableSave = isset($_GET['id']) ? true : false;
        ?>
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disableSave));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/create'), array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('create') . '";} ); return false;'
        ));
        ?>
        <?php $content = $this->renderPartial('../tips/transaksi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->renderPartial('_jsFunctions', array('modPasien' => $modPasien, 'model' => $model)); ?>
    <?php $this->endWidget(); ?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogDokter',
        'options' => array(
            'title' => 'Dokter',
            'autoOpen' => false,
            'resizable' => true,
            'modal' => true,
            'width' => 570,
        ),
    ));

    $criteria = new CDbCriteria();
    $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
    $criteria->order = 'nama_pegawai';
    $models = DokterV::model()->findAll($criteria);
    $dataProvider = new CActiveDataProvider('DokterV', array(
        'criteria' => $criteria,
    ));

    $modDokter = new RJDokterV('searchDokterdialog');
    $modDokter->unsetAttributes();
    if (isset($_GET['RJDokterV'])) {
        $modDokter->attributes = $_GET['RJDokterV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dokter-m-grid',
        'dataProvider' => $modDokter->searchDokterdialog(),
        'filter' => $modDokter,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                                            "id" => "selectDokter",
                                                            "onClick" => "
                                                                    $(\"#dialogDokter\").dialog(\"close\");
                                                                    $(\"#' . CHtml::activeId($modPasien, 'nama_pegawai') . '\").val(\"$data->nama_pegawai\");
                                                                    $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                                            "))',
            ),
            array(
                'header' => 'Gelar Depan',
                'value' => '$data->gelardepan',
            ),
            'nama_pegawai',
        )
    ));

    $this->endWidget('ext.bootstrap.widgets.BootGridView');
    ?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogParamedis',
        'options' => array(
            'title' => 'Paramedis',
            'autoOpen' => false,
            'resizable' => true,
            'modal' => true,
            'width' => 570,
        ),
    ));

    $criteria = new CDbCriteria();
    $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
    $criteria->order = 'nama_pegawai';
    $models = ParamedisV::model()->findAll($criteria);
    $dataProvider = new CActiveDataProvider('ParamedisV', array(
        'criteria' => $criteria,
    ));

    $modParamedis = new RJParamedisV('searchParamedisdialog');
    $modParamedis->unsetAttributes();
    if (isset($_GET['RJParamedisV'])) {
        $modParamedis->attributes = $_GET['RJParamedisV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'paramedis-m-grid',
        'dataProvider' => $modParamedis->searchParamedisdialog(),
        'filter' => $modParamedis,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                                            "id" => "selectParamedis",
                                                            "onClick" => "
                                                                    $(\"#dialogParamedis\").dialog(\"close\");
                                                                    $(\"#' . CHtml::activeId($model, 'paramedis_nama') . '\").val(\"$data->nama_pegawai\");
                                                                    $(\"#' . CHtml::activeId($model, 'paramedis_id') . '\").val(\"$data->pegawai_id\");
                                                            "))',
            ),
            array(
                'header' => 'Gelar Depan',
                'value' => '$data->gelardepan',
            ),
            'nama_pegawai',
        )
    ));

    $this->endWidget('ext.bootstrap.widgets.BootGridView');
    ?>
</div>