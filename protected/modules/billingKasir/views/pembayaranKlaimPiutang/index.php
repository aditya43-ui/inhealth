<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<style type="text/css">
    .integer-decimal {
        text-align: right;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembayaran Klaim Piutang Penjamin</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (!empty($modPengajuanKlaim->pengajuanklaimpiutang_id)) {
            $this->breadcrumbs = array(
                'Informasi Pengajuan Klaim Piutang Penjamin' => Yii::app()->request->getUrlReferrer(),
                'Pembayaran Klaim Piutang Penjamin',
            );
        } else {
            $this->breadcrumbs = array(
                'Pembayaran Klaim Piutang Penjamin',
            );
        }
        ?>
        <?php
        Yii::app()->clientScript->registerScript('search', "
   $('.search-button').click(function(){
           $('.search-form').toggle();
           return false;
   });
   $('#searchLaporan').submit(function(){
           return false;
   });
   ");
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial(
                    $this->path_view . '_pengajuanPiutang',
                    array('modPendaftaran' => $modPendaftaran, 'modPengajuanKlaim' => $modPengajuanKlaim)
                );
                // $this->renderPartial($this->path_view.'_search',
                //         array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modPembayaranKlaim'=>$modPembayaranKlaim,
                //                 'modPembayaranKlaimDetail'=>$modPembayaranKlaimDetail,'format'=>$format,'modPengajuanKlaim'=>$modPengajuanKlaim,));
                ?>
            </div>
        </div>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembayaran-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#BKPasienM_no_rekam_medik',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekInputTindakan(); '),
        )); ?>
        <?php echo $form->errorSummary(array($modPembayaranKlaim, $modPembayaranKlaimDetail)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembayaran Klaim Piutang Penjamin</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<div style='max-height:300px;max-width:960px;overflow-y: scroll;'>-->
                <table id="tableList" class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Pilih<br>
                                <?php
                                echo CHtml::checkBox('checkPembayaran', true, array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'checkbox-column', 'onClick' => 'checkAllPembayaran()', 'checked' => 'checked'
                                ))
                                ?>
                            </th>
                            <th>No.</th>
                            <th>Tgl. Pendaftaran/<br> No. Pendaftaran</th>
                            <th>Tgl. Pembayaran/<br> No. Pembayaran</th>
                            <th>No. Kartu Peserta</th>
                            <th>No. Rekam Medik</th>
                            <th>Instalasi/<br> Ruangan</th>
                            <th>Nama Pasien</th>
                            <th>No Referensi</th>
                            <th>Jumlah Tagihan<br>(Rp)</th>
                            <th>Keringanan<br>(Rp)</th>
                            <th>Jumlah Piutang<br>(Rp)</th>
                            <th>Jumlah Telah Bayar<br>(Rp)</th>
                            <th>Jumlah Bayar<br>(Rp)</th>
                            <th>Sisa Tagihan<br>(Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // if(isset($tr)){
                        //     echo $tr;
                        // }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr class="trfooter">
                            <td colspan="9">Total</td>
                            <?php
                            $totaltransaksi = 0;
                            $totpiutang = 0;
                            $tottelahbayar = 0;
                            $totbayar = 0;
                            $totsisatagihan = 0;
                            $totdiskon = 0;
                            // $modTandaBukti = 'null';
                            ?>
                            <td>
                                <?php echo CHtml::textField("tottagihan", $totaltransaksi, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal lebar3', 'style' => 'width:120px;')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField("totdiskon", $totdiskon, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal lebar3', 'style' => 'width:120px;')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField("totpiutang", $totpiutang, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal lebar3', 'style' => 'width:120px;')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField("tottelahbayar", $tottelahbayar, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal lebar3', 'style' => 'width:120px;')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField("totbayar", $totbayar, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal lebar3', 'style' => 'width:120px;')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField("totsisatagihan", $totsisatagihan, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal lebar3', 'style' => 'width:120px;')); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan Pembayaran</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Pembayaran - Ke', 'bayarke', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo CHtml::activeHiddenField($modPembayaranKlaim, 'carabayar_id'); ?>
                                <?php echo CHtml::activeHiddenField($modPembayaranKlaim, 'penjamin_id'); ?>
                                <?php echo $form->textField($modPembayaranKlaim, 'bayarke', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Pembayaran Klaim', 'tglpembayaranklaim', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPembayaranKlaim,
                                    'attribute' => 'tglpembayaranklaim',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No. Pembayaran <span class="required">*</span>', 'noPembayaran', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPembayaranKlaim, 'nopembayaranklaim', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Cara Membayar <span class="required">*</span> ', 'caraMembayar', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modPembayaranKlaim, 'pembayaranmelalui', LookupM::getItems('carapembayaranklaim'), array(
                                    'onchange' => 'enableInputPembayaran()',
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                    'maxlength' => 50,
                                )); ?>
                            </div>
                        </div>
                        <div id="divDenganTransfer" class="hide">
                            <div class="control-group">
                                <?php echo CHtml::label('Bank Pengirim <span class="required">*</span> ', 'bankPenerima', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($modPembayaranKlaim, 'namabank', LookupM::getItemsUrutan('bank'), array('empty' => '-- Pilih --', 'readonly' => false, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('No. Rek. Pengirim <span class="required">*</span> ', 'bankPenerima', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPembayaranKlaim, 'norekbank', array('readonly' => false, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('No. Bukti Setor <span class="required">*</span> ', 'bankPenerima', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPembayaranKlaim, 'nobuktisetor', array('readonly' => false, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label('Bank Penerima <span class="required">*</span> ', 'bankPenerima', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php
                                    $bank_data = BankM::model()->findAll('bank_aktif = true order by namabank');
                                    $list_bank = CHtml::listData($bank_data, 'bank_id', 'bankNoRekening');
                                    $option_bank = array();
                                    foreach ($bank_data as $item) {
                                        $rekening = BankrekM::model()->findByAttributes(array(
                                            'bank_id' => $item->bank_id,
                                            'saldonormal' => 'D',
                                        ));
                                        $option_bank[$item->bank_id] = array(
                                            'data-rekening' => '',
                                        );
                                        if (!empty($rekening)) {
                                            $rek5 = Rekening5M::model()->findByPk($rekening->rekening5_id);
                                            $option_bank[$item->bank_id]['data-rekening'] = $rek5->kdrekening5 . " - " . $rek5->nmrekening5;
                                        }
                                    }
                                    echo $form->dropDownlist($modTandabukti, 'bank_id', $list_bank, array(
                                        'empty' => '-- Pilih --',
                                        'options' => $option_bank,
                                        'onchange' => 'setKodeAkunBank()',
                                        'readonly' => false, 'class' => 'span3',
                                        'onkeypress' => "return $(this).focusNextInputField(event);"
                                    )); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Kode Akun", '', array('class' => 'control-label', 'required' => true, 'label' => 'Nominal')); ?>
                                <div class="controls">
                                    <?php echo CHtml::textField('kode_akun_bank', '', array(
                                        'id' => 'kode_akun_bank', 'class' => 'span3', 'readonly' => true,
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Terima Dari', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPembayaranKlaim, 'terimadari', array(
                                    'class' => 'span3',
                                    'placeholder' => 'Terima Dari',
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Alamat', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textArea($modPembayaranKlaim, 'alamatpenyetor', array(
                                    'class' => 'span3',
                                    'placeholder' => 'Alamat',
                                    'onkeypress' => "return $(this).focusNextInputField(event);"
                                )); ?>
                            </div>
                        </div>
                        <div style="overflow-x: auto;max-width: 100%">
                            <?php
                            $this->renderPartial(
                                $this->path_view . '_rowListRekening',
                                array(
                                    'form' => $form
                                )
                            );
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Total Tagihan', 'totalTagihan', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo CHtml::textField('txt_totaltagihan', 0, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Keringanan', 'totalDiskon', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPembayaranKlaim, 'totaldiskon', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Piutang', 'totalPiutang', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPembayaranKlaim, 'totalpiutang', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Telah Bayar', 'totalTelahBayar', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPembayaranKlaim, 'telahbayar', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Bayar', 'totalBayar', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPembayaranKlaim, 'totalbayar', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Biaya Administrasi', 'biaya_administrasi', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPembayaranKlaim, 'biaya_administrasi', array('onblur' => 'hitungAdministrasi();', 'class' => 'inputFormTabel integer-decimal span3')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Penerimaan', 'totalBayar', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPembayaranKlaim, 'totalpenerimaan', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Sisa Piutang', 'totalSisaPiutang', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPembayaranKlaim, 'totalsisapiutang', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if ($modPembayaranKlaim->isNewRecord)
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
            else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
                );
            }
            $reffUrl = ((isset($_GET['frame']) && !empty($_GET['pendaftaran_id'])) ? array('modul_id' => Yii::app()->session['modul_id'], 'frame' => $_GET['frame'], 'pendaftaran_id' => $_GET['pendaftaran_id']) : array('modul_id' => Yii::app()->session['modul_id']));
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index', $reffUrl),
                array('title' => 'Ulang', 'class' => 'btn btn-default')
            );
            if (!isset($_GET['id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();return false", 'disabled' => FALSE));
            }
            ?>
            <?php
            $tips = array(
                '0' => 'tanggal',
                '1' => 'autocomplete-search',
                '2' => 'ulang',
                '3' => 'waktutime',
                '4' => 'simpan',
                '5' => 'print',
                '6' => 'status_print'
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('form' => $form, 'modPembayaranKlaim' => $modPembayaranKlaim, 'modPendaftaran' => $modPendaftaran)); ?>
    </div>
</div>
<?php
//========= Dialog buat cari data no pengunjung =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPembayaranPasien',
    'options' => array(
        'title' => 'Rincian Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="framePembayaranPasien" width="100%" height="530"></iframe>
<?php
$this->endWidget();
//========= end pencarian pasien dialog ====================================
?>