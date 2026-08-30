<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pencarianobat-form',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($modObat, 'jenisstokopname'),
        'htmlOptions' => array(),
    ));
    ?>
    <div class="row-fluid">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Jenis Stock Opname', 'jenisstokopname', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    if (empty($model->formuliropname_id)) {
                        echo $form->dropDownList($modObat, 'jenisstokopname', LookupM::getItems('jenisstokopname'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onchange' => 'setJenisStokOpname();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
                    } else {
                        echo $form->textField($modObat, 'jenisstokopname', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
                    }
                    ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($modObat, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true ORDER BY jenisobatalkes_nama ASC'), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($modObat, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($modObat, 'obatalkes_kode', array('placeholder' => 'Ketik Kode Obat Alkes', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($modObat, 'obatalkes_nama', array('placeholder' => 'Ketik Nama Obat Alkes', 'class' => 'span3', 'maxlength' => 200, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($modObat, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Tampilkan', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'return cekJenisOp();')); ?>
        <?php // echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-default', 'type'=>'reset')); 
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    function cekJenisOp() {
        var jenis = $("#GFInformasistokobatalkesV_jenisstokopname option:selected").val();
        if (jenis == '') {
            myAlert("Maaf, <b>Jenis Stock Opname</b> belum dipilih", "Perhatian");
            return false;
        }
    }
</script>