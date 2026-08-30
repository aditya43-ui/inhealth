<style type="text/css">
    .integer-decimal {
        text-align: right;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Jurnal Pengajuan <span class="jenistransaksi">THR</span> Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js',  CClientScript::POS_END); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js',  CClientScript::POS_END); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'frm-jurnalpengajuanbonusthr',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        ));
        ?>

        <?php echo $this->renderPartial($this->path_view . "_search", array(), true); ?>

        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Kode Akun</th>
                    <th>Nama Akun</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                </tr>
            </thead>
            <tbody id="tab_rekening">

            </tbody>
            <tfoot>
                <tr>
                    <td style="font-weight: bold;" colspan="2">
                        Total
                    </td>
                    <td><?php echo CHtml::textField('totalrek_debit', 0, array('class' => 'span2 integer-decimal', 'readonly' => true)); ?></td>
                    <td><?php echo CHtml::textField('totalrek_kredit', 0, array('class' => 'span2 integer-decimal', 'readonly' => true)); ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'simpanjurnalgaji();')
            ); //formSubmit(this,event) 
            ?>
            <?php
            $content = $this->renderPartial('/tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    function simpanjurnalgaji() {
        var periode = $('input[name="form_cari[periodegaji]"]').val();
        var jenistransaksi = $('select[name="form_cari[jenisgaji]"]').val();
        var totalpengajuan = $("#total_pengajuan").val();

        var totaldebit = $("#totalrek_debit").val();
        var totalkredit = $("#totalrek_kredit").val();

        if (parseFloat(totalpengajuan) > 0) {
            if (parseFloat(totaldebit) === parseFloat(totalkredit)) {
                $('.integer-decimal, .float2, .integer2').each(function() {
                    $(this).val(unformatNumber($(this).val()));
                });
                $('#frm-jurnalpengajuanbonusthr').submit();
            } else {
                myAlert("Saldo Debit dan Kredit Tidak Sama");
            }
        } else {
            myAlert("Belum Ada Data Pengajuan " + jenistransaksi + " pada periode " + periode);
        }
    }

    function getJenisTransaksi() {
        var jenistransaksi = $('select[name="form_cari[jenisgaji]"]').val();

        if (jenistransaksi != '') {
            $('.jenistransaksi').html(jenistransaksi);
        } else {
            $('.jenistransaksi').html("THR");
        }

    }

    function getDataPengajuanPeriode() {

        var is_kosong = false;
        $("#form_cari :input, select").each(function() {
            if ($(this).val() == "") {
                is_kosong = true;
            }
        });
        getJenisTransaksi();

        $("#tab_rekening").html("");
        $("#jumlah_pegawai").val(0);
        $("#total_pengajuan").val(0);
        $("#total_pph21").val(0);
        $("#total_thp").val(0);
        $("#totalrek_debit").val(0);
        $("#totalrek_kredit").val(0);

        if (is_kosong) {
            myAlert('Silakan Isi Periode dan Jenis Transaksi !!')
            return false;
        }

        $.post('<?php echo $this->createUrl('loadPengajuan'); ?>', $("#form_cari :input, select").serialize(), function(data) {
            $("#tab_rekening").html(data.rekening);
            $("#jumlah_pegawai").val(data.jumlah_pegawai);
            $("#total_pengajuan").val(data.total_pengajuan);
            $("#total_pph21").val(data.totalpph21);
            $("#total_thp").val(data.totalthp);
            hitungTotal();
            $(".pengbonusthrdetail_id").val(JSON.stringify(data.pengbonusthrdetail_id));
        }, 'json');
    }

    function hitungTotal() {
        unformatNumberSemua();
        var totaldebit = 0;
        var totalkredit = 0;

        $("#tab_rekening").find('tr').each(function() {
            var debit = parseFloat($(this).find(".saldodebit").val());
            var kredit = parseFloat($(this).find(".saldokredit").val());

            totaldebit += debit;
            totalkredit += kredit;
        });
        $("#totalrek_debit").val(totaldebit);
        $("#totalrek_kredit").val(totalkredit);
        formatNumberSemua();
    }

    $(document).ready(function() {
        // getDataPengajuanPeriode();
    });
</script>