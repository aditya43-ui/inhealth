<?php $linkHalaman = CustomFunction::getUrlByMenuID(2755); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php
$konfsy = KonfigsystemK::model()->find();
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.currency',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'precision' => 0,
    )
));
?>
<style>
    .bg_yellow td {
        background-color: yellow !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pengajuan Jasa Dokter</b>
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
            'Pengajuan Jasa Dokter',
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gjpembayaranjasa-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                // 'onsubmit'=>'unformatNumbers();'
                'onsubmit' => 'return cekValidasi(this);'
            ),
            'focus' => '#GJPembayaranjasaT_pilihDokter',
        )); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php
        //if(isset($_GET['sukses'])){
        //	Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
        //}   
        //$this->widget('bootstrap.widgets.BootAlert'); 
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body" id="formCari">
                <?php echo $this->renderPartial($this->path_view . '_formCari', array('form' => $form, 'model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Daftar Jasa</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_formDetail', array('form' => $form, 'model' => $model, 'modDetails' => $modDetails, 'dataDetails' => $dataDetails)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengajuan</b>
                </div>
            </div>
            <div class="panel-body" id="formPembayaran">
                <?php echo $this->renderPartial($this->path_view . '_form', array('form' => $form, 'model' => $model, 'modPajakDokter' => $modPajakDokter)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (isset($_GET['id'])) {
                $disabledSimpan = 'disabled';
                $disabledPrint = '';
            } else {
                $disabledSimpan = '';
                $disabledPrint = 'disabled';
            }
            ?>
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array(
                    'title' => 'Simpan',
                    'class' => 'btn btn-danger',
                    'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)',
                    //                        'onClick'=>'onClickSubmit();return false;',
                    'disabled' => $disabledSimpan
                )
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('create'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                "#",
                array(
                    'class' => 'btn btn-info',
                    'onclick' => "print('PRINT'); return false",
                    'disabled' => $disabledPrint,
                )
            );
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    function pilihDokter() {
        return false;
        var pilih = $("#GJPembayaranjasaT_pilihDokter");
        $(".instalasikomponen").show();
        $("#total_terima_perawat").parents(".form-group").hide();
        $("#tab_askep tbody tr").each(function() {
            $(this).remove();
        });
        reloadItemPerawat();
        if (pilih.val() == "rujukan") {
            $(".form_perawat").hide();
            $("#formRujukan").show();
            $("#formTglPenunjangAwal").show();
            $("#formTglPenunjangAkhir").show();
            $("#formDokter").find('input').each(function() {
                $(this).val("");
            });
            $("#formTglPendaftaranAwal").find('input').each(function() {
                // $(this).val("");
            });
            $("#formTglPendaftaranAkhir").find('input').each(function() {
                // $(this).val("");
            });
            $("#formDokter").hide();
            $("#formTglPendaftaranAwal").hide();
            $("#formTglPendaftaranAkhir").hide();
            $("#total_terima_perawat").val(0);
            $("#panel_pajakdokter").show().find(":input").prop("disabled", false);
        } else if (pilih.val() == "rs") {
            $(".form_perawat").hide();
            $("#formDokter").show();
            $("#formTglPendaftaranAwal").show();
            $("#formTglPendaftaranAkhir").show();
            $("#formRujukan").find('input').each(function() {
                $(this).val("");
            });
            $("#formTglPenunjangAwal").find('input').each(function() {
                // $(this).val("");
            });
            $("#formTglPenunjangAkhir").find('input').each(function() {
                // $(this).val("");
            });
            $("#formRujukan").hide();
            $("#formTglPenunjangAwal").hide();
            $("#formTglPenunjangAkhir").hide();
            $("#total_terima_perawat").val(0);
            $("#panel_pajakdokter").show().find(":input").prop("disabled", false);
        } else if (pilih.val() == "askep" || pilih.val() == "farmasi" || pilih.val() == "sopir" || pilih.val() == "laundry" || pilih.val() == "radio" || pilih.val() == "paramedis") {
            $(".form_perawat").show();
            $("#formDokter, .instalasikomponen").hide();
            $("#formTglPendaftaranAwal").show();
            $("#formTglPendaftaranAkhir").show();
            $("#formRujukan").find('input').each(function() {
                $(this).val("");
            });
            $("#formTglPenunjangAwal").find('input').each(function() {
                // $(this).val("");
            });
            $("#formTglPenunjangAkhir").find('input').each(function() {
                // $(this).val("");
            });
            $("#formRujukan").hide();
            $("#formTglPenunjangAwal").hide();
            $("#formTglPenunjangAkhir").hide();
            $("#pegawai_kelompokpegawai_id").val(pilih.val());
            <?php if (!isset($_GET['id'])) : ?>
                $.fn.yiiGridView.update("perawat-t-grid", {
                    data: $("#dialogPerawat :input").serialize()
                });
            <?php endif; ?>
            $("#total_terima_perawat").parents(".form-group").show();
            $("#panel_pajakdokter").hide().find(":input").prop("disabled", true);
        }
        bersihTabelDetail();
        bersihFormPembayaran();
    }

    function addDetail() {
        var rujukandari_id = $('#GJPembayaranjasaT_rujukandari_id').val();
        var pegawai_id = $('#GJPembayaranjasaT_pegawai_id').val();
        var pegawai_nama = $('#GJPembayaranjasaT_pegawaiNama').val();
        var tgl_awalPenunjang = $('#GJPembayaranjasaT_tgl_awalPenunjang').val();
        var tgl_akhirPenunjang = $('#GJPembayaranjasaT_tgl_akhirPenunjang').val();
        var tgl_awalPendaftaran = $('#GJPembayaranjasaT_tgl_awalPendaftaran').val();
        var tgl_akhirPendaftaran = $('#GJPembayaranjasaT_tgl_akhirPendaftaran').val();
        var pilih = $("#GJPembayaranjasaT_pilihDokter");
        var jasa = $("#GJPembayaranjasaT_pilihDokter").val();
        var postobj = {};
        var komponentarifIds = {};
        var instalasi_id = {};
        var i = 0;
        var carabayar_id = {};
        var penjamin_id = {};
        var tgl_awal = "";
        var tgl_akhir = "";
        if ($('.komponentarif_id').val() != null && $('.komponentarif_id').val() != "") {
            komponentarifIds = $('.komponentarif_id').val();
        }
        if ($('.instalasi_id').val() != null && $('.instalasi_id').val() != "") {
            instalasi_id = $('.instalasi_id').val();
        }
        if ($('.carabayar_id').val() != null && $('.carabayar_id').val() != "") {
            carabayar_id = $('.carabayar_id').val();
        }
        if ($('.penjamin_id').val() != null && $('.penjamin_id').val() != "") {
            penjamin_id = $('.penjamin_id').val();
        }
        /*
	if (jasa === "rujukan") {
		pegawai_id = null;
		if(tgl_awalPenunjang.length > 0) { // && tgl_akhirPenunjang.length > 0 && i > 0){
			tgl_awal = tgl_awalPenunjang;
			//tgl_akhir = tgl_akhirPenunjang;
		} else {
			myAlert ("Silakan isi form dengan benar ! Pegawai, Tanggal dan Komponen Tarif wajib diisi!");
			return false;
		}
		postobj = {
			rujukandari_id:rujukandari_id, 
			tgl_awal:tgl_awal, 
			//tgl_akhir:tgl_akhir, 
			komponentarifId:komponentarifIds
		};
		$('#GJPembayaranjasaT_pegawai_id').val("");
	} else if (jasa === "rs") { */
        rujukandari_id = null;
        if (pegawai_id.trim() == "" || pegawai_nama.trim() == "") {
            myAlert("Silakan isi form dengan benar ! Pegawai wajib diisi!");
            return false;
        }
        if (tgl_awalPendaftaran.length > 0) { // && tgl_akhirPendaftaran.length > 0){
            tgl_awal = tgl_awalPendaftaran;
            //tgl_akhir = tgl_akhirPendaftaran;
        } else {
            myAlert("Silakan isi form dengan benar ! Pegawai dan Tanggal wajib diisi!");
            return false;
        }
        postobj = {
            pegawai_id: pegawai_id,
            tgl_awal: tgl_awal,
            //tgl_akhir:tgl_akhir, 
            komponentarifId: komponentarifIds,
            instalasi_id: instalasi_id,
            penjamin_id: penjamin_id,
            carabayar_id: carabayar_id
        };
        $('#GJPembayaranjasaT_rujukandari_id').val("");
        /*
	} else if (jasa === "askep" || jasa === "farmasi" || jasa === "sopir" || jasa === "laundry" || jasa === "radio" || jasa === "paramedis") {
        rujukandari_id = null;
		if(tgl_awalPendaftaran.length > 0) {// && tgl_akhirPendaftaran.length > 0){
			tgl_awal = tgl_awalPendaftaran;
			//tgl_akhir = tgl_akhirPendaftaran;
		} else {
			myAlert ("Silakan isi form dengan benar ! Pegawai, Tanggal dan Komponen Tarif wajib diisi!");
			return false;
		}
		postobj = {
			// pegawai_id: null, 
			tgl_awal:tgl_awal, 
			//tgl_akhir:tgl_akhir, 
                        jasa: jasa,
                        penjamin_id: penjamin_id,
                        carabayar_id: carabayar_id
			// komponentarifId:null,
            // instalasi_id: null
		};
        $('#GJPembayaranjasaT_rujukandari_id').val("");
        $('#GJPembayaranjasaT_pegawai_id').val("");
    }
	bersihTabelDetail();
	bersihFormPembayaran();
    $("#panel_pajakdokter").hide().find(':input').prop('disabled', true);
	$('#tabelDetail').addClass('animation-loading');
    if (jasa == "farmasi") {
        $.post("<?php echo $this->createUrl('addDetailPembayaranJasaFarmasi'); ?>", postobj,
		function(data){
			if (data.tr == ""){
				myAlert('Data tidak ditemukan!');				
			}else{
				$('#tabelDetail tbody').append(data.tr);
				$("#tabelDetail tbody tr .integer2").each(function(){
					$(this).maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
				});    
                $('#tabelDetail tbody input[name$="[jumahtarif]"], #tabelDetail tbody input[name$="[jumlahjasa]"], #tabelDetail tbody input[name$="[jumlahbayar]"]').each(function() {
                    $(this).val(formatThousandDecimal($(this).val()));
                });
				hitungSemua();
			}
			$('#tabelDetail').removeClass('animation-loading');
		}, "json");
    } else {
    */
        $.post("<?php echo $this->createUrl('addDetailPembayaranJasa'); ?>", postobj,
            function(data) {
                $('#tabelDetail tbody').html("");
                if (data.tr == "") {
                    myAlert('Data tidak ditemukan!');
                    hitungSemua();
                    hitungPajak(data);
                    hitungTotal();
                } else {
                    $("#panel_pajakdokter").show().find(':input').prop('disabled', false);
                    /*
                    if (data.is_dokter == 1) {
                    } else {
                        $("#panel_pajakdokter").hide().find(':input').prop('disabled', true);
                    }
                    */
                    $('#tabelDetail tbody').append(data.tr);
                    $("#tabelDetail tbody tr .integer2").each(function() {
                        $(this).maskMoney({
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ",",
                            "thousands": ".",
                            "precision": 2,
                            "symbol": null
                        });
                    });
                    $('#tabelDetail tbody input[name$="[jumahtarif]"], #tabelDetail tbody input[name$="[jumlahjasa]"], #tabelDetail tbody input[name$="[jumlahbayar]"]').each(function() {
                        $(this).val(formatThousandDecimal($(this).val()));
                    });
                    totaljasa = $('#footer_total_jasa').val();
                    console.log(totaljasa);
                    hitungSemua();
                    hitungPajak(data);
                    hitungTotal();
                }
                $('#tabelDetail').removeClass('animation-loading');
            }, "json");
        //}
        return false;
    }

    function formatNumbers() {
        $('.integer2').each(function() {
            this.value = formatThousandDecimal(this.value)
        });
    }

    function unformatNumbers() {
        $('.integer2').each(function() {
            this.value = unformatNumber(this.value)
        });
    }

    function bersihTabelDetail() {
        $('#tabelDetail tbody').html("");
    }

    function bersihFormPembayaran() {
        $('#formPembayaran .integer2').each(function() {
            $(this).val(0);
        });
    }

    function hitungTotal() {
        $("#footer_total_tarif").val($("#GJPembayaranjasaT_totaltarif").val());
        $("#footer_total_jasa").val($("#GJPembayaranjasaT_totaljasa").val());
        $("#footer_total_pajak").val($("#GJPembayaranjasaT_total_pajak").val());
        $("#footer_total_pengajuan").val($("#GJPembayaranjasaT_total_terima").val());
        var total_jasa = parseFloat(unformatNumber($("#footer_total_jasa").val()));
        var total_pajak = parseFloat(unformatNumber($("#footer_total_pajak").val()));
        $('#tabelDetail tbody tr').each(function() {
            var sub_jasa = parseFloat(unformatNumber($(this).find('input[name$="[jumlahjasa]"]').val()));
            var sub_pajak = (total_pajak / total_jasa) * sub_jasa;
            var sub_pengajuan = sub_jasa - sub_pajak;
            $(this).find('input[name$="[jumlahpajak]"]').val(formatThousandDecimal(sub_pajak));
            $(this).find('input[name$="[jumlahbayar]"]').val(formatThousandDecimal(sub_pengajuan));
        });
        var pem_totaljasa = parseFloat(unformatNumber($("#GJPembayaranjasaT_totaljasa").val()));
        var pem_totalpajak = parseFloat(unformatNumber($("#GJPembayaranjasaT_total_pajak").val()));
        var pem_totaladjs = parseFloat(unformatNumber($("#GJPembayaranjasaT_totaladjsument").val()));
        var pem_totalbayajasa = ((pem_totaljasa + pem_totaladjs) - pem_totalpajak);
        $("#GJPembayaranjasaT_totalbayarjasa").val(formatThousandDecimal(pem_totalbayajasa));
        $("#PajakdokterT_penghasilanbruto").val($("#GJPembayaranjasaT_totaljasa").val());
    }

    function hitungPajak(data) {
        var total_jasa = parseFloat(unformatNumber($("#GJPembayaranjasaT_totaljasa").val()));
        var total_terima = 0;
        var total_bruto = parseFloat(unformatNumber($("#GJPembayaranjasaT_totaltarif").val()));
        var pkp = total_bruto / 2;
        var pkp2 = pkp - data.ptkp;
        var akumulasi = data.pajak_akumulasi + pkp2;
        var pelapisan_pph = 0;
        var pajak_progressif = 0;
        var akumulasi_hitung = akumulasi;
        var level1 = (akumulasi_hitung <= 50000000) ? akumulasi_hitung * 0.05 : 2500000;
        akumulasi_hitung -= 50000000;
        var level2 = (akumulasi_hitung > 0) ? ((akumulasi_hitung <= 200000000) ? (akumulasi_hitung) * 0.15 : 30000000) : 0;
        akumulasi_hitung -= 200000000;
        var level3 = (akumulasi_hitung > 0) ? ((akumulasi_hitung <= 250000000) ? (akumulasi_hitung) * 0.25 : 62500000) : 0;
        akumulasi_hitung -= 250000000;
        var level4 = (akumulasi_hitung > 0) ? (akumulasi_hitung) * 0.30 : 0;
        console.log("Lapis", level1, level2, level3, level4);
        pelapisan_pph = level1 + level2 + level3 + level4;
        pajak_progressif = pelapisan_pph > 0 ? pelapisan_pph - data.pelapisan_bulan_lalu : 0;
        total_terima = total_jasa - pajak_progressif;
        $("#panel_pajakdokter .pajak_bruto").val(formatThousandDecimal(total_bruto));
        $("#panel_pajakdokter .pajak_pkp").val(formatThousandDecimal(pkp));
        $("#panel_pajakdokter .pajak_ptkp").val(formatThousandDecimal(data.ptkp));
        $("#panel_pajakdokter .pajak_setelahptkp").val(formatThousandDecimal(pkp2));
        $("#panel_pajakdokter .pajak_pkpkumulatif").val(formatThousandDecimal(akumulasi));
        $("#panel_pajakdokter .pajak_pelapisan").val(formatThousandDecimal(pelapisan_pph));
        <?php if (!empty($konfsy->ispajakdokter) && $konfsy->ispajakdokter) { ?>
            $("#panel_pajakdokter .pajak_pajakprogresif, #GJPembayaranjasaT_total_pajak").val(formatThousandDecimal(pajak_progressif));
        <?php } else { ?>
            $("#panel_pajakdokter .pajak_pajakprogresif, #GJPembayaranjasaT_total_pajak").val(0);
        <?php } ?>
        $("#GJPembayaranjasaT_total_terima").val(formatThousandDecimal(total_terima));
        $("#GJPembayaranjasaT_totalbayarjasa").val(formatThousandDecimal(total_terima));
    }

    function hitungSemua() {
        var jasa = $("#GJPembayaranjasaT_pilihDokter").val();
        var totTarif = 0;
        var totJasa = 0;
        var totBayar = 0;
        var totSisa = 0;
        $('#tabelDetail tbody tr').each(function() {
            if ($(this).find('input[name$="[pilihDetail]"]').is(":checked")) { //hitung yang dicheck aja
                var jmltarif = parseFloat(unformatNumber($(this).find('input[name$="[jumahtarif]"]').val()));
                var jmljasa = parseFloat(unformatNumber($(this).find('input[name$="[jumlahjasa]"]').val()));
                var jmlbayar = parseFloat(unformatNumber($(this).find('input[name$="[jumlahbayar]"]').val()));
                if (jmljasa < jmlbayar) {
                    jmlbayar = jmljasa;
                    $(this).find('input[name$="[jumlahbayar]"]').val(formatThousandDecimal(jmlbayar));
                }
                var jmlsisa = parseFloat(unformatNumber(jmljasa - jmlbayar));
                if (jmlsisa <= 0) {
                    jmlsisa = 0;
                }
                $(this).find('input[name$="[sisajasa]"]').val(formatThousandDecimal(jmlsisa));
                totTarif += jmltarif;
                totJasa += jmljasa;
                totBayar += jmlbayar;
                totSisa += jmlsisa;
            }
        });
        $("#GJPembayaranjasaT_totaltarif").val(formatThousandDecimal(totTarif));
        $("#GJPembayaranjasaT_totaljasa").val(formatThousandDecimal(totJasa));
        $("#GJPembayaranjasaT_totalbayarjasa").val(formatThousandDecimal(totBayar));
        $("#GJPembayaranjasaT_totalsisajasa").val(formatThousandDecimal(totSisa));
        $("#GJPembayaranjasaT_total_terima").val(formatThousandDecimal(totBayar));
        // hitungpph();
        // hitung askep
        $("#total_terima_perawat").val(0);
        if (jasa === "askep" ||
            jasa === "farmasi" ||
            jasa === "sopir" ||
            jasa === "radio" ||
            jasa === "laundry" ||
            jasa === "paramedis") {
            hitungTotalPerPerawatAskep();
        }
    }

    function hitungTotalPerPerawatAskep() {
        var total_terima = parseFloat(unformatNumber($('#GJPembayaranjasaT_total_terima').val()));
        var row = $("#tab_askep tbody tr").length;
        if (row == 0) {
            $("#total_terima_perawat").val(0);
        } else {
            console.log("Total Jasa Askep", total_terima / row);
            $("#total_terima_perawat").val(formatThousandDecimal(total_terima / row));
        }
    }

    function checkAll(obj) {
        if ($(obj).is(':checked')) {
            $('#tabelDetail tbody tr').each(function() {
                $(this).find('input[name$="[pilihDetail]"]').each(function() {
                    $(this).attr('checked', true)
                });
                $(this).find('input[name$="[pilihDetail]"]').each(function() {
                    $(this).val(1)
                });
            });
        } else {
            $('#tabelDetail tbody tr').each(function() {
                $(this).find('input[name$="[pilihDetail]"]').each(function() {
                    $(this).removeAttr('checked')
                });
                $(this).find('input[name$="[pilihDetail]"]').each(function() {
                    $(this).val("")
                });
            });
        }
        hitungSemua();
    }

    function checkIni(obj) {
        if ($(obj).is(':checked')) {
            $(obj).parent().find('input[name$="[pilihDetail]"]').each(function() {
                $(this).attr('checked', true)
            });
            $(obj).parent().find('input[name$="[pilihDetail]"]').each(function() {
                $(this).val(1)
            });
        } else {
            $(obj).parent().find('input[name$="[pilihDetail]"]').each(function() {
                $(this).removeAttr('checked')
            });
            $(obj).parent().find('input[name$="[pilihDetail]"]').each(function() {
                $(this).val("")
            });
            $('#pilihSemua').removeAttr('checked');
        }
        hitungSemua();
    }

    function print(caraPrint) {
        <?php if (!empty($model->pembayaranjasa_id)) { ?>
            window.open('<?php echo $this->createUrl('Print', array('id' => $model->pembayaranjasa_id)); ?>' + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=980,height=400,scrollbars=1');
        <?php } ?>
    }

    function onClickSubmit() {
        if (requiredCheck($("form"))) {
            cekInput();
        }
    }

    function simpanProses() {
        $("#gjpembayaranjasa-t-form").submit();
    }

    function cekValidasi(obj) {
        var jasa = $("#GJPembayaranjasaT_pilihDokter").val();
        if ($("#tabelDetail tbody tr").length == 0) {
            myAlert("Data Jasa belum ditampilkan");
            return false;
        }
        if ($("#GJPembayaranjasaT_pilihDokter").val() == 'askep' && $("#tab_askep tbody tr").length == 0) {
            myAlert("Perawat belum ditambahkan.");
            return false;
        }
        if ((jasa === "askep" ||
                jasa === "farmasi" ||
                jasa === "sopir" ||
                jasa === "radio" ||
                jasa === "laundry" ||
                jasa === "paramedis") && $("#tab_askep tbody tr").length == 0) {
            myAlert("Mohon tambahkan Pegawai Penerima Jasa.");
            return false;
        }
        // myAlert("Test");
        // return false;
        return requiredCheck(obj);
    }

    function cekInput() {
        if ($('#GJPembayaranjasaT_totaltarif').val() == 0) {
            myAlert('Belum ada data pembayaran');
            return false;
        } else {
            $("#gjpembayaranjasa-t-form").submit();
        }
    }

    function hitungpph() {
        return false;
        /*
        var totalgajipph = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model, 'totalbayarjasa') ?>").val()));        
        var totalgajipphtahun = totalgajipph * 12;
        $("#<?php echo CHtml::activeId($model, 'gajipph') ?>").val(formatNumber(totalgajipphtahun));
        var biayajabatan = 0.05 * totalgajipphtahun;
        if (biayajabatan >= 6000000) {
            biayajabatan = 6000000;
        }
        $("#<?php echo CHtml::activeId($model, 'biayajabatan') ?>").val(formatNumber(biayajabatan));
        $("#<?php echo CHtml::activeId($model, 'iuranpensiun') ?>").val(formatNumber(2400000));
        var penerimaanbersih = totalgajipphtahun - biayajabatan - unformatNumber($("#<?php echo CHtml::activeId($model, 'iuranpensiun') ?>").val());
        $("#<?php echo CHtml::activeId($model, 'penerimaanpph') ?>").val(formatNumber(penerimaanbersih));
        var ptkp = unformatNumber($('#<?php echo CHtml::activeId($model, 'ptkp') ?>').val());
        var pkp = penerimaanbersih - ptkp;
        if (pkp <= 0)
            pkp = 0;
        $("#<?php echo CHtml::activeId($model, 'pkp') ?>").val(formatNumber(pkp));
        $.post('<?php echo $this->createUrl('AmbilPph'); ?>', {pkp: pkp}, function (data) {
            var persen = data.percent / 100;
            var persenpertahun = persen * pkp;
            var persenperbulan = persenpertahun / 12;
            var pembulatan = Math.round(persenperbulan * Math.pow(10, 0)) / Math.pow(10, 0);
            $('#<?php echo CHtml::activeId($model, 'pphpersen') ?>').val(formatNumber(persenpertahun));
            $('#<?php echo CHtml::activeId($model, 'pph21') ?>').val(formatNumber(persenperbulan));
            //$('#PenggajiankompT_komponengaji_id_16').val(formatNumber(pembulatan));
            //$('#PenggajiankompT_komponengaji_id_35').val(formatNumber(pembulatan));
            $('#<?php echo CHtml::activeId($model, 'total_pajak') ?>').val(formatNumber(pembulatan));
            $("#label_persen").html('PPh (' + data.percent + ' %)');
            $('#<?php echo CHtml::activeId($model, 'persentasepph21') ?>').val(data.percent);
            var statuskawin = $('#statusperkawinan').val();
            if (statuskawin == 'KAWIN') {
                var kodekawin = 'K';
            } else {
                var kodekawin = 'TK';
            }
            var jmlanak = $('#jml_tanggungan').val();
            if (jmlanak > 3) {
                jmlanak = 3;
            }
            var kdptkp = kodekawin + "/" + jmlanak;
            $('#<?php echo CHtml::activeId($model, 'kodeptkp') ?>').val(kdptkp);
            $('#<?php echo CHtml::activeId($model, 'total_terima') ?>').val(formatNumber(parseInt(totalgajipph)+pembulatan));
        }, 'json');
        */
    }
    <?php
    $row = str_replace("\n", "", $this->renderPartial($this->path_view . '_rowPerawat', array(), true));
    $row = str_replace("\r", "", $row);
    ?>
    var row = '<?php echo $row; ?>';

    function dialogPerawat() {
        $("#dialogPerawat").dialog("open");
        reloadItemPerawat();
    }

    function reloadItemPerawat() {
        var rows;
        $("#perawat-t-grid .perawat_id").each(function() {
            rows = $(this);
            rows.parents("tr").removeClass("bg_yellow");
            $("#tab_askep tbody tr").each(function() {
                console.log($(rows).val(), $(this).find(".pegawai_askep").val());
                if ($(rows).val() == $(this).find(".pegawai_askep").val()) {
                    rows.parents("tr").addClass("bg_yellow");
                }
            });
        });
        hitungSemua();
    }

    function hapusPegawaiAskep(obj) {
        $(obj).parents("tr").remove();
        reloadItemPerawat();
    }

    function tambahPerawat(pegawai) {
        var lastrow = "";
        var pegawai_id = pegawai.pegawai_id;
        var is_ada = false;
        $("#tab_askep tbody .pegawai_askep").each(function(data) {
            if ($(this).val() == pegawai_id) is_ada = true;
        });
        if (is_ada) {
            myAlert("Perawat sudah ditambahkan sebelumnya.");
            return false;
        }
        $("#tab_askep tbody").append(row);
        lastrow = $("#tab_askep tbody tr:last-child");
        lastrow.find(".askep_nik").html(pegawai.nomorindukpegawai);
        lastrow.find(".askep_nama").html(pegawai.nama_pegawai);
        lastrow.find(".pegawai_askep").val(pegawai.pegawai_id);
        reloadItemPerawat();
    }
    $(document).ready(function() {
        var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
        var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
        jQuery(".komponentarif_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
        jQuery(".instalasi_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
        /**
         * multi select cara bayar dan penjamin
         */
        jQuery(cara).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
                var brands = cara_all;
                var selected = [];
                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });
                penj.addClass('animation-loading');
                //alert(selected);
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjamin);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onSelectAll: function() {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
                var brands = cara_all;
                var selected = [];
                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });
                penj.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjaminan);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onDeselectAll: function() {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
                var brands = cara_all;
                var selected = '';
                penj.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjamin);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        }).hide();
        jQuery(penj).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
        /**
         * multi select propinsi dan kabupaten
         */
        pilihDokter(); //default
        formatNumbers();
    });
</script>