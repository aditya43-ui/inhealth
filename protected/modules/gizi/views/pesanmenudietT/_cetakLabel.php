<style>
    .add-on{
        float: right !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Cetak Label Makanan
        </div>
    </div>
    <div class="panel-body">
        <?php
        $check = false;
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'cari',
            'type' => 'horizontal',
        ));
        $ruangan = !empty($modPesan->ruangan_id) ? $modPesan->ruangan->ruangan_nama : '-';
        ?>
        <table style="color: black;" width="100%" >
            <tr>
                <td width="15%" height="40px"><label>Jenis Pesan menu</label></td>
                <td width="20%" height="40px"><?php echo CHtml::textField('jenispesanmenu', $modPesan->jenispesanmenu, array('class' => 'span2', 'readonly' => true)) ?></td>
                <td></td>
                <td width="15%" height="40px"><label>Ruangan</label></td>
                <td width="20%" height="40px">
                    <div class="control-group">
                        <div class="controls"> 
                            <?php echo CHtml::textField('ruangan', $ruangan, array('class' => 'span2', 'readonly' => true)) ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="15%" height="40px"><label>Nomor Pesan Menu</label></td>
                <td width="20%" height="40px"><?php echo CHtml::textField('noppesanmenu', $modPesan->nopesanmenu, array('class' => 'span2', 'readonly' => true)) ?></td>
                <td></td>
                <td width="15%" height="40px"><label>Tanggal Kirim</label></td>
                <td width="25%" height="40px">
                    <div class="control-group">
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'name' => 'tgl_kirim',
                                'value' => date('d M Y'),
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="15%" height="40px">&nbsp;</td>
                <td width="20%" height="40px">&nbsp;</td>
                <td></td>
                <td width="15%" height="40px">&nbsp;</td>
                <td width="20%" height="40px"><?php echo CHtml::link(Yii::t('mds', '{icon} Pencarian', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn', 'style' => 'width:80%')); ?></td>
            </tr>
        </table>
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        ");
        ?>
        <div class="cari-lanjut search-form" style="display:none">
            <?php
            $this->renderPartial('_pencarian', array(
                'model' => $model,
                'modPesan' => $modPesan
            ));
            ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Daftar Pemesanan Menu
                </div>
            </div>
            <div class="panel-body" style="overflow-x: scroll">
                <?php if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PASIEN) { ?>
                    <table class="table table-striped table-bordered table-condensed" id="dafarpemesanan">
                        <thead>
                            <tr>
                                <th style="text-align: center"><?php echo CHtml::checkBox("pilihall", $check, array('class' => 'pilihall', 'name' => 'pilih[]', 'value' => "", 'onchange' => 'checkThis(this);')) ?></th>
                                <th style="text-align: center">No. Pendaftaran</th>
                                <th style="text-align: center">No. Rekam Medik</th>
                                <th style="text-align: center">Nama Pasien</th>
                                <th style="text-align: center">Umur</th>
                                <th style="text-align: center">Jenis Kelamin</th>
                                <th style="text-align: center">Tipe Diet</th>
                                <!-- <th style="text-align: center">Jenis Makanan</th> -->
                                <th style="text-align: center">Jenis Diet</th>
                                <!-- <th style="text-align: center">Jenis Diet Lain</th> -->
                                <th style="text-align: center">Jenis Waktu</th>
                                <th style="text-align: center">Alat Makan</th>
                                <th style="text-align: center">Jumlah Pesanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;

                            if (!empty($modDetailPesan)) {
                                foreach ($modDetailPesan as $tampilData) {
                                    $this->renderPartial('_rowpasien', array('tampilData' => $tampilData, 'i' => $i++, 'check' => $check));
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <table class="table table-striped table-bordered table-condensed" id="dafarpemesanan">
                        <thead>
                            <tr>
                                <th style="text-align: center"><?php echo CHtml::checkBox("pilihall", $check, array('class' => 'pilihall', 'name' => 'pilih[]', 'value' => "", 'onchange' => 'checkThis(this);')) ?></th>
                                <th style="text-align: center">Instalasi/Ruangan</th>
                                <th style="text-align: center">Tipe Diet</th>
                                <th style="text-align: center">Jenis Makanan</th>
                                <th style="text-align: center">Jenis Diet</th>
                                <th style="text-align: center">Jenis Waktu</th>
                                <th style="text-align: center">Alat Makan</th>
                                <th style="text-align: center">Jumlah Pesanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;

                            if (!empty($modDetailPesan)) {
                                foreach ($modDetailPesan as $tampilData) {
                                    $this->renderPartial('_rowpegawai', array('tampilData' => $tampilData, 'modPesan' => $modPesan, 'i' => $i++, 'check' => $check));
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'pilihdaftarpemesanan',
            'type' => 'horizontal',
        ));
        echo CHtml::hiddenField('PesanmenudietT[pesanmenudiet_id]', $_GET['pesanmenudiet_id'], array());
        echo CHtml::hiddenField('PesanmenudietT[jenispesanmenu]', $modPesan->jenispesanmenu, array());
        echo CHtml::hiddenField('PesanmenudietT[tgl_kirim]', date('d/m/Y'), array());
        ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'printPemesanan(\'PDF\');')) . "&nbsp&nbsp"; ?>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrintPemesanan = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/cetakLabelMakanan');
$js = <<< JSCRIPT
function printpilihPermintaan(caraPrint){
    window.open("${urlPrintPemesanan}/"+$('#pilihdaftarpemesanan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<script>
    /**
     * Set Ajax pemesan
     * @returns {undefined}
     */
    function caripemesanan() {
        var pesanmenudiet_id = <?php echo $_GET['pesanmenudiet_id'] ?>;
        var jenispesanmenu = $('#jenispesanmenu').val();

        if (jenispesanmenu == 'Pasien') {
            var jeniswaktu_id = $('#PesanmenudetailT_jeniswaktu_id').val();
            var menudiet_id = $('#PesanmenudetailT_menudiet_id').val();
            var nama_pasien = $('#PesanmenudetailT_nama_pasien').val();
            var no_rekam_medik = $('#PesanmenudetailT_no_rekam_medik').val();
        } else {
            var jeniswaktu_id = $('#PesanmenupegawaiT_jeniswaktu_id').val();
            var menudiet_id = $('#PesanmenupegawaiT_menudiet_id').val();
            var nama_pasien = $('#PesanmenupegawaiT_nama_pegawai').val();
        }

        $('#dafarpemesanan').addClass("animation-loading");

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setPemesanan'); ?>',
            data: {jeniswaktu_id: jeniswaktu_id, menudiet_id: menudiet_id, nama_pasien: nama_pasien, no_rekam_medik: no_rekam_medik, pesanmenudiet_id: pesanmenudiet_id, jenispesanmenu: jenispesanmenu},
            dataType: "json",
            success: function (data) {
                $('#dafarpemesanan > tbody > tr').remove();
                $("#dafarpemesanan > tbody").html(data.form);
                $('#dafarpemesanan').removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Print Pemesanan
     * @param {type} caraPrint
     * @returns {Boolean}
     */
    function printPemesanan(caraPrint) {
        var tgl_kirim = $('#tgl_kirim').val();
        $('#PesanmenudietT_tgl_kirim').val(tgl_kirim);
    
        var html = [];
        var i = 0;
        var cek = $("#dafarpemesanan > tbody > tr").find('.pilihcheck:checked').length;

        if (cek < 1) {
            window.parent.myAlert("Pilih Minimal Satu Daftar Pemesanan Menu");
            return false;
        }

        $("#dafarpemesanan > tbody > tr").find('.pilihcheck:checked').each(function () {
            html[i] = $(this).val();
            console.log(html[i]);
            i++;
        });

        console.log(html);

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setprint'); ?>',
            data: {id: html},
            dataType: "json",
            success: function (data) {
                if (html != "") {
                    printpilihPermintaan(caraPrint);
                } else {
                    myAlert("Silahkan Pilih Minimal Satu Daftar Pemesanan Menu");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /*
     * Check All
     * @param {type} obj
     * @returns {undefined}     
     */
    function checkThis(obj) {
        if ($(".pilihall").is(":checked")) {
            $("#dafarpemesanan > tbody > tr").find('.pilihcheck').each(function () {
                $(this).prop("checked", true);
            });
        } else {
            $("#dafarpemesanan > tbody > tr").find('.pilihcheck').each(function () {
                $(this).prop("checked", false);
            });
        }
    }
</script>