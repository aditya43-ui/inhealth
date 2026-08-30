<?php

// $this->widget('application.extensions.moneymask.MMask', array(
//     'element' => '.numbersOnly',
//     'config' => array(
//         'defaultZero' => true,
//         'allowZero' => true,
//         'decimal' => '.',
//         'thousands' => '',
//         'precision' =>0,
//     )
// ));

// $this->widget('application.extensions.moneymask.MMask',array(
//     'element'=>'.currency',
//     'currency'=>'PHP',
//     'config'=>array(
//         'symbol'=>'Rp ',
//         'defaultZero'=>true,
//         'allowZero'=>true,
//         'precision'=>0,
//     )
// ));

?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <div class='control-label'>Tanggal Tutup Kasir</div>
            <div class="controls">
                <?php $model->tglclosingkasir = $format->formatDateTimeForUser($model->tglclosingkasir); ?>
                <?php echo $form->textField($model, 'tglclosingkasir', array('readonly' => true, 'class' => 'realtime span3')); ?>
                <?php /*
					$this->widget('MyDateTimePicker',
						array(
							'model'=>$model,
							'attribute'=>'tglclosingkasir',
							'mode'=>'datetime',
							'options'=>array(
								'dateFormat'=>Params::DATE_FORMAT,
							),
							'htmlOptions'=>array('readonly' => true,
							'class'=>'realtime',
							'onkeypress'=>"return $(this).focusNextInputField(event)"),
						)
					); */
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'closingkasir_no', array('class' => 'span3', 'readonly' => true)); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'jmltransaksi', array('readOnly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->hiddenField($model, 'closingdari'); ?>
            <?php echo $form->hiddenField($model, 'sampaidengan'); ?>
            <?php echo $form->hiddenField($model, 'pegawai_id'); ?>
            <?php echo $form->hiddenField($model, 'create_loginpemakai_id'); ?>
            <?php echo $form->hiddenField($model, 'create_ruangan'); ?>
        </div>

        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'closingsaldoawal', array('class' => 'span3 integer-decimal', 'onkeyup' => 'hitungTotalSetoran()', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'terimauangpelayanan', array('readOnly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'piutang', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'terimauangmuka', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onkeyup' => 'hitungTransaksi()')); ?>
        </div>
        <div class="control-group" hidden>
            <label class='control-label'>Jumlah Penerimaan Umum</label>
            <div class="controls">
                <?php
                echo (CHtml::textField("jum_penerimaan_umum", $informasi['total_penerimaan_umum'], array('readOnly' => true, 'size' => 20, 'class' => 'span3 integer-decimal')));
                /*
                    echo CHtml::htmlButton('List',
                        array(
                            'onclick' => 'listPenerimaanUmum()',
                            'class' => 'btn btn-danger',
                            'rel' => "tooltip",
                            'id' => 'penerimaanUmum',
                            'title' => "Klik untuk Melihat Penerimaan Umum"
                        )
                    );
                ?>
                <?php
                    echo CHtml::checkBox('isPenerimaanUmum',false,
                        array(
                            'rel' => "tooltip",
                            'id' => 'isPenerimaanUmum',
                            'title' => "Check untuk Tidak Menyimpan Penerimaan Umum"
                        )
                    );
                     * 
                     */
                ?>
            </div>
        </div>
        <div class="control-group" hidden>
            <label class='control-label'>
                Jumlah Pengeluaran Umum
            </label>
            <div class="controls">
                <?php
                echo (CHtml::textField("jum_pengeluaran_umum", $informasi['total_pengeluaran_umum'], array('readOnly' => true, 'size' => 20, 'class' => 'span3 integer-decimal')));
                /*
                    echo CHtml::htmlButton('List',
                        array(
                            'onclick' => 'listPengeluaranUmum()',
                            'class' => 'btn btn-danger',
                            'rel' => "tooltip",
                            'id' => 'pengeluaranUmum',
                            'title' => "Klik untuk Melihat Pengeluaran Umum"
                        )
                    );
                ?>
                <?php
                    echo CHtml::checkBox('isPengeluaranUmum',false,
                        array(
                            'rel' => "tooltip",
                            'id' => 'isPengeluaranUmum',
                            'title' => "Check untuk Tidak Menyimpan Pengeluaran Umum"
                        )
                    );
                     * 
                     */
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Jumlah Penerimaan Tunai</label>
            <div class="controls">
                <?php
                echo ($form->textField($model, "jumlahtunai", array('readonly' => true, 'size' => 20, 'class' => 'span3 integer-decimal')));
                //                    echo(CHtml::textField("jum_penerimaan_tunai", 0, array('readOnly'=>true, 'size'=>20, 'class'=>'span3 integer-decimal'))); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Jumlah Penerimaan Non Tunai</label>
            <div class="controls">
                <?php
                echo ($form->textField($model, "jumlahnontunai", array('readonly' => true, 'size' => 20, 'class' => 'span3 integer-decimal')));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Jumlah Pengeluaran Umum</label>
            <div class="controls">
                <?php
                echo ($form->textField($model, "totalpengeluaran", array('readonly' => false, 'size' => 20, 'class' => 'span3 integer-decimal', 'onblur' => 'hitungTransaksi();')));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Jumlah Retur Tindakan</label>
            <div class="controls">
                <?php
                echo ($form->textField($model, "jumlah_returtagihan", array('readonly' => true, 'size' => 20, 'class' => 'span3 integer-decimal', 'onblur' => 'hitungTransaksi();')));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class='control-label'>Jumlah Debit</label>
            <div class="controls">
                <?php
                echo ($form->textField($model, "jumlahdebit", array('readonly' => true, 'size' => 20, 'class' => 'span3 integer-decimal')));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Jumlah Kredit</label>
            <div class="controls">
                <?php
                echo ($form->textField($model, "jumlahkredit", array('readonly' => true, 'size' => 20, 'class' => 'span3 integer-decimal')));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->hiddenField($model, 'jmluanglogam', array('value' => 0)); ?>
            <?php echo $form->hiddenField($model, 'jmluangkertas', array('value' => 0)); ?>
        </div>
        <div id="div_recehan" hidden>
        <?php
        foreach ($rPecahanUang as $value) {
        ?>
            <div class="control-group">
                <div class='control-label'><?php echo $value['lookup_name']; ?></div>
                <div class="controls">
                    <?php
                    echo (CHtml::textField("jum_recehan[" . $value['lookup_value'] . "]", 0, array('onkeypress' => "return $(this).focusNextInputField(event)", 'onKeyup' => 'hitungRecehan()', 'is_receh' => ($value['lookup_value'] < 500 ? 1 : 0), 'recehan_val' => $value['lookup_value'], 'size' => 20, 'class' => 'span3  integer2')));
                    echo (CHtml::hiddenField("val_recehan[" . $value['lookup_value'] . "]", $value['lookup_value'], array('size' => 20, 'class' => 'span3 numbersOnly recehan')));
                    ?>
                </div>
            </div>
        <?php } ?>
        </div>
        <div class="control-group" hidden>
            <div class='control-label'>Total Recehan</div>
            <div class="controls">
                <?php
                echo (CHtml::textField("total_recehan", 0, array('readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'size' => 20, 'class' => 'span3 numericOnly recehan', 'style' => 'text-align: right;')));;
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Shift <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'shift_id', CHtml::listData($model->getShiftItems(), 'shift_id', 'shift_nama'), array('empty' => '-- Pilih Shift --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));?>
                <?php
                //echo $form->dropDownList(
                //    $model,
                //    'shift_id',
                //    CHtml::listData(ShiftM::model()->findAll('shift_aktif = true') /* getShiftRuangan(Yii::app()->user->getState('ruangan_id')) */, 'shift_id', 'shiftJam'),
                //    array(
                //        'inline' => true,
                //        'empty' => '-- Pilih --',
                //        'onkeypress' => "return $(this).focusNextInputField(event)"
//
                //    )
                //); ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Jumlah Retur Obat</label>
            <div class="controls">
                <?php
                echo ($form->textField($model, "jumlahreturoa", array('readonly' => true, 'size' => 20, 'class' => 'span3 integer-decimal')));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Jumlah Pemakaian Uang Muka</label>
            <div class="controls">
                <?php
                echo ($form->textField($model, "pemakaianuangmuka", array('readonly' => true, 'size' => 20, 'class' => 'span3 integer-decimal')));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Total Tutup Kasir</label>
            <div class="controls">
                <?php
                echo $form->textField($model, 'nilaiclosingtrans', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
                <div style="display: none; margin-top:5px;font-size:11px;color:red;width:200px;padding:5px;border:1px solid;">Total Tutup Kasir = Total Penerimaan Tunai + Total Administrasi</div>
            </div>
        </div>
        <div class="control-group">
            <?php
            //                echo $form->textFieldRow($model,'nilaiclosingtrans',array('readOnly'=>true,'class'=>'span3 integer-decimal','onkeypress'=>"return $(this).focusNextInputField(event)"));
            ?>
            <?php echo $form->textFieldRow($model, 'totalsetoran', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="controls">
            <div style="color:red;width:200px;padding:5px;border:1px solid;">Total Setoran = Total Tutup Kasir + Saldo Awal</div>
        </div>

        <div class="control-group">
            <?php echo $form->textAreaRow($model, 'keterangan_closing', array('placeholder' => 'Keterangan Closing', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
</div>

<!--<div class="control-group">
                <?php // echo CHtml::label('Langsung Setor ke Bank','setorBank', array('class'=>'control-label inline')) 
                ?> 
                <div class="controls">
                    <?php // echo CHtml::checkBox('setorBank',false,array('onchange'=>"setorBankEnable(this);")) 
                    ?>
                    <i class="icon-chevron-down"></i>
                </div>
            </div>-->
<!--<div id="setor_bank" style="display: none;">-->
<?php // $this->renderPartial('_formSetorBank', array('form'=>$form, 'modSetor'=>$mSetorBank)); 
?>
<!--</div>-->
<?php /* $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                'id'=>'setor_bank',
                'content'=>array(
                    'content-setorbank'=>array(
                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan form setoran bank')).'<b>Langsung Setor ke Bank</b>',
                        'isi'=>$this->renderPartial('_formSetorBank',array(
                                'form'=>$form, 
                                'modSetor'=>$mSetorBank
                                ),true),
                        'active'=>false,
                        ),   
                    ),
                )); */ ?>
</div>
</div>

<div class="form-actions">
    <?php
    if (empty($id)) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_submit')
        );
        //array('class' => 'btn btn-danger', 'type'=>'submit', 'onclick'=>'setVerifikasi();', 'onkeypress'=>'setVerifikasi();')); 
    } else {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
        );
    }
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('ClosingKasir/Index'),
        array('class' => 'btn btn-default', 'onclick' => 'return true;')
    );
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();return false", 'disabled' => empty($id)));
    $content = $this->renderPartial('tips/transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php
if (!empty($id)) {
    $idClosing = $id;
    $urlPrint = $this->createUrl('rincian');
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&idClosing=${idClosing}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
}


?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogPenerimaanUmum',
        'options' => array(
            'title' => 'List Penerimaan Umum',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 400,
            'resizable' => false,
        ),
    )
);
?>
<table id="tblDialogUmum" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tgl. Penerimaan</th>
            <th>No. Kas Bayar</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count((array)$rPenerimaanUmum) > 0) {
            $no = 1;
            foreach ($rPenerimaanUmum as $value) {
        ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $value['tglpenerimaan']; ?></td>
                    <td><?php echo $value['nopenerimaan']; ?></td>
                    <td><?php echo $value['totalharga']; ?></td>
                </tr>
            <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="5">Data tidak ditemukan.</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<?php
$this->endWidget();

$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogPengeluaranUmum',
        'options' => array(
            'title' => 'List Pengeluaran Umum',
            'autoOpen' => false,
            'modal' => true,
            'width' => 700,
            'height' => 400,
            'resizable' => false,
        ),
    )
);
?>
<table id="tblDialogUmum" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tgl. Penerimaan</th>
            <th>No. Kas Bayar</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count((array)$rPengeluaranUmum) > 0) {
            $no = 1;
            foreach ($rPengeluaranUmum as $value) {
        ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $value['tglpengeluaran']; ?></td>
                    <td><?php echo $value['nopengeluaran']; ?></td>
                    <td><?php echo $value['totalharga']; ?></td>
                </tr>
            <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="5">Data tidak ditemukan.</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<?php
$this->endWidget();
?>

<?php
$js = <<< JSCRIPT
function listPenerimaanUmum()
{
    $("#dialogPenerimaanUmum").dialog("open");
}
function listPengeluaranUmum()
{
    $("#dialogPengeluaranUmum").dialog("open");
}
JSCRIPT;
Yii::app()->clientScript->registerScript('dialog', $js, CClientScript::POS_HEAD);
?>
<script>
    function setTanggalClosing() {
        var tgl_awal = $('#BKTandabuktibayarT_tgl_awal').val();
        var tgl_akhir = $('#BKTandabuktibayarT_tgl_akhir').val();
        $("#BKClosingkasirT_closingdari").val(tgl_awal);
        $("#BKClosingkasirT_sampaidengan").val(tgl_akhir);
    }
    setTanggalClosing();
    $("#BKClosingkasirT_closingsaldoawal").keyup();

    function cekValidasi(form) {

        // if ($("#tblBayarTind tbody .rows").length == 0) {
        //     myAlert("Data pembayaran tidak ada.");
        //     return false;
        // }

        if ($("#BKClosingkasirT_keterangan_closing").val().trim() == "") {
            myAlert("Keterangan Closing harus Diisi.");
            return false;
        }
        if ($("#BKClosingkasirT_shift_id").val().trim() == "") {
            myAlert("Shift harus Diisi.");
            return false;
        }

        if (requiredCheck(form)) {
            $("#btn_submit").prop("disabled", true);
            $(".integer-decimal").each(function() {
                $(this).val(parseFloat(unformatNumber($(this).val())));
            });

            return true;
        }

        return false;
    }
</script>