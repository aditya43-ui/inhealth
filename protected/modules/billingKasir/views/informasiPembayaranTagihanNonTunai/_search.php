<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'caripasien-form',
    'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pembayaran", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label(CHtml::activecheckBox($model, 'ceklis') . " <label for='BKInformasipembayarantagihannontunaiV_ceklis'>Jatuh Tempo</label>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgljatuhtempo_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgljatuhtempo_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgljatuhtempo_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgljatuhtempo_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgljatuhtempo_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgljatuhtempo_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nopembayaran', array('placeholder' => 'No. Pembayaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php
        $carabayar = CarabayarM::model()->findAll(array(
            'condition' => 'carabayar_aktif = true',
            'order' => 'carabayar_nourut',
        ));
        $penjamin = PenjaminpasienM::model()->findAll(array(
            'condition' => 'penjamin_aktif = true',
            'order' => 'penjamin_nama',
        ));
        $pegawai = DokterV::model()->findAllByAttributes(array(
            'instalasi_id' => Params::INSTALASI_ID_RJ,
            'pegawai_aktif' => true,
        ), array(
            'order' => 'nama_pegawai',
        ));
        foreach ($carabayar as $idx => $item) {
            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                'carabayar_id' => $item->carabayar_id,
                'penjamin_aktif' => true,
            ));
            if (empty($penjamins)) unset($carabayar[$idx]);
        }
        $kelas = KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true order by kelaspelayanan_nama');
        $kamar = KamarruanganM::model()->findAll(array(
            'join' => 'join ruangan_m r on r.ruangan_id = t.ruangan_id',
            'condition' => 't.kamarruangan_aktif = true and r.instalasi_id = ' . Params::INSTALASI_ID_RI,
            'order' => 't.kamarruangan_nokamar, t.kamarruangan_nobed',
        ));
        echo $form->dropDownListRow($model, 'carabayar_nama', CHtml::listData($carabayar, 'carabayar_nama', 'carabayar_nama'), array(
            'empty' => '-- Pilih --',
            'class' => 'span4',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
            ),
        ));
        echo $form->dropDownListRow($model, 'penjamin_nama', CHtml::listData($penjamin, 'penjamin_nama', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        ?>
    </div>
    <div class="col-sm-6">
        <?php 
        $model->petugasadministrasi_id = Yii::app()->user->getState('pegawai_id');
        //echo $form->textFieldRow($model, 'petugasadministrasi_id', array('placeholder' => 'No. Pembayaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <?php
        echo $form->dropDownListRow($model, 'kelastanggungan_id', CHtml::listData($kelas, 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        echo $form->dropDownListRow($model, 'petugasadministrasi_id',  CHtml::listData($model->getKasirRuanganItems(), 'pegawai_id', 'pegawai.nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)"));
        ?>
        <?php
        $instalasi = InstalasiM::model()->findAllByAttributes(array(
            'instalasi_id' => array(2, 3, 4),
        ));
        $ruangan = RuanganM::model()->findAllByAttributes(array(
            'instalasi_id' => array(2, 3, 4),
            'ruangan_aktif' => true,
        ), array(
            'order' => 'instalasi_id, ruangan_nama',
        ));
        echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
            'empty' => '-- Pilih --',
            'class' => 'span4',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/GetRuangAkhirDariInsAkhir', array('encode' => false, 'namaModel' => get_class($model))),
                'success' => 'function(data){$("#' . CHtml::activeId($model, "ruanganakhir_id") . '").html(data); }',
            ),
        ));
        echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($kelas, 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
        ?>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Pembayaran', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jnspembayar_id', CHtml::listData(JnspembayarM::model()->findAll('jnspembayar_aktif = true'), 'jnspembayar_id', 'jnspembayar_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Bank', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'bankpembayaran_id', CHtml::listData(BankM::model()->findAll('bank_aktif = true and ispenerimaan = true'), 'bank_id', 'namabank'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onchange' => 'setNamaBank();', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <!--<div class="control-group">
            <?php //echo CHtml::activeLabel($model, 'bank_id', array('class' => 'control-label', 'label'=>'Bank Penerima')); 
            ?>
            <div class="controls">
                <?php
                //     $bank_data = BankM::model()->findAll('bank_aktif = true order by namabank');
                //
                // $list_bank = CHtml::listData($bank_data, 'bank_id', 'bankNoRekening');
                //
                // echo $form->dropDownList($model, 'bank_id', $list_bank,
                //         array('empty'=>'-- Pilih --', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>
                    </div>
            </div>-->
        <div class="control-group">
            <?php
            $model-> closingkasir_id =2;
            echo $form->dropDownListRow($model, 'closingkasir_id', array(2 => 'BELUM', 1 => 'SUDAH'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    );
    ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array(
            'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
        array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printAll(\'PRINT\')')
    );
    ?>
    <?php
    $content = $this->renderPartial('laboratorium.views.tips.informasi_pencarian', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>



<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintInformasiPasien');
$urlPrintPegawai =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintInformasiPegawai');
$urlPrintPembayaran =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintAll');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gzpesanmenudiet-t-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printPegawai(caraPrint)
{
    window.open("${urlPrintPegawai}/"+$('#gzpesanmenudiet-t-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printAll(caraPrint)
{
    window.open("${urlPrintPembayaran}/"+$('#caripasien-form :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>

<script>
    function caribayar() {
        var tgl_awal = $('#BKInformasipembayarantagihannontunaiV_tgl_awal').val();
        var tgl_akhir = $('#BKInformasipembayarantagihannontunaiV_tgl_akhir').val();
        var carabayar_nama = $('#BKInformasipembayarantagihannontunaiV_carabayar_nama').val();
        var tgljatuhtempo_awal = $('#BKInformasipembayarantagihannontunaiV_tgljatuhtempo_awal').val();
        var tgljatuhtempo_akhir = $('#BKInformasipembayarantagihannontunaiV_tgljatuhtempo_akhir').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        var petugasadministrasi_id = $('#BKInformasipembayarantagihannontunaiV_petugasadministrasi_id').val();
        

        var payload = {
            tgl_awal: tgl_awal,
            tgl_akhir:tgl_akhir,
            carabayar_nama:carabayar_nama,
            petugasadministrasi_id:petugasadministrasi_id,
            tgljatuhtempo_awal:tgljatuhtempo_awal,
            tgljatuhtempo_akhir:tgljatuhtempo_akhir,

        };

        var form = document.createElement('form');
        //var target = 
        form.style.visibility = 'hidden';
        form.method = 'POST';
        form.target = '_blank';
        form.action = '<?php echo Yii::app()->createUrl('billingKasir/InformasiPembayaranTagihanNonTunai/printAll') ?>';
        // form.setAttribute('<?php echo Yii::app()->createUrl('billingKasir/InformasiPembayaranTagihanNonTunai/printAll') ?>', "_blank");
        $.each(Object.keys(payload), function(index, key) {
            var input = document.createElement('input');
            input.name = key;
            input.value = payload[key];
            form.appendChild(input)
        });
        document.body.appendChild(form);
        form.submit();

        // $.ajax({
        //     type: 'POST',
        //     url: '<?php //echo Yii::app()->createUrl('billingKasir/InformasiPembayaranTagihanNonTunai/printAll') ?>',
        //     data: {
        //         tgl_awal,tgl_akhir,carabayar_nama,petugasadministrasi_id
        //     },
        //     dataType: "json",
        //     success: function(data) {
        //         if (data.status == false) {
        //             $(".nodata").show();
        //             //alert("Data Anda tidak tersedia")
        //         } else {
        //             data_booking.data_pasien = data.pasien_id
        //             $("#pasien_id").val(data.pasien_id);
        //             $(".halaman2").show();
        //             $(".halaman1").hide();
        //         }
        //         console.log("data pasien:", data_booking);
        //     }
        // });

        // window.open("<?php //echo Yii::app()->createUrl('billingKasir/InformasiPembayaranTagihanNonTunai/printAll')  
                        ?>")

        console.log(tgl_awal, tgl_akhir, carabayar_nama, petugasadministrasi_id);
    }
</script>