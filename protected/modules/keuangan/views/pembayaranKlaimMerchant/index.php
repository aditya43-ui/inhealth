<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pembayaran Klaim Merchant</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Pembayaran',
                ); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-search"></i> Pencarian
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                                        ?></p>-->
                            <?php
                            $this->renderPartial(
                                '_search',
                                array(
                                    'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPembayaranKlaim' => $modPembayaranKlaim,
                                    'modPembayaranKlaimDetail' => $modPembayaranKlaimDetail, 'modTandabukti' => $modTandabukti
                                )
                            );
                            ?>
                        </div>
                        <?php
                        Yii::app()->clientScript->registerScript('search', "
							$('.search-button').click(function(){
								$('.search-form').toggle();
								return false;
							});
							$('#searchLaporan').submit(function(){
							//                getDataRekeningKlaim();
							//                setTimeout(function(){//karna form rekening butuh waktu ketika ajax request nya        
							//                    updateRekening();
							//                },1000);
									return false;
								});
							");
                        $this->widget('bootstrap.widgets.BootAlert');
                        ?>
                        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
                        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pembayaran</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                            'id' => 'pembayaran-form',
                            'enableAjaxValidation' => false,
                            'type' => 'horizontal',
                            'focus' => '#',
                            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'return cekInputTindakan(); '),
                        )); ?>
                        <?php
                        if (!empty($_GET['id'])) {
                        ?>
                            <div class="alert alert-block alert-success">
                                <a class="close" data-dismiss="alert">×</a>
                                Data berhasil disimpan
                            </div>
                        <?php } ?>
                        <?php echo $form->errorSummary(array($modPembayaranKlaim, $modPembayaranKlaimDetail)); ?>
                        <div class="block-tabel">
                            <!--<div style='max-height:300px;max-width:960px;overflow-y: scroll;'>-->
                            <table id="tableList" class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Rekam Medik <br> No. Pendaftaran</th>
                                        <th>Nama Pasien</th>
                                        <th>Alamat</th>
                                        <th>Penanggung Jawab <br> Pasien</th>
                                        <th>No. Transaksi</th>
                                        <th>Jumlah Tagihan</th>
                                        <th>Jumlah Piutang</th>
                                        <th>Jumlah Telah Bayar</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Sisa Tagihan</th>
                                        <th>Pilih<br>
                                            <?php
                                            echo CHtml::checkBox('checkPembayaran', true, array(
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'checkbox-column', 'onClick' => 'checkAllPembayaran()', 'checked' => 'checked'
                                            ))
                                            ?>
                                        </th>
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
                                        <td colspan="6">Total</td>
                                        <td>
                                            <?php echo CHtml::textField("tottagihan", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3', 'style' => 'width:70px;',)); ?>
                                        </td>
                                        <td>
                                            <?php echo CHtml::textField("totpiutang", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3', 'style' => 'width:70px;',)); ?>
                                        </td>
                                        <td>
                                            <?php echo CHtml::textField("tottelahbayar", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3', 'style' => 'width:70px;',)); ?>
                                        </td>
                                        <td>
                                            <?php echo CHtml::textField("totbayar", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3', 'style' => 'width:70px;',)); ?>
                                        </td>
                                        <td>
                                            <?php echo CHtml::textField("totsisatagihan", 0, array('readonly' => true, 'class' => 'inputFormTabel currency lebar3', 'style' => 'width:70px;',)); ?>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Pembayaran</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                                        ?></p>-->
                            <div class='col-sm-6'>
                                <div class="control-group">
                                    <?php $modTandabukti->tglbuktibayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modTandabukti->tglbuktibayar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                                    <?php echo CHtml::label('Tgl. Pembayaran', 'tglpembayaran', array('class' => 'control-label inline')) ?>
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
                                                'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
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
                                        <?php echo $form->dropDownList($modPembayaranKlaim, 'pembayaranmelalui', LookupM::getItems('carapembayaranklaim'), array('onchange' => 'enableInputPembayaran()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:120px;')); ?>
                                    </div>
                                </div>
                                <div id="divDenganTransfer" class="hide">
                                    <?php echo $form->textFieldRow($modPembayaranKlaim, 'nobuktisetor', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                    <?php echo $form->textFieldRow($modPembayaranKlaim, 'alamatpenyetor', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                    <?php echo $form->textFieldRow($modPembayaranKlaim, 'namabank', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                    <?php echo $form->textFieldRow($modPembayaranKlaim, 'norekbank', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                                </div>
                            </div>
                            <div class='col-sm-6'>
                                <div class="control-group">
                                    <?php echo CHtml::label('Total Piutang', 'totalPiutang', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modPembayaranKlaim, 'totalpiutang', array('onkeyup' => 'hitungTotalPiutang();', 'readonly' => false, 'class' => 'inputFormTabel currency span3', 'style' => 'width:110px;', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Total Telah Bayar', 'totalTelahBayar', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modPembayaranKlaim, 'telahbayar', array('onkeyup' => 'hitungTelahBayar();', 'readonly' => false, 'class' => 'inputFormTabel currency span3', 'style' => 'width:110px;', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Total Bayar', 'totalBayar', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modPembayaranKlaim, 'totalbayar', array('onkeyup' => 'hitungTotalBayar();', 'readonly' => false, 'class' => 'inputFormTabel currency span3', 'style' => 'width:110px;')) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Total Sisa Piutang', 'totalSisaPiutang', array('class' => 'control-label inline')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modPembayaranKlaim, 'totalsisapiutang', array('onkeyup' => 'hitungTotalSisaTagihan();', 'readonly' => false, 'class' => 'inputFormTabel currency span3', 'style' => 'width:110px;', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
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
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                        );
                    else {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
                        );
                    }
                    $reffUrl = ((isset($_GET['frame']) && !empty($_GET['pendaftaran_id'])) ? array('modul_id' => Yii::app()->session['modul_id'], 'frame' => $_GET['frame'], 'pendaftaran_id' => $_GET['pendaftaran_id']) : array('modul_id' => Yii::app()->session['modul_id']));

                    //BELUM ADA FUNGSINYA >>> echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true)); 
                    ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl('index', $reffUrl),
                        array('title' => 'Ulang', 'class' => 'btn btn-default')
                    ); ?>
                    <?php
                    $content = $this->renderPartial('keuangan.views.tips.transaksi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>

        </div>
    </div>
</div>
</div>



<div>
    <?php
    //FORM REKENING
    //            $this->renderPartial('keuangan.views.pembayaranKlaimMerchant.rekening._formRekening',
    //                array(
    //                    'form'=>$form,
    //                    'modRekenings'=>$modRekenings,
    //                )
    //            );
    ?>
</div>


<?php
$pembulatanHarga = KonfigfarmasiK::model()->find()->pembulatanharga;
//    $pembulatan = ($pembulatanHarga > 0) ? $totTagihan % $pembulatanHarga : 0 ;
?>

<script type="text/javascript">
    $('.currency').each(function() {
        this.value = formatInteger(this.value)
    });

    function enableInputPembayaran() {
        if ($('#KUPembayaranklaimT_pembayaranmelalui').val() == "CASH")
            $('#divDenganTransfer').show();
        else if ($('#KUPembayaranklaimT_pembayaranmelalui').val() == "TRANSFER")
            $('#divDenganTransfer').show();
        else
            $('#divDenganTransfer').hide();
        if ($('#KUPembayaranklaimT_pembayaranmelalui').val() == 'TRANSFER') {
            //alert('isi');
            $('#KUPembayaranklaimT_nobuktisetor').removeAttr('readonly');
            $('#KUPembayaranklaimT_alamatpenyetor').removeAttr('readonly');
            $('#KUPembayaranklaimT_namabank').removeAttr('readonly');
            $('#KUPembayaranklaimT_norekbank').removeAttr('readonly');
        } else {
            //alert('kosong');
            $('#KUPembayaranklaimT_nobuktisetor').attr('readonly', 'readonly');
            $('#KUPembayaranklaimT_alamatpenyetor').attr('readonly', 'readonly');
            $('#KUPembayaranklaimT_namabank').attr('readonly', 'readonly');
            $('#KUPembayaranklaimT_norekbank').attr('readonly', 'readonly');

            $('#KUPembayaranklaimT_nobuktisetor').val('');
            $('#KUPembayaranklaimT_alamatpenyetor').val('');
            $('#KUPembayaranklaimT_namabank').val('');
            $('#KUPembayaranklaimT_norekbank').val('');
        }
    }

    function hitungPembayaran() {
        $('#tableList').find('input[name$="[pembayaranpelayanan_id]"]').each(function() {
            hitungTotalPembayaran(this);
        });
        hitungJmlPembayaran();
    }

    function hitungTotalPembayaran(obj) {
        var pembayaranpelayanan_id = unformatNumber(obj.value);
        var jmlTagihan = unformatNumber($(obj).parents('tr').find('input[name$="[jmltagihan]"]').val());
        var jmlPiutang = unformatNumber($(obj).parents('tr').find('input[name$="[jmlpiutang]"]').val());
        var jmlTelahBayar = unformatNumber($(obj).parents('tr').find('input[name$="[jmltelahbayar]"]').val());
        var jmlBayar = unformatNumber($(obj).parents('tr').find('input[name$="[jmlBayar]"]').val());
        var JmlSisaTagihan = unformatNumber($(obj).parents('tr').find('input[name$="[jmlsisatagihan]"]').val());



        var totTagihan = 0;
        $(obj).parents('table').find(':checkbox:checked').each(function() {
            $(this).parents('tr').find('input[name$="[jmltagihan]"]').each(function() {
                totTagihan = totTagihan + unformatNumber(this.value);
            });
        });
        $('#tottagihan').val(formatInteger(totTagihan));

        var totPiutang = 0;
        $(obj).parents('table').find(':checkbox:checked').each(function() {
            $(this).parents('tr').find('input[name$="[jmlpiutang]"]').each(function() {
                totPiutang = totPiutang + unformatNumber(this.value);
            });
        });
        $('#totpiutang').val(formatInteger(totPiutang));
        $('#KUPembayaranklaimT_totalpiutang').val(formatInteger(totPiutang));

        var totTelahBayar = 0;
        $(obj).parents('table').find(':checkbox:checked').each(function() {
            $(this).parents('tr').find('input[name$="[jmltelahbayar]"]').each(function() {
                totTelahBayar = totTelahBayar + unformatNumber(this.value);
            });
        });
        $('#tottelahbayar').val(formatInteger(totTelahBayar));

        var totBayar = 0;
        $(obj).parents('table').find(':checkbox:checked').each(function() {
            $(this).parents('tr').find('input[name$="[jmlbayar]"]').each(function() {
                totBayar = totBayar + unformatNumber(this.value);
            });
        });
        $('#totbayar').val(formatInteger(totBayar));

        var totSisaTagihan = 0;
        $(obj).parents('table').find(':checkbox:checked').each(function() {
            $(this).parents('tr').find('input[name$="[jmlsisatagihan]"]').each(function() {
                totSisaTagihan = totSisaTagihan + unformatNumber(this.value);
            });
        });
        $('#totsisatagihan').val(formatInteger(totSisaTagihan));
    }

    function hitungJmlPembayaran() {
        var totalPiutang = unformatNumber($('#totpiutang').val());
        var totalTelahBayar = unformatNumber($('#KUPembayaranklaimT_telahbayar').val());
        var totalBayar = unformatNumber($('#KUPembayaranklaimT_totalbayar').val());
        var totalSisaPiutang = unformatNumber($('#KUPembayaranklaimT_totalsisapiutang').val());


        totpiutang = totalPiutang;
        $('#KUPembayaranklaimT_totalpiutang').val(totpiutang);
    }

    function cekInputTindakan() {
        jumlahPilihan = $(".cek:checked").length;
        if (jumlahPilihan < 1) {
            alert('Tidak Ada Transaksi Pembayaran');
            return false;
        }

        if ($('#tottagihan').val() <= 0) {
            alert('Tidak ada Tagihan');
            return false;
        } else {
            $('.currency').each(function() {
                this.value = unformatNumber(this.value)
            });
            $('.number').each(function() {
                this.value = unformatNumber(this.value)
            });
            return true;
        }
        return false;
    }

    function hitungTotalBayar(obj) {
        totalBayar = 0;
        totJmlBayar = 0;

        totalBayar = unformatNumber($('#KUPembayaranklaimT_totalbayar').val());
        var totaltagihan = $('#tottagihan').val();
        var sisatagihan = unformatNumber(totaltagihan) - totalBayar;
        $('#totsisatagihan').val(sisatagihan);

        $('#tableList tbody .cek').each(function() {
            var totTagihan = unformatNumber($('#tottagihan').val());
            var totPiutang = unformatNumber($('#totpiutang').val());
            var totTelahBayar = unformatNumber($('#tottelahbayar').val());
            var totBayar = unformatNumber($('#totbayar').val());
            var totSisaTagihan = unformatNumber($('#totsisatagihan').val());

            totJmlBayar = 0;
            totJmlSisaTagihan = 0;
            $('.cek').each(function() {

                var jmlTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltagihan]"]').val()));
                var jmlPiutang = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlpiutang]"]').val()));
                var jmlTelahBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltelahbayar]"]').val()));
                var jmlBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlbayar]"]').val()));
                var jmlSisaTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlsisatagihan]"]').val()));

                var totalJumlahBayar = unformatNumber($(this).parents('tr').find('.jmlbayar').val());
                var totalJumlahSisaTagihan = unformatNumber($(this).parents('tr').find('.jmlsisatagihan').val());

                // var nilaijmlbayar = jmlTagihan / totTagihan * totBayar;
                // alert(nilaijmlbayar);

                jmlSisaTagihan = 0;

                jumlahBayar = Math.ceil((((jmlTagihan - jmlTelahBayar) / (totTagihan)) * (totalBayar)).toFixed(2));

                pembulatan = (jumlahBayar) % <?php echo $pembulatanHarga; ?>;

                jmlPembulatan = <?php echo $pembulatanHarga; ?> - pembulatan;
                if (jQuery.isNumeric(jmlPembulatan)) {
                    if (jmlPembulatan >= <?php echo $pembulatanHarga; ?>) {
                        jmlPembulatan = 0;
                    }
                }

                if (jQuery.isNumeric(totalJumlahBayar)) {
                    totJmlBayar += parseFloat(unformatNumber(totalJumlahBayar));
                }
                if (jQuery.isNumeric(totalJumlahSisaTagihan)) {
                    totJmlSisaTagihan += parseFloat(unformatNumber(totalJumlahSisaTagihan));
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

                jmlSisaTagihan = Math.ceil((((jmlTagihan - jmlTelahBayar) / (totTagihan)) * (totSisaTagihan)).toFixed(2));

                $(this).parents("tr").find('input[name$="[jmlbayar]"]').val(formatInteger(jumlahBayar));
                $(this).parents("tr").find('input[name$="[jmlsisatagihan]"]').val(formatInteger(jmlSisaTagihan));
                $('#totbayar').val(formatInteger(totJmlBayar));
                // $('#totsisatagihan').val(formatInteger(totJmlSisaTagihan));

            });
        });
        $('#totbayar').val(totalBayar);
    }

    function checkAllPembayaran() {
        if ($("#checkPembayaran").is(":checked")) {
            $('#tableList input[name*="cekList"]').each(function() {
                $(this).attr('checked', true);
            })
        } else {
            $('#tableList input[name*="cekList"]').each(function() {
                $(this).removeAttr('checked');
            })
        }

        $("#tableList > tbody > tr:last .cek").maskMoney({
            "symbol": "Rp ",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ".",
            "thousands": ",",
            "precision": 0
        });
        setAll();
    }

    function updateRekening() {
        //    setTimeout(function(){//karna form rekening butuh waktu ketika ajax request nya        
        var saldo = unformatNumber($('#KUPembayaranklaimT_totalbayar').val());
        updateRekeningPembayaranKlaim(saldo);
        //    },1500);
    }
</script>

<?php
$url = Yii::app()->createUrl($this->route);
$jmltotpiutang = CHtml::activeId($modPembayaranKlaim, 'totalpiutang');
$jmltotbayar = CHtml::activeId($modPembayaranKlaim, 'totalbayar');
$jmltottelahbayar = CHtml::activeId($modPembayaranKlaim, 'telahbayar');
$jmltotsisapiutang = CHtml::activeId($modPembayaranKlaim, 'totalsisapiutang');

$js = <<< JS
    
    function setAll(obj){
    
        jmltagihan = 0;
        jmlpiutang = 0;
        jmltelahbayar = 0;
        jmlbayar = 0;
        jmlsisatagihan = 0;
    
        jmltotpiutang = 0;
        jmltotbayar = 0;
        jmltottelahbayar = 0;
        jmltotsisapiutang = 0;
    
        totaltransaksi = 0;
    
        $('.cek').each(function(){
           if ($(this).is(':checked')){
                temptagihan = unformatNumber($(this).parents('tr').find('.jmltagihan').val());
                temppiutang = unformatNumber($(this).parents('tr').find('.jmlpiutang').val());
                temptelahbayar = unformatNumber($(this).parents('tr').find('.jmltelahbayar').val());
                tempbayar = unformatNumber($(this).parents('tr').find('.jmlbayar').val());
                tempsisatagihan = unformatNumber($(this).parents('tr').find('.jmlsisatagihan').val());
    
                temptotaltransaksi = $(this).parents('tr').find('.totaltransaksi').val();
                totalbayar = parseFloat(unformatNumber($('#REClosingkasirT_nilaiclosingtrans').val()));
                saldoawal = parseFloat($('#REClosingkasirT_closingsaldoawal').val());
                totalnilaiclosing =$('#totalnilaiclosing').val();

                jmlnilaiclosing = totalbayar + saldoawal;
        
                if (jQuery.isNumeric(temptagihan)){
                    jmltagihan += parseFloat(unformatNumber(temptagihan));
                }
                if (jQuery.isNumeric(temppiutang)){
                    jmlpiutang += parseFloat(unformatNumber(temppiutang));
                }
                if (jQuery.isNumeric(temptelahbayar)){
                    jmltelahbayar += parseFloat(unformatNumber(temptelahbayar));
                }
                if (jQuery.isNumeric(tempbayar)){
                    jmlbayar += parseFloat(unformatNumber(tempbayar));
                }
                if (jQuery.isNumeric(tempsisatagihan)){
                    jmlsisatagihan += parseFloat(unformatNumber(tempsisatagihan));
                }
                 $(this).parents('tr').find('.cek').val(1);
            }else{
                $(this).parents('tr').find('.cek').val(0);
            }
        });
        
    
        $('#KUPembayaranklaimT_totalpiutang').val(formatInteger(jmlpiutang));
        $('#KUPembayaranklaimT_telahbayar').val(formatInteger(jmltelahbayar));
        $('#KUPembayaranklaimT_totalbayar').val(formatInteger(jmlbayar));
        $('#KUPembayaranklaimT_totalsisapiutang').val(formatInteger(jmlsisatagihan));
        
        $('#tottagihan').val(formatInteger(jmltagihan));
        $('#totpiutang').val(formatInteger(jmlpiutang));
        $('#tottelahbayar').val(formatInteger(jmltelahbayar));
        $('#totbayar').val(formatInteger(jmlbayar));
        $('#totsisatagihan').val(formatInteger(jmlsisatagihan));
        setTimeout(function(){//karna form rekening butuh waktu ketika ajax request nya        
            updateRekeningPembayaranKlaim(jmlbayar);
        },1000);
    
    }
           
    function hitungSisaTagihan(obj){
         $('#tableList tbody .cek').each(function(){
        
            totTagihan = unformatNumber($('#tottagihan').val());
            totPiutang = unformatNumber($('#totpiutang').val());
            totTelahBayar = unformatNumber($('#tottelahbayar').val());
            totBayar = unformatNumber($('#totbayar').val());
            totSisaTagihan = unformatNumber($('#totsisatagihan').val());
        
            jmlTagihan = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[jmltagihan]"]').val()));
            jmlPiutang = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[jmlpiutang]"]').val()));
            jmlTelahBayar = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[jmltelahbayar]"]').val()));
            jmlBayar = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[jmlbayar]"]').val()));
            jmlSisaTagihan = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[jmlsisatagihan]"]').val()));

            jumlahSisaTagihan = 0; 
            if(jmlBayar > jmlPiutang){
                jumlahSisaTagihan = 0;
            }else{
                jumlahSisaTagihan = (jmlPiutang - jmlBayar);
            }
        
            $('.cek').each(function(){
                    totalJumlahSisaTagihan = unformatNumber($(this).parents('tr').find('.jmlsisatagihan').val());

                    totalJumlahSisaTagihan = 0;
                    if (jQuery.isNumeric(totalJumlahSisaTagihan)){
                        totalJumlahSisaTagihan += parseFloat(unformatNumber(totalJumlahSisaTagihan));
                    }
            });

            $(obj).parents("tr").find('input[name$="[jmlsisatagihan]"]').val(formatInteger(jumlahSisaTagihan));            
            $(obj).parents("tr").find('input[name$="[jmlpiutang]"]').val(formatInteger(jmlPiutang));
            $(obj).parents("tr").find('input[name$="[jmlbayar]"]').val(formatInteger(jmlBayar));
            $('#totalsisatagihan').val(formatInteger(totalJumlahSisaTagihan));
        });
        setAll(this);
    }
    
    function hitungJumlahPiutang(obj){
         $('#tableList tbody .cek').each(function(){
        
            totTagihan = unformatNumber($('#tottagihan').val());
            totPiutang = unformatNumber($('#totpiutang').val());
            totTelahBayar = unformatNumber($('#tottelahbayar').val());
            totBayar = unformatNumber($('#totbayar').val());
            totSisaTagihan = unformatNumber($('#totsisatagihan').val());
        
            jmlTagihan = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[jmltagihan]"]').val()));
            jmlPiutang = unformatNumber((obj.value));
            jmlTelahBayar = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[jmltelahbayar]"]').val()));
            jmlBayar = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[jmlbayar]"]').val()));
            jmlSisaTagihan = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[jmlsisatagihan]"]').val()));
    
            $('.cek').each(function(){
    
                    jumlahSisaTagihan = 0; 
                    if(jmlBayar > jmlPiutang){
                        jumlahSisaTagihan = 0;
                    }else{
                        jumlahSisaTagihan = (jmlPiutang - jmlBayar);
                    }

                    totalJumlahSisaTagihan = 0;
                    if (jQuery.isNumeric(totalJumlahSisaTagihan)){
                        totalJumlahSisaTagihan += parseFloat(unformatNumber(jmlSisaTagihan));
                    }
            });

            $(obj).parents("tr").find('input[name$="[jmlsisatagihan]"]').val(formatInteger(jumlahSisaTagihan));
            $(obj).parents("tr").find('input[name$="[jmlpiutang]"]').val(formatInteger(jmlPiutang));
            $('#totalsisatagihan').val(formatInteger(totalJumlahSisaTagihan));
        });
        setAll(this);
    }
    
    function hitungJumlahTelahBayar(obj){
        $('#tableList tbody .cek').each(function(){
    
            totTagihan = unformatNumber($('#tottagihan').val());
            totPiutang = unformatNumber($('#totpiutang').val());
            totTelahBayar = unformatNumber($('#tottelahbayar').val());
            totBayar = unformatNumber($('#totbayar').val());
            totSisaTagihan = unformatNumber($('#totsisatagihan').val());
        
            jmlTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltagihan]"]').val()));
            jmlPiutang = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlpiutang]"]').val()));
            jmlPiutang2 = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlpiutang2]"]').val()));
            jmlTelahBayar = (obj.value);
            jmlBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlbayar]"]').val()));
            jmlSisaTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlsisatagihan]"]').val()));

            jumlahSisaTagihan = 0; 
            if(jmlTelahBayar > jmlPiutang){
    //                jumlahSisaTagihan = (jmlBayar - (jmlPiutang2 - jmlTelahBayar));
                     // jumlahPiutang = (jmlPiutang2 - jmlTelahBayar);
                  jumlahSisaTagihan = 0;
                  jumlahPiutang = 0;
            }else{
                jumlahSisaTagihan2 = ((jmlPiutang2 - jmlTelahBayar) - jmlBayar);
                jumlahSisaTagihan = (jumlahSisaTagihan2 < 0 ? 0 : jumlahSisaTagihan2);
                jumlahPiutang = (jmlPiutang2 - jmlTelahBayar);
            }
        
            $('.cek').each(function(){
                    totalJumlahSisaTagihan = unformatNumber($(this).parents('tr').find('.jmlsisatagihan').val());
                    totalJumlahPiutang = unformatNumber($(this).parents('tr').find('.jmlpiutang').val());

                    totalJumlahSisaTagihan = 0;
                    if (jQuery.isNumeric(totalJumlahSisaTagihan)){
                        totalJumlahSisaTagihan += parseFloat(unformatNumber(totalJumlahSisaTagihan));
                    }
            });
                $(this).parents("tr").find('input[name$="[jmlsisatagihan]"]').val(jumlahSisaTagihan);
                $('#totalsisatagihan').val(formatInteger(totalJumlahSisaTagihan));

        });
        setAll(this);
    }
      
        
    function ajaxGetList(){
        tglAwal = $('#Filter_tgl_awal').val();
        tglAkhir = $('#Filter_tgl_akhir').val();
        bankkartu = $('#KUTandabuktibayarT_bankkartu').val();    
        carabayar_id = $('#KUTandabuktibayarT_carabayar_id').val();
        penjamin_id = $('#KUTandabuktibayarT_penjamin_id').val();    
		
		if(carabayar_id == '' || penjamin_id == ''){
			myAlert('Isi Data Jenis Penjamin dan Penjamin');
		}else{
			$('#tableList').addClass('animation-loading');
			$.get('${url}', {tgl_awal:tglAwal, tgl_akhir:tglAkhir, bankkartu:bankkartu, carabayar_id:carabayar_id, penjamin_id:penjamin_id,},function(data){
				$('#tableList tbody').html(data);
				$('#tableList').removeClass('animation-loading');
			});
			setTimeout(function(){checkAllPembayaran();}, 1000);
		}
    }
    
    function hitungSemuaTransaksi(){
        $('.cek').each(function(){
                    jmltagihan = unformatNumber($(this).parents('tr').find('.jmltagihan').val());
                    jmlpiutang = unformatNumber($(this).parents('tr').find('.jmlpiutang').val());
                    jmlpiutang = unformatNumber($(this).parents('tr').find('.jmltelahbayar').val());
                    jmlpiutang = unformatNumber($(this).parents('tr').find('.jmlbayar').val());
                    jmlpiutang = unformatNumber($(this).parents('tr').find('.jmlsisatagihan').val());

                    if(jmltagihan == ''){
                        jmltagihan = 0;
                    }
                    if(jmlpiutang == ''){
                        jmlpiutang = 0;
                    }
                    if(jmltelahbayar == ''){
                        jmltelahbayar = 0;
                    }
                    if(jmlbayar == ''){
                        jmlbayar = 0;
                    }
                    if(jmlsisatagihan == ''){
                        jmlsisatagihan = 0;
                    }
                    
                    $(this).parents('tr').find('.jmltagihan').val(jmltagihan);
                    $(this).parents('tr').find('.jmlpiutang').val(jmlpiutang);
                    $(this).parents('tr').find('.jmltelahbayar').val(jmltelahbayar);
                    $(this).parents('tr').find('.jmlbayar').val(jmlbayar);
                    $(this).parents('tr').find('.jmlsisatagihan').val(jmlsisatagihan);
        });
    }
    
    function hitungTelahBayar(){
    
    }
    
    function hitungTotalSisaTagihan(){
    
    }
    
    function hitungTotalPiutang(){
    
        var jmlbayar = unformatNumber($('#KUPembayaranklaimT_totalbayar').val());
        setTimeout(function(){//karna form rekening butuh waktu ketika ajax request nya        
            updateRekeningPembayaranKlaim(jmlbayar);
        },1500);
    }
    
    function updateRekeningPembayaranKlaim(saldo){
        $("#tableList > tbody > tr").each(function(){
            saldoTotal = saldo;
            if($(this).find('input[name$="[saldonormal]"]').val() == "D"){
                $(this).find('input[name$="[saldodebit]"]').val(saldoTotal);
            }else{
                $(this).find('input[name$="[saldokredit]"]').val(saldoTotal);
            }
        });
    }
    function cekInput()
    {
        $(".currency").each(function(){this.value = unformatNumber(this.value)});
        return true;
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
</div>