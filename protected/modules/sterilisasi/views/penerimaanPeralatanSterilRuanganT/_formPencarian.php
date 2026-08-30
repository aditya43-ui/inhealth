<?php
$hiddent = '';
$readOnly = false;
if (isset($_GET['kirimperlinensteril_id'])) {
    $hiddent = 'hidden';
    $readOnly = true;
}
?>
<div class="row">
    <div class="col-sm-6 <?php echo $hiddent; ?>">
        <div class="control-group">
            <label class='control-label'>Tanggal Pengajuan</label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modCari,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Sampai Dengan</label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modCari,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3'),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow(
            $modCari,
            'kirimperlinensteril_no',
            array('readonly' => $readOnly, 'class' => 'span4', 'placeholder' => 'No. Pengiriman', 'maxlength' => 20)
        ); ?>
    </div>

</div>
<div class="form-actions <?php echo $hiddent; ?>">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'id' => 'pencarian', 'onclick' => 'cekNoPengiriman()', 'onkeypress' => 'cekNoPengiriman()')
    );
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
        'class' => 'btn btn-default',
        'title' => 'Ulang',
        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'
    ));
    ?>
</div>