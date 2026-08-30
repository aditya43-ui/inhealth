<style type="text/css">
    table tfoot tr td {
        background-color: white !important
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Jurnal Pengajuan Jasa dan Pajak Dokter</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js',  CClientScript::POS_END); ?>
            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js',  CClientScript::POS_END); ?>
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'jurnalpegajuanjasa-t-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
                'focus' => '#',
            ));
            ?>

            <?php echo $this->renderPartial($this->path_view . "_search", array(), true); ?>
        </div>

        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th style="width: 120px !important">Kode Akun</th>
                    <th>Nama Akun</th>
                    <th style="width: 150px !important">Debit</th>
                    <th style="width: 150px !important">Kredit</th>
                </tr>
            </thead>
            <tbody id="tab_rekening">

            </tbody>
            <tfoot>
                <tr>
                    <td style="font-weight: bold; text-align: right" colspan="2">
                        Total
                    </td>
                    <td><?php echo CHtml::textField('totalrek_debit', 0, array('class' => 'span3 integer2', 'readonly' => true)); ?></td>
                    <td><?php echo CHtml::textField('totalrek_kredit', 0, array('class' => 'span3 integer2', 'readonly' => true)); ?></td>
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
        var totalpengajuan = $("#total_pengajuan").val();

        var totaldebit = $("#totalrek_debit").val();
        var totalkredit = $("#totalrek_kredit").val();

        if (parseFloat(totalpengajuan) > 0) {
            if (parseFloat(totaldebit) === parseFloat(totalkredit)) {
                $('#jurnalpegajuanjasa-t-form').submit();
            } else {
                myAlert("Saldo Debit dan Kredit Tidak Sama");
            }
        } else {
            myAlert("Belum Ada Data Pengajuan Jasa Dokter untuk periode " + periode);
        }
    }

    function getDataPengajuanPeriode() {

        var is_kosong = false;
        $("#form_cari :input").each(function() {
            if ($(this).val() == "") {
                is_kosong = true;
            }
        });

        $("#tab_rekening").empty();
        $("#jumlah_pegawai").val(0);
        $("#total_pengajuan").val(0);
        $("#total_pajak").val(0);
        $("#totalrek_debit").val(0);
        $("#totalrek_kredit").val(0);

        if (is_kosong) {
            return false;
        }

        $.post('<?php echo $this->createUrl('loadNilaiPengajuan'); ?>', $("#form_cari :input").serialize(), function(data) {
            $("#tab_rekening").html(data.rekening);
            $("#jumlah_pegawai").val(data.jumlah_pegawai);
            $("#total_pengajuan").val(data.total_pengajuan);
            $("#total_pajak").val(data.total_pajak);
            hitungTotal();
            $(".pembayaranjasa_id").val(JSON.stringify(data.pembayaranjasa_id));
        }, 'json');
    }

    function hitungTotal() {
        var totaldebit = 0;
        var totalkredit = 0;

        $("#tab_rekening").find('tr').each(function() {
            var debit = parseFloat(unformatNumber($(this).find(".saldodebit").val()));
            var kredit = parseFloat(unformatNumber($(this).find(".saldokredit").val()));

            totaldebit += debit;
            totalkredit += kredit;
        });
        $("#totalrek_debit").val(formatNumber(totaldebit));
        $("#totalrek_kredit").val(formatNumber(totalkredit));
    }

    $(document).ready(function() {
        getDataPengajuanPeriode();
    });
</script>