<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php

$this->breadcrumbs = array(
    'Transaksi Penghapusan Piutang Penjamin Tak Tertagih',
);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'frm-penghapusanpiutang',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Penghapusan Piutang Penjamin Tak Tertagih</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Klaim Piutang Penjamin</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Pengajuan Klaim", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($modPengajuan, 'pengajuanklaimpiutang_id', array('readonly' => true));
                                echo $form->hiddenField($modPengajuan, 'penjamin_id', array('readonly' => true));
                                echo $form->textField($modPengajuan, 'tglpengajuanklaimanklaim', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("No. Pengajuan Klaim", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPengajuan, 'nopengajuanklaimanklaim', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Jenis Penjamin', "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPengajuan, 'carabayar_nama', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Penjamin", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPengajuan, 'penjamin_nama', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Total Piutang", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPengajuan, 'totalpiutang', array('readonly' => true, 'class' => 'span3 integer-decimal'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Total Telah Bayar", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPengajuan, 'tlhdibayar', array('readonly' => true, 'class' => 'span3 integer-decimal'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Total Sisa Piutang", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modPengajuan, 'totalsisapiutang', array('readonly' => true, 'class' => 'span3 integer-decimal'));
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penghapusan Piutang Tak Tertagih</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Penghapusan Piutang <span class="required">*</span>', '', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglpenghapusanpiutang',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Pegawai Penghapusan <span class='required'>*</span>", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($model, 'pegawaipenghapusan_id', array('readonly' => true));
                                echo $form->textField($model, 'pegawaipenghapusan_nama', array('readonly' => true, 'class' => 'span3'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Total Piutang Tak Tertagih <span class='required'>*</span>", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($model, 'jmlpiutangtaktertagih', array('readonly' => true, 'class' => 'span3 integer-decimal'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Alasan Penghapusan <span class="required">*</span>', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textArea($model, 'alasanpenghapusan', array(
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);"
                                )); ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <table id="tblInputRekening" class="table table-bordered table-condensed" widht="450">
                            <thead>
                                <tr>
                                    <th width="100">Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th width="100">Debit</th>
                                    <th width="100">Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $saveDisabled = (isset($_GET['sukses']) ? true : false);
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'disabled' => $saveDisabled, 'onclick' => 'simpanData()'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print()', 'disabled' => ($saveDisabled == true) ? false : true));
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
            $content = $this->renderPartial('keuangan.views.tips.transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function() {
            getDataRekening();
        }, 1000);

    });

    function simpanData() {
        $(".integer, .float, .integer-decimal").each(function() {
            $(this).val(unformatNumber($(this).val()));
        });
        $('#frm-penghapusanpiutang').submit();
    }

    function hitungTotal() {
        unformatNumberSemua();
        var jml = parseFloat($('#<?php echo CHtml::activeId($model, 'jmlpiutangtaktertagih'); ?>').val());
        $("#tblInputRekening > tbody").find('.saldodebit').val(jml);
        $("#tblInputRekening > tbody").find('.saldokredit').val(jml);
        formatNumberSemua();
    }

    function getDataRekening() {
        var penjamin_id = $("#<?php echo CHtml::activeId($modPengajuan, 'penjamin_id') ?>").val();
        $("#tblInputRekening").find('tbody').html('');
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDataRekening'); ?>',
            data: {
                penjamin_id: penjamin_id
            },
            dataType: "json",
            success: function(data) {
                $("#tblInputRekening > tbody").append(data.replace());
                renameRowRekening($("#tblInputRekening"));
                hitungTotal()
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function renameRowRekening(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
    }

    function print() {
        var pembayarklaim_id = "<?php echo isset($_GET['pembayarklaim_id']) ? $_GET['pembayarklaim_id'] : null; ?>";
        var pengajuanklaimpiutang_id = "<?php echo isset($_GET['pengajuanklaimpiutang_id']) ? $_GET['pengajuanklaimpiutang_id'] : null; ?>";
        window.open("<?php echo $this->createUrl('printPenghapusan') ?>&pembayarklaim_id=" + pembayarklaim_id + "&pengajuanklaimpiutang_id=" + pengajuanklaimpiutang_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
    }
</script>