<style type="text/css">
  .integer-decimal, .float2, .integer2{
    text-align: right;
  }
</style>
<div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Transaksi Pembayaran Piutang Perorangan (Angsuran)</div>
        </div>
            <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
        'Bayar Angsuran',
    );?>
    <?php
    $this->widget('application.extensions.moneymask.MMask',array(
        'element'=>'.currency',
        'currency'=>'PHP',
        'config'=>array(
            'symbol'=>'Rp. ',
    //        'showSymbol'=>true,
    //        'symbolStay'=>true,
            'defaultZero'=>true,
            'allowZero'=>true,
            'decimal'=>',',
            'thousands'=>'.',
            'precision'=>0,
        )
    ));

    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan !");
    }
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'bayarangsuranpelayanan-t-form',
        'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#BKBayarAngsuranPelayananT_jmlbayarangsuran',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event)',
                'onSubmit'=>'return cekAngsuran();'
            ),
    )); ?>

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Pembayaran</div>
            </div>
            <div class="panel-body">

                <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

                    <?php echo $form->errorSummary($modAngsuran); ?>

                    <?php echo $form->hiddenField($modAngsuran,'tandabuktibayar_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->hiddenField($modAngsuran,'pembayaranpelayanan_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($modAngsuran,'tglbayarangsuran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                <div class="col-sm-6">

                    <?php echo $form->textFieldRow($modAngsuran,'bayarke',array('readonly'=>true,'class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Total Tagihan','totTagihan', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php echo CHtml::textField('totTagihan',$modPembayaran->totalbiayapelayanan,array('readonly'=>true,'class'=>'integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jumlah Yang Sudah Dibayarkan','jmltelahbayar', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modAngsuran, 'jmltelahbayar',array('readonly'=>true,'class'=>'integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Total Sisa Tagihan','totsisatagihan', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php echo CHtml::textField('totsisatagihan',$modPembayaran->totalsisatagihan,array('readonly'=>true,'class'=>'integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modAngsuran,'jmlbayarangsuran',array('class'=>'inputFormTabel span3 integer-decimal', 'onkeyup'=>'hitungSisaAngsuran();', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Sisa Angsuran','sisaangsuran', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modAngsuran, 'sisaangsuran',array('readonly'=>true,'class'=>'integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        </div>
                    </div>
                    <?php //echo $form->hiddenField($modAngsuran,'sisaangsuran',array('readonly'=>true,'class'=>'inputFormTabel span3 integer-decimal', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo CHtml::hiddenField('sisaangsuran', $modAngsuran->sisaangsuran,array('readonly'=>true)); ?>


                    <div hidden>
                    <div class="control-group ">
                        <?php echo CHtml::label('Deposit','deposit', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php echo CHtml::textField('deposit',isset($totDeposit)?$totDeposit:null,array('readonly'=>true,'class'=>'integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Total Pembebasan','totPembebasan', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php echo CHtml::textField('totPembebasan',isset($totPembebasanTarif)?$totPembebasanTarif:null,array('readonly'=>true,'class'=>'integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        </div>
                    </div>
                    </div>
                    <?php echo $form->textFieldRow($modTandaBukti,'biayaadministrasi',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'biayamaterai',array('onkeyup'=>'hitungJmlBayar();','class'=>'inputFormTabel integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'jmlpembayaran',array('onkeyup'=>'hitungKembalian();','readonly'=>true,'class'=>'inputFormTabel integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'jmlpembulatan',array('readonly'=>true,'class'=>'inputFormTabel integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'uangditerima',array('class'=>'inputFormTabel integer-decimal span3', 'onblur'=>'hitungKembalian(); cekKembalian();', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'uangkembalian',array('readonly'=>true,'class'=>'inputFormTabel integer-decimal span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($modTandaBukti,'darinama_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textAreaRow($modTandaBukti,'alamat_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'sebagaipembayaran_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>

                    <div class="control-group ">
                        <?php $modAngsuran->tglbayarangsuran = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modAngsuran->tglbayarangsuran, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                        <?php echo $form->labelEx($modAngsuran,'tglbayarangsuran', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modAngsuran,
                                                    'attribute'=>'tglbayarangsuran',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>

                        </div>
                    </div>

                    <div class="control-group ">
                        <?php $modTandaBukti->tglbuktibayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modTandaBukti->tglbuktibayar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                        <?php echo $form->labelEx($modTandaBukti,'tglbuktibayar', array('class'=>'control-label inline','label'=>'Tanggal Bukti Kas Masuk')) ?>
                        <div class="controls">
                            <?php
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modTandaBukti,
                                                    'attribute'=>'tglbuktibayar',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>

                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($modTandaBukti,'tglbuktibayar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->hiddenField($modTandaBukti,'carapembayaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->hiddenField($modTandaBukti,'is_menggunakankartu',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>

                    <?php echo $form->dropDownListRow($modTandaBukti,'carapembayaran',  LookupM::getItems('carapembayaran'),array('readonly'=>true,'disabled'=>true,'onchange'=>'ubahCaraPembayaran(this)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php //echo $form->dropDownListRow($modTandaBukti,'carapembayaran',  LookupM::getItems('carapembayaran'),array('onchange'=>'ubahCaraPembayaran(this)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <div class="control-group ">
                        <?php echo CHtml::label('Pembayaran Non Tunai','pakeKartu', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php echo CHtml::checkBox('pakeKartu',false,array('onchange'=>"enableInputKartu();", 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        </div>
                    </div>
                    <div id="divDenganKartu" hidden>
                    <div class="col-sm-12">

                    </div>
                    <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">Berdasarkan Jenis Pembayaran</div>
                            </div>
                            <div class="panel-body">
                                <div style="overflow: auto;">
                                <?php
                                echo $this->renderPartial($this->path_view.'_formBayarBank',array(
                                    'form'=>$form,
                                    'modTandaBukti'=>$modTandaBukti,
                                ),true);

                                ?>
                                </div>
                            </div>
                        </div>
                        <!-- <?php// echo $form->dropDownListRow($modTandaBukti,'dengankartu',  LookupM::getItems('dengankartu'),array('onchange'=>'enableInputKartu()','empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php// echo $form->dropDownListRow($modTandaBukti,'bankkartu', LookupM::getItems('bank'), array('empty'=>'-- Pilih --','readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>

                        <div class="control-group">
                            <?php //echo CHtml::activeLabel($modTandaBukti, 'nokartu', array('class' => 'control-label required', 'required' => true)); ?>
                            <div class="controls">
                                <?php //echo $form->textField($modTandaBukti,'nokartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php //echo CHtml::activeLabel($modTandaBukti, 'nostrukkartu', array('class' => 'control-label required', 'required' => true)); ?>
                            <div class="controls">
                                <?php //echo $form->textField($modTandaBukti,'nostrukkartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php //echo CHtml::activeLabel($modTandaBukti, 'bank_nominal', array('class' => 'control-label required', 'required' => true, 'label'=>'Nominal')); ?>
                            <div class="controls">
                                <?php //echo $form->textField($modTandaBukti, 'bank_nominal', array('required' => true, 'class' => 'span2 integer2', 'onblur'=>'cekBayarBank(); hitungKembalian();', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php //echo CHtml::activeLabel($modTandaBukti, 'bank_id', array('class' => 'control-label', 'required' => true, 'label'=>'Bank Penerima')); ?>
                            <div class="controls">
                            <?php

                            // $bank_data = BankM::model()->findAll('bank_aktif = true order by namabank');
                            //
                            // $list_bank = CHtml::listData($bank_data, 'bank_id', 'bankNoRekening');
                            // $option_bank = array();
                            //
                            // foreach ($bank_data as $item) {
                            //     $rekening = BankrekM::model()->findByAttributes(array(
                            //         'bank_id'=>$item->bank_id,
                            //         'saldonormal'=>'D',
                            //     ));
                            //
                            //     $option_bank[$item->bank_id] = array(
                            //         'data-rekening'=>'',
                            //     );
                            //
                            //     if (!empty($rekening)) {
                            //         $rek5 = Rekening5M::model()->findByPk($rekening->rekening5_id);
                            //         $option_bank[$item->bank_id]['data-rekening'] = $rek5->kdrekening5." - ".$rek5->nmrekening5;
                            //     }
                            //
                            //
                            // }
                            //
                            // echo $form->dropDownList($modTandaBukti, 'bank_id', $list_bank,
                            //         array('required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",
                            //             'onchange'=>'setKodeAkunBank()',
                                      //  'options'=>$option_bank)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php //echo CHtml::label("Kode Akun", '', array('class' => 'control-label', 'required' => true, 'label'=>'Nominal')); ?>
                            <div class="controls">
                                <?php ///echo CHtml::textField('kode_akun_bank', '', array(
                                    //'id'=>'kode_akun_bank', 'class'=>'span4', 'readonly'=>true,
                               /// )); ?>
                            </div>
                        </div> -->
                    </div>
                    <hr/>
                    </div>
            </div>
        </div>

        <div class="form-actions">
                <?php
                    echo CHtml::htmlButton(
                        $modAngsuran->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array(
                            'class'=>'btn btn-primary submit',
                            'type'=>'submit',
                            'onKeypress'=>'return formSubmit(this,event)',
                        )
                    );


                    if (isset($_GET['sukses']) && $_GET['sukses'] == 1) {

                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printKuitansi(); return false;",'disabled'=>false  ));
                    } else {
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"return false;",'disabled'=>true  ));
                    }

                ?>
                <?php
                $content = $this->renderPartial('tips/transaksi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                ?>
        </div>
            </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">

<?php if (isset($_GET['idAngsuran'])):

    $bayar = BayarangsuranpelayananT::model()->findByPk($_GET['idAngsuran']);

    ?>

function printKuitansi()
{
    var bayarangsuranpelayanan_id = "<?php echo $bayar->bayarangsuranpelayanan_id; ?>";
    //harusnya menggunakan controller yang sama
    window.open("<?php echo $this->createUrl('printKuitansiAngsuran') ?>&bayarangsuranpelayanan_id="+bayarangsuranpelayanan_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
}


<?php endif; ?>



$(document).ready(function(data) {
  formatNumberSemua();
    // $('.integer2').each(
    //     function()
    //     {
    //         this.value = formatNumber(this.value);
    //     }
    // );

    setValidasiCekDisabled($("#bayarangsuranpelayanan-t-form"), function() {
        if ($("#BKBayarAngsuranPelayananT_jmlbayarangsuran").val() == 0) {
            return false;
        }
        return true;
    });

    hitungSisaAngsuran();
    setKodeAkunBank();
    enableInputKartu();

});

function setKodeAkunBank() {
    var data = $("#BKTandabuktibayarT_bank_id :selected").data('rekening');
    $("#kode_akun_bank").val(data);
}


function simpanProses()
{
  $(".integer2, .float2, .integer-decimal").each(function(){
      $(this).val(unformatNumber($(this).val()));
  });
    $("#bayarangsuranpelayanan-t-form").submit();
}

function formSubmit(obj,evt)
{
     evt = (evt) ? evt : event;
     var form_id = $(obj).closest('form').attr('id');
     var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);

     if(charCode == 13)
     {
         if(cekAngsuran())
         {
            simpanProses();
         }
     }
     return false;
}

function cekAngsuran()
{
    // $('.integer2').each(
    //     function(){
    //         this.value = unformatNumber(this.value);
    //     }
    // );

    $(".integer2, .float2, .integer-decimal").each(function(){
				$(this).val(unformatNumber($(this).val()));
		});

    if($('#BKBayarAngsuranPelayananT_jmlbayarangsuran').val() == 0)
    {
        myAlert('Jumlah angsuran tidak boleh kosong !!');
        $('#BKBayarAngsuranPelayananT_jmlbayarangsuran').focus();
        return false;
    }

    return true;
}

function hitungSisaAngsuran()
{
    // var sisa = parseFloat(unformatNumber($('#sisaangsuran').val()));
    
    var angsuran = parseFloat(unformatNumber($('#<?php echo CHtml::activeId($modAngsuran,'jmlbayarangsuran'); ?>').val()));
    var sisatagihan = parseFloat(unformatNumber($('#totsisatagihan').val()));
    var totatagihan = parseFloat(unformatNumber($('#totTagihan').val()));
    var jumlahbayar = parseFloat(unformatNumber($('#<?php echo CHtml::activeId($modAngsuran, 'jmltelahbayar'); ?>').val()));
    
    var sisaAngsuran = (sisatagihan - angsuran);

    if (sisaAngsuran < 0){
        sisaAngsuran = sisatagihan;
        myAlert("Jumlah bayar angsuran tidak boleh lebih dari sisa angsuran");
        $("#<?php echo CHtml::activeId($modAngsuran, 'jmlbayarangsuran'); ?>").val(formatThousandDecimal(sisaAngsuran));
        $("#<?php echo CHtml::activeId($modTandaBukti, 'jmlpembayaran'); ?>").val(formatThousandDecimal(sisaAngsuran));
        $("#<?php echo CHtml::activeId($modTandaBukti, 'uangditerima'); ?>").val(formatThousandDecimal(sisaAngsuran));
    }
    $('#<?php echo CHtml::activeId($modAngsuran, 'sisaangsuran'); ?>').val(formatThousandDecimal(sisaAngsuran));
    $('#<?php echo CHtml::activeId($modTandaBukti, 'jmlpembayaran'); ?>').val(formatThousandDecimal(sisaAngsuran));
    hitungJmlBayar();
    cekBayarBank();
    hitungKembalian();
}

function hitungKembalian()
{
    var jmlBayar = parseFloat(unformatNumber($('#BKTandabuktibayarT_jmlpembayaran').val()));
    var jmlBulat = parseFloat(unformatNumber($('#BKTandabuktibayarT_jmlpembulatan').val()));
    var uangDiterima = parseFloat(unformatNumber($('#BKTandabuktibayarT_uangditerima').val()));
    var uangBank = parseFloat(unformatNumber($('#BKTandabuktibayarT_bank_nominal').val()));
    var uangKembalian;

    if (uangBank > jmlBayar) {
        uangBank = jmlBayar;
        $('#BKTandabuktibayarT_bank_nominal').val(formatThousandDecimal(uangBank));
    }

    uangKembalian = (uangDiterima + uangBank - jmlBulat) - jmlBayar;

    if (uangKembalian < 0) {
        uangKembalian = 0;
        uangDiterima = jmlBayar - (uangBank - jmlBulat);
    }

    $('#BKTandabuktibayarT_uangditerima').val(formatThousandDecimal(uangDiterima));
    $('#BKTandabuktibayarT_uangkembalian').val(formatThousandDecimal(uangKembalian));
}

// function cekBayarBank() {
//     var jmlBayar = unformatNumber($('#BKTandabuktibayarT_jmlpembayaran').val());
//     var jmlBulat = unformatNumber($('#BKTandabuktibayarT_jmlpembulatan').val());
//     var uangDiterima = unformatNumber($('#BKTandabuktibayarT_uangditerima').val());
//     var uangBank = unformatNumber($('#BKTandabuktibayarT_bank_nominal').val());

//     if (uangBank > jmlBayar) {
//         uangBank = jmlBayar;
//         $('#BKTandabuktibayarT_bank_nominal').val(formatNumber(uangBank));
//     }

//     uangDiterima = jmlBayar - uangBank;

//     var uangDiterimaBulat = Math.round(uangDiterima/100) * 100;
//     jmlBulat = uangDiterimaBulat - uangDiterima;
//     $('#BKTandabuktibayarT_jmlpembulatan').val(formatNumber(jmlBulat));
//     $('#BKTandabuktibayarT_uangditerima').val(formatNumber(uangDiterimaBulat));

//     console.log("UANG TERIMA", uangDiterimaBulat);
// }

function cekBayarBank(obj) {
    nominal = 0;
    pembulatan = 0;

    var jmlBayar = parseFloat(unformatNumber($('#BKTandabuktibayarT_jmlpembayaran').val()));
    var jmlBulat = parseFloat(unformatNumber($('#BKTandabuktibayarT_jmlpembulatan').val()));

    if(jmlBayar > 0){
        $('.submit').attr('disabled',false);
    }


    $(".main_nominal").each(function() {
        var nilai = parseFloat(unformatNumber($(this).val()));
        nominal += nilai;

    });
    nominal_kotor = nominal;

    if (typeof obj == "undefined" || obj == null) {
        obj = $(".row_main").not(".ada_data").find(".main_nominal").eq(0);
    }

    var nominal_obj = parseFloat(unformatNumber($(obj).val()));

    $(".main_nominal").not(obj).each(function() {
        var nilai = parseFloat(unformatNumber($(this).val()));
        nominal_non_input += nilai;
    });



    var iurbiayaBulat = jmlBayar + jmlBulat;
    //var iurbiayaBulat = iurbiaya;

    if (nominal > 0) {
        iurbiayaBulat = jmlBayar;
        pembulatan = 0;
        $("#pembulatankasir").val(formatThousandDecimal(pembulatan));
    }

    // console.log('=== pembulatan '+pembulatan);
    // console.log('=== nominal A '+nominal);
    if (nominal  > (jmlBayar + pembulatan)) {
        nominal = (jmlBayar + pembulatan) ;
    }



    // if (nominal + uangmuka > (iurbiaya + pembulatan)) {
    //     nominal = (iurbiaya + pembulatan) - uangmuka;
    // }

    if (typeof obj != "undefined" || obj != null) {
        $(obj).val(formatThousandDecimal(nominal_obj - (nominal_kotor - nominal)));
    }


    //console.log("NOMINAL BANK", nominal);

    // $("#BKTandabuktibayarT_bank_nominal").val(formatNumber(nominal));

    iurbiayaBulat -= nominal;


//    var tot_inacbg_semua = parseInt(unformatNumber($("#form-rinciansemua #tot_inacbg").val()));
//    if(tot_inacbg_semua > 0){
//        iurbiaya = iurbiaya - tot_inacbg_semua;
//    }
    //$("#pembulatankasir").val(formatNumber(pembulatan));
    $("#BKTandabuktibayarT_uangditerima").val(formatThousandDecimal(iurbiayaBulat));
}

function hitungJmlBayar()
{
    var biayaAdministrasi = parseFloat(unformatNumber($('#BKTandabuktibayarT_biayaadministrasi').val()));
    var biayaMaterai = parseFloat(unformatNumber($('#BKTandabuktibayarT_biayamaterai').val()));
    var deposit = parseFloat(unformatNumber($('#deposit').val()));
    var totPembebasan = parseFloat(unformatNumber($('#totPembebasan').val()));
    var totDiscountTind = parseFloat(unformatNumber($('#totaldiscount_tindakan').val()));
    var totBayar = 0;
    var totTagihan = parseFloat(unformatNumber($('#BKBayarAngsuranPelayananT_jmlbayarangsuran').val()));
    var jmlPembulatan = parseFloat(unformatNumber($('#BKTandabuktibayarT_jmlpembulatan').val()));
    var jmlPembayaran = parseFloat(unformatNumber($('#BKTandabuktibayarT_jmlpembayaran').val()));

    // totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai - totDiscountTind - totPembebasan - deposit;
    totBayar = totTagihan + biayaAdministrasi + biayaMaterai;

    var totBayarRound = Math.round(totBayar/100) * 100;
    jmlPembulatan = totBayarRound - totBayar;

    $('#BKTandabuktibayarT_jmlpembulatan').val(formatThousandDecimal(jmlPembulatan));

    $('#BKTandabuktibayarT_jmlpembayaran').val(formatThousandDecimal(totBayar));
    $('#BKTandabuktibayarT_uangditerima').val(formatThousandDecimal(totBayarRound));
    hitungKembalian();
}

function enableInputKartu()
{
    if($('#pakeKartu').is(':checked'))
        $('#divDenganKartu').show();


    else {
        $('#divDenganKartu').hide();
        $('#BKTandabuktibayarT_dengankartu').val('');
        $('#BKTandabuktibayarT_bankkartu').val('');
        $('#BKTandabuktibayarT_nokartu').val('');
        $('#BKTandabuktibayarT_nostrukkartu').val('');
        $('#BKTandabuktibayarT_bank_id').val('');
        $('#BKTandabuktibayarT_bank_nominal').val('');
    }
    if($('#BKTandabuktibayarT_dengankartu').val() != ''){
        //myAlert('isi');
        $('#BKTandabuktibayarT_is_menggunakankartu').val(1);
        $('#BKTandabuktibayarT_bankkartu').removeAttr('readonly');
        $('#BKTandabuktibayarT_nokartu').removeAttr('readonly');
        $('#BKTandabuktibayarT_nostrukkartu').removeAttr('readonly');
        $('#BKTandabuktibayarT_bank_id').removeAttr('readonly');
        $('#BKTandabuktibayarT_bank_id').attr('disabled',false);
        $('#BKTandabuktibayarT_bank_nominal').attr('disabled',false);
        $('#BKTandabuktibayarT_nokartu').attr('disabled',false);
        $('#BKTandabuktibayarT_nostrukkartu').attr('disabled',false);
    } else {
        //myAlert('kosong');
        $('#BKTandabuktibayarT_bankkartu').attr('readonly','readonly');
        $('#BKTandabuktibayarT_nokartu').attr('readonly','readonly');
        $('#BKTandabuktibayarT_nostrukkartu').attr('readonly','readonly');
        $('#BKTandabuktibayarT_bank_id').attr('readonly','readonly');
        $('#BKTandabuktibayarT_bank_id').attr('disabled',true);
        $('#BKTandabuktibayarT_bank_nominal').attr('disabled',true);
        $('#BKTandabuktibayarT_nokartu').attr('disabled',true);
        $('#BKTandabuktibayarT_nostrukkartu').attr('disabled',true);

        $('#BKTandabuktibayarT_bankkartu').val('');
        $('#BKTandabuktibayarT_nokartu').val('');
        $('#BKTandabuktibayarT_nostrukkartu').val('');
        $('#BKTandabuktibayarT_bank_id').val('');
        $('#BKTandabuktibayarT_bank_nominal').val('');
        cekBayarBank();
    }
    cekDisabled();
}

function ubahCaraPembayaran(obj)
{
    if(obj.value == 'CICILAN'){
        $('#BKTandabuktibayarT_jmlpembayaran').attr('readonly', true);
    } else {
        $('#BKTandabuktibayarT_jmlpembayaran').attr('readonly', true);
        hitungJmlBayar();
    }

    if(obj.value == 'TUNAI'){
        hitungJmlBayar();
    }
}

function cekKembalian(){

}
</script>
