<style>
th {
    background-color: #ececec;
}

.input-append .hasDatepicker {
    border-radius: 5px;
}

.btn-info {
    background-color: #76A2BE;
    border-color: #76A2BE;
}

.btn-info:hover {
    background-color: #678DA6;
    border-color: #678DA6;
}

</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'buatjadwal-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#lamaterapi',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        )); ?>

<table style="width: 100%;" class="table table-bordered">
    <tr>
        <th style="width: 7%;">No.</th>
        <th style="width: 25%;">Nama Jenis</th>
        <th style="width: 35%;">Jenis Pemeriksaan</th>
        <th style="width: 30%;">Tanggal Jadwal</th>
        <th></th>
    </tr>
    <?php
        if(!empty($permintaan)) {
            foreach($permintaan as $i => $per) {
                echo "<tr>";
                    echo "<td>" . ($i + 1) . ". </td>";
                    echo "<td>" . "Ruang Tindakan". "</td>";
                    echo "<td>" . $per->tindakanrm->tindakanrm_nama . "</td>";
                    echo "<td>";

                    echo CHtml::activeHiddenField($per, '[' . $i . ']permintaankepenunjang_id', array('readonly'=>true, 'class' => 'permintaan_id'));
                    
                    $per->tglpermintaankepenunjang = MyFormatter::formatDateTimeForUser($per->tglpermintaankepenunjang);

                        $this->widget('MyDateTimePicker',array(
                            'model' => $per,
                            'attribute' => "[$i]tglpermintaankepenunjang",
                            'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('disabled'=>true,'class'=>'span3 tglpermintaan'),
                         ));
                    echo "</td>";
                    echo "<td valign='middle'>" . CHtml::checkBox('cek_masuk[' . $i . ']', false, array('class'=>"cek-penunjang", 'style' => 'vertical-align: middle;')) . "</td>";

                echo "</tr>";
            }
        }
    ?>
</table>
<br>
<div class="row row-fluid">
    <div class="col-sm-8">
        <table style="width: 100%;">
            <tr>
                <td nowrap>Tanggal Pemeriksaan&emsp;</td>
                <td>
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'tglpermintaanpenunjang_lama',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'disabled' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'tglpermintaanpenunjang_lama', 'class' => 'span4'
                        ),
                    ));
                ?>
                </td>
            </tr>
            <tr>
                <td nowrap>Tanggal Jadwal Pemeriksaan&emsp;</td>
                <td>
                <?php echo CHtml::hiddenField('permintaankepenunjang_id', ''); ?>
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'tglpermintaanpenunjang_baru',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'tglpermintaankepenunjang', 'class' => 'span4'
                        ),
                    ));
                ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-sm-4" style="vertical-align: bottom; margin-top: 20px;">
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(
                Yii::t('mds', 'Simpan Jadwal', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-info submit', 'title' => 'Simpan', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);')
            );
        ?>
</div>
    </div>
</div>






<?php $this->endWidget(); ?>

<script>

$('.add-on').addClass('hide');

$('.cek-penunjang').change(function () {

    $('.cek-penunjang').prop('checked', false);
    $(this).prop('checked', true);

    var tgl = $(this).closest('tr').find('.tglpermintaan').val();
    var id = $(this).closest('tr').find('.permintaan_id').val();

    $('#tglpermintaanpenunjang_lama').val(tgl);
    $('#permintaankepenunjang_id').val(id);

});
</script>