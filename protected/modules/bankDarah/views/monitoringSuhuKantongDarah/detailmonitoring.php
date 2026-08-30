<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/fileinput.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/datetime.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'monitoringsuhudetail-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)',
    ),
        ));
$this->widget('bootstrap.widgets.BootAlert'); 
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Monitoring Suhu Coolbox</div>
    </div>
    <div class="panel-body">   
        <fieldset class="" id="tablePegawaicuti">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Tabel Monitoring Suhu Coolbox</div>
                </div>
                <div class="panel-body">               
                    <div class="form-actions">
                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <label class="control-label">No. Penggunaan Coolbox</label>                                
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'no_penggunaan_coolbox', array('class' => 'span3', 'readonly' => true)); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Tanggal Monitoring</label>                                
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'tgl_penggunaan_coolbox', array('class' => 'span3', 'readonly' => true)); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Jenis Coolbox', '', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'coolboxdarah_nama', array('class' => 'span3', 'readonly' => true)); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Lokasi Rekrutmen', '', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'ruangan_nama', array('class' => 'span3', 'readonly' => true)); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <?php echo CHtml::label('Jumlah Ice Pack', '', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'jumlah_icepack', array('class' => 'span3 numbers-only', 'readonly' => true)); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Ukuran Coolbox', '', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'ukuran_coolbox', array('class' => 'span3', 'readonly' => true)); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Jenis Kantong Yang Diisikan', '', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'jenis_kantong', array('class' => 'span3', 'readonly' => true)); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Standar Suhu', '', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'standar_suhu', array('class' => 'span3', 'readonly' => true)); ?> ℃
                                    </div>
                                </div>
                                <?php echo $form->hiddenField($model, 'penggunaan_coolbox_id', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->hiddenField($model, 'coolboxdarah_id', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Monitoring Suhu Cool Box</span></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class = "col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Jam Monitoring', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modKantong,
                                    'attribute' => 'jam_monitoring',
                                    'mode' => 'time',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('class' => 'span3 ', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Kosong Tanpa Listrik', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modKantong, 'kosongtanpalistrik', array('class' => 'span3 angkacoma-only setkosong monitor')); ?> ℃
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Kosong Dengan Listrik', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modKantong, 'kosongdenganlistrik', array('class' => 'span3 angkacoma-only setkosong monitor')); ?> ℃
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Listrik Dan Ice Pack Suhu', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modKantong, 'listrikdanicepack', array('class' => 'span3 angkacoma-only setkosong monitor')); ?> ℃
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Mulai Isi Kantong Darah', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modKantong, 'mulaiisikantong', array('class' => 'span3 angkacoma-only setkosong monitor')); ?> ℃
                            </div>
                        </div>
                    </div>
                    <div class = "col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Setelah Diisi Kantong Darah', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modKantong, 'setelahdiisikantong', array('class' => 'span3 angkacoma-only setkosong monitor')); ?> ℃
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Lepas Listrik', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modKantong, 'lepaslistrik', array('class' => 'span3 angkacoma-only setkosong monitor')); ?> ℃
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Keterangan", 'ket_monitoring', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextArea($modKantong, 'ket_monitoring', array('class' => 'span3 monitor')); ?>
                                <?php echo CHtml::activeHiddenField($modKantong, 'monitoring_ke', array('class'=>'span3')); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo CHtml::label('Nama Petugas Monitoring', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $modKantong->petugasmonitoring_id = Yii::app()->user->getState('pegawai_id');
                                $cekPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                                if (!empty($cekPegawai)) {
                                    $modKantong->petugasmonitoring_nama = $cekPegawai->namaLengkap;
                                } else {
                                    $modKantong->petugasmonitoring_nama = '';
                                }
                                ?>
                                <?php echo $form->hiddenField($modKantong, 'petugasmonitoring_id', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->textField($modKantong, 'petugasmonitoring_nama', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label(" ", 'tglmonitoring', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Tambah', array('{icon}' => '<i class="entypo-plus"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'tambahSuhu();return false;')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Tabel Monitoring Suhu Cool Box</span></div>
            </div>
            <div class="panel-body" style="overflow-y: auto;">
                <div class="row-fluid">
                    <table class="table table-bordered table-striped table-condensed" id="detail-suhu">
                        <thead>
                            <tr>
                                <th>Jam Monitoring</th>
                                <th>Kosong Tanpa Listrik</th>
                                <th>Kosong Dengan Listrik</th>
                                <th>Listrik dan Ice Pack</th>
                                <th>Mulai Isi Kantong Darah</th>
                                <th>Setelah Diisi Kantong Darah</th>
                                <th>Lepas Listrik</th>
                                <th>Petugas Monitoring</th>
                                <th>Keterangan</th>
                                <th>Batal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->renderPartial('_rowTabel3', array('form' => $form,
                                'modShow' => $modShow));
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('id'=>'tombol_simpan' ,'disabled'=>true, 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'cekSimpan();return false;'));
        echo "&nbsp;";
        echo '&nbsp;' . CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array(
            'class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')) . "&nbsp;";
        echo "&nbsp;";

        $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        echo "&nbsp;";
        echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl('monitoringSuhuKantongDarah/Informasi', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-green'));
        ?>
    </div>
</div>
<?php $this->endWidget();
?>   
<script>

    function tambahSuhu() {
        var petugasmonitoring_id = $("#<?php echo CHtml::activeId($modKantong, 'jam_monitoring') ?>").val();
        if (petugasmonitoring_id == "") {
            myAlert("Jam Monitoring Belum Diinputkan");
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setSuhuMonitor2'); ?>',
            data: $('#monitoringsuhudetail-form').serialize(),
            dataType: "json",
            success: function (data) {
                $("#detail-suhu > tbody").append(data.form);
                reset();
                $("#MonitoringkantongT_jam_monitoring").val('');
                $(".monitor").removeClass('error');
                $(".monitor").val('');
                $(".setkosong").val('');
                cekTabelMonitoring();
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }
    function reset() {
        renameInput("BDMonitoringkantongT", "kosongtanpalistrik_suhu");
        renameInput("BDMonitoringkantongT", "kosongtanpalistrik");
        renameInput("BDMonitoringkantongT", "kosongdenganlistrik_suhu");
        renameInput("BDMonitoringkantongT", "kosongdenganlistrik");
        renameInput("BDMonitoringkantongT", "listrikdanicepack_suhu");
        renameInput("BDMonitoringkantongT", "listrikdanicepack");
        renameInput("BDMonitoringkantongT", "mulaiisikantong_suhu");
        renameInput("BDMonitoringkantongT", "mulaiisikantong");
        renameInput("BDMonitoringkantongT", "setelahdiisikantong_suhu");
        renameInput("BDMonitoringkantongT", "setelahdiisikantong");
        renameInput("BDMonitoringkantongT", "lepaslistrik_suhu");
        renameInput("BDMonitoringkantongT", "lepaslistrik");
        renameInput("BDMonitoringkantongT", "ket_monitoring");
        renameInput("BDMonitoringkantongT", "petugasmonitoring_id");
        renameInput("BDMonitoringkantongT", "jammonitoring");
        renameInput("BDMonitoringkantongT", "monitoring_ke");
    }

    function renameInput(modelName, attributeName)
    {
        var i = 0;
        $('#detail-suhu tbody tr').each(function () {
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            i++;
        });
    }

    function batalDetail(obj) {
        myConfirm("Apakah anda akan membatalkan monitoring ini ?", "Peringatan", function (r) {
            if (r) {
                $(obj).parents('tr').detach();
                reset();
                cekTabelMonitoring();
            }
        });
    }

    function cekSimpan() {
        $(".angkacoma-only").each(function () {
            $(this).val(parseFloat(unformatNumber($(this).val())));
        });
        var trLength = $('#detail-suhu tbody tr').length;
        if (trLength > 0) {
            $("#monitoringsuhudetail-form").submit();
        } else {
            myAlert("Tambahkan pencatatan monitoring suhu terlebih dahulu");
        }
    }
    
    function cekTabelMonitoring(){
        var ada = 0;
        $('#detail-suhu tbody tr').find('input[name$="[petugasmonitoring_id]"]').each(function () {
            ada++;
        });
        
        if(ada == 0){
            $('#tombol_simpan').attr('disabled', true);
        }else{
            $('#tombol_simpan').removeAttr('disabled');
        }
    }

    $(document).ready(function () {
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });

        cekDisabled('form');

    });

    function hapusBaris(obj) {

        var id = $(obj).parents("tr").find(".monitoringkantong_id").val();

        myConfirm("Apakah Anda yakin, ingin menghapus data ini ?", "Perhatian !", function (r) {
            if (r) {
                var del = "<tr><td><input type='hidden' value='" + id + "' name='hapus[monitor][]'></td></tr>";

                $("#tabel-hapus > tbody").append(del);

                $(obj).parents("tr").remove();
                renameInput($("#table-monitoring"));
                generatePicker();
            }
        });

    }


</script>

