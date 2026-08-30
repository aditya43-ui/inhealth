<?php
$this->breadcrumbs = array(
    'Rujukan Keluar',
);
$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
//
//echo '<legend class="rim">RUJUKAN KE LUAR</legend><hr>';
//$this->renderPartial('/_tabulasi',array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi));

?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpasien-dirujuk-keluar-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($modRujukanKeluar, 'nosuratrujukan'),
)); ?>

<?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'form-riwayat',
    'content' => array(
        'content-detailpasien' => array(
            'header' => '<b>Riwayat Rujukan Keluar</b>',
            'isi' => $this->renderPartial('_listRujukanKeluar', array(
                'form' => $form,
                'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar
            ), true),
            'active' => true,
        ),
    ),
)); ?>
<div class="row">
    <div class="span12">
        <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'buttons' => array(
                array('label' => 'Print', 'icon' => 'entypo-print', 'url' => '#', 'htmlOptions' => array('onclick' => 'print(\'PRINT\')')),
                array('label' => '', 'items' => array(
                    array('label' => 'PDF', 'icon' => 'icon-book', 'url' => '', 'itemOptions' => array('onclick' => 'print(\'PDF\')')),
                    array('label' => 'Excel', 'icon' => 'icon-pdf', 'url' => '', 'itemOptions' => array('onclick' => 'print(\'EXCEL\')')),

                )),
            ),
            'htmlOptions' => array('style' => 'float:right')
            //        'htmlOptions'=>array('class'=>'btn')
        )); ?>
    </div>
</div>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($modRujukanKeluar); ?>

<table class="items">
    <tr>
        <td width="50%">
            <?php //echo $form->textFieldRow($modRujukanKeluar,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php //echo $form->textFieldRow($modRujukanKeluar,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <div class="control-group">
                <?php echo $form->labelEx($modRujukanKeluar, 'tgldirujuk', array('class' => 'control-label')) ?>
                <?php $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modRujukanKeluar,
                        'attribute' => 'tgldirujuk',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true),
                    )); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($modRujukanKeluar, 'tglberlakusurat', array('class' => 'control-label')) ?>
                <?php $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRujukanKeluar->tglberlakusurat, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $modRujukanKeluar,
                        'attribute' => 'tglberlakusurat',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true),
                    )); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow(
                $modRujukanKeluar,
                'pegawai_id',
                CHtml::listData($modRujukanKeluar->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
            ); ?>
            <?php //echo $form->textFieldRow($modRujukanKeluar,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php echo $form->dropDownListRow(
                $modRujukanKeluar,
                'rujukankeluar_id',
                CHtml::listData($modRujukanKeluar->getRujukanItems(), 'rujukankeluar_id', 'rumahsakitrujukan'),
                array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
            ); ?>
            <?php // echo $form->dropDownListRow($modRujukanKeluar, 'dirujukkebagian', LookupM::getItems('dirujukkebagian'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
            ?>
            <?php echo $form->textFieldRow($modRujukanKeluar, 'dirujukkebagian', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
            <?php echo $form->textFieldRow($modRujukanKeluar, 'nosuratrujukan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'disabled' => true)); ?>
            <?php //echo $form->textFieldRow($modRujukanKeluar,'tgldirujuk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php echo $form->textFieldRow($modRujukanKeluar, 'kepadayth', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php // echo $form->textFieldRow($modRujukanKeluar,'dirujukkebagian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); 
            ?>
            <?php //echo $form->dropDownListRow($modRujukanKeluar,'ruanganasal_id', CHtml::listData($modRujukanKeluar->getRuanganInstalasiItems($modPendaftaran->instalasi_id), 'ruangan_id', 'ruangan_nama'),
            //array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php echo $form->textAreaRow($modRujukanKeluar, 'catatandokterperujuk', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($modRujukanKeluar, 'alasandirujuk', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </td>
        <td width="50%">
            <?php echo $form->textAreaRow($modRujukanKeluar, 'hasilpemeriksaan_ruj', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($modRujukanKeluar, 'diagnosasementara_ruj', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($modRujukanKeluar, 'pengobatan_ruj', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($modRujukanKeluar, 'lainlain_ruj', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php if (isset($_GET['pasiendirujukkeluar_id'])) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true)
        );
    } else {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
        );
    } ?>

    <?php $content = $this->renderPartial('../tips/tips', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content)); ?>
</div>
<?php
$urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);
$urlPrintRujukan =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRujukan&id=' . $modPendaftaran->pendaftaran_id);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printRujukan(caraPrint,rujukankeluar_id)
{
    window.open("${urlPrintRujukan}&rujukankeluar_id="+rujukankeluar_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailrujukan',
    'options' => array(
        'title' => 'Detail Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
        'position' => 'top',
    ),
));

echo '<div id="contentDetailRujukan"> </div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
    function viewDetailRujukan(idPasienDirujuk) {
        $.post('<?php echo $this->createUrl('ajaxDetailRujukanKeluar') ?>', {
            idPasienDirujuk: idPasienDirujuk
        }, function(data) {
            $('#contentDetailRujukan').html(data.result);
        }, 'json');
        $('#dialogDetailrujukan').dialog('open');
    }

    function hapusRujukan(obj, id) {
        var tabel = obj;
        myConfirm('Apakah Anda akan menghapus rujukan keluar ini?', 'Perhatian!', function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('hapusRujukKeluar'); ?>',
                    data: {
                        rujukankeluar_id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.sukses == 1) {
                            var delete_row = $(tabel).parents('tr');
                            delete_row.detach();
                        }
                        myAlert(data.pesan);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });

            }
        });
    }

    $(document).ready(function() {
        // Notifikasi Pasien
        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                simpanNotifikasi(params);
        <?php
            }
        }
        ?>
    });
</script>