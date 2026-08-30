<?php
$this->breadcrumbs = array(
    'Informasi Permintaan Darah Pasien' => Yii::app()->request->getUrlReferrer(),
    'Pengiriman Darah ',
);

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pengiriman Darah
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penyiapandarah-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        )); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body" id="form_permintaan">
                <?php echo $this->renderPartial($this->path_view . 'form/_formPasien', array(
                    'permintaan' => $permintaan,
                    'pendaftaran' => $pendaftaran,
                    'model' => $model,
                ), true); ?>
            </div>
        </div>
        <div id="hasil_pengujian">

            <?php echo $this->renderPartial($this->path_view . 'form/_formPemeriksaanGolDar', array(
                'modPemeriksaanGolDar' => $modPemeriksaanGolDar
            ), true); ?>

        </div>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Pengiriman Darah
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'form/_formPenyiapan', array(
                    'form' => $form,
                    'model' => $model,
                ), true); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php

            //$model = PenyiapandarahT::model()->findByAttributes(array(
            //  'permintaandarah_id'=>$permintaan->permintaandarah_id,
            //));

            $disabled = isset($_GET['sukses']) ? true : false;

            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array(
                    'title' => 'Simpan',
                    'class' => 'btn btn-danger ' . (($disabled == true) ? '' : 'submit'),
                    'disabled' => $disabled,
                    'type' => 'submit'
                )
            );
            if (!isset($_GET['frame']) || $_GET['frame'] != 1) {
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
                    'class' => 'btn btn-default',
                    'title' => 'Ulang',
                    //                                      'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = ' . $this->createUrl('index') . ';}); return false;'
                ));
            }

            echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array(
                'class' => 'btn btn-info',
                'onclick' => "printLabel()",
                "disabled" => !$disabled,
            ));

            $content = $this->renderPartial($this->path_view . 'tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    /**
     * Link Print Label 
     */
    function printLabel() {
        var pendaftaran_id = "<?= isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null ?>";
        var penyiapandarah_ke = "<?= isset($_GET['penyiapandarah_ke']) ? $_GET['penyiapandarah_ke'] : null ?>";
        var pasienkirimkeunitlain_id = "<?= isset($_GET['pasienkirimkeunitlain_id']) ? $_GET['pasienkirimkeunitlain_id'] : null ?>";

        if (pendaftaran_id != "" && penyiapandarah_ke != "") {
            window.open('<?php echo $this->createUrl('printLabel'); ?>&pendaftaran_id=' + pendaftaran_id + '&pasienkirimkeunitlain_id=' + pasienkirimkeunitlain_id + '&penyiapandarah_ke=' + penyiapandarah_ke, 'printwin', 'left=100,top=100,width=800,height=500');
        }
    }

    $(document).ready(function() {
        setValidasiCekDisabled($("#penyiapandarah-form"), function() {
            var ok = true;

            $(".req").each(function() {
                if ($(this).val() == "") ok = false;
            });

            var jml = $("#tab_penyiapan > tr").length;

            if (jml < 1) {
                ok = false;
            }

            return ok;
        });
        $('.tanggal').hide();
    });

    function setPermintaan(data) {
        $("#PenyiapandarahT_no_permintaandarah").val(data.no_permintaandarah);
        $("#PenyiapandarahT_permintaandarah_id").val(data.permintaandarah_id);

        $("#form_permintaan #tgl_pendaftaran").val(data.pendaftaran.tgl_pendaftaran);
        $("#form_permintaan #no_pendaftaran").val(data.pendaftaran.no_pendaftaran);
        $("#form_permintaan #ruangan").val(data.ruangan_nama);
        $("#form_permintaan #kelaspelayanan").val(data.kelaspelayanan_nama);
        $("#form_permintaan #diagnosis").val(data.diagnosa_nama);
        $("#form_permintaan #penjamin").val(data.penjamin_nama);
        $("#form_permintaan #alamatpasien").val(data.pasien.alamat_pasien);

        $("#form_permintaan #no_rekam_medik").val(data.pasien.no_rekam_medik);
        $("#form_permintaan #nama_pasien").val(data.pasien.nama_pasien);
        $("#form_permintaan #tanggal_lahir").val(data.pasien.tanggal_lahir);
        $("#form_permintaan #umur").val(data.pendaftaran.umur);
        $("#form_permintaan #jeniskelamin").val(data.pasien.jeniskelamin);
        $("#form_permintaan #golongandarah").val(data.pasien.golongandarah + " / " + data.pasien.rhesus);
        $("#form_permintaan #doktermenangani").val(data.nama_pegawai);

        loadHasilTest(data.permintaandarah_id);
    }

    function loadHasilTest(permintaandarah_id) {
        $("#hasil_pengujian").empty();
        $.post('<?php echo $this->createUrl('loadPengujian'); ?>', {
            id: permintaandarah_id
        }, function(data) {
            $("#hasil_pengujian").html(data.html);
            $("#tab_penyiapan").html(data.html_penyiapan);

            setDateTimePickerPenyiapan();
            setAutoCompletePenyiapan();

            $("#alamatpasien").blur();

        }, "json");
    }

    function setDateTimePickerPenyiapan() {
        jQuery(".tgl_tab_penyiapan").datetimepicker(jQuery.extend({
                showMonthAfterYear: false
            },
            jQuery.datepicker.regional['id'], {
                'dateFormat': 'dd M yy',
                'minDate': 'd',
                'timeText': 'Waktu',
                'hourText': 'Jam',
                'minuteText': 'Menit',
                'secondText': 'Detik',
                'showSecond': true,
                'timeOnlyTitle': 'Pilih   Waktu',
                'timeFormat': 'hh:mm:ss',
                'changeYear': true,
                'changeMonth': true,
                'showAnim': 'fold'
            }));
    }

    function setAutoCompletePenyiapan() {
        jQuery(".peg_pelabelan_nama").autocomplete({
            'showAnim': 'fold',
            'minLength': 3,
            'focus': function(event, ui) {
                $(this).val("");
                return false;
            },
            'select': function(event, ui) {
                $(this).val(ui.item.label);
                $(this).parents("td").find(".peg_pelabelan").val(ui.item.pegawai_id);
                $("#PenyiapandarahT_lamapenyiapan_detik_0").blur();
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: "<?php echo $this->createUrl('AutocompletePetugas'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            }
        });

        jQuery(".peg_referal_nama").autocomplete({
            'showAnim': 'fold',
            'minLength': 3,
            'focus': function(event, ui) {
                $(this).val("");
                return false;
            },
            'select': function(event, ui) {
                $(this).val(ui.item.label);
                $(this).parents("td").find(".peg_referal_id").val(ui.item.pegawai_id);
                $("#PenyiapandarahT_lamapenyiapan_detik_0").blur();
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: "<?php echo $this->createUrl('AutocompletePetugasLabeling'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            }
        });
    }
</script>