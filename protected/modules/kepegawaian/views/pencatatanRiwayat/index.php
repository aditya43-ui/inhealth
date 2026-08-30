<?php
$this->breadcrumbs = array(
    'Pencatatan Riwayat Pribadi Pegawai',
);

$arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Pencatatan Riwayat').' Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Pegawai', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pegawai', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu = $arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-user-edit"></i> Transaksi <b>Pencatatan Riwayat Pribadi Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pegawai</b> </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPegawaiReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data pegawai')); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->errorSummary($model); ?>
                <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <fieldset class="" id="form-pegawai">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::label('NIP', 'nomorindukpegawai', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php

                                    $modul = ModulK::model()->findByAttributes(
                                        array('modul_key' => $this->module->id)
                                    );
                                    $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '');
                                    $this->widget('MyJuiAutoComplete', array(
                                        'name' => 'nomorindukpegawai',
                                        'value' => $model->nomorindukpegawai,
                                        'sourceUrl' => $this->createUrl('PegawairiwayatNip'),
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 4,
                                            'focus' => 'js:function( event, ui ) {
                                                            $("#pegawai_id").val( ui.item.value );
                                                            $("#namapegawai").val( ui.item.nama_pegawai );
                                                            return false;
                                                        }',
                                            'select' => 'js:function( event, ui ) {
                                                            $("#pegawai_id").val( ui.item.value );
                                                            setDataPegawai(ui.item.value);
                                                            return false;
                                                        }',

                                        ),
                                        'htmlOptions' => array('placeholder' => 'NIP', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4'),
                                        'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPasienDialog'),
                                    )); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Nama Pegawai', 'namapegawai', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                                    <?php

                                    $modul = ModulK::model()->findByAttributes(
                                        array('modul_key' => $this->module->id)
                                    );
                                    $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '');
                                    $this->widget('MyJuiAutoComplete', array(
                                        'name' => 'namapegawai',
                                        'value' => $model->nama_pegawai,
                                        'sourceUrl' => $this->createUrl('Pegawairiwayat'),
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 4,
                                            'focus' => 'js:function( event, ui ) {
                                                            $("#pegawai_id").val( ui.item.value );
                                                            $("#namapegawai").val( ui.item.nama_pegawai );
                                                            return false;
                                                        }',
                                            'select' => 'js:function( event, ui ) {
                                                            $("#pegawai_id").val( ui.item.value );
                                                            setDataPegawai(ui.item.value);
                                                            return false;
                                                        }',

                                        ),
                                        'htmlOptions' => array('placeholder' => 'Nama Pegawai', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4'),
                                        'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPasienDialog'),
                                    )); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($model, 'tempatlahir_pegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'tempatlahir_pegawai')); ?>
                            <?php
                            $model->tgl_lahirpegawai = MyFormatter::formatDateTimeForUser($model->tgl_lahirpegawai);
                            echo $form->textFieldRow($model, 'tgl_lahirpegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'tgl_lahirpegawai')); ?>
                        </div>
                        <div class="col-sm-6">
                            <?php echo $form->textFieldRow($model, 'jeniskelamin', array('class' => 'span4', 'readonly' => true, 'id' => 'jeniskelamin')); ?>
                            <?php echo $form->textFieldRow($model, 'statusperkawinan', array('class' => 'span4', 'readonly' => true, 'id' => 'statusperkawinan')); ?>
                            <?php echo $form->textFieldRow($model, 'jabatan_id', array('class' => 'span4', 'readonly' => true, 'id' => 'jabatan')); ?>
                            <?php echo $form->textAreaRow($model, 'alamat_pegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'alamat_pegawai')); ?>
                            <?php
                            if (file_exists(Params::pathPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai)) {
                                echo CHtml::image(Params::pathPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                            } else {
                                echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                            }
                            ?>
                        </div>
                    </div>
                </fieldset>
                <?php $this->renderPartial('_tabMenu', array()); ?>
                <?php $this->renderPartial('_jsFunctions', array()); ?>
                <div>
                    <iframe class="biru" id="frame" src="" frameborder="0" style="overflow-y:scroll" width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $tips = array(
                '0' => 'hapus',
                '1' => 'simpan',
                '2' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));

$modPegawai = new PegawaiM;
if (isset($_GET['PegawaiM']))
    $modPegawai->attributes = $_GET['PegawaiM'];

$provider = $modPegawai->search();
$provider->sort->defaultOrder = 'nama_pegawai asc';
$provider->criteria->order = 'nama_pegawai asc';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $provider,
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "
                                          setDataPegawai(\"$data->pegawai_id\");
                                          $(\"#dialogPegawai\").dialog(\"close\");    
                                          return false;
                                "))',
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        'tempatlahir_pegawai',
        'tgl_lahirpegawai',
        array(
            'name' => 'jeniskelamin',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'statusperkawinan',
            'filter' => CHtml::activeDropDownList($modPegawai, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Jabatan',
            'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(
                JabatanM::model()->findAll(array(
                    'condition' => 'jabatan_aktif = true',
                    'order' => 'jabatan_nama'
                )),
                'jabatan_id',
                'jabatan_nama'
            ), array('empty' => '-- Pilih --')),
        ),
        // 'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>