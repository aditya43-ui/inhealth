<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
?>
<style>
    .form-horizontal .control-label{
        text-align: right;
        width: 180px
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><strong>Review Rencana Umum Pengadaan</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('bootstrap.widgets.BootAlert');

                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'rup-t-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
                ));
                ?>
                <?php
                $this->widget('bootstrap.widgets.BootAlert');
                ?>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><b> Detil Pekerjaan </b></div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial('detail/_formRUP', array('model' => $model, 'modLokasi' => $modLokasi, 'arrLokasi' => $arrLokasi, 'form' => $form), true); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><b> RAB/HPS </b></div>
                    </div>
                    <div class="panel-body">
                        <div class="panel-body overflow-x">
                            <?php echo $this->renderPartial('detail/_formRAB', array('modRAB' => $modRAB, 'form' => $form), true); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><b> Dana </b></div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial('detail/_formDana', array('model' => $model, 'modSumberDana' => $modSumberDana, 'modJenis' => $modJenis, 'arrSumberDana' => $arrSumberDana, 'arrJenis' => $arrJenis, 'form' => $form), true); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <b> Jadwal</b></div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial('detail/_formJadwal', array('model' => $model, 'form' => $form), true); ?>
                    </div>
                </div>                    
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <b> Dokumen Pendukung</b></div>
                    </div>
                    <div class="panel-body">
                        <div class="panel-body overflow-x">
                            <?php echo $this->renderPartial('detail/_formDokDukung', array('model' => $model, 'form' => $form), true); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><b> Pejabat Pengadaan </b></div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial('detail/_formPejabat', array('model' => $model, 'form' => $form), true); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><b> Catatan</b></div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial('detail/_formCatatan', array('model' => $model, 'modRiwayatPengadaan' => $modRiwayatPengadaan, 'form' => $form), true); ?>
                    </div>
                </div>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-riwayat',
                    'content' => array(
                        'content-riwayat' => array(
                            'header' => CHtml::htmlButton("<i class='icon-accordion icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat pengadaan')) . '<b> Riwayat</b>',
                            'isi' => $this->renderPartial('detail/_riwayat', array('form' => $form, 'model' => $modRiwayat), true),
                            'active' => false,
                        ),
                    ),
                ));
                ?>

                <div class="tombol_review">
                    <?php
                    $cekLogin = Yii::app()->user->getState('pegawai_id');
                    if (($model->rencanaumumpengadaan_status == 'Persetujuan PPK' && $model->pegawaippk_id == $cekLogin) ||
                            ($model->rencanaumumpengadaan_status == 'Persetujuan KPA' && $model->pegawaikpa_id == $cekLogin) ||
                            ($model->rencanaumumpengadaan_status == 'Persetujuan PA' && $model->pegawaipa_id == $cekLogin)) {
                        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', 'Setuju') :
                                        Yii::t('mds', '{icon} Setuju', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-success', 'id' => 'btn_menyetujui', 'type' => 'button', 'onclick' => 'setMenyetujui("' . $model->rencanaumumpengadaan_id . '");return false;'));
                        echo '&nbsp;';
                        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', 'Revisi') :
                                        Yii::t('mds', '{icon} Revisi', array('{icon}' => '<i class="icon-remove icon-white"></i>')), array('class' => 'btn btn-danger', 'id' => 'btn_revisi', 'type' => 'button', 'onclick' => 'setRevisi("' . $model->rencanaumumpengadaan_id . '");return false;'));
                    } else {
                        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', 'Setuju') :
                                        Yii::t('mds', '{icon} Setuju', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'myAlert("Maaf, Anda tidak bisa melakukan review")'));
                        echo '&nbsp;';
                        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', 'Revisi') :
                                        Yii::t('mds', '{icon} Revisi', array('{icon}' => '<i class="icon-remove icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'myAlert("Maaf, Anda tidak bisa melakukan review")'));

                        echo "&nbsp;";
                        echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-success', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
                    }
                    ?>
                </div>

            </div>
            <?php echo $this->renderPartial('detail/_jsFunction', array('model' => $model, 'modLokasi' => $modLokasi, 'modSumberDana' => $modSumberDana, 'modJenis' => $modJenis, 'form' => $form), true); ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
</div>

<script>
    function setMenyetujui(id) {
        $('#RiwayatpengadaanR_statusnya').val('DISETUJUI');
        disableOnSubmit($("#btn_menyetujui"), 'no_unformat');
        $('#rup-t-form').submit();

    }

    function setRevisi(id) {
        $('#RiwayatpengadaanR_statusnya').val('DITOLAK');
        disableOnSubmit($("#btn_revisi"), 'no_unformat');
        $('#rup-t-form').submit();
    }

    $(document).ready(function () {
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');

<?php if (isset($_GET['sukses'])) { ?>
            $(".tombol_review button").each(function (btn) {
                $(this).attr("disabled", true);
            });
            window.history.go(-2);
<?php } ?>
    });
</script>