<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'agunitkerja-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return cekRuangan()'),
    'focus' => '#' . CHtml::activeId($model, 'kodeunitkerja'),
));

$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kodeunitkerja', array('placeholder' => 'Kode', 'class' => 'span3 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo CHtml::label("Divisi", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'divisi', LookupM::getItems('divisiunitkerja'), array('empty' => 'Pilih', 'class'=>'span3')) ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'namaunitkerja', array('placeholder' => 'Nama Unit', 'class' => 'span3 hurufs-only', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->dropDownListRow($model, 'nama_instalasi', CHtml::listData(InstalasiM::model()->findAllByAttributes(array('instalasi_aktif' => true), array('order' => 'instalasi_nama ASC')), 'instalasi_id', 'instalasi_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'updateNamaRuangan()')); ?>
        <?php echo $form->error($model, 'nama_instalasi'); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <div id="dropruangan" class="controls">
                <?php
                if ($model->isNewRecord) {
                    $this->widget(
                        'application.extensions.emultiselect.EMultiSelect',
                        array('sortable' => true, 'searchable' => true)
                    );
                    echo CHtml::dropDownList(
                        'ruangan_id[]',
                        '',
                        CHtml::listData(SARuanganM::model()->findAll('ruangan_aktif= true ORDER BY ruangan_nama'), 'ruangan_id', 'ruangan_nama'),
                        array('multiple' => 'multiple', 'id' => 'ruangan_id', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                    );
                } else {
                    $arrUnitRuangan = array();
                    foreach ($modRuanganUnit as $dataUnitRuangan) {
                        $arrUnitRuangan[] = $dataUnitRuangan['ruangan_id'];
                    }
                    $this->widget(
                        'application.extensions.emultiselect.EMultiSelect',
                        array('sortable' => true, 'searchable' => true)
                    );
                    echo CHtml::dropDownList(
                        'ruangan_id[]',
                        $arrUnitRuangan,
                        CHtml::listData(SARuanganM::model()->findAll('ruangan_aktif= true ORDER BY ruangan_nama'), 'ruangan_id', 'ruangan_nama'),
                        array('multiple' => 'multiple', 'id' => 'ruangan_id', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                    );
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Unit Kerja', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/add1', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<script>
    function updateNamaRuangan() {
        var instalasi_id = $("#<?php echo CHtml::activeId($model, 'nama_instalasi') ?>").val();
        $('#dropruangan').addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetRuangan'); ?>',
            data: {
                instalasi_id: instalasi_id
            },
            dataType: "json",
            success: function(data) {
                $('#dropruangan .multiselect').html(data.list);
                $('#dropruangan ul.available').html(data.available);
                $(".multiselect").multiselect("destroy");
                $('#dropruangan').removeClass("animation-loading");
                $(".multiselect").multiselect({
                    sortable: true,
                    searchable: true
                });
            }
        });
    }

    function cekRuangan() {
        if ($(".selected").find("li").length < 2) {
            myAlert("Maaf, <b>Ruangan</b> belum dipilih", "Perhatian!");
            return false;
        } else {
            return requiredCheck("#agunitkerja-m-form");
        }

    }

    function namaLain(nama) {
        document.getElementById('SAUnitkerjaM_namalain').value = nama.value.toUpperCase();
    }
</script>