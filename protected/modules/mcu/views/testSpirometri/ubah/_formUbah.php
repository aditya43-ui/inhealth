<?php
$this->breadcrumbs = array(
    'Mcu',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pemeriksaan Tes Spirometri berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'tesspirometri-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
));
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Tes Spirometri</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <?php
            $modPegawai = new PegawairuanganV();

            $modPegawai->unsetAttributes();
            $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

            if (isset($_GET['PegawairuanganV'])) {
                $modPegawai->attributes = $_GET['PegawairuanganV'];
            }

            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'tes-spirometri-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            ));

            $this->widget('bootstrap.widgets.BootAlert');

            echo $this->renderPartial($this->path_view . '_info', array(
                'form' => $form,
                'model' => $model,
                'modPemeriksaanFisik' => $modPemeriksaanFisik,
            ), true);

            echo $this->renderPartial($this->path_view . '_formSpirometri', array(
                'form' => $form,
                'model' => $model,
            ), true);
            ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        Kesimpulan dan Saran
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'kesimpulan', array('class' => 'control-label')); ?>
                        <div class="controls" style="width: calc(100% - 150px);">
                            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'kesimpulan', 'toolbar' => 'mini', 'height' => '100px')) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'test_spirometri', array('class' => 'control-label', 'label' => 'Tes Spirometri')); ?>
                        <div class="controls" style="width: calc(100% - 150px);">
                            <?php
                            echo $form->textField($model, 'test_spirometri', array(
                                'class' => 'span4',
                                'readonly' => true,
                            )); ?>
                        </div>
                    </div>


                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'test_reversibilitas_plus', array('class' => 'control-label', 'label' => 'Tes Reversibilitas')); ?>
                        <div class="controls" style="width: calc(100% - 150px);">
                            <?php
                            echo $form->textField($model, 'test_reversibilitas_nilai', array('class' => 'angkacoma-only span1', 'style' => 'text-align: right;'));
                            echo "&emsp;";
                            echo $form->radioButtonList($model, 'test_reversibilitas_is_positif', [0 => 'Negatif', 1 => 'Positif'], array(
                                'template' => '<span style="margin-right: 10px;">{input}{label}</span>',
                                'onclick' => 'checkInputLevel(this);',
                                'class' => 'radio_reversibilitas'
                            ));
                            ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'saran', array('class' => 'control-label')); ?>
                        <div class="controls" style="width: calc(100% - 150px);">
                            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'saran', 'toolbar' => 'mini', 'height' => '100px')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'pengetahui_id', array('class' => 'control-label', 'label' => 'Pegawai Mengetahui')); ?>
                        <div class="controls">
                            <?php
                            echo $form->hiddenField($model, 'pengetahui_id');
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'mengetahui_nama',
                                'sourceUrl' => $this->createUrl('autocompletePegawaiMengetahui'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.nama_pegawai);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.nama_pegawai);
                                        $("#' . CHtml::activeId($model, 'pengetahui_id') . '").val(ui.item.pegawai_id);
                                        return false;
                                    }'
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder' => 'Pegawai Mengetahui',
                                    'class' => 'span3',
                                    'style' => 'width:150px;',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php $this->endWidget(); ?>
            <div class="form-actions">
                <?php
                $sukses = isset($_GET['sukses']) ? true : false;
                $disableSave = false;
                $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
                ?>
                <?php $disablePrint = ($disableSave) ? false : true; ?>
                <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => $sukses)); //formSubmit(this,event)        
                ?>
                <?php //if(!isset($_GET['frame'])){
                //echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                //$this->createUrl($this->id.'/update&id='.$model->spirometri_id), 
                // array('class' => 'btn btn-default',
                //   'onclick'=>'return refreshForm(this);'));
                //} 
                ?>
                <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-primary', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>

            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
// Dialog buat nambah data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pegawai Mengatahui',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'minHeight' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV();

$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}

$prop = $modPegawai->search();
$prop->criteria->order = 'nama_pegawai';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sapegawai-m-grid',
    'dataProvider' => $prop,
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => '',
            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                "onClick"=>"
                $(\"#' . CHtml::activeId($model, 'pengetahui_id') . '\").val(\"$data->pegawai_id\");
                $(\"#' . CHtml::activeId($model, 'mengetahui_nama') . '\").val(\"$data->nama_pegawai\");
                $(\"#dialogPegawaiMengetahui\").dialog(\"close\");  return false;  
                "
            ))',
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList(
                $modPegawai,
                'jabatan_id',
                JabatanM::model()->jabatanList(),
                array('empty' => '-- Pilih --')
            ),
            'value' => function ($data) {
                if (empty($data->jabatan_id)) {
                    return "";
                }

                $jabatan = JabatanM::model()->findByPk($data->jabatan_id);
                if (empty($jabatan)) {
                    return "-";
                }

                return $jabatan->jabatan_nama;
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>

<?php $this->endWidget(); ?>
<?php
echo $this->renderPartial($this->path_view . '_jsFunctions', array(
    'form' => $form,
    'model' => $model,
), true);
?>