<?php
$this->breadcrumbs = array(
    'Mcu',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pemeriksaan Treadmill berhasil ubah");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'treadmillubah-mcu-form',
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
            <i class="far fa-edit"></i> Ubah <b>Treadmill</b>
        </div>
        <div style="float:right; margin-bottom:5px">
            <?php echo CHtml::link('<i class="entypo-back" style="color: black;"></i> Kembali', '#', array('class' => '', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: black;')) ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-body">

            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'duration_treadmill', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList(
                        $modTreadmill,
                        'duration_treadmill',
                        CHtml::listData(KlasifikasifitnesM::model()->findAll(), 'klasifikasifitnes_id', 'lama_menit'),
                        array('style' => 'width:160px;', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")
                    ); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'blood_preasure', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('CMaskedTextField', array(
                        'model' => $modTreadmill,
                        'attribute' => 'td_systolic',
                        'mask' => '999',
                        'placeholder' => '0',
                        'htmlOptions' => array('class' => 'span1 numbers-only systolic', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onkeyup' => 'returnValue(this); getText();', 'onblur' => 'setRange(this);') // change(this); getTekananDarah(this) change(this);getText();
                    ));
                    ?> /
                    <?php
                    $this->widget('CMaskedTextField', array(
                        'model' => $modTreadmill,
                        'attribute' => 'td_diastolic',
                        'mask' => '999',
                        'placeholder' => '0',
                        'htmlOptions' => array('class' => 'span1 numbers-only diastolic', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onkeyup' => 'returnValue(this); getText();') //getTekananDarah(this); ,'onkeyup'=>'getText();'
                    ));
                    ?> mmHg
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->LabelEx($modTreadmill, 'heart_rate', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modTreadmill, 'heart_rate', array('class' => 'span1 numbersOnly systolic', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'returnValue(this)')); ?>
                    <?php echo CHtml::htmlButton(
                        '<i class="icon-plus icon-white"></i>',
                        array(
                            'onclick' => 'tambahTreadmill();return false;',
                            'class' => 'btn btn-danger',
                            'onkeypress' => "tambahTreadmill();return false;",
                            'rel' => "tooltip",
                            'title' => "Klik untuk menambahkan Treadmill",
                            'disabled' => false,
                        )
                    );
                    ?>
                </div>
            </div>

            <table style="width: 100%; border: none;">
                <tr>
                    <td width="100%">
                        <table id="form-treadmilldetail-mcu" class="table table-bordered table-condensed">

                            <thead>
                                <tr>
                                    <th>Duration</th>
                                    <th>Blood Preasure</th>
                                    <th>Heart Rate</th>
                                    <th>Work Load</th>
                                    <th>Est. 02 Rate</th>
                                    <th>Max. 02 Intake</th>
                                    <th>Mets</th>
                                    <th>Fitness Clasification</th>
                                    <th>Walking</th>
                                    <th>Jogging</th>
                                    <th>Bicycling</th>
                                    <th>Other Sport</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php //echo $form->textField($modTreadmill,'duration_treadmill',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                                        ?>
                                        <?php echo $form->textField($modTreadmillDetail, 'duration_treadmill', array('readonly' => false, 'class' => 'span1')); ?>
                                    </td>
                                    <td><?php echo $form->textField($modTreadmillDetail, 'td_systolic', array('readonly' => false, 'class' => 'span1 integer')); ?> /
                                        <?php echo $form->textField($modTreadmillDetail, 'td_diastolic', array('readonly' => false, 'class' => 'span1 integer')); ?> mmHg</td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'heartrate_treadmill', array('readonly' => false, 'class' => 'span1 integer')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'workload_kph', array('readonly' => false, 'class' => 'span1 integer')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'est02_rate_min', array('readonly' => false, 'class' => 'span1 integer')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'max02_intake', array('readonly' => false, 'class' => 'span1 integer')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'mets_treadmill', array('readonly' => false, 'class' => 'span1 integer')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'fitnessclassification', array('readonly' => false, 'class' => 'span2')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'walking_kmhr_treadmill', array('readonly' => false, 'class' => 'span2')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'jogging_kmhr_treadmill', array('readonly' => false, 'class' => 'span2')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textField($modTreadmillDetail, 'bicycling_kmhr_treadmill', array('readonly' => false, 'class' => 'span2')); ?>
                                    </td>
                                    <td>
                                        <?php echo $form->textArea($modTreadmillDetail, 'sports_kmhr_treadmill', array('readonly' => false, 'class' => 'span2')); ?>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </td>
                </tr>
            </table>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'resttime_menit', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modTreadmill, 'resttime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'worktime_menit', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modTreadmill, 'worktime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'recoverytime_menit', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modTreadmill, 'recoverytime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'totaltime_menit', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modTreadmill, 'totaltime_menit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?> min
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'interpretation_tradmill', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modTreadmill, 'interpretation_tradmill', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'namapemeriksa_treadmill', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete', array(
                            'model' => $modTreadmill,
                            'attribute' => 'namapemeriksa_treadmill',
                            'value' => '',
                            'sourceUrl' => $this->createUrl('AutocompletePemeriksa'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.nama_pegawai);
                                    return false;
                            }',
                            ),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->LabelEx($modTreadmill, 'hasiltreadmill', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->radioButtonListInlineRow($modTreadmill, 'hasiltreadmill', array('Normal' => 'Normal', 'Ada Kelainan' => 'Ada Kelainan'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php //$this->endWidget(); 
        ?>
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
            <?php if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/update&id=' . $modTreadmill->treadmill_id),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            } ?>
        </div>
    </div>
</div>
</div>
<?php $this->endWidget(); ?>

<?php
// =====================Dialog buat nambah data pegawai =========================
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
                $(\"#' . CHtml::activeId($modTreadmill, 'pengetahui_id') . '\").val(\"$data->pegawai_id\");
                $(\"#' . CHtml::activeId($modTreadmill, 'mengetahui_nama') . '\").val(\"$data->nama_pegawai\");
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
    'modTreadmill' => $modTreadmill,
), true);
?>