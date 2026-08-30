<style>
    .integerFloat {
        text-align: right;
    }

    .tdOdd {
        background-color: #f8f8f8;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<!--div class="white-container"-->
<div class="row">
    <?php
    $this->breadcrumbs = array(
        'Jurnal',
    );
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');

    $menu_label = array(
        'jurnalPenjualan' => 'Jurnal Penjualan',
        'jurnalPelayanan' => 'Jurnal Piutang',
        'jurnalPengeluaranKas' => 'Jurnal Pengeluaran Kas',
        'jurnalPenerimaanKas' => 'Jurnal Penerimaan Kas',
        'jurnalPembelian' => 'Jurnal Utang',
        'jurnalPersediaan' => 'Jurnal Persediaan',
    );

    $menu_nama = empty($menu_label[Yii::app()->controller->id]) ? "Jurnal Umum" : $menu_label[Yii::app()->controller->id];


    ?>
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Posting <?php echo $menu_nama; ?></b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-search"></i> Pencarian
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->renderPartial($path_view . '__formSearch', array('model' => $model));
                        ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Jurnal Rekening</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <div class="col-sm-12" id="progress_jurnal" hidden>
                            <div class="progress progress-stripped active">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;" id="progress_jurnal_bar">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <?php
                        $form = $this->beginWidget(
                            'ext.bootstrap.widgets.BootActiveForm',
                            array(
                                'id' => 'form-grid-jurnal-rek',
                                'enableAjaxValidation' => false,
                                'type' => 'horizontal',
                                'htmlOptions' => array(
                                    'onKeyPress' => 'return disableKeyPress(event)'
                                ),
                                'focus' => '#',
                            )
                        );
                        echo $this->renderPartial($path_view . '__gridJurnalRekening', array('model' => $model));
                        ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Posting Jurnal', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('title' => 'Posting jurnal', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl('index'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );

                    $content = $this->renderPartial('akuntansi.views.jurnalPenerimaanKas.tips', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRek',
    'options' => array(
        'title' => 'Daftar Rekening',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));

$modRekDebit = new Rekeningakuntansi5V('searchDialogAccount');
$modRekDebit->unsetAttributes();

if (isset($_GET['Rekeningakuntansi5V'])) {
    $modRekDebit->attributes = $_GET['Rekeningakuntansi5V'];
    $modRekDebit->rekening5_id = (!empty($_GET['Rekeningakuntansi5V']['rekening5_id']) ? $_GET['Rekeningakuntansi5V']['rekening5_id']: null);
    $modRekDebit->rekening6_id = (!empty($_GET['Rekeningakuntansi5V']['rekening6_id']) ? $_GET['Rekeningakuntansi5V']['rekening6_id']: null);
    $modRekDebit->rekening7_id = (!empty($_GET['Rekeningakuntansi5V']['rekening7_id']) ? $_GET['Rekeningakuntansi5V']['rekening7_id']: null);
}

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchDialogAccount(),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
				"id" => "selectRekDebit",
				"onClick" =>"
                pilihDialogRekening(".CJSON::encode($data->attributes).");
					$(\"#dialogRek\").dialog(\"close\");  
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'type' => 'raw',
            'value' => '$data->koderekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'koderekeninglast', array('class' => 'numbers-only', 'maxlength' => 12))
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = KelrekeningM::model()->findByPk($data->kelompokrekeninglast_id);
                return $kel ? $kel->namakelrekening : "-";
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'kelompokrekeninglast_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 1',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening1;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening1_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening1_id is not null',
                    'order' => 'namarekening1 ASC',
                )),
                'rekening1_id',
                'namarekening1'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 2',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening2;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening2_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening2_id is not null',
                    'order' => 'namarekening2 ASC',
                )),
                'rekening2_id',
                'namarekening2'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 3',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening3;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening3_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening3_id is not null',
                    'order' => 'namarekening3 ASC',
                )),
                'rekening3_id',
                'namarekening3'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 4',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening4;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening4_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening4_id is not null',
                    'order' => 'namarekening4 ASC',
                )),
                'rekening4_id',
                'namarekening4'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 5',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening5;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening5_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening5_id is not null',
                    'order' => 'namarekening5 ASC',
                )),
                'rekening5_id',
                'namarekening5'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 6) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 6',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening6;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening6_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening6_id is not null',
                    'order' => 'namarekening6 ASC',
                )),
                'rekening6_id',
                'namarekening6'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 7) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 7',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening7;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening7_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening7_id is not null',
                    'order' => 'namarekening7 ASC',
                )),
                'rekening7_id',
                'namarekening7'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 8) ? true: false)
        ),
        array(
            'header' => 'Nama Rekening Terakhir',
            'type' => 'raw',
            'value' => '$data->namarekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'namarekeninglast', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Saldo Normal',
            'type' => 'raw',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
        . '}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>




<script type="text/javascript">
    // submit progress
    var total_submit = 0;
    var total_save = 0;

    var row_tidakada = '<tr><td colspan="9">Tidak ditemukan hasil</td></tr>';

    <?php if (Yii::app()->controller->id == 'jurnalPenerimaanKas') { ?>
        var frmInputRekening = new String(<?php echo CJSON::encode($this->renderPartial($path_view . '__formInputRekeningPenerima', array('model' => $model, 'form' => $form), true)); ?>);
    <?php } else { ?>
        var frmInputRekening = new String(<?php echo CJSON::encode($this->renderPartial($path_view . '__formInputRekeningBaru', array('model' => $model, 'form' => $form), true)); ?>);
    <?php } ?>

    var cur_id;

    function ubahRekening(obj) {
        cur_id = $(obj).parents("tr").index();
        $("#dialogRek").dialog("open");
    }

    function getDataRekening() {
        setTimeout(
            function() {
                $('#btn_submit').click();
            }, 1000
        );
    }

    function pilihDialogRekening(data) {
        var obj = $("#daftar-jural-rek-grid > tbody > tr").eq(cur_id);
        
        $(obj).find(".rek1").val(data.rekening1_id);
        $(obj).find(".rek2").val(data.rekening2_id);
        $(obj).find(".rek3").val(data.rekening3_id);
        $(obj).find(".rek4").val(data.rekening4_id);
        $(obj).find(".rek5").val(data.rekeninglast_id);

        $(obj).find(".nama5").val(data.namarekeninglast);
        $(obj).find(".kode5").html(data.koderekeninglast);
    }

    // getDataRekening();

    $('#form-search-jurnal-rek').submit(function() {
        $("#progress_jurnal_bar").css("width", "0%");
        $('#frmGridJurnalRek').addClass("animation-loading");
        $('#daftar-jural-rek-grid tbody').empty();
        $("#total_debit").val(formatThousandDecimal(0));
        $("#total_kredit").val(formatThousandDecimal(0));

        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getDaftarRekening'); ?>", {
                data: $('#form-search-jurnal-rek').serialize()
            },
            function(data) {
                $("#progress_jurnal").hide();

                if (data.length != 0) {
                    loadJurnalSatuSatu(data);
                    $('#daftar-jural-rek-grid').hide();
                    $("#progress_jurnal").show();
                    $("#btn_simpan").prop("disabled", false);
                } else {
                    $('#daftar-jural-rek-grid tbody').append(row_tidakada);
                    $("#btn_simpan").prop("disabled", true);
                }


                $('#frmGridJurnalRek').removeClass("animation-loading");


            }, "json"
        );
        return false;
    });

    function loadJurnalSatuSatu(data) {
        var k = 0;
        var intervals = 5;
        var timeinterval = 500;

        var datalen = data.length;

        var itv = setInterval(function() {
            var j = 0;

            // console.log(k);

            for (var j = 0; j < intervals; j++) {
                var i = j + k;
                if ((k + j) >= data.length) {
                    clearInterval(itv);
                    setSetelahLoad();
                    $('#daftar-jural-rek-grid').show();
                    $("#progress_jurnal").hide();

                    break;
                }

                $('#frmGridJurnalRek').find("tbody").append(frmInputRekening.replace());
                $('#daftar-jural-rek-grid').find("textarea[name$='[x][urianjurnal]']").val(data[i].urianjurnal);
                $('#daftar-jural-rek-grid').find('textarea[name$="[x][urianjurnal]"]').attr('id', 'AKJurnalrekeningT_' + i + '_urianjurnal');
                $('#daftar-jural-rek-grid').find('textarea[name$="[x][urianjurnal]"]').attr('name', 'AKJurnalrekeningT[' + i + '][urianjurnal]');
                /*
                $('#daftar-jural-rek-grid').find("td[name$='[x][saldodebit]']").text(data[i].saldodebit);
                $('#daftar-jural-rek-grid').find('td[name$="[x][saldodebit]"]').attr('name', 'AKJurnalrekeningT['+ i +'][saldodebit]');

                $('#daftar-jural-rek-grid').find("td[name$='[x][saldokredit]']").text(data[i].saldokredit);
                $('#daftar-jural-rek-grid').find('td[name$="[x][saldokredit]"]').attr('name', 'AKJurnalrekeningT['+ i +'][saldokredit]');
                */

                $('#daftar-jural-rek-grid').find("input[name$='[x][saldodebit]']").val((data[i].saldodebit));
                $('#daftar-jural-rek-grid').find('input[name$="[x][saldodebit]"]').attr('id', 'AKJurnalrekeningT_' + i + '_saldodebit]');
                $('#daftar-jural-rek-grid').find('input[name$="[x][saldodebit]"]').attr('name', 'AKJurnalrekeningT[' + i + '][saldodebit]');

                $('#daftar-jural-rek-grid').find("input[name$='[x][saldokredit]']").val((data[i].saldokredit));
                $('#daftar-jural-rek-grid').find('input[name$="[x][saldokredit]"]').attr('id', 'AKJurnalrekeningT_' + i + '_saldokredit]');
                $('#daftar-jural-rek-grid').find('input[name$="[x][saldokredit]"]').attr('name', 'AKJurnalrekeningT[' + i + '][saldokredit]');

                //					alert(data[i].tglbuktijurnalform);
                //$('#daftar-jural-rek-grid').find("td[name$='[x][tglbuktijurnal]']").text(data[i].tglbuktijurnalform);
                //$('#daftar-jural-rek-grid').find('td[name$="[x][tglbuktijurnal]"]').attr('name', 'AKJurnalrekeningT['+ i +'][tglbuktijurnal]');
                $('#daftar-jural-rek-grid').find("span[name$='[x][tglbuktijurnal]']").text(data[i].tglbuktijurnalform);
                $('#daftar-jural-rek-grid').find('span[name$="[x][tglbuktijurnal]"]').attr('name', 'AKJurnalrekeningT[' + i + '][tglbuktijurnal]');

                $('#daftar-jural-rek-grid').find("span[name$='[x][nobuktijurnal]']").text(data[i].nobuktijurnal);
                $('#daftar-jural-rek-grid').find('span[name$="[x][nobuktijurnal]"]').attr('name', 'AKJurnalrekeningT[' + i + '][nobuktijurnal]');

                //baru
                $('#daftar-jural-rek-grid').find("span[name$='[x][tglreferensi]']").text(data[i].tglreferensi);
                $('#daftar-jural-rek-grid').find('span[name$="[x][tglreferensi]"]').attr('name', 'AKJurnalrekeningT[' + i + '][tglreferensi]');

                //baru
                $('#daftar-jural-rek-grid').find("span[name$='[x][noreferensi]']").text(data[i].noreferensi);
                $('#daftar-jural-rek-grid').find('span[name$="[x][noreferensi]"]').attr('name', 'AKJurnalrekeningT[' + i + '][noreferensi]');

                $('#daftar-jural-rek-grid').find("td[name$='[x][kodejurnal]']").text(data[i].kodejurnal);
                $('#daftar-jural-rek-grid').find('td[name$="[x][kodejurnal]"]').attr('name', 'AKJurnalrekeningT[' + i + '][kodejurnal]');

                $('#daftar-jural-rek-grid').find("td[name$='[x][urianjurnal]']").html(data[i].urianjurnal);
                $('#daftar-jural-rek-grid').find('td[name$="[x][urianjurnal]"]').attr('name', 'AKJurnalrekeningT[' + i + '][urianjurnal]');

                $('#daftar-jural-rek-grid').find("td[name$='[x][kode_rekening]']").text(data[i].kode_rekening);
                $('#daftar-jural-rek-grid').find('td[name$="[x][kode_rekening]"]').attr('name', 'AKJurnalrekeningT[' + i + '][kode_rekening]');

                /*
                $('#daftar-jural-rek-grid').find("td[name$='[x][saldo_normal]']").text(data[i].saldo_normal);
                $('#daftar-jural-rek-grid').find('td[name$="[x][saldo_normal]"]').attr('name', 'AKJurnalrekeningT['+ i +'][saldo_normal]');
                */

                $('#daftar-jural-rek-grid').find("input[name$='[x][jurnalrekening_id]']").val(data[i].jurnalrekening_id);
                $('#daftar-jural-rek-grid').find('input[name$="[x][jurnalrekening_id]"]').attr('id', 'AKJurnalrekeningT_' + i + '_jurnalrekening_id]');
                $('#daftar-jural-rek-grid').find('input[name$="[x][jurnalrekening_id]"]').attr('name', 'AKJurnalrekeningT[' + i + '][jurnalrekening_id]');

                var nm_rekening_temp = data[i].nama_rekening;
                var jns_rekening = "Debit";
                if (data[i].saldodebit == 0) {
                    nm_rekening_temp = data[i].nama_rekening;
                    var jns_rekening = "Kredit";
                }

                $('#daftar-jural-rek-grid').find("input[name$='[x][rekening_nama]']").val(nm_rekening_temp);
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening_nama]"]').attr('id', 'AKJurnalrekeningT_' + i + '_rekening_nama');
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening_nama]"]').attr('name', 'AKJurnalrekeningT[' + i + '][rekening_nama]');

                $('#daftar-jural-rek-grid').find("input[name$='[x][jurnaldetail_id]']").val(data[i].jurnaldetail_id);
                $('#daftar-jural-rek-grid').find('input[name$="[x][jurnaldetail_id]"]').attr('id', 'AKJurnalrekeningT_' + i + '_jurnaldetail_id');
                $('#daftar-jural-rek-grid').find('input[name$="[x][jurnaldetail_id]"]').attr('name', 'AKJurnalrekeningT[' + i + '][jurnaldetail_id]');

                $('#daftar-jural-rek-grid').find("input[name$='[x][rekening1_id]']").val(data[i].rekening1_id);
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening1_id]"]').attr('id', 'AKJurnalrekeningT_' + i + '_rekening1_id');
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening1_id]"]').attr('name', 'AKJurnalrekeningT[' + i + '][rekening1_id]');

                $('#daftar-jural-rek-grid').find("input[name$='[x][rekening2_id]']").val(data[i].rekening2_id);
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening2_id]"]').attr('id', 'AKJurnalrekeningT_' + i + '_rekening2_id');
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening2_id]"]').attr('name', 'AKJurnalrekeningT[' + i + '][rekening2_id]');

                $('#daftar-jural-rek-grid').find("input[name$='[x][rekening3_id]']").val(data[i].rekening3_id);
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening3_id]"]').attr('id', 'AKJurnalrekeningT_' + i + '_rekening3_id');
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening3_id]"]').attr('name', 'AKJurnalrekeningT[' + i + '][rekening3_id]');

                $('#daftar-jural-rek-grid').find("input[name$='[x][rekening4_id]']").val(data[i].rekening4_id);
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening4_id]"]').attr('id', 'AKJurnalrekeningT_' + i + '_rekening4_id');
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening4_id]"]').attr('name', 'AKJurnalrekeningT[' + i + '][rekening4_id]');

                $('#daftar-jural-rek-grid').find("input[name$='[x][rekening5_id]']").val(data[i].rekening5_id);
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening5_id]"]').attr('id', 'AKJurnalrekeningT_' + i + '_rekening5_id');
                $('#daftar-jural-rek-grid').find('input[name$="[x][rekening5_id]"]').attr('name', 'AKJurnalrekeningT[' + i + '][rekening5_id]');

                //                    $('#daftar-jural-rek-grid').find('input[name$="[x][is_checked]"]').val(data[i].jurnalrekening_id);
                $('#daftar-jural-rek-grid').find('input[name$="[x][is_checked]"]').attr('id', 'AKJurnalrekeningT_' + i + '_is_checked');
                $('#daftar-jural-rek-grid').find('input[name$="[x][is_checked]"]').attr('name', 'AKJurnalrekeningT[' + i + '][is_checked]');

                $('#daftar-jural-rek-grid').find("input[name$='[x]cekTd']").val(data[i].cehkRek);
                $('#daftar-jural-rek-grid').find('input[name$="[x]cekTd"]').attr('id', '_' + i + 'cekTd');
                $('#daftar-jural-rek-grid').find('input[name$="[x]cekTd"]').attr('name', '[' + i + '][cekTd]');

                jQuery('#AKJurnalrekeningT_' + i + '_rekening_nama').autocomplete({
                    'showAnim': 'fold',
                    'minLength': 2,
                    'focus': function(event, ui) {
                        return false;
                    },
                    'select': function(event, ui) {
                        $(this).val(ui.item.value);
                        $(this).parents("tr").find('input[name$="[rekening1_id]"]').val(ui.item.struktur_id);
                        $(this).parents("tr").find('input[name$="[rekening2_id]"]').val(ui.item.kelompok_id);
                        $(this).parents("tr").find('input[name$="[rekening3_id]"]').val(ui.item.jenis_id);
                        $(this).parents("tr").find('input[name$="[rekening4_id]"]').val(ui.item.obyek_id);
                        $(this).parents("tr").find('input[name$="[rekening5_id]"]').val(ui.item.rincianobyek_id);
                        $(this).parents("tr").find('td[name$="[kode_rekening]"]').val(ui.item.label);
                        return false;
                    },
                    'source': '/ehospitaljk/index.php?r=ActionAutoComplete/rekeningAkuntansi&id_jenis_rek=' + jns_rekening
                });
            }
            k += intervals;

            $("#progress_jurnal_bar").css("width", (k * 100 / datalen) + "%");

        }, timeinterval, data);

        console.log(data);
    }

    function setBackgroundTr() {
        $("#daftar-jural-rek-grid tbody tr").each(function() {
            //                    var jurnalrekeningId = $(this).find("input[name$='[jurnalrekening_id]']").val();
            //                    var jurnalrekeningId = $(this).find("td[name$='[kodejurnal]']").text();
            var jurnalrekeningId = $(this).find("input[name$='[cekTd]']").val();

            if (jurnalrekeningId != '') {
                back = parseFloat(jurnalrekeningId) % 2;
                if (back == 1) {
                    $(this).find('td').addClass("tdOdd");
                }
            }
        });
    }

    function setSetelahLoad() {
        $(".integer2").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": ".",
            "precision": 0
        });

        $('#daftar-jural-rek-grid').find(".integerFloat").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": ".",
            "precision": 2
        });

        //mengubah warna background berdasarkan jurnalrekening_id
        setBackgroundTr();

        cekTotalCeklis();
    }

    $('#btn_resset').click(function() {
        getDataRekening();
    });

    $('#form-grid-jurnal-rek').submit(
        function() {

            // cek apakah ada data kosong
            var is_akun_kosong = false;
            var is_uraian_kosong = false;

            $("#daftar-jural-rek-grid tbody tr").each(function() {
                if ($(this).find(".ceklis").is(":checked")) {

                    if ($(this).find(".rek5").val() == "" || $(this).find(".nama5").val().trim() == "") {
                        is_akun_kosong = true;
                    }
                    if ($(this).find(".uraian").val() == "") {
                        is_uraian_kosong = true;
                    }
                }

            });

            if (is_akun_kosong) {
                myAlert("Nama Akun di beberapa jurnal belum diisi.");
                return false;
            }
            if (is_uraian_kosong) {
                myAlert("Uraian Transaksi di beberapa jurnal belum diisi.");
                return false;
            }

            // /*
            if ($("#total_debit").val().trim() != $("#total_kredit").val().trim()) {
                myAlert("Total Saldo Debit/Kredit yang akan diposting tidak sama.");
                return false;
            }
            // */

            var serialize_data = $(this).serialize();

            myConfirm("Proses posting akan memakan waktu lama. Mohon tidak menutup halaman sampai proses selesai.<br>Apakah Anda akan melanjutkan?", "Peringatan", function(r) {
                if (r) {

                    $("#btn_simpan").prop("disabled", true);

                    $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/simpanJurnalPosting'); ?>", {
                            data: serialize_data
                        },
                        function(data) {
                            if (data.status == 'ok') {
                                $('#frmGridJurnalRek').find("tbody").empty();
                                $('#btn_submit').click();
                                $("#total_debit").val(formatThousandDecimal(0));
                                $("#total_kredit").val(formatThousandDecimal(0));
                                myAlert("<?php echo $menu_nama; ?> berhasil diposting.");
                            } else {
                                myAlert("<?php echo $menu_nama; ?> gagal diposting.<br>" + data.pesan);
                            }

                            $("#btn_simpan").prop("disabled", false);
                        },
                        'json'
                    );
                }
            });

            return false;
        }
    );

    $('#btn_reset_grid').click(
        function() {
            window.location.reload();
        }
    );

    function checkAll() {
        if ($("#checkAllObat").is(":checked")) {
            $('#daftar-jural-rek-grid input[name*="is_checked"]').each(
                function() {
                    $(this).attr('checked', true);
                }
            );
        } else {
            $('#daftar-jural-rek-grid input[name*="is_checked"]').each(
                function() {
                    $(this).removeAttr('checked');
                }
            );
        }
        cekTotalCeklis();
    }

    function checkRekening(obj) {
        var jurnalrekening_id = $(obj).parents("tr").find("input[name$='[jurnalrekening_id]']").val();
        if ($(obj).is(":checked")) {
            $('#daftar-jural-rek-grid').find('input[name$="[jurnalrekening_id]"][value="' + jurnalrekening_id + '"]').each(
                function() {
                    $(this).parents("tr").find("input[name$='[is_checked]']").attr('checked', true);
                    $(this).parents("tr").find("input[name$='[is_checked]']").prop('checked', true);
                }
            );
        } else {
            $('#daftar-jural-rek-grid').find('input[name$="[jurnalrekening_id]"][value="' + jurnalrekening_id + '"]').each(
                function() {
                    $(this).parents("tr").find("input[name$='[is_checked]']").attr('checked', false);
                    $(this).parents("tr").find("input[name$='[is_checked]']").prop('checked', false);
                }
            );
        }

        cekTotalCeklis();

    }

    function cekTotalCeklis() {
        var total_debit = 0;
        var total_kredit = 0;
        $('#daftar-jural-rek-grid tbody tr').each(function() {
            var debit = parseFloat(unformatNumber($(this).find(".saldodebit").val()));
            var kredit = parseFloat(unformatNumber($(this).find(".saldokredit").val()));
            //            var debit = parseFloat($(this).find(".saldodebit").val());
            //            var kredit = parseFloat($(this).find(".saldokredit").val());

            if ($(this).find(".ceklis").is(":checked")) {
                total_debit += debit;
                total_kredit += kredit;
            }

        });

        //        console.log(total_debit, total_kredit);

        $("#total_debit").val(formatThousandDecimal(total_debit));
        $("#total_kredit").val(formatThousandDecimal(total_kredit));
    }

    $(".alphanum").keyup(function() {
        $(this).val($(this).val().replace(/[^a-zA-Z0-9]/gi, ''));
    });

    $('#daftar-jural-rek-grid tbody').append(row_tidakada);
</script>


<?php
$this->endWidget();
?>
