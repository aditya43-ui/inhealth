<legend class="rim">Pencarian</legend>
<div class="search-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'pesanambulans-t-search',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($modPemesanan, 'pesanambulans_no'),
    )); ?>
    <table>
        <tr>
            <td>
                <?php //echo $form->textFieldRow($modPemesanan,'tglpemesananambulans',array('class'=>'span3')); 
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Pemesanan', 'tgl_pemesanan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $modPemesanan->tgl_awal = $format->formatDateTimeForUser($modPemesanan->tgl_awal); ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPemesanan,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5'),
                        ));
                        ?>
                        <?php $modPemesanan->tgl_awal = $format->formatDateTimeForDb($modPemesanan->tgl_awal); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                        Sampai dengan
                  </label>
                    <div class="controls">
                        <?php $modPemesanan->tgl_akhir = $format->formatDateTimeForUser($modPemesanan->tgl_akhir); ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPemesanan,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5'),
                        ));
                        ?>
                        <?php $modPemesanan->tgl_akhir = $format->formatDateTimeForDb($modPemesanan->tgl_akhir); ?>
                    </div>
                </div>
                <div class="control-group"><label for="namaPasien" class="control-label">
                        No. Pesan Ambulans</label>
                    <div class="controls">
                        <?php echo $form->textField($modPemesanan, 'pesanambulans_no', array('placeholder' => 'No. Pesan Ambulans', 'class' => 'span3', 'maxlength' => 20)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group"><label for="namaPasien" class="control-label">
                        No. Rekam medis</label>
                    <div class="controls">
                        <?php echo $form->textField($modPemesanan, 'norekammedis', array('placeholder' => 'No. Rekam Medik', 'class' => 'span3', 'maxlength' => 10)); ?></div>
                </div>
                <div class="control-group"><label for="namaPasien" class="control-label">
                        Nama Pasien</label>
                    <div class="controls">
                        <?php echo $form->textField($modPemesanan, 'namapasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3', 'maxlength' => 100)); ?></div>
                </div>
                <div class="control-group"><label for="namaPasien" class="control-label">
                        Nama ruang</label>
                    <div class="controls">
                        <?php echo $form->textField($modPemesanan, 'ruangan_nama', array('placeholder' => 'Nama Ruangan', 'class' => 'span3')); ?></div>
                </div>
            </td>
        </tr>
    </table>


    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
        <?php
        $content = $this->renderPartial('../tips/informasi_ambulans', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

        ?>
    </div>

    <?php $this->endWidget(); ?>

</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintInformasiPemesanan');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#pesanambulans-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}   
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

?>