<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Batal Pengeluaran Umum</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Batal Keluar Umum',
        ); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'batalbayarsupplier-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                // 'onsubmit'=>'return cekOtorisasi();'
                'onsubmit' => 'return cekValidasi(this);'
            ),
            'focus' => '#' . CHtml::activeId($modPengeluaran, 'nopengeluaran'),
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengeluaran Umum</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_infoPengeluaran', array('form' => $form, 'modPengeluaran' => $modPengeluaran)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pembatalan
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php $modBatalBayar->tglbatalkeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBatalBayar->tglbatalkeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                            <?php echo $form->labelEx($modBatalBayar, 'tglbatalkeluar', array('class' => 'control-label')) ?>
                            <div class="controls">
                            <?php   
											// echo $form->textField($modBatalBayar, 'tglbatalkeluar', array('class'=>'realtime'));
											$this->widget('MyDateTimePicker',array(
															'model'=>$modBatalBayar,
															'attribute'=>'tglbatalkeluar',
															'mode'=>'datetime',
															'options'=> array(
																'dateFormat'=>Params::DATE_FORMAT,
																'maxDate' => 'd',
															),
															'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true,
															),
											)); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textAreaRow($modBatalBayar, 'alasanbatalkeluar', array('placeholder' => 'Alasan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::activeHiddenField($modBatalBayar, 'user_id_otorisasi', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modBatalBayar, 'user_name_otoritasi', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modBatalBayar, 'tandabuktikeluar_id', array('class' => 'span3', 'readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($modBatalBayar, 'pengeluaranumum_id', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->renderPartial($this->path_view . '_formPenerimaanKas', array('form' => $form, 'modPengeluaran' => $modPengeluaran, 'modTandabukti' => $modTandabukti, 'modPenUmum' => $modPenUmum), true); ?>
        <?php //echo $form->errorSummary(array($modBatalBayar)); 
        ?>
        <div class="form-actions">
            <?php
            if ($modBatalBayar->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
                );
            }
            // TIDAK ADA FUNGSINYA >>> echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false)); 

            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array('title' => 'Ulang', 'disabled' => false, 'class' => 'btn btn-default')
            );

            $content = $this->renderPartial($this->path_view . 'tips', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
//    $('.integer2').each(function() {
//        this.value = formatNumber(this.value)
//    });

    function cekLogin() {
        $.post('<?php echo $this->createUrl('CekLogin', array('task' => 'Retur')); ?>', $('#formLogin').serialize(), function(data) {
            if (data.error != '')
                myAlert(data.error);
            $('#' + data.cssError).addClass('error');
            if (data.status == 'success') {
                $('#BKBatalKeluarUmumT_user_name_otoritasi').val(data.username);
                $('#BKBatalKeluarUmumT_user_id_otorisasi').val(data.userid);
                $('#loginDialog').dialog('close');
            } else {
                myAlert(data.status);
            }
        }, 'json');
    }

    function cekOtorisasi() {
        if ($('#BKBatalKeluarUmumT_user_name_otoritasi').val() == '' || $('#BKBatalKeluarUmumT_user_id_otorisasi').val() == '') {
            $('#loginDialog').dialog('open');
            return false;
        }

        $('.integer2').each(function() {
            this.value = unformatNumber(this.value)
        });
        return true;
    }

    function getDataRekening(params) {
        if (params == null) {
            params = $("#PenerimaanumumT_jenispenerimaan_id").val();
        }
        
        $("#tblInputRekening > tbody").find('tr').detach();
        $.post('<?php echo Yii::app()->createUrl('keuangan/penerimaanUmum/GetDataRekeningByJnsPenerimaan'); ?>', {
                jenispenerimaan_id: params
            },
            function(data) {
                if (data != null) {
                    $("#tblInputRekening > tbody").append(data.replace());
                    renameRowRekening();
                    setNilaiJurnal();
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
        
        getDataRekening(null);
    }
    /*
    	function hitungJmlBayar()
    	{
    		var biayaAdministrasi = 0; //unformatNumber($('#TandabuktibayarT_biayaadministrasi').val());
    		var biayaMaterai = 0; //unformatNumber($('#TandabuktibayarT_biayamaterai').val());
    		var totTagihan = unformatNumber($('#totTagihan').val());
    		var jmlPembulatan = unformatNumber($('#TandabuktibayarT_jmlpembulatan').val());
    		totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai;
    		$('#TandabuktibayarT_jmlpembayaran').val(formatNumber(totBayar));
    		$('#TandabuktibayarT_uangditerima').val(formatNumber(totBayar));
    		hitungKembalian();
    	}
        */

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

        var nilai = parseFloat(unformatNumber($("#TandabuktibayarT_jmlpembayaran").val()));
        var saldodebit = 0;
        var saldokredit = 0;

        if ($("#tblInputRekening tbody tr").length > 0) {
            $("#tblInputRekening .saldodebit").each(function() {
                saldodebit += parseFloat(unformatNumber($(this).val()));
            });
            $("#tblInputRekening .saldokredit").each(function() {
                saldokredit += parseFloat(unformatNumber($(this).val()));
            });

            if (saldodebit != saldokredit) {
                myAlert("Saldo debit dan kredit pada Rekening tidak sama.");
                return false;
            }

            if (saldodebit != nilai) {
                myAlert("Saldo rekening dengan Jumlah Penerimaan tidak sama");
                return false;
            }
        }
        // console.log("OK");

        // return false;
        return requiredCheck(obj);
    }

    $(document).ready(function() {
        <?php
        if (isset($modBatalBayar->batalkeluarumum_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_KEUANGAN ?>,
                judulnotifikasi: 'Pembatalan Pengeluaran Umum ',
                isinotifikasi: 'Telah dilakukan pembatalan pengeluaran umum dengan <?php echo $modPengeluaran->nopengeluaran ?> pada <?php echo $modBatalBayar->tglbatalkeluar ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    })
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
					$(\"#PenerimaanumumT_jenispenerimaan_id\").val(\"$data->jenispenerimaan_id\");
					$(\"#PenerimaanumumT_jenisKodeNama\").val(\"$data->jenispenerimaan_nama\");
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