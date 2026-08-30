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
        //        'decimal'=>',',
        //        'thousands'=>'.',
        'precision' => 0,
    )
));
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pembayaran-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#TandabuktibayarT_biayaadministrasi',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return cekKarcis();'
    ),
)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembayaran Karcis</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Pembayaran Tindakan
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table id="tblBayarTind" class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Pilih</th>
                            <th>Tanggal</th>
                            <th>Uraian Tindakan</th>
                            <th>Jumlah</th>
                            <th>Tarif</th>
                            <!--<th>Tarif Cyto</th>
                            <th>Tanggungan Asuransi</th>
                            <th>Tanggungan Pemerintah</th>
                            <th>Tanggungan Rumah Sakit</th>-->
                            <th>Iur Biaya</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totQty = 0;
                        $totTarif = 0;
                        $totCyto = 0;
                        $totSubAsuransi = 0;
                        $totSubPemerintah = 0;
                        $totSubRs = 0;
                        $totIur = 0;
                        $totPembebasanTarif = 0;
                        $totDiscount_tindakan = 0; ?>
                        <?php foreach ($modTindakan as $i => $tindakan) { ?>
                            <tr>
                                <td>
                                    <?php echo CHtml::checkBox("pembayaran[$i][tindakanpelayanan_id]", true, array('value' => $tindakan->tindakanpelayanan_id, 'uncheckValue' => '0')) ?>
                                    <?php $subsidi = $this->cekSubsidi($tindakan); ?>
                                </td>
                                <td>
                                    <?php echo $tindakan->tgl_tindakan ?>
                                    <?php
                                    $pembebasanTarif = PembebasantarifT::model()->findAllByAttributes(array('tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id));
                                    $tarifBebas = 0;
                                    foreach ($pembebasanTarif as $i => $pembebasan) {
                                        $tarifBebas = $tarifBebas + $pembebasan->jmlpembebasan;
                                    }
                                    $totPembebasanTarif = $totPembebasanTarif + $tarifBebas;
                                    $totDiscount_tindakan = $totDiscount_tindakan + $tindakan->discount_tindakan;
                                    ?>
                                    <?php echo CHtml::hiddenField("pembayaran[$i][tgl_tindakan]", $tindakan->tgl_tindakan, array('readonly' => true, 'class' => 'inputFormTabel span2')); ?>
                                    <?php echo CHtml::hiddenField("pembayaran[$i][carabayar_id]", $tindakan->carabayar_id, array('readonly' => true)); ?>
                                    <?php echo CHtml::hiddenField("pembayaran[$i][penjamin_id]", $tindakan->penjamin_id, array('readonly' => true)); ?>
                                    <?php echo CHtml::hiddenField("pembayaran[$i][discount_tindakan]", $tindakan->discount_tindakan, array('readonly' => true)); ?>
                                    <?php echo CHtml::hiddenField("pembayaran[$i][pembebasan_tarif]", $tarifBebas, array('readonly' => true)); ?>
                                </td>
                                <td>
                                    <?php echo isset($tindakan) ? $tindakan->tipepaket->tipepaket_nama : '-' . ' - ' . $tindakan->daftartindakan->daftartindakan_nama;
                                    $modTandaBukti->sebagaipembayaran_bkm = isset($tindakan->daftartindakan) ? $tindakan->daftartindakan->daftartindakan_nama : '-';
                                    ?>
                                    <?php echo CHtml::hiddenField("pembayaran[$i][daftartindakan_id]", $tindakan->daftartindakan_id, array('readonly' => true, 'class' => 'inputFormTabel lebar2')); ?>
                                </td>
                                <td>
                                    <?php $qtyTindakan = $tindakan->qty_tindakan;
                                    $totQty = $totQty + $qtyTindakan; ?>
                                    <?php echo CHtml::textField("pembayaran[$i][qty_tindakan]", $tindakan->qty_tindakan, array('readonly' => true, 'class' => 'inputFormTabel lebar2')); ?>
                                </td>
                                <td>
                                    <?php $tarifTindakan = $tindakan->tarif_tindakan;
                                    $totTarif = $totTarif + $tarifTindakan; ?>
                                    <?php echo CHtml::textField("pembayaran[$i][tarif_tindakan]", $tindakan->tarif_tindakan, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                </td>
                                <td>
                                    <?php $tarifCyto = $tindakan->tarifcyto_tindakan;
                                    $totCyto = $totCyto + $tarifCyto; ?>
                                    <?php echo CHtml::hiddenField("pembayaran[$i][tarifcyto_tindakan]", $tindakan->tarifcyto_tindakan, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                    <?php $subsidiAsuransi = isset($subsidi['asuransi']) ? $subsidi['asuransi'] : 0;
                                    $totSubAsuransi = $totSubAsuransi + $subsidiAsuransi; ?>
                                    <?php echo CHtml::hiddenField("pembayaran[$i][subsidiasuransi_tindakan]", $subsidiAsuransi, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                    <?php $subsidiPemerintah = isset($subsidi['pemerintah']) ? $subsidi['pemerintah'] : 0;
                                    $totSubPemerintah = $totSubPemerintah + $subsidiPemerintah; ?>
                                    <?php echo CHtml::hiddenField("pembayaran[$i][subsidipemerintah_tindakan]", $subsidiPemerintah, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                    <?php $subsidiRumahSakit = isset($subsidi['rumahsakit']) ? $subsidi['rumahsakit']  : 0;
                                    $totSubRs = $totSubRs + $subsidiRumahSakit; ?>
                                    <?php echo CHtml::hiddenField("pembayaran[$i][subsisidirumahsakit_tindakan]", $subsidiRumahSakit, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                    <?php $iurBiaya = ($tarifTindakan + $tarifCyto) - ($subsidiAsuransi + $subsidiPemerintah + $subsidiRumahSakit);
                                    $totIur = $totIur + $iurBiaya; ?>
                                    <?php //$iurBiaya = $tindakan->iurbiaya_tindakan; $totIur = $totIur + $iurBiaya; 
                                    ?>
                                    <?php echo CHtml::textField("pembayaran[$i][iurbiaya_tindakan]", $iurBiaya, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::textField("pembayaran[$i][sub_total]", $iurBiaya, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                    <?php //echo $tindakan->daftartindakan_id; 
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr class="trfooter">
                            <td colspan="3">Total</td>
                            <td>
                                <?php echo CHtml::textField("totalqtytindakan", $totQty, array('readonly' => true, 'class' => 'inputFormTabel lebar2')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField("totalbiayatindakan", $totTarif, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::hiddenField("totalcyto", $totCyto, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                <?php echo CHtml::hiddenField("totalsubsidiasuransi", $totSubAsuransi, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                <?php echo CHtml::hiddenField("totalsubsidipemerintah", $totSubPemerintah, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                <?php echo CHtml::hiddenField("totalsubsidirs", $totSubRs, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                <?php echo CHtml::textField("totaliurbiaya", $totIur, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField("totalbayartindakan", $totIur, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                <?php echo CHtml::hiddenField("totalpembebasan", $totPembebasanTarif, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                                <?php echo CHtml::hiddenField("totaldiscount_tindakan", $totDiscount_tindakan, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </fieldset>
                <?php echo CHtml::hiddenField("totalqty_oa", 0, array('readonly' => true, 'class' => 'inputFormTabel lebar2')); ?>
                <?php echo CHtml::hiddenField("totalbiaya_oa", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                <?php echo CHtml::hiddenField("totalcyto_oa", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                <?php echo CHtml::hiddenField("totalsubsidiasuransi_oa", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                <?php echo CHtml::hiddenField("totalsubsidipemerintah_oa", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                <?php echo CHtml::hiddenField("totalsubsidirs_oa", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                <?php echo CHtml::hiddenField("totaliurbiaya_oa", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                <?php echo CHtml::hiddenField("totalbayar_oa", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3')); ?>
                <?php
                $pembulatanHarga = Yii::app()->user->getState('pembulatanharga') || 1;
                $totIurOa = 0;
                $totTagihan = $totIur + $totIurOa;
                $totDeposit = 0;
                $modTandaBukti->jmlpembayaran = $totTagihan;
                $modTandaBukti->biayaadministrasi = 0;
                $modTandaBukti->biayamaterai = 0;
                $modTandaBukti->uangkembalian = 0;
                $modTandaBukti->uangditerima = $totTagihan;
                $pembulatan = $modTandaBukti->jmlpembayaran % $pembulatanHarga;
                if ($pembulatan > 0) {
                    $modTandaBukti->jmlpembulatan = $pembulatanHarga - $pembulatan;
                    $modTandaBukti->jmlpembayaran = $modTandaBukti->jmlpembayaran + $pembulatan - $totDiscount_tindakan - $totPembebasanTarif - $totDeposit;
                    $harusDibayar = $modTandaBukti->jmlpembayaran;
                } else {
                    $modTandaBukti->jmlpembulatan = 0;
                }
                ?>
                <div class="panel panel-success" style="margin-top: 17px;">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Pembayaran</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label('Total Tagihan', 'harusDibayar', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo CHtml::textField('totTagihan', $totTagihan, array('readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Deposit', 'deposit', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo CHtml::textField('deposit', $totDeposit, array('readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Total Pembebasan', 'totPembebasan', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo CHtml::textField('totPembebasan', $totPembebasanTarif, array('readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                                    </div>
                                </div>
                                <?php echo CHtml::activeHiddenField($modTandaBukti, 'jmlpembulatan', array('readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::activeHiddenField($modTandaBukti, 'biayaadministrasi', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::activeHiddenField($modTandaBukti, 'biayamaterai', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($modTandaBukti, 'jmlpembayaran', array('onkeyup' => 'hitungKembalian();', 'readonly' => true, 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($modTandaBukti, 'uangditerima', array('onkeyup' => 'hitungKembalian();', 'class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($modTandaBukti, 'uangkembalian', array('class' => 'inputFormTabel currency span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                            <div class="col-sm-6">
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
                                <?php //echo $form->textFieldRow($modTandaBukti,'tglbuktibayar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                                ?>
                                <?php echo $form->dropDownListRow($modTandaBukti, 'carapembayaran',  LookupM::getItems('carapembayaran'), array('onchange' => 'ubahCaraPembayaran(this)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
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
                            </div>
                        </div>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($modTandaBukti,'closingkasir_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->textFieldRow($modTandaBukti,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->textFieldRow($modTandaBukti,'shift_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->textFieldRow($modTandaBukti,'bayaruangmuka_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->textFieldRow($modTandaBukti,'pembayaranpelayanan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->textFieldRow($modTandaBukti,'nourutkasir',array('class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php //echo $form->textFieldRow($modTandaBukti,'nobuktibayar',array('class'=>'inputFormTabel currency span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
                ?>
                <?php //echo $form->textFieldRow($modTandaBukti,'keterangan_pembayaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <div class="form-actions">
                    <?php
                    $ValidTindakan = BKTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), 'karcis_id IS NOT NULL');
                    // echo "<pre>"; print_r($ValidTindakan->attributes); exit();
                    $tandabukti = TandabuktibayarT::model()->findByAttributes(array('pembayaranpelayanan_id' => isset($ValidTindakan->tindakansudahbayar->pembayaranpelayanan_id) ? $ValidTindakan->tindakansudahbayar->pembayaranpelayanan_id : null));
                    // echo $ValidTindakan->tindakansudahbayar_id;
                    if (!empty($ValidTindakan->tindakansudahbayar_id)) {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
                        );
                        if (empty($id)) {
                            $id = $tandabukti->tandabuktibayar_id;
                        }
                        // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($id);return false",'disabled'=>false)); 
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-info', 'onclick' => "printRincian($id);return false", 'disabled' => FALSE));
                        echo CHtml::link(Yii::t('mds', '{icon} Print Bukti Kas Masuk', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-info', 'onclick' => "printBKM();return false", 'disabled' => FALSE));
                        echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-info', 'onclick' => "printKuitansi($id);return false", 'disabled' => FALSE));
                    } else {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => false)
                        );
                        //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true)); 
                    }
                    ?>
                </div>
                <?php $this->endWidget(); ?>
                <?php $modTandaBukti2 = TandabuktibayarT::model()->findByPk($id); ?>
                <div id="testForm"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function hitungKembalian() {
        var jmlBayar = unformatNumber($('#TandabuktibayarT_jmlpembayaran').val());
        var uangDiterima = unformatNumber($('#TandabuktibayarT_uangditerima').val());
        var uangKembalian = uangDiterima - jmlBayar;
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

    function printRincian(idTandaBukti) {
        if (idTandaBukti != '') { //JIka di Konfig Systen diset TRUE untuk Print kunjungan
            window.open("<?php echo $this->createUrl('printRincianSudahBayarNew') ?>&idTandaBukti=" + idTandaBukti, "", 'location=_new, width=1024px');
        }
    }

    function printBKM() {
        var pembayaranpelayanan_id = "<?php echo isset($modTandaBukti2->pembayaranpelayanan_id) ? $modTandaBukti2->pembayaranpelayanan_id : null; ?>";
        //harusnya menggunakan controller yang sama
        window.open("<?php echo $this->createUrl('printdetailKasMasuk') ?>&idPembayaran=" + pembayaranpelayanan_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
    }
    // function printBKM(idTandaBukti)
    // {
    //     if(idTandaBukti!=''){ //JIka di Konfig Systen diset TRUE untuk Print kunjungan
    //     window.open("<?php echo $this->createUrl('printRincianSudahBayar') ?>&idTandaBukti="+idTandaBukti,"",'location=_new, width=1024px');
    //     }
    // }
    function printKuitansi(idTandaBukti) {
        if (idTandaBukti != '') { //JIka di Konfig Systen diset TRUE untuk Print kunjungan
            window.open('<?php echo $this->createUrl('print/bayarKasir', array('idTandaBukti' => '')); ?>' + idTandaBukti, 'printkwi', 'left=100,top=100,width=400,height=400,scrollbars=1');
        }
    }

    function cekKarcis() {
        if ($('#TandabuktibayarT_sebagaipembayaran_bkm').val() == '') {
            myAlert('"Sebagai Pembayaran" tidak boleh kosong!');
            $('#TandabuktibayarT_sebagaipembayaran_bkm').addClass('error');
        }
        if ($('#totalbayartindakan').val() <= 0) {
            myAlert('Tidak ada karcis');
            return false;
        } else {
            $('.currency').each(function() {
                this.value = unformatNumber(this.value)
            });
            return true;
        }
    }
    $('.currency').each(function() {
        this.value = formatNumber(this.value)
    });
</script>
<?php
//if($successSave){
//Yii::app()->clientScript->registerScript('tutupDialog',"
//window.parent.setTimeout(\"$('#dialogBayarKarcis').dialog('close')\",1500);
//window.parent.$.fn.yiiGridView.update('pencarianpasien-grid', {
//		data: $('#caripasien-form').serialize()
//});
//",  CClientScript::POS_READY);
//}
?>