<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->breadcrumbs = array(
    'Retur Penerimaan Umum',
); ?>
<?php
/*
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.integer2',
    'integer2'=>'PHP',
    'config'=>array(
//        'showSymbol'=>true,
//        'symbolStay'=>true,
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>',',
        'thousands'=>'.',
        'precision'=>0,
    )
));
 * 
 */
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'returpenerimaanumum-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return cekOtorisasi(this);'
    ),
)); ?>
<br>
<?php $this->renderPartial('_infoBuktiBayar', array('modBuktiBayar' => $modBuktiBayar)) ?>

<?php echo $form->errorSummary(array($modRetur, $modBuktiKeluar)) ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <tr>
                <td><?php echo CHtml::activeLabel($modPenerimaan, 'tglpenerimaan', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('KUPenerimaanUmumT[tglpenerimaan]', $modPenerimaan->tglpenerimaan, array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPenerimaan, 'nopenerimaan', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('KUPenerimaanUmumT[nopenerimaan]', $modPenerimaan->nopenerimaan, array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPenerimaan, 'kelompoktransaksi', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('KUPenerimaanUmumT[kelompoktransaksi]', $modPenerimaan->kelompoktransaksi, array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPenerimaan, 'hargasatuan', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('KUPenerimaanUmumT[hargasatuan]', $modPenerimaan->hargasatuan, array('class' => 'integer2', 'readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPenerimaan, 'namapenandatangan', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('KUPenerimaanUmumT[namapenandatangan]', $modPenerimaan->namapenandatangan, array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPenerimaan, 'totalharga', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('KUPenerimaanUmumT[totalharga]', $modPenerimaan->totalharga, array('class' => 'integer2', 'readonly' => true)); ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Retur</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php echo $this->renderPartial('_rowListRekening', array('form' => $form, 'modPengUmum' => $modPengUmum), true); ?>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php $modRetur->tglreturumum = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modRetur->tglreturumum, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                    <?php echo $form->labelEx($modRetur, 'tglreturumum', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modRetur, 'tglreturumum', array('class' => 'span3 realtime', 'readonly' => true));
                        /*
                            $this->widget('MyDateTimePicker',array(
                                        'model'=>$modRetur,
                                        'attribute'=>'tglreturumum',
                                        'mode'=>'datetime',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                    ));
                     *  
                     */
                        ?>

                    </div>
                </div>
                <?php echo $form->textAreaRow($modRetur, 'alasanreturumum', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($modBuktiKeluar, 'biayaadministrasi', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);", "readonly" => true)); ?>
                <?php echo CHtml::activeHiddenField($modRetur, 'user_name_otoritasi', array('class' => 'span3', 'readonly' => true)); ?>
                <?php echo CHtml::activeHiddenField($modRetur, 'user_id_otorisasi', array('class' => 'span3', 'readonly' => true)); ?>
                <?php echo CHtml::activeHiddenField($modRetur, 'penerimaanumum_id', array('class' => 'span3', 'readonly' => true)); ?>
                <?php echo CHtml::activeHiddenField($modRetur, 'tandabuktibayar_id', array('class' => 'span3', 'readonly' => true)); ?>
                <?php echo $form->dropDownListRow($modBuktiKeluar, 'tahun', CustomFunction::getTahun(null, null), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)); ?>
                <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <div id="divCaraBayarTransfer" class="hide">
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'melalubank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $modRetur->returpenerimaanumum_id)
    );
    //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false)); 
    ?>
</div>
<?php $this->endWidget(); ?>



<script>
    // $('.integer2').each(function(){this.value = formatNumber(this.value)});

    $(document).ready(function() {
        $("form").find('.integer2').each(function() {
            $(this).val(formatNumber($(this).val()));
        });
    });

    function cekLogin() {
        $.post('<?php echo $this->createUrl('CekLogin', array('task' => 'Retur')); ?>', $('#formLogin').serialize(), function(data) {
            if (data.error != '')
                myAlert(data.error);
            $('#' + data.cssError).addClass('error');
            if (data.status == 'success') {
                $('#KUReturPenerimaanUmumT_user_name_otoritasi').val(data.username);
                $('#KUReturPenerimaanUmumT_user_id_otorisasi').val(data.userid);
                $('#loginDialog').dialog('close');
                myAlert("Anda berhasil Login!");
            } else {
                myAlert("Anda gagal Login!");
            }
        }, 'json');
    }

    function cekOtorisasi(obj) {
        // return false;


        if (!cekValidasi(obj)) return false;

        // if($('#KUReturPenerimaanUmumT_user_name_otoritasi').val() == '' || $('#KUReturPenerimaanUmumT_user_id_otorisasi').val() == ''){
        //    $('#loginDialog').dialog('open');
        //    return false;
        // } 
        /*
	$(".integer2").each(function(){
		$(this).val(parseInt(unformatNumber($(this).val())));
	});
    */

        return requiredCheck(obj);
    }

    function formCarabayar(carabayar) {
        if (carabayar == 'TRANSFER') {
            $('#divCaraBayarTransfer').slideDown();
        } else {
            $('#divCaraBayarTransfer').slideUp();
            $('#divCaraBayarTransfer input').each(function() {
                $(this).val('')
            });
        }
    }

    function hitungJmlKeluar() {
        var biayaAdmin = unformatNumber($('#KUTandabuktikeluarT_biayaadministrasi').val());
        var jmlKeluar = unformatNumber($('#KUTandabuktikeluarT_jmlkaskeluar').val());

        $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatNumber(biayaAdmin + jmlKeluar));
    }


    function getDataRekening(params) {
        $("#tblInputRekening > tbody").find('tr').detach();
        $.post('<?php echo Yii::app()->createUrl('/keuangan/pengeluaranUmum/GetDataRekeningByJnsPengeluaran'); ?>', {
                jenispengeluaran_id: params
            },
            function(data) {
                if (data != null) {
                    $("#tblInputRekening > tbody").append(data.replace());
                    renameRowRekening();
                    // hitungTotalHarga();
                }
            }, "json");
    }

    function setNilaiJurnal() {
        var nilai = parseFloat(unformatNumber($("#TandabuktibayarT_jmlpembayaran").val()));

        $("#tblInputRekening .saldodebit, #tblInputRekening .saldokredit").val(formatNumber(nilai));
    }

    function renameRowRekening() {
        var idx = 0;
        $("#tblInputRekening > tbody").find('tr').each(
            function() {
                unMaskMoneyInput(this);
                maskMoneyInput(this);
                $(this).find('input').each(
                    function() {

                        var name_field = $(this).attr('name');
                        var id_field = $(this).attr('id');
                        $(this).attr('name', name_field.replace('99', idx));
                        $(this).attr('id', id_field.replace('99', idx));

                    }
                );
                idx++;
            }
        );
    }

    function removeDataRekening(obj) {
        $(obj).parent().parent('tr').detach();
    }

    function maskMoneyInput(tr) {
        $(tr).find('input.integer2:text').maskMoney({
            "symbol": "Rp",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": ".",
            "precision": 0
        });
    }

    function unMaskMoneyInput(tr) {
        $(tr).find('input.integer2:text').unmaskMoney();
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

    function hitungJmlBayar() {
        var biayaAdministrasi = unformatNumber($('#TandabuktibayarT_biayaadministrasi').val());
        var biayaMaterai = unformatNumber($('#TandabuktibayarT_biayamaterai').val());
        var totTagihan = unformatNumber($('#totTagihan').val());
        var jmlPembulatan = unformatNumber($('#TandabuktibayarT_jmlpembulatan').val());
        totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai;
        $('#TandabuktibayarT_jmlpembayaran').val(formatNumber(totBayar));
        $('#TandabuktibayarT_uangditerima').val(formatNumber(totBayar));
        hitungKembalian();
    }

    function hitungKembalian() {
        var jmlBayar = unformatNumber($('#TandabuktibayarT_jmlpembayaran').val());
        var uangDiterima = unformatNumber($('#TandabuktibayarT_uangditerima').val());
        var uangKembalian = uangDiterima - jmlBayar;
        if (uangKembalian < 0) {
            uangKembalian = 0;
        }
        $('#TandabuktibayarT_uangkembalian').val(formatNumber(uangKembalian));

    }



    function cekValidasi(obj) {
        var total_keluar = parseFloat(unformatNumber($("#KUTandabuktikeluarT_jmlkaskeluar").val()));
        var saldodebit = 0;
        var saldokredit = 0;



        $(".saldodebit").each(function() {
            saldodebit += parseFloat(unformatNumber($(this).val()));
        });
        $(".saldokredit").each(function() {
            saldokredit += parseFloat(unformatNumber($(this).val()));
        });

        console.log(total_keluar, saldodebit, saldokredit);

        if (saldodebit == 0 && saldokredit == 0 && $("#tblInputRekening tbody tr").length == 0) return true;

        if (saldodebit - saldokredit != 0) {
            myAlert("Maaf, saldo rekening debit dan kredit tidak sama.");
            return false;
        }

        if (saldodebit != total_keluar) {
            myAlert("Maaf, saldo rekening dengan total kas keluar tidak sama.");
            return false;
        }

        return true;
    }
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'loginDialog',
    'options' => array(
        'title' => 'Login',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 190,
        'resizable' => false,
    ),
)); ?>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'formLogin')); ?>
<div class="control-group">
    <?php echo CHtml::label('Login Pemakai', 'username', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('username', '', array()); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Password', 'password', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::passwordField('password', '', array()); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'cekLogin();return false;')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), '#', array('class' => 'btn btn-default', 'onclick' => "$('#loginDialog').dialog('close');return false", 'disabled' => false)); ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisPenerimaan',
    'options' => array(
        'title' => 'Daftar Jenis Penerimaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));

$modJenisPenerimaan = new JenispenerimaanM();
$modJenisPenerimaan->unsetAttributes();
if (isset($_GET['JenispenerimaanM'])) {
    $modJenisPenerimaan->attributes = $_GET['JenispenerimaanM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'jenispenerimaan-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modJenisPenerimaan->searchJenisPenerimaanRek(),
    'filter' => $modJenisPenerimaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
        ),
        array(
            'header' => 'Jenis Penerimaan',
            'name' => 'jenispenerimaan_nama',
            'value' => '$data->jenispenerimaan_nama',
        ),
        array(
            'header' => 'Nama Lain',
            'name' => 'jenispenerimaan_namalain',
            'value' => '$data->jenispenerimaan_namalain',
        ),
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					getDataRekening($data->jenispenerimaan_id);
					$(\"#KUPenerimaanUmumT_jenispenerimaan_id\").val(\"$data->jenispenerimaan_id\");
					$(\"#KUPenerimaanUmumT_jenisKodeNama\").val(\"$data->jenispenerimaan_nama\");
					$(\"#dialogJenisPenerimaan\").dialog(\"close\");    
					return false;
			"))',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>