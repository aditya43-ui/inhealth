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
        )); 


?>
<?= Chtml::hiddenField('pasienmasukpenunjang_id', $modPenunjang->pasienmasukpenunjang_id ?? '') ?>
<div style="height: 200px; overflow-y: scroll;">
    <table style="width: 100%;" class="table table-bordered">
        <tr>
            <th style="width: 7%;">No.</th> 
            <th style="width: 35%;">Kunjungan ke</th>
            <th style="width: 30%;">Tanggal Kunjungan</th>
        </tr>
    
        <?php 
            if(count($modRiwayatKunjunganRehab) > 0) {
                foreach ($modRiwayatKunjunganRehab as $key => $value) {
                   
                
        ?>
        <tr>
            <td><?= $key+1 ?></td>
            <td><?= $value->kunjunganrehabke ?></td>
            <td><?= $value->tgl_kunjunganrehab ?></td>
        </tr>
        <?php   }
            }
            if(count($modRiwayatKunjunganRehab) < 7) {
                for($i = count($modRiwayatKunjunganRehab) + 1; $i <= 7; $i++ ) {
        ?>
            <tr>
                <td><?= $i ?></td>
                <td></td>
                <td></td>
            </tr>
        <?php
                }
            } 
        ?>
    </table>
</div>
<br>
<div class="row row-fluid">
    <div class="col-sm-8">
        <table style="width: 100%;">
            <tr>
                <td nowrap>Kunjungan Ke&emsp;</td>
                <td>
                <?php
                    if(!empty($modPenunjang)) {
                        $modPenunjang->kunjunganrehabke += 1;
                    }
                    echo $form->textField($modPenunjang, 'kunjunganrehabke', ['class' => 'numbers-only'])
                ?>
                </td>
            </tr>
            <tr>
                <td nowrap>Tanggal Kunjungan&emsp;</td>
                <td>
           
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'tglkunjunganrehab',
                        'value' => date('Y-m-d'),
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'tgl_jadwalpemeriksaan', 'class' => 'span4'
                        ),
                    ));
                ?>
                </td>
            </tr>
            <tr>
                <td>Kunjungan Terakhir</td>
                <td>
                    <?= $form->checkBox($modPenunjang, 'is_terakhirkunjungan') ?>
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


</script>