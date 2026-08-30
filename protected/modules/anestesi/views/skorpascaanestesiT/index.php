<?php Yii::app()->clientScript->registerScriptFile('js/dropdownMulti.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php 
$myicon = new MyIcon();
?>
<style>        
    .control-label{
        text-align:right !important;
        vertical-align: top !important;
    }        
    .form-horizontal .control-label{
        width: 150px !important;
    }
    .input-prepend, .input-append{
        margin-bottom: 0px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN ANESTESI ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Intra Anestesia berhasil disimpan");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'skorpascaanestesi-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));
        ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Skor Aldrette Pasca Anestesi / Sedasi </div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial($this->path_view . '_formSkorAldrette', array(
                    'model' => $model,
                    'modAldrette' => $modAldrette,
                    'nilaiAldrette' => $nilaiAldrette,
                    'form' => $form));
                ?>	
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Evaluasi Nyeri Pasca Anestesi / Sedasi</div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial($this->path_view . '_formSkorEvaluasiNyeri', array(
                    'model' => $model,
                    'modEvaluasiNyeri' => $modEvaluasiNyeri,
                    'nilaiEvaluasiNyeri' => $nilaiEvaluasiNyeri,
                    'form' => $form));
                ?>	
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Skor Bromage Pasca Anestesi / Sedasi</div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial($this->path_view . '_formSkorBromage', array(
                    'model' => $model,
                    'modBromage' => $modBromage,
                    'nilaiBromage' => $nilaiBromage,
                    'modGambarTubuh' => $modGambarTubuh,
                    'form' => $form));
                ?>
            </div>
        </div>

        <div class="panel-body">
            <div class="row-fluid">
                <div class="span6">             
                    <div class="control-group">
                        <?php echo CHtml::label('Pasien Pindah Ke', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'style' => 'width:200px;', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Tanggal / Jam ", 'koordinatormutu_id', array('class' => 'control-label required')) ?>
                        <div class = "controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'waktu',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="control-group">
                        <?php echo CHtml::label("Disetujui Oleh", 'catatan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                                $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'pegawai_nama',
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
                                                    $("#' . Chtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id); 
                                                    return false;
                                                }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Ketik Nama Pegawai', 
                                    'class' => 'span3 pegawai_nama',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pegawai_id') . '").val(""); '
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                            ));
                            ?>
                            <?php echo $form->error($model, 'pegawai_id'); ?>                        
                            <?php echo $form->hiddenField($model, 'pegawai_id', array()); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
            echo "&nbsp;";

            if (!isset($_GET['frame'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index&pasienanastesi_id='.$_GET['pasienanastesi_id']), array('class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'));
            }
            echo "&nbsp;";

            if (isset($_GET['id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printHasil();return false"));
                echo "&nbsp;";
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printHasil();return false", 'disabled' => true));
                echo "&nbsp;";
            }

            $content = $this->renderPartial($this->path_view . 'tips/tipsIntraAnestesi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?> 
        </div>	
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('jsFunctions', array('model'=>$model)); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'width' => 900,
        'height' => 680,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modPegawai = new PegawaiM('search');
//$modPegawai->kelompokpegawai_id = PARAMS::KELOMPOKPEGAWAI_ID_DOKTER_UMUM;
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawaiM'])) {
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai1-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condesed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>', "#", array("class" => "btn-small",
                            "onClick" => "
                                    $('#SkorpascaanastesiT_pegawai_id').val('" . $data->pegawai_id . "');
                                    $('#SkorpascaanastesiT_pegawai_nama').val('" . $data->nama_pegawai . "');
                                    $('#dialogPegawai').dialog('close');    
                                    return false;"
                ));
            },
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif  = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'unitkerja_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'unitkerja_id', Chtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif  = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --')),
            'value' => '!empty($data->unitkerja_id)?$data->unitkerja->namaunitkerja:"-"',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>