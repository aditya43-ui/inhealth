<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bedahanastesilokal-postop-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienmasukpenunjang_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php // echo $form->hiddenField($model,'rencanaoperasi_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>

<div class="control-group">
    <?php echo $form->labelEx($model, 'pendarahan_jml', array('class' => 'control-label', 'label' => 'Pendarahan')); ?>
    <div class="controls">
        <?php echo $form->textField($model, 'perdarahan_jml', array('class' => 'span2 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <label>cc</label>
    </div>
</div>
<br>
<div class="panel panel-dark">
    <span class="group-title">
        Pemeriksaan Fisik Post Operasi
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'td_systolic', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'td_systolic', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                        <label>/</label>
                        <?php echo $form->textField($model, 'td_dyastolic', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                        <label>mmHg</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'hb_nilai', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'hb_nilai', array('class' => 'span1 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <label>mg/dl</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'suhubadan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'suhubadan', array('class' => 'span1 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <label>&deg;C</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'respirationrate', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'respirationrate', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'style' => 'text-align: right;')); ?>
                        <label>x/menit</label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'ht_nilai', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'ht_nilai', array('class' => 'span1 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <label></label>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'beratbadan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'beratbadan', array('class' => 'span1 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <label>Kg</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$crPeriksa = new CDbCriteria;
$crPeriksa->join = 'join jenispemeriksaanlab_m j on j.jenispemeriksaanlab_id = t.jenispemeriksaanlab_id';
$crPeriksa->addCondition("j.jenispemeriksaanlab_kelompok = 'PATOLOGI ANATOMI'");
$crPeriksa->order = 'pemeriksaanlab_nama';
$periksa = PemeriksaanlabM::model()->findAll($crPeriksa);
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Spesimen yang Diambil</div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Jenis Spesimen Jaringan</th>
                    <th>Diperoleh dari Hasil</th>
                    <th>Lokasi Mengembalian</th>
                    <th>Volume</th>
                    <th>Dikirim untuk Pemeriksaan PA</th>
                    <th>Permintaan Pemeriksaan PA</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($spesimen as $item) : ?>
                    <tr>
                        <td><?php

                            $jenis = JenisspesimenPaM::model()->findByPk($item->jenisspesimen_pa_id);

                            echo empty($jenis) ? "-" : $jenis->jenisspesimen_pa_nama;

                            /// var_dump($item->attributes); die;
                            ?></td>
                        <td><?php
                            $teknik = TeknikpengambilanspesimenM::model()->findByPk($item->teknikpengambilanspesimen_id);
                            echo empty($teknik) ? "-" : $teknik->teknikpengambilanspesimen_nama;
                            ?>

                        </td>
                        <td><?php echo $item->lokasipengambilanspesimen; ?></td>
                        <td><?php echo $form->textField($item, '[' . $item->spesimenhasiloperasi_id . ']volumespesimen', array(
                                'class' => 'span2'
                            )); ?></td>
                        <td class="radio_main">
                            <?php echo $form->radioButtonList($item, '[' . $item->spesimenhasiloperasi_id . ']statuskirim_pa', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array(
                                'class' => 'statuskirim_pa'
                            )); ?>
                            <?php echo $form->textField($item, '[' . $item->spesimenhasiloperasi_id . ']tujuanpengirimanspesimen_lainnya', array(
                                'class' => 'span3 tujuanpengirimanspesimen_lainnya',
                            )); ?>
                        </td>
                        <td>
                            <?php

                            $det = SpesimenhasiloperasidetT::model()->findAllByAttributes(array(
                                'spesimenhasiloperasi_id' => $item->spesimenhasiloperasi_id,
                            ));

                            $det_res = array();

                            foreach ($det as $det_item) {
                                $det_res[] = $det_item->pemeriksaanlab_id;
                            }
                            $item->permintaanPeriksa = $det_res;

                            echo $form->checkBoxList($item, '[' . $item->spesimenhasiloperasi_id . ']permintaanPeriksa', CHtml::listData($periksa, 'pemeriksaanlab_id', 'pemeriksaanlab_nama'), array());

                            ?>
                        </td>
                        <td>
                            <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
                                'onclick' => 'hapusItemSpesimen(' . $item->spesimenhasiloperasi_id . ', this); return false',
                            )); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create', array('pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id)),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php // echo CHtml::link(Yii::t('mds','{icon} Pengaturan BedahanastesilokalPostopT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>

<script>
    function ceklisPeriksaPA() {
        $(".radio_main").each(function() {
            var ceklis = $(this).find(".statuskirim_pa:checked").val();

            if (ceklis == "Tidak") {
                $(this).find(".tujuanpengirimanspesimen_lainnya").attr("readonly", false);
            } else {
                $(this).find(".tujuanpengirimanspesimen_lainnya").attr("readonly", true).val("");
            }
        });
    }

    function hapusItemSpesimen(id, obj) {
        myConfirm("Anda yakin untuk menghapus spesimen ini?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusSpesimen'); ?>', {
                    id: id
                }, function(data) {
                    if (data.ok == 1) {
                        $(obj).parents("tr").remove();
                        myAlert(data.msg);
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }

    $(document).ready(function() {
        $(".statuskirim_pa").on('click', ceklisPeriksaPA);
        ceklisPeriksaPA();
    });
</script>