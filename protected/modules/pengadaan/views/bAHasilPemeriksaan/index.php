<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); 
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bahasilpemeriksaan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div style="min-height: 950px !important">
    <div class="panel-group joined" id="accordion-khp"> 
        <div class="panel panel-success"> 
            <div class="panel-heading"> 
                <h4 class="panel-title" style="background-color: #a6db9c"> 
                    <a data-toggle="collapse" data-parent="#accordion-khp" href="#riwayat" aria-expanded="true" class="">
                        Riwayat Berita Acara Hasil Pemeriksaan Pekerjaan
                    </a> 
                </h4> 
            </div> 
            <div id="riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
                <div class="panel-body" style="background-color: #fff">
                    <?php echo $this->renderPartial('_riwayat', array('model' => $model, 'form' => $form), true); ?>
                </div> 
            </div> 
        </div> 
        <div class="panel panel-success"> 
            <div class="panel-heading"> 
                <h4 class="panel-title" style="background-color: #b0eaa5"> 
                    <a data-toggle="collapse" data-parent="#accordion-khp" href="#transaksi" class="" aria-expanded="false">
                        Berita Acara Hasil Pemeriksaan Pekerjaan
                    </a> 
                </h4> 
            </div>
            <div id="transaksi" class="panel-collapse collapse in" aria-expanded="true"> 
                <div class="panel-body" style="background-color: #fff">
                    <div class="panel panel-gradient">
                        <div class="panel-heading">
                            <div class="panel-title">Transaksi <strong>Berita Acara Hasil Pemeriksaan Pekerjaan</strong></div>
                        </div>
                        <div class="panel-body">

                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-title"><span class='judul'>Data Berita Acara Hasil Pemeriksaan Pekerjaan</span></div>
                                </div>
                                <div class="panel-body">
                                    <?php $this->renderPartial('_formHasilPemeriksaan', array('model' => $model, 'modPeriksaKerja' => $modPeriksaKerja, 'form' => $form)); ?>
                                </div>
                            </div>
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-title"><span class='judul'>Lampiran</span></div>
                                </div>
                                <div class="panel-body">
                                    <?php $this->renderPartial('_formLampiran', array('modelDetail' => $modelDetail, 'form' => $form, 'modSPK' => $modSPK, 'model' => $model)); ?>
                                </div>
                            </div>

                            <div class="row-fluid">
                                <div class="form-actions">
                                    <?php
                                    if (empty($_GET['bahasilpemeriksaanpekerjaan_id'])) {
                                        
                                    }
                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'submit'));
                                    ?>
                                    <?php
                                    echo "&nbsp;";
                                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'])), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
                                    echo "&nbsp;";
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div> 
        </div> 
    </div> 

    <?php
    $this->endWidget();
    $urlGetRiwayat = $this->createUrl('GetRiwayat');
    $suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
    ?>

    <script>
        function cekRiwayat(obj) {
            var suratperjanjiankerja_id = <?php echo $suratperjanjiankerja_id ?>;
            if (suratperjanjiankerja_id !== "") {
                $.post("<?php echo $urlGetRiwayat ?>", {suratperjanjiankerja_id: suratperjanjiankerja_id, },
                        function (data) {
                            $("#tableRiwayat").children("tbody").append(data.tr);
                        }, "json");
            } else {
                myAlert("Silahkan pilih data Surat Perjanjian Kerja !");
            }
            return false;

        }
        function print() {
            window.open('<?php echo $this->createUrl('print', array('id' => $model->bahasilpemeriksaanpekerjaan_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
        }
        function setLampiran(bapemeriksaanpekerjaan_id) {
            $.post("<?php echo $this->createUrl('getLampiran') ?>", {bapemeriksaanpekerjaan_id: bapemeriksaanpekerjaan_id, },
                    function (data) {
                        $("#tabel_lampiran").html(data.tr);
                    }, "json");
        }

        function ubahPemeriksaan(obj) {
            var bapemeriksaanpekerjaan_id = obj.value;
            $("#bahasilpemeriksaan-m-form").addClass("animation-loading");
//            $('#tblDokumen > tbody').html("");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('GetDokumen'); ?>',
                data: {
                    id: bapemeriksaanpekerjaan_id,
                }, //
                dataType: "json",
                success: function (data) {
                    setHasil(data);
                    setLampiran(bapemeriksaanpekerjaan_id);
                    $("#bahasilpemeriksaan-m-form").removeClass("animation-loading");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }

        function setHasil(data) {
            $('#ADBahasilpemeriksaanpekerjaanT_terminke').val(data.terminke);
            $('#ADBahasilpemeriksaanpekerjaanT_termin_terminjumlah').val(data.termin);
            $('#ADBahasilpemeriksaanpekerjaanT_supplier_id').val(data.supplier_id);
            $('#ADBahasilpemeriksaanpekerjaanT_termin_termintotal').val(data.jumlahtermin);

            $('#ADBahasilpemeriksaanpekerjaanT_total_pembayaran').val(data.total_pembayaran);
            $('#ADBahasilpemeriksaanpekerjaanT_total_dibulatkan').val(data.total_dibulatkan);
            $('#ADBahasilpemeriksaanpekerjaanT_total_harga').val(data.total_harga);
            $('#ADBahasilpemeriksaanpekerjaanT_jumlah_pajak').val(data.jumlah_pajak);
            $('#ADBahasilpemeriksaanpekerjaanT_jumlah_harga').val(data.jumlah_harga);
            $('#ADBahasilpemeriksaanpekerjaanT_termin_persen').val(data.termin_persen);

            formatNumberSemua();

            $('#penyedia').val(data.supplier_nama);
            $('#direktur').val(data.direktur);
            $('#alamat').val(data.alamat);
//            $(".tabelLampiran > tfoot > tr:last").remove();
            $(".tabelLampiran > tfoot").find(".termin").remove();
            $(".tabelLampiran > tfoot > tr:last").after(data.tr);
        }

        $('#tombolPemeriksaan').click(function () {
            $.fn.yiiGridView.update('pemeriksaanpekerjaan-grid', {
                data: {
                    "BapemeriksaanpekerjaanT[suratperjanjiankerja_id]": <?= $_GET['suratperjanjiankerja_id'] ?>,
                }
            });
        });
<?php if (empty($_GET['bahasilpemeriksaanpekerjaan_id'])) { ?>
            setValidasiCekDisabled($("#bahasilpemeriksaan-m-form"), function () {
                return true;
            });
<?php } ?>

        $(document).ready(function () {
             $('.integer-decimal').each(function(){
                $(this).val(formatThousandDecimal(parseFloat($(this).val())));
            });
            cekRiwayat();
<?php if (isset($_GET['sukses'])) { ?>
                $('input').attr('readonly', true);
                $('.add-on').hide();
    <?php } ?>
        });
        
    document.getElementById("ADBahasilpemeriksaanpekerjaanT_dokumen_pendukung").onchange = function () {
        if (this.files[0].size > 5000000) {
            toastr.error('Ukuran maksimal dokumen 5mb');
            $("#ADBahasilpemeriksaanpekerjaanT_dokumen_pendukung").attr("src", "blank");
            $('#ADBahasilpemeriksaanpekerjaanT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#ADBahasilpemeriksaanpekerjaanT_dokumen_pendukung').unwrap();
            return false;
        }
    }
    </script>

    <?php
// ===========================Dialog Penelitian=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialog1',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'BA Hasil Pemeriksaan Pekerjaan',
            'autoOpen' => false,
            'width' => 1100,
            'height' => 600,
            'resizable' => true,
            'scroll' => false,
        ),
    ));
    ?>
    <iframe src="" name="frame1" width="100%" height="100%">
    </iframe>
    <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
    ?>
    <?php
// ===========================Dialog Penelitian=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialog2',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Detail BA Hasil Pemeriksaan Pekerjaan',
            'autoOpen' => false,
            'width' => 1100,
            'height' => 600,
            'resizable' => true,
            'scroll' => false,
        ),
    ));
    ?>
    <iframe src="" name="frame2" width="100%" height="100%">
    </iframe>
    <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
    ?>