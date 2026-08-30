<?php
$this->breadcrumbs = array(
    'Pembayaran',
); ?>
<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.currency',
    'currency' => 'PHP',
    'config' => array(
        'symbol' => 'Rp ',
        //        'showSymbol'=>true,
        //        'symbolStay'=>true,
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => '.',
        'thousands' => ',',
        'precision' => 0,
    )
));
?>
<?php if (isset($_GET['idPenjualanResep'])) $idPenjualanResep = $_GET['idPenjualanResep']; ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pembayaran-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#TandabuktibayarT_biayaadministrasi',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return cekInputTindakan();'
    ),
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->hiddenField($modPasien, 'pasien_id', array('readonly' => true)); ?>
<fieldset>
    <legend class="rim">Pembayaran Obat Alkes</legend>
    <table id="tblBayarOA" class="table table-condensed">
        <thead>
            <tr>
                <th>Pilih</th>
                <th>Tanggal</th>
                <th>Nama Obat Alkes</th>
                <th>Jumlah</th>
                <th>Tarif</th>
                <th>Adm/Serv/Kons</th>
                <th>Tanggungan Asuransi</th>
                <!--<th>Tanggungan Pemerintah</th>-->
                <th>Tanggungan Rumah Sakit</th>
                <th>Iur Biaya</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totQtyOa = 0;
            $totHargaJualOa = 0;
            $totCytoOa = 0;
            $totSubAsuransiOa = 0;
            $totSubPemerintahOa = 0;
            $totSubRsOa = 0;
            $totIurOa = 0;
            $totIur = 0;
            $subsidiOa = 0;
            $oaSubsidipemerintah = 0;
            $totDiscount_tindakan = 0;
            $totPembebasanTarif = 0;
            foreach ($modObatalkes as $i => $obatAlkes) { ?>
                <tr>
                    <td><?php echo CHtml::checkBox("pembayaranAlkes[$i][obatalkespasien_id]", true, array('value' => $obatAlkes->obatalkespasien_id, 'uncheckValue' => '0')) ?></td>
                    <td><?php echo $obatAlkes->tglpelayanan ?></td>
                    <td>
                        <?php //$subsidiOa = (isset($obatAlkes) ? PembayaranLangsungController::cekSubsidiOa($obatAlkes) : null);
                        ?>
                        <?php echo (isset($obatAlkes->obatalkes->obatalkes_nama) ? $obatAlkes->obatalkes->obatalkes_nama : "") ?>
                        <?php echo CHtml::hiddenField("pembayaranAlkes[$i][obatalkes_id]", $obatAlkes->obatalkes_id, array('readonly' => true, 'class' => 'inputFormTabel lebar2')); ?>
                        <?php echo CHtml::hiddenField("pembayaranAlkes[$i][carabayar_id]", $obatAlkes->carabayar_id, array('readonly' => true)); ?>
                        <?php echo CHtml::hiddenField("pembayaranAlkes[$i][penjamin_id]", $obatAlkes->penjamin_id, array('readonly' => true)); ?>
                        <?php echo CHtml::hiddenField("pembayaranAlkes[$i][hargasatuan]", $obatAlkes->hargasatuan_oa, array('readonly' => true)); ?>
                    </td>
                    <td>
                        <?php $totQtyOa = $totQtyOa + $obatAlkes->qty_oa; ?>
                        <?php echo CHtml::textField("pembayaranAlkes[$i][qty_oa]", $obatAlkes->qty_oa, array('readonly' => true, 'class' => 'inputFormTabel lebar2')); ?>
                    </td>
                    <td>
                        <?php $totHargaJualOa = $totHargaJualOa + $obatAlkes->hargajual_oa; ?>
                        <?php $oaHargajual = $obatAlkes->hargajual_oa; ?>
                        <?php echo CHtml::textField("pembayaranAlkes[$i][hargajual_oa]", $obatAlkes->hargajual_oa, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                    </td>
                    <td>
                        <?php $oaCyto = $obatAlkes->biayaadministrasi + $obatAlkes->biayaservice + $obatAlkes->biayakonseling; ?>
                        <?php $totCytoOa = $totCytoOa + $obatAlkes->biayaadministrasi + $obatAlkes->biayaservice + $obatAlkes->biayakonseling; ?>
                        <?php echo CHtml::textField("pembayaranAlkes[$i][tarifcyto]", $oaCyto, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                    </td>
                    <td>
                        <?php $totSubAsuransiOa = $totSubAsuransiOa + $obatAlkes->subsidiasuransi; ?>
                        <?php $oaSubsidiasuransi = $subsidiOa['asuransi']; ?>
                        <?php echo CHtml::textField("pembayaranAlkes[$i][subsidiasuransi]", $oaSubsidiasuransi, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                    </td>
                    <!--<td>
                    <?php //$totSubPemerintahOa = $totSubPemerintahOa + $obatAlkes->subsidipemerintah; 
                    ?>
                    <?php //$oaSubsidipemerintah = $subsidiOa['pemerintah']; 
                    ?>
                    <?php //echo CHtml::textField("pembayaranAlkes[$i][subsidipemerintah]", $oaSubsidipemerintah, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); 
                    ?>
                </td>-->
                    <td>
                        <?php $totSubRsOa = $totSubRsOa + $obatAlkes->subsidirs ?>
                        <?php $oaSubsidirs = $subsidiOa['rumahsakit']; ?>
                        <?php echo CHtml::textField("pembayaranAlkes[$i][subsidirs]", $oaSubsidirs, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                    </td>
                    <td>
                        <?php $oaIurbiaya = ($oaHargajual + $oaCyto) - ($oaSubsidiasuransi + $oaSubsidipemerintah + $oaSubsidirs); ?>
                        <?php $obatAlkes->iurbiaya = $oaIurbiaya; ?>
                        <?php $totIurOa = $totIurOa + $oaIurbiaya; ?>
                        <?php echo CHtml::textField("pembayaranAlkes[$i][iurbiaya]", $oaIurbiaya, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                    </td>
                    <td>
                        <?php //echo $obatAlkes->daftartindakan_id 
                        ?>
                        <?php echo CHtml::textField("pembayaranAlkes[$i][sub_total]", $oaIurbiaya, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr class="trfooter">
                <td colspan="3">Total</td>
                <td>
                    <?php echo CHtml::textField("totalqty_oa", $totQtyOa, array('readonly' => true, 'class' => 'inputFormTabel lebar2')); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totalbiaya_oa", $totHargaJualOa, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totalcyto_oa", $totCytoOa, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totalsubsidiasuransi_oa", $totSubAsuransiOa, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                </td>
                <!--<td>
                    <?php //echo CHtml::textField("totalsubsidipemerintah_oa", $totSubPemerintahOa, array('readonly'=>true,'class'=>'inputFormTabel currency lebar3')); 
                    ?>
                </td>-->
                <td>
                    <?php echo CHtml::textField("totalsubsidirs_oa", $totSubRsOa, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totaliurbiaya_oa", $totIurOa, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totalbayar_oa", $totIurOa, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                </td>
            </tr>
        </tbody>
    </table>
</fieldset>
<?php
$pembulatanHarga = Yii::app()->user->getState('pembulatanharga');
$totTagihan = $totIur + $totIurOa;
$totDeposit = 0;
if (empty($modTandaBukti->tandabuktibayar_id)) {
    $modTandaBukti->jmlpembayaran = $totTagihan;
    $modTandaBukti->biayaadministrasi = 0;
    $modTandaBukti->biayamaterai = 0;
    $modTandaBukti->uangkembalian = 0;
    $modTandaBukti->uangditerima = $totTagihan;
    $pembulatan = ($modTandaBukti->jmlpembayaran > 0 && $pembulatanHarga > 0) ? $modTandaBukti->jmlpembayaran % $pembulatanHarga : 0;
    if ($pembulatan > 0) {
        $modTandaBukti->jmlpembulatan = $pembulatanHarga - $pembulatan;
        $modTandaBukti->jmlpembayaran = $modTandaBukti->jmlpembayaran + $pembulatan - $totDiscount_tindakan - $totPembebasanTarif - $totDeposit;
        $modTandaBukti->uangditerima =  $modTandaBukti->jmlpembayaran + $pembulatan - $totDiscount_tindakan - $totPembebasanTarif - $totDeposit;
        $harusDibayar = $modTandaBukti->jmlpembayaran;
    } else {
        $modTandaBukti->jmlpembulatan = 0;
    }
}
?>
<fieldset>
    <legend class="rim">Data Pembayaran</legend>
    <table>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Total Tagihan', 'harusDibayar', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::textField('totTagihan', $totTagihan, array('readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php //echo CHtml::label('Deposit','deposit', array('class'=>'control-label inline')) 
                    ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('deposit', $totDeposit, array('readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php //echo CHtml::label('Total Pembebasan','totPembebasan', array('class'=>'control-label inline')) 
                    ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('totPembebasan', $totPembebasanTarif, array('readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modTandaBukti, 'jmlpembulatan', array('readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'biayaadministrasi', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($modTandaBukti, 'biayamaterai', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'jmlpembayaran', array('onkeyup' => 'hitungKembalian();', 'readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'uangditerima', array('onkeyup' => 'hitungKembalian();', 'class' => 'inputFormTabel currency span3', 'onblur' => 'cekKembalian();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'uangkembalian', array('readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <div class="control-group">
                    <?php $modTandaBukti->tglbuktibayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modTandaBukti->tglbuktibayar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <?php echo $form->labelEx($modTandaBukti, 'tglbuktibayar', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modTandaBukti,
                            'attribute' => 'tglbuktibayar',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($modTandaBukti, 'carapembayaran',   LookupM::getItems('carapembayaran'), array('onchange' => 'ubahCaraPembayaran(this)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Menggunakan Kartu', 'pakeKartu', array('class' => 'control-label inline')) ?>
                    <div class="controls">
                        <?php echo CHtml::checkBox('pakeKartu', false, array('onchange' => "enableInputKartu();", 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
                <div id="divDenganKartu" class="hide">
                    <?php echo $form->dropDownListRow($modTandaBukti, 'dengankartu',  LookupM::getItems('dengankartu'), array('onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti, 'bankkartu', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti, 'nokartu', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modTandaBukti, 'nostrukkartu', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
                <?php echo $form->textFieldRow($modTandaBukti, 'darinama_bkm', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textAreaRow($modTandaBukti, 'alamat_bkm', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modTandaBukti, 'sebagaipembayaran_bkm', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </td>
        </tr>
    </table>
</fieldset>
<div class="form-actions">
    <?php
    if ($successSave || $sudahBayar) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-primary disabled', 'disabled' => true, 'type' => 'submit', 'onclick' => 'return false;', 'onKeypress' => 'return formSubmit(this,event)')
        );
        echo CHtml::link(
            Yii::t('mds', '{icon} Print BKM', array('{icon}' => '<i class="entypo-print"></i>')),
            '#',
            array('class' => 'btn btn-info', 'onclick' => "printKasir();return false", 'disabled' => false)
        );
        echo CHtml::link(
            Yii::t('mds', '{icon} Print Faktur', array('{icon}' => '<i class="entypo-print"></i>')),
            '#',
            array('class' => 'btn btn-info', 'onclick' => "printFaktur();return false", 'disabled' => false)
        );
    } else {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'if(cekInputTindakan()) return formSubmit(this,event)')
        );
        echo CHtml::link(
            Yii::t('mds', '{icon} Print BKM', array('{icon}' => '<i class="entypo-print"></i>')),
            '#',
            array('class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true)
        );
        echo CHtml::link(
            Yii::t('mds', '{icon} Print Faktur', array('{icon}' => '<i class="entypo-print"></i>')),
            '#',
            array('class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true)
        );
    }
    ?>
    <?php
    $content = $this->renderPartial('tips/tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<div id="testForm"></div>
<script type="text/javascript">
    //window.parent.$('#dialogPembayaran').dialog('close').fade(3000);
    $('.currency').each(function() {
        this.value = formatNumber(this.value)
    });

    function hitungKembalian() {
        var jmlBayar = unformatNumber($('#TandabuktibayarT_jmlpembayaran').val());
        var uangDiterima = unformatNumber($('#TandabuktibayarT_uangditerima').val());
        var uangKembalian;
        uangKembalian = uangDiterima - jmlBayar;
        //    $('#TandabuktibayarT_uangditerima').val(formatNumber(uangDiterima));
        $('#TandabuktibayarT_uangkembalian').val(formatNumber(uangKembalian));
    }

    function cekKembalian() {
        var jmlBayar = unformatNumber($('#TandabuktibayarT_jmlpembayaran').val());
        var uangDiterima = unformatNumber($('#TandabuktibayarT_uangditerima').val());
        if (uangDiterima < jmlBayar) {
            myConfirm('Uang diterima tidak boleh lebih kecil dari Jumlah Pembayaran', 'Perhatian!',
                function(r) {
                    if (r) {
                        uangDiterima = jmlBayar;
                    } else {
                        $('#TandabuktibayarT_uangditerima').addClass('error');
                        $('#TandabuktibayarT_uangditerima').focus();
                        $('#TandabuktibayarT_uangditerima').select();
                    }
                });
        }
        uangKembalian = uangDiterima - jmlBayar;
        //    $('#TandabuktibayarT_uangditerima').val(formatNumber(uangDiterima));
        $('#TandabuktibayarT_uangkembalian').val(formatNumber(uangKembalian));
    }

    function enableInputKartu() {
        if ($('#pakeKartu').is(':checked'))
            $('#divDenganKartu').show();
        else
            $('#divDenganKartu').hide();
        if ($('#TandabuktibayarT_dengankartu').val() != '') {
            //myAlert('isi');
            $('#TandabuktibayarT_bankkartu').removeAttr('readonly');
            $('#TandabuktibayarT_nokartu').removeAttr('readonly');
            $('#TandabuktibayarT_nostrukkartu').removeAttr('readonly');
        } else {
            //myAlert('kosong');
            $('#TandabuktibayarT_bankkartu').attr('readonly', 'readonly');
            $('#TandabuktibayarT_nokartu').attr('readonly', 'readonly');
            $('#TandabuktibayarT_nostrukkartu').attr('readonly', 'readonly');
            $('#TandabuktibayarT_bankkartu').val('');
            $('#TandabuktibayarT_nokartu').val('');
            $('#TandabuktibayarT_nostrukkartu').val('');
        }
    }

    function hitungJmlBayar() {
        var biayaAdministrasi = unformatNumber($('#TandabuktibayarT_biayaadministrasi').val());
        var biayaMaterai = unformatNumber($('#TandabuktibayarT_biayamaterai').val());
        var deposit = unformatNumber($('#deposit').val());
        var totPembebasan = unformatNumber($('#totPembebasan').val());
        var totDiscountTind = unformatNumber($('#totaldiscount_tindakan').val());
        var totBayar = 0;
        var totTagihan = unformatNumber($('#totTagihan').val());
        var jmlPembulatan = unformatNumber($('#TandabuktibayarT_jmlpembulatan').val());
        totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai - totDiscountTind - totPembebasan - deposit;
        $('#TandabuktibayarT_jmlpembayaran').val(formatNumber(totBayar));
        hitungKembalian();
    }

    function ubahCaraPembayaran(obj) {
        if (obj.value == 'CICILAN') {
            $('#TandabuktibayarT_jmlpembayaran').removeAttr('readonly');
        } else {
            $('#TandabuktibayarT_jmlpembayaran').attr('readonly', true);
            hitungJmlBayar();
        }
        if (obj.value == 'TUNAI') {
            hitungJmlBayar();
        }
    }

    function printKasir() {
        //    if(idTandaBukti!=''){ 
        window.open('<?php echo Yii::app()->createUrl('billingKasir/informasipenjualanresep/buktiKasMasukFarmasi', array('idPenjualanResep' => $idPenjualanResep, 'idTandaBukti' => $modTandaBukti->tandabuktibayar_id)); ?>', 'printwin', 'left=100,top=100,width=980,height=640,scrollbars=1');
        //    }     
    }

    function printFaktur() {
        window.open('<?php echo Yii::app()->createUrl('billingKasir/informasipenjualanresep/fakturPembayaranApotek', array('id' => $idPenjualanResep, 'idTandaBukti' => $modTandaBukti->tandabuktibayar_id)); ?>', 'printwin', 'left=100,top=100,width=980,height=640,scrollbars=1');
    }

    function cekInputTindakan() {
        var submit = true;
        if ($('#TandabuktibayarT_sebagaipembayaran_bkm').val() == '') {
            myAlert('"Sebagai Pembayaran" tidak boleh kosong!');
            $('#TandabuktibayarT_sebagaipembayaran_bkm').addClass('error');
            $('#TandabuktibayarT_sebagaipembayaran_bkm').focus();
            submit = false;
        }
        if ($('#totalbayartindakan').val() <= 0 && $('#totalbayar_oa').val() <= 0) {
            myAlert('Tidak ada tindakan / Obat Alkes');
        } else {
            submit = true && submit;
        }
        if (submit) {
            $('.currency').each(function() {
                this.value = unformatNumber(this.value);
            });
            return submit;
        }
    }
</script>