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
        ////'pegawai_id',
        //                array( 
        //                        'name'=>'pegawai_id', 
        //                        'value'=>'$data->pegawai_id', 
        //                        'filter'=>false, 
        //                ),
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
        // 'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>

<?php $this->endWidget(); ?>