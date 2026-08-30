<?php
$this->breadcrumbs = array(
    'Tutup Jadwal Dokter',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi Tutup Jadwal Dokter</div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $form = $this->beginWidget(
            'ext.bootstrap.widgets.BootActiveForm',
            array(
                'id' => 'tutupjadwaldokter-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array(
                    'onKeyPress' => 'return disableKeyPress(event)'
                ),
                'focus' => '#',
            )
        );
        ?>
        <div id="panel_cari">
            <?php echo $form->textFieldRow($model, 'no_tutupjadwaldokter', array('class' => 'span3', 'readonly' => true)); ?>
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Periode Tutup", 'tgl_tutup', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->periodeawal_tutupjadwal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->periodeakhir_tutupjadwal)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->periodeawal_tutupjadwal)) ?> - <?php echo date('d M Y', strtotime($model->periodeakhir_tutupjadwal)) ?></span>
                        <?php echo $form->hiddenField($model, 'periodeawal_tutupjadwal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'periodeakhir_tutupjadwal', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <?php
            $list = CHtml::listData(DokterV::model()->findAll('pegawai_aktif = true order by nama_pegawai'), 'pegawai_id', 'namaLengkap');
            echo $form->dropDownListRow($model, 'pegawai_id', $list, array(
                'empty' => '-- Pilih --',
                'class' => 'span3 pegawai_id',
                'onchange' => "$('#tab_jadwal tbody').empty();",
            )); ?>
            <?php echo $form->textAreaRow($model, 'alasan_tutup', array('rows' => 3, 'class' => 'span3')); ?>
            <div class="control-group">
                <?php echo CHtml::label("&nbsp;", 'tgl_tutup', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::htmlButton("Cari", array('class' => 'btn btn-success', 'onclick' => 'cariJadwal();')); ?>
                </div>
            </div>
            <hr />
        </div>
        <table class="table table-bordered table-condensed" id="tab_jadwal">
            <thead>
                <tr>
                    <th>Hari / Tanggal</th>
                    <th>Poliklinik</th>
                    <th>Jam Praktik</th>
                    <th>Dokter Pengganti</th>
                    <th>
                        <?php echo CHtml::checkBox('pilihsemua_jadwal', false, array(
                            'onclick' => 'pilihSemuaJadwal();',
                        )); ?> Semua
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton('Simpan', array(
                'class' => 'btn btn-primary', 'onclick' => 'cekSubmit();',
            )); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    function cariJadwal() {
        $("#tab_jadwal tbody").empty();
        $.post('<?php echo $this->createUrl('loadJadwal') ?>', $("#panel_cari :input").serialize(), function(data) {
            if (data.ok == 0) {
                myAlert(data.msg);
            } else {
                $("#tab_jadwal tbody").html(data.html);
                $("#pilihsemua_jadwal").prop("checked", false).change();
            }
        }, 'json');
    }

    function pilihSemuaJadwal() {
        var ceklis = $("#pilihsemua_jadwal").is(":checked");
        $(".ceklis_jadwal").prop("checked", ceklis);
    }

    function cekSubmit() {
        var total = 0;
        var kosong = 0;
        $("#tab_jadwal tbody tr").each(function() {
            if ($(this).find(".ceklis_jadwal").is(":checked")) {
                total++;
                if ($(this).find(".ceklis_pegawai").val() == "") {
                    kosong++;
                }
            }
        });
        if (total == 0) {
            myAlert("Tidak ada jadwal yang dipilih");
            return false;
        }
        if (kosong > 0) {
            myAlert("Dokter pengganti pada jadwal terpilih harus diisi.");
            return false;
        }
        $("#tutupjadwaldokter-form").submit();
    }
    $(document).ready(function() {
        jQuery(".pegawai_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
        }).hide();
    });
</script>