<?php
$this->breadcrumbs = array(
    'Tindakan',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjtindakan-pelayanan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-briefcase-medical"></i> Pemeriksaan Tindakan
        </div>
    </div>
    <div class="panel-body">

        <div class="formInputTab">
            <?php
            if (!empty($modViewTindakans)) {
                $this->renderPartial($this->path_view.'_listTindakanPasien', array(
                    'modTindakans' => $modViewTindakans,
                    'modViewBmhp' => $modViewBmhp,
                    'removeButton' => true
                ));
            }
            ?>
            <p class="help-block"><?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>


            <?php
            echo CHtml::hiddenField('tipepaket_id', '', array());
            echo CHtml::hiddenField('kelaspelayanan_id', $modAdmisi->kelaspelayanan_id, array());
            echo CHtml::hiddenField('penjamin_id', $modAdmisi->penjamin_id, array());
            echo CHtml::hiddenField('deposit', $modDeposit, array());
            ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Tindakan</b>
                    </div>
                    <div class="panel-options">
                    <?php
                    echo $form->dropDownList(
                        $modTindakan,
                        '[0]tipepaket_id',
                        Chtml::listData($modTindakan->getTipePaketItems($modAdmisi->carabayar_id, $modAdmisi->penjamin_id), 'tipepaket_id', 'tipepaket_nama'),
                        // array('style' => 'display: none'),	
                        array(
                            'class' => 'span3',
                            'style' => 'margin-top: 5px;',
                            'onkeypress' => "return $(this).focusNextInputField(event);",
                            'onchange' => 'loadTindakanPaket(this.value,"' . $modAdmisi->kelaspelayanan_id . '","' . $modPendaftaran->kelompokumur_id . '", '.$modPendaftaran->pendaftaran_id.')'
                        )
                    );

                    ?>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="items table table-striped table-bordered table-condensed" id="tblInputTindakan">
                        <thead>
                            <tr>
                                <th rowspan="2">&nbsp;</th>
                                <th>Kategori Tindakan</th>
                                <th rowspan="2">Uraian Tindakan</th>
                                <!--<th rowspan="2">Tarif Satuan</th>-->
                                <th rowspan="2">Jumlah</th>
                                <!--<th rowspan="2">Tarif Satuan</th>-->
                                <!--<th rowspan="2">Jumlah Tindakan</th>-->
                                <th rowspan="2">Satuan Tindakan</th>
                                <th rowspan="2">Cyto </th>
                                <th rowspan="2">Tarif Satuan</th>
                                <th rowspan="2">Total Tarif</th>
                            </tr>
                            <tr>
                                <th>Tanggal Tindakan</th>
                            </tr>
                        </thead>
                        <?php
                        $trTindakan = $this->renderPartial($this->path_view.'_rowTindakanPasien', array('modTindakan' => $modTindakan, 'modTindakans' => $modTindakans), true);
                        echo $trTindakan;
                        ?>
                    </table>
                    <div <?php echo Params::HIDDEN_HARGA ?>>
                        <b>Total Nominal Tarif : </b>
                        <?php echo CHtml::textField("totalTarif", 0, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal')); ?>
                    </div>
                </div>
            </div>

            <hr>
            <?php echo $form->errorSummary($modTindakan); ?>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Alat Medis</b>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <?php $this->renderPartial($this->path_view.'_formPemakaianBahan', array()); ?>
                </div>
            </div>

            <?php /*
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Paket BMHP</b></div>
            </div>
            <div class="panel-body table-responsive">
                    <?php $this->renderPartial($this->path_view.'_formPaketBmhp',array('modViewBmhp'=>$modViewBmhp, 'modTindakan'=>$modTindakan)); ?>
               </div>
        </div>
             * 
             */ ?>

        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'type' => 'button', 'onKeypress' => 'cekInput();', 'onClick' => 'cekInput();')
            ); ?>
            <?php
            echo CHtml::link(
                Yii::t(
                    'mds',
                    '{icon} Print',
                    array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')
                ),
                'javascript:void(0);',
                array(
                    'class' => 'btn btn-info',
                    'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ");return false"
                )
            );
            ?>
            <?php
            echo CHtml::link(
                Yii::t(
                    'mds',
                    '{icon} Edukasi Transfusi',
                    array('{icon}' => '<i class="' . MyIcon::getIcons('approve') . '"></i>')
                ),
                'javascript:void(0);',
                array(
                    'class' => 'btn btn-primary',
                    'onclick' => "$('#dialog-edukasi-transfusi').dialog('open');return false"
                )
            );
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_dialogPemeriksa', array('modTindakan' => $modTindakan)); ?>
<?php $this->renderPartial($this->path_view.'_dialogPemeriksaLengkap', array('modTindakan' => $modTindakan)); ?>
<?php $this->renderPartial($this->path_view.'_dialogEdukasiTransfusi', array('modPendaftaran' => $modPendaftaran)); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDeposit',
    'options' => array(
        'title' => 'Status Deposit Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php
if (!empty($modBayarUangMuka)) {
    $this->renderPartial($this->path_view.'_dialogDeposit', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modBayarUangMuka' => $modBayarUangMuka, 'jmluangmuka', $modDeposit));
}
?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php echo $this->renderPartial($this->path_view.'_jsFunction', array(
    'modTindakan' => $modTindakan,
    'modPendaftaran' => $modPendaftaran,
    'modPasien' => $modPasien,
    'modBayarUangMuka' => $modBayarUangMuka,
    'modAdmisi' => $modAdmisi,
    'modJenisTarif' => $modJenisTarif,
), true); ?>
<?php
//========= Dialog buat daftar tindakan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDaftarTindakanPaket',
    'options' => array(
        'title' => 'Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div id="tableDaftarTindakanPaket"></div>';
$this->renderPartial($this->path_view.'_daftarTindakanPaket');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar tindakan =============================
?>
<div style='display:none;'>
    <?php
    $this->widget('MyDateTimePicker', array(
        'name' => 'testingkktest',
        'mode' => 'datetime',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
            'maxDate' => 'd',
        ),
        'htmlOptions' => array(
            'readonly' => true,
            'onkeypress' => "return $(this).focusNextInputField(event)", 'id' => 'RITindakanPelayananT_0_tgl_tindakan'
        ),
    ));
    ?>
</div>