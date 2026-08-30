<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saaksespengguna-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Login Pemakai <span class="required">*</span>', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namaloginpemakai',
                    'value' => $model->loginpemakai_id,
                    'sourceUrl' => $this->createUrl('AutocompleteLoginPemakai'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                setDataPemakai(ui.item.value);
                                                return false;
                                            }',
                        'select' => 'js:function( event, ui ) {
                                                setDataPemakai(ui.item.value);
                                                return false;
                                            }',

                    ),
                    'htmlOptions' => array('placeholder' => 'Login Pemakai', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required'),
                    'tombolDialog' => array('idDialog' => 'dialogLoginPemakai', 'idTombol' => 'tombolLoginPemakai'),
                )); ?>
            </div>
        </div>
        <?php echo $form->hiddenField($model, 'loginpemakai_id', array('id' => 'loginpemakai_id')); ?>
        <div class="control-group">
            <?php echo CHtml::label('Nama', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('nama_pegawai', '', array('placeholder' => 'Nama', 'id' => 'namapegawai', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
            </div>
        </div>
    </div>

</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Akses Pemakai</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class='table table-bordered table-striped datatable' id="aksesPengguna">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Peran Pengguna</th>
                    <th>Tugas Pemakai</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($modPeran as $i => $peran) {
                ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php
                            echo CHtml::CheckBox('peran', '', array(
                                'value' => $peran->peranpengguna_id,
                                'onclick' => 'tambahModul(this)',
                            ));
                            echo '&nbsp;' . $peran->peranpenggunanama; ?></td>
                        <td id="row_modul_<?php echo $peran->peranpengguna_id; ?>"></td>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Akses Pemakai', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'create')); ?>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLoginPemakai',
    'options' => array(
        'title' => 'Daftar Login Pemakai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPemakai = new LoginpemakaiK;
if (isset($_GET['LoginpemakaiK']))
    $modPemakai->attributes = $_GET['LoginpemakaiK'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPemakai->search(),
    'filter' => $modPemakai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPemakai",
                            "onClick" => "
                                          setDataPemakai(\"$data->loginpemakai_id\");
                                          $(\"#dialogLoginPemakai\").dialog(\"close\");    
                                          return false;
                                "))',
        ),
        'nama_pemakai',
        'pegawai.nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>