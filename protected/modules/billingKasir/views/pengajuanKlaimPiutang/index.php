<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<style type="text/css">
    .integer-decimal {
        text-align: right;
    }
</style>
<div class='panel panel-gradient'>
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pengajuan Klaim Piutang Penjamin</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pengajuan Klaim Piutang Penjamin',
        ); ?>
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
        <div class='panel panel-success'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial(
                    $this->path_view . '_search',
                    array(
                        'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPengajuanKlaim' => $modPengajuanKlaim,
                        'modPengajuanKlaimDetail' => $modPengajuanKlaimDetail, 'format' => $format
                    )
                );
                ?>
            </div>
        </div>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pengajuan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#BKPasienM_no_rekam_medik',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'return cekInputTindakan(); '),
        )); ?>
        <div class='panel panel-success'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengajuan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<div style='max-height:300px;max-width:960px;overflow-y: scroll;'>-->
                <table id="tableList" class="table table-striped table-condensed table-bordered">
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
                            <th>Tgl. Pendaftaran/<br>No. Pendaftaran</th>
                            <th>Tgl. Pembayaran/<br>No. Pembayaran</th>
                            <th>No. Kartu Peserta</th>
                            <th>No. Rekam Medik</th>
                            <th>Instalasi/<br> Ruangan</th>
                            <th>Nama Pasien</th>
                            <th>No. Referensi</th>
                            <th>Jumlah Tagihan<br>(Rp)</th>
                            <th>Jumlah Pembayaran<br>(Rp)</th>
                            <th>Keringanan<br>(Rp)</th>
                            <th>Jumlah Piutang<br>(Rp)</th>
                            <th>Jumlah Pengajuan<br>(Rp)</th>
                            <th>Sisa Tagihan<br>(Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($tr)) {
                            echo $tr;
                        }
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
                            $totpengajuan = 0;
                            $totsisatagihan = 0;
                            ?>
                            <td>
                                <?php echo CHtml::textField("tottagihan", $totaltransaksi, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span2',)); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField("totbayar", $totpiutang, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span2',)); ?>
                            </td>
                            <td></td>
                            <td>
                                <?php echo CHtml::textField("totpiutang", $totpiutang, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span2',)); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField("totpengajuan", $totpengajuan, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span2',)); ?>
                            </td>
                            <td>
                                <?php echo CHtml::textField("totsisatagihan", $totsisatagihan, array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span2',)); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class='panel panel-success'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengajuan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php $modPengajuanKlaim->tglpengajuanklaimanklaim = isset($modPengajuanKlaim->tglpengajuanklaimanklaim) ? MyFormatter::formatDateTimeForUser($modPengajuanKlaim->tglpengajuanklaimanklaim) : date('d M Y H:i:s', strtotime(date('Y-m-d H:i:s'))); ?>
                            <?php echo CHtml::label('Tgl. Pengajuan Klaim', 'tglpengajuanklaimanklaim', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPengajuanKlaim,
                                    'attribute' => 'tglpengajuanklaimanklaim',
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
                            <?php $modPengajuanKlaim->tgljatuhtempo = isset($modPengajuanKlaim->tgljatuhtempo) ? MyFormatter::formatDateTimeForUser($modPengajuanKlaim->tgljatuhtempo) : date('d M Y H:i:s', strtotime(date('Y-m-d H:i:s'))); ?>
                            <?php echo CHtml::label('Tgl. Jatuh Tempo', 'tgljatuhtempo', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPengajuanKlaim,
                                    'attribute' => 'tgljatuhtempo',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'minDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No. Pengajuan Klaim <span class="required">*</span>', 'noPembayaran', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPengajuanKlaim, 'nopengajuanklaimanklaim', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Tagihan', 'totalTagihan', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPengajuanKlaim, 'totaltagihan', array('onkeyup' => 'hitungTotalPiutang();', 'readonly' => true, 'class' => 'inputFormTabel integer-decimal span2', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Total Keringanan', 'totalDiskon', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPengajuanKlaim, 'totaldiskon', array('onkeyup' => 'hitungTotalPiutang();', 'readonly' => true, 'class' => 'inputFormTabel integer-decimal span2', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Piutang', 'totalPiutang', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPengajuanKlaim, 'totalpiutang', array('onkeyup' => 'hitungTotalPiutang();', 'readonly' => true, 'class' => 'inputFormTabel integer-decimal span2', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Pengajuan', 'totalBayar', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPengajuanKlaim, 'totalbayar', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal span2', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Total Sisa Piutang', 'totalSisaPiutang', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPengajuanKlaim, 'totalsisapiutang', array('onkeyup' => 'hitungTotalSisaTagihan();', 'readonly' => true, 'class' => 'inputFormTabel integer-decimal span2', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (!isset($_GET['id'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
                echo "&nbsp";
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
                );
            }
            $reffUrl = ((isset($_GET['frame']) && !empty($_GET['pendaftaran_id'])) ? array('modul_id' => Yii::app()->session['modul_id'], 'frame' => $_GET['frame'], 'pendaftaran_id' => $_GET['pendaftaran_id']) : array('modul_id' => Yii::app()->session['modul_id']));
            if (!isset($_GET['id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();return false", 'disabled' => FALSE));
            }
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index', $reffUrl),
                array('title' => 'Ulang', 'class' => 'btn btn-default')
            ); ?>
            <?php
            $tips = array(
                '0' => 'tanggal',
                '1' => 'waktutime',
                '2' => 'cari2',
                '3' => 'ulang',
                '4' => 'simpan',
                '5' => 'print',
                '6' => 'status_print'
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
$pembulatanHarga = Yii::app()->user->getState('pembulatanharga');
//    $pembulatan = ($pembulatanHarga > 0) ? $totTagihan % $pembulatanHarga : 0 ;
?>
<script type="text/javascript">
    // $('.integer2').each(function(){this.value = formatInteger(this.value)});
    function enableInputPembayaran() {
        if ($('#BKPembayaranklaimT_pembayaranmelalui').val() == "CASH")
            $('#divDenganTransfer').show();
        else if ($('#BKPembayaranklaimT_pembayaranmelalui').val() == "TRANSFER")
            $('#divDenganTransfer').show();
        else
            $('#divDenganTransfer').hide();
        if ($('#BKPembayaranklaimT_pembayaranmelalui').val() == 'TRANSFER') {
            //myAlert('isi');
            $('#BKPembayaranklaimT_nobuktisetor').removeAttr('readonly');
            $('#BKPembayaranklaimT_alamatpenyetor').removeAttr('readonly');
            $('#BKPembayaranklaimT_namabank').removeAttr('readonly');
            $('#BKPembayaranklaimT_norekbank').removeAttr('readonly');
        } else {
            //myAlert('kosong');
            $('#BKPembayaranklaimT_nobuktisetor').attr('readonly', 'readonly');
            $('#BKPembayaranklaimT_alamatpenyetor').attr('readonly', 'readonly');
            $('#BKPembayaranklaimT_namabank').attr('readonly', 'readonly');
            $('#BKPembayaranklaimT_norekbank').attr('readonly', 'readonly');
            $('#BKPembayaranklaimT_nobuktisetor').val('');
            $('#BKPembayaranklaimT_alamatpenyetor').val('');
            $('#BKPembayaranklaimT_namabank').val('');
            $('#BKPembayaranklaimT_norekbank').val('');
        }
    }

    function hitungPembayaran() {
        $('#tableList').find('input[name$="[pembayaranpelayanan_id]"]').each(function() {
            hitungTotalPembayaran(this);
        });
        hitungJmlPembayaran();
    }

    function hitungTotalPembayaran(obj) {
        unformatNumberSemua();
        var pembayaranpelayanan_id = parseFloat(obj.value);
        var jmlTagihan = parseFloat($(obj).parents('tr').find('input[name$="[jmltagihan]"]').val());
        var jmlPiutang = parseFloat($(obj).parents('tr').find('input[name$="[jmlpiutang]"]').val());
        var jmlTelahBayar = parseFloat($(obj).parents('tr').find('input[name$="[jmltelahbayar]"]').val());
        var jmlBayar = parseFloat($(obj).parents('tr').find('input[name$="[jmlBayar]"]').val());
        var JmlSisaTagihan = parseFloat($(obj).parents('tr').find('input[name$="[jmlsisatagihan]"]').val());
        var totTagihan = 0;
        var totBayar = 0;
        var totPiutang = 0;
        var totPengajuan = 0;
        var totTelahBayar = 0;
        var totBayar = 0;
        var totSisaTagihan = 0;
        $(obj).parents('table').find(':checkbox:checked').each(function() {
            $(this).parents('tr').find('input[name$="[jmltagihan]"]').each(function() {
                totTagihan = totTagihan + parseFloat(this.value);
            });
            $(this).parents('tr').find('input[name$="[jmlpiutang]"]').each(function() {
                totPiutang = totPiutang + parseFloat(this.value);
            });
            $(this).parents('tr').find('input[name$="[jmltelahbayar]"]').each(function() {
                totTelahBayar = totTelahBayar + parseFloat(this.value);
            });
            $(this).parents('tr').find('input[name$="[jmlbayar]"]').each(function() {
                totBayar = totBayar + parseFloat(this.value);
            });
            $(this).parents('tr').find('input[name$="[jmlsisatagihan]"]').each(function() {
                totSisaTagihan = totSisaTagihan + parseFloat(this.value);
            });
        });
        // console.log("kick");
        $('#tottagihan').val(totTagihan);
        $('#totpiutang').val(totPiutang);
        $('#BKPembayaranklaimT_totalpiutang').val(totPiutang);
        $('#tottelahbayar').val(totTelahBayar);
        $('#totbayar').val(totBayar);
        $('#totsisatagihan').val(totSisaTagihan);
        formatNumberSemua();
    }

    function hitungJmlPembayaran() {
        unformatNumberSemua();
        var totalPiutang = parseFloat($('#totpiutang').val());
        var totalTelahBayar = parseFloat($('#BKPembayaranklaimT_telahbayar').val());
        var totalBayar = parseFloat($('#BKPembayaranklaimT_totalbayar').val());
        var totalSisaPiutang = parseFloat($('#BKPembayaranklaimT_totalsisapiutang').val());
        totpiutang = totalPiutang;
        $('#BKPembayaranklaimT_totalpiutang').val(totpiutang);
        formatNumberSemua();
    }

    function cekInputTindakan() {
        jumlahPilihan = $(".cek:checked").length;
        if (jumlahPilihan < 1) {
            myAlert('Tidak Ada Transaksi Pembayaran');
            return false;
        }
        $(".integer, .float, .integer-decimal").each(function() {
            $(this).val(unformatNumber($(this).val()));
        });
        //if($('#tottagihan').val() <=0 ){totsisatagihan
        // if($('#totsisatagihan').val() <=0 ){
        //    myAlert('Tidak ada Tagihan');
        //    return false;
        // } else {
        // $('.integer2').each(function(){this.value = unformatNumber(this.value)});
        // $('.number').each(function(){this.value = unformatNumber(this.value)});
        return true;
        // }
        // $('.integer2').each(function(){this.value = unformatNumber(this.value)});
        // $('.number').each(function(){this.value = unformatNumber(this.value)});
        // return false;
    }

    function hitungTotalBayar(obj) {
        unformatNumberSemua();
        totalBayar = 0;
        totJmlBayar = 0;
        totalBayar = parseFloat($('#BKPembayaranklaimT_totalbayar').val());
        $('#tableList tbody .cek').each(function() {
            var totTagihan = parseFloat($('#tottagihan').val());
            var totPiutang = parseFloat($('#totpiutang').val());
            var totTelahBayar = parseFloat($('#tottelahbayar').val());
            var totBayar = parseFloat($('#totbayar').val());
            var totSisaTagihan = parseFloat($('#totsisatagihan').val());
            totJmlBayar = 0;
            totJmlSisaTagihan = 0;
            $('.cek').each(function() {
                var jmlTagihan = parseFloat($(this).parents('tr').find('input[name$="[jmltagihan]"]').val());
                var jmlPiutang = parseFloat($(this).parents('tr').find('input[name$="[jmlpiutang]"]').val());
                var jmlTelahBayar = parseFloat($(this).parents('tr').find('input[name$="[jmltelahbayar]"]').val());
                var jmlBayar = parseFloat($(this).parents('tr').find('input[name$="[jmlbayar]"]').val());
                var jmlSisaTagihan = parseFloat($(this).parents('tr').find('input[name$="[jmlsisatagihan]"]').val());
                var totalJumlahBayar = parseFloat($(this).parents('tr').find('.jmlbayar').val());
                var totalJumlahSisaTagihan = parseFloat($(this).parents('tr').find('.jmlsisatagihan').val());
                jmlSisaTagihan = 0;
                jumlahBayar = Math.ceil(((jmlPiutang - jmlTelahBayar) / (totPiutang) * (totalBayar)).toFixed(2));
                pembulatan = (jumlahBayar) % <?php echo $pembulatanHarga; ?>;
                jmlPembulatan = <?php echo $pembulatanHarga; ?> - pembulatan;
                if (jQuery.isNumeric(jmlPembulatan)) {
                    if (jmlPembulatan >= <?php echo $pembulatanHarga; ?>) {
                        jmlPembulatan = 0;
                    }
                }
                if (jQuery.isNumeric(totalJumlahBayar)) {
                    totJmlBayar += parseFloat(totalJumlahBayar);
                }
                if (jQuery.isNumeric(totalJumlahSisaTagihan)) {
                    totJmlSisaTagihan += parseFloat(totalJumlahSisaTagihan);
                }
                if (jmlBayar > jmlPiutang) {
                    if (jmlSisaTagihan > 0) {
                        jumlahSisaTagihan = 0;
                    } else {
                        jumlahSisaTagihan = (jmlBayar - (jmlPiutang - jmlTelahBayar));
                    }
                } else {
                    jmlSisaTagihan = ((jmlPiutang - jmlTelahBayar) - jmlBayar);
                }
                $(this).parents("tr").find('input[name$="[jmlbayar]"]').val((jumlahBayar + jmlPembulatan));
                $(this).parents("tr").find('input[name$="[jmlsisatagihan]"]').val(jmlSisaTagihan);
                $('#totbayar').val(totJmlBayar);
                $('#totsisatagihan').val(totJmlSisaTagihan);
            });
        });
        formatNumberSemua();
    }

    function checkAllPembayaran() {
        if ($("#checkPembayaran").is(":checked")) {
            $('#tableList input[name*="cekList"]').each(function() {
                $(this).prop('checked', true);
            })
        } else {
            $('#tableList input[name*="cekList"]').each(function() {
                $(this).prop('checked', false);
            })
        }
        // $("#tableList > tbody > tr:last .cek").maskMoney({"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
        setAll();
    }

    function print() {
        var pengajuanklaimpiutang_id = "<?php echo isset($modPengajuanKlaim->pengajuanklaimpiutang_id) ? $modPengajuanKlaim->pengajuanklaimpiutang_id : null; ?>";
        //harusnya menggunakan controller yang sama
        window.open("<?php echo $this->createUrl('print') ?>&pengajuanklaimpiutang_id=" + pengajuanklaimpiutang_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
    }
</script>
<?php
$url = Yii::app()->createUrl($this->route);
$jmltotpiutang = CHtml::activeId($modPengajuanKlaim, 'totalpiutang');
$jmltotbayar = CHtml::activeId($modPengajuanKlaim, 'totalbayar');
$jmltottelahbayar = CHtml::activeId($modPengajuanKlaim, 'telahbayar');
$jmltotsisapiutang = CHtml::activeId($modPengajuanKlaim, 'totalsisapiutang');
$js = <<< JS
    function setAll(obj){
      unformatNumberSemua();
        jmltagihan = 0;
        jmlpiutang = 0;
        jmltelahbayar = 0;
        jmlbayar = 0;
        jmlsisatagihan = 0;
		jmlpengajuan = 0;
        jmltotpiutang = 0;
        jmltotbayar = 0;
        jmltottelahbayar = 0;
        jmltotsisapiutang = 0;
        jmldiskon = 0;
        totaltransaksi = 0;
        $('.cek').each(function(){
           if ($(this).is(':checked')){
                temptagihan = parseFloat($(this).parents('tr').find('.jmltagihan').val());
                temppiutang = parseFloat($(this).parents('tr').find('.jmlpiutang').val());
                temptelahbayar = parseFloat($(this).parents('tr').find('.jmltelahbayar').val());
                tempbayar = parseFloat($(this).parents('tr').find('.jmlbayar').val());
                tempsisatagihan = parseFloat($(this).parents('tr').find('.jmlsisapiutang').val());
                temppengajuan = parseFloat($(this).parents('tr').find('.jmlpengajuan').val());
                nilai_diskon = parseFloat($(this).parents('tr').find('.nilai_diskon').val());
                temptotaltransaksi = parseFloat($(this).parents('tr').find('.totaltransaksi').val());
                totalbayar = parseFloat($('#REClosingkasirT_nilaiclosingtrans').val());
                saldoawal = parseFloat($('#REClosingkasirT_closingsaldoawal').val());
                totalnilaiclosing = parseFloat($('#totalnilaiclosing').val());
                jmlnilaiclosing = totalbayar + saldoawal;
				temppiutang = parseFloat(temppiutang);
				temppengajuan = parseFloat(temppengajuan);
                if (jQuery.isNumeric(temptagihan)){
                    jmltagihan += parseFloat(temptagihan);
                }
                if (jQuery.isNumeric(temppiutang)){
                    jmlpiutang += temppiutang;
                }
                if (jQuery.isNumeric(temptelahbayar)){
                    jmltelahbayar += parseFloat(temptelahbayar);
                }
                if (jQuery.isNumeric(tempbayar)){
                    jmlbayar += parseFloat(tempbayar);
                }
                if (jQuery.isNumeric(temppengajuan)){
                    jmlpengajuan += temppengajuan;
                }
                if (jQuery.isNumeric(tempsisatagihan)){
                    jmlsisatagihan += parseFloat(tempsisatagihan);
                }
                if (jQuery.isNumeric(nilai_diskon)){
                    jmldiskon += nilai_diskon;
                }
                 $(this).parents('tr').find('.cek').val(1);
            }else{
                $(this).parents('tr').find('.cek').val(0);
            }
        });
        jmlsisatagihan = jmlpiutang - jmlpengajuan;
        // console.log(jmlsisatagihan, jmlpiutang, jmlpengajuan);
        $('#BKPembayaranklaimT_totalpiutang, #BKPengajuanklaimpiutangT_totalpiutang').val(jmlpiutang);
        $('#BKPembayaranklaimT_telahbayar').val(jmltelahbayar);
        $('#BKPembayaranklaimT_totalbayar').val(jmlpengajuan);
        $('#BKPengajuanklaimpiutangT_totaltagihan').val(jmltagihan);
        $('#BKPengajuanklaimpiutangT_totaldiskon').val(jmldiskon);
        $('#BKPengajuanklaimpiutangT_totalbayar').val(jmlpengajuan);
        $('#BKPengajuanklaimpiutangT_totalsisapiutang').val(jmlsisatagihan);
        $('#tottagihan').val(jmltagihan);
        $('#totpiutang').val(jmlpiutang);
        $('#tottelahbayar').val(jmltelahbayar);
        $('#totbayar').val(jmlbayar);
        $('#totsisatagihan').val(jmlsisatagihan);
        $('#totpengajuan').val(jmlpengajuan);
        formatNumberSemua();
    }
	function hitungDiskon() {
    unformatNumberSemua();
		$("#tableList tbody tr").each(function() {
			var tagihan = parseFloat($(this).find(".jmltagihan").val());
			var bayar = parseFloat($(this).find(".jmlbayar").val());
      var diskonrp = parseFloat($(this).find(".nilai_diskon").val());
      var diskonpersen = ((diskonrp / tagihan)*100);
      if (diskonpersen > 0){
          diskonpersen = parseFloat(diskonpersen.toFixed(2));
      }
      if(diskonpersen > 100){
        myAlert('Keringanan (Rp) tidak boleh melebih 100 %');
        $(this).find(".nilai_diskon").val(0);
        diskonpersen = 0;
        diskonrp = 0;
      }
			// var diskon = parseFloat(unformatNumber($(this).find(".discount").val()));
      var sisa_bayar = (tagihan - bayar);
      if (sisa_bayar > 0){
          sisa_bayar = parseFloat(sisa_bayar.toFixed(2));
      }
      var pengajuan = sisa_bayar - diskonrp;
      if (pengajuan > 0){
          pengajuan = parseFloat(pengajuan.toFixed(2));
      }
			$(this).find(".jmlpiutang, .jmlpengajuan").val(pengajuan);
			$(this).find(".discount").val(diskonpersen);
		});
    formatNumberSemua();
    hitungPengajuan();
		// setAll();
	}
	function hitungPengajuan() {
    unformatNumberSemua();
    var is_lebih = false;
		$("#tableList tbody tr").each(function() {
			var pengajuan = parseFloat($(this).find('.jmlpengajuan').val());
			var piutang = parseFloat($(this).find(".jmlpiutang").val());
      if (pengajuan > piutang) {
          pengajuan = piutang;
          $(this).find(".jmlpengajuan").val(pengajuan);
          is_lebih = true;
      }
      $(this).find(".jmlsisapiutang").val((piutang - pengajuan));
      if (pengajuan == 0) {
          $(this).find('.cek').val(0).prop('checked', false);
      }
		});
    formatNumberSemua();
		setAll();
	}
    function ajaxGetList(){
        tgl_awal = $('#Filter_tgl_awal').val();
        tgl_akhir = $('#Filter_tgl_akhir').val();
        carabayar_id = $('#BKPendaftaranT_carabayar_id').val();
        penjamin_id = $('#BKPendaftaranT_penjamin_id').val();
        if(carabayar_id == '' || penjamin_id == ''){
            myAlert('Isi Data Jenis Penjamin dan Penjamin');
        }else{
            $('#tableList').addClass('animation-loading');
            $.get('${url}', {tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, carabayar_id:carabayar_id, penjamin_id:penjamin_id},function(data){
                $('#tableList tbody').html(data.tr);
                $('#BKPengajuanklaimpiutangT_tgljatuhtempo').val(data.tgl);
                hitungDiskon();
                // $('#tableList tbody tr .integer2').maskMoney({
                //     "symbol":"",
                //     "defaultZero":true,
                //     "allowZero":true,
                //     "decimal":",",
                //     "thousands":".",
                //     "precision":0
                // });
                // $('#tableList tbody tr .float2').maskMoney({
                //     "symbol":"",
                //     "defaultZero":true,
                //     "allowZero":true,
                //     "decimal":",",
                //     "thousands":"",
                //     "precision":2
                // });
                $('#tableList').removeClass('animation-loading');
                checkAllPembayaran();
            }, 'json');
        }
    }
    function cekInput()
    {
        // $(".integer2").each(function(){this.value = unformatNumber(this.value)});
        return true;
    }
    function setCeklisPengajuan(obj) {
      unformatNumberSemua();
        var jmlpiutang = parseFloat($(obj).parents('tr').find('.jmlpiutang').val());
        if ($(obj).parents('tr').find('.cek').is(':checked')) {
            $(obj).parents('tr').find('.jmlpengajuan').val(jmlpiutang);
        } else {
            $(obj).parents('tr').find('.jmlpengajuan').val(0);
        }
        formatNumberSemua();
        hitungPengajuan();
    }
JS;
Yii::app()->clientScript->registerScript('onheadDialog', $js, CClientScript::POS_HEAD);
?>
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
        'precision' => 0,
    )
));
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincian',
    'options' => array(
        'title' => 'Rincian Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
    )
));
?>
<iframe src="" name="iframeRincian" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>