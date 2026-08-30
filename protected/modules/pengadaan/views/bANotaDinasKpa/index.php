<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'notadinas-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div class="panel-group joined" id="accordion-uji">
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #a6db9c"> 
                <a data-toggle="collapse" data-parent="#accordion-uji" href="#riwayat" aria-expanded="true" class="">
                    Riwayat Berita Acara Nota Dinas KPA
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff; overflow: auto; max-height: 300px;">
                <?php echo $this->renderPartial('_riwayat', array('model' => $model, 'form' => $form), true); ?>
            </div> 
        </div> 
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><span class='judul'>Nota Dinas KPA</span></div>
    </div>
    <div class="panel-body" style="height: 200px !important">
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'notadinaskpa_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'nomor_notadinas', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor Nota Dinas')); ?>
                <?php echo $form->dropDownListRow($model, 'notadinaskpa_kepada', LookupM::getItems('tujuannotadinaskpa'), array('empty' => '-- Pilih --', 'class' => 'span4',));
                ?>
            </div>
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'notadinaskpa_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'notadinaskpa_tanggal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($model, 'notadinaskpa_tanggal'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'termin_ke', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'termin_ke', array('class' => 'span1', 'readonly' => true)); ?>
                    </div>
                    <label class="control-label" style="width: 35px !important">Dari</label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'total_termin', array('class' => 'span1', 'readonly' => true)); ?>
                    </div>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'terminke', array('class' => 'span1', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($model, 'termin_persen', array('class' => 'span1', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pegkpa_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pegkpa_nama', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php
        $cekNotaDinasKPA = ADNotadinaskpaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
        $jumlahpemeriksaan = count($cekNotaDinasKPA) + 1;

        $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
        $jumlahTermin = count($cekTermin);

        if ($modSPK->istermin == true) {
            if ($jumlahpemeriksaan > $jumlahTermin && empty($_GET['notadinaskpa_id'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                echo "&nbsp;";
            } else {
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                    echo "&nbsp;";
                }
            }
        } else {
            if ($jumlahpemeriksaan > 1 && empty($_GET['notadinaskpa_id'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                echo "&nbsp;";
            } else {
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                    echo "&nbsp;";
                }
            }
        }

        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id)), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
        echo "&nbsp;";
        ?>
    </div>
</div>

<?php
$this->endWidget();

$urlGetRiwayat = $this->createUrl('GetRiwayat');
$suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
?>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayat',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Nota Dinas KPA',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 320,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframe1" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
<script>
    function cekRiwayat(obj) {
        var suratperjanjiankerja_id = <?php echo $suratperjanjiankerja_id ?>;
        if (suratperjanjiankerja_id !== "") {
            $.post("<?php echo $urlGetRiwayat ?>", {suratperjanjiankerja_id: suratperjanjiankerja_id, },
                    function (data) {
                        $("#tableRiwayat").children("tbody").append(data.tr);
                    }, "json");
        } else {
            myAlert("Silahkan pilih data Surat Perjanjian Kerja !");
        }
        return false;

    }

    $(document).ready(function () {
        cekRiwayat();
<?php if (isset($_GET['sukses'])) { ?>
            $('input').attr('readonly', true);
            $('.add-on').hide();
<?php } ?>
    });
</script>