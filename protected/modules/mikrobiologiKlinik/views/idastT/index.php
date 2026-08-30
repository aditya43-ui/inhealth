<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'idast-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<style>
    .form-horizontal .control-label{
        width: 170px !important;
    }
</style>
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>ID/AST</strong></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'><strong>Data Spesimen</strong></span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formSpesimen', array('modSpesimen' => $modSpesimen, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success panel-shadow" id="row1">
            <div class="panel-heading">
                <div class="panel-title"> 
                    <b> Data ID/AST</b> 
                </div>
                <span style="float:right; padding: 10px">
                    <?= CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-green', 'type' => 'button', 'onclick' => 'showPanel();return false;')); ?>
                </span>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'><strong>Identification</strong></span></div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formIdentifikasi', array('model' => $model, 'form' => $form)); ?>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'><strong>Antibiotic Susceptibility Test</strong></span></div>
                    </div>
                    <div class="panel-body">
                        <table id="AST" width="80%" style="margin-left: 110px">

                        </table>
                        <br>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'keterangan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($model, 'keterangan', array('rows' => 3, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="row2"> 
            <?php 
            if (!empty($model2->idast_id)) {
                $this->renderPartial('_formRow2', array('model2' => $model2, 'modelDetail2' => $modelDetail2)); 
            }
            ?>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'><strong>Person In Charge</strong></span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formPIC', array('model' => $model, 'modSpesimen' => $modSpesimen, 'form' => $form)); ?>
            </div>
        </div>
        <br>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                    echo "&nbsp;";
                }
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('spesimen_id' => $modSpesimen->spesimen_id)), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
                echo "&nbsp;";


                if (!empty($model->idast_id)) {
                    $cekLoginpemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
                    if ($model->status_verifikasi == 'Terverifikasi') {
                        if ($cekLoginpemakai->pegawai_id == $model->verifikator_id) {
                            echo CHtml::link(Yii::t('mds', '{icon} Terverifikasi', array('{icon}' => '<i class="glyphicon glyphicon-ok"></i>')), $this->createUrl($this->id . '/index', array('spesimen_id' => $modSpesimen->spesimen_id)), array('class' => 'btn btn-success', 'onclick'=>'myConfirm("Apakah anda yakin akan membatalkan verifikasi?","Perhatian!",function(r){if(r) setBatalVerifikasi();}); return false;'));
                        } else {
                            echo CHtml::Link("<i class='glyphicon glyphicon-ok'></i> Terverifikasi", 'javascript:;', array("class" => "btn btn-green", 'onclick' => 'myAlert("Anda tidak bisa membatalkan verifikasi","Perhatian !")'));
                        }
                    } else {
                        if ($cekLoginpemakai->pegawai_id == $model->verifikator_id) {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Belum Terverifikasi', array('{icon}' => '<i class="glyphicon glyphicon-ok"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi();'));
                        } else {
                            echo CHtml::Link("<i class='glyphicon glyphicon-ok'></i> Belum Terverifikasi", 'javascript:;', array("class" => "btn btn-danger", 'onclick' => 'myAlert("Anda tidak bisa melakukan verifikasi","Perhatian !")'));
                        }
                    }
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Belum Terverifikasi', array('{icon}' => '<i class="glyphicon glyphicon-ok"></i>')), $this->createUrl($this->id . '/index', array('spesimen_id' => $modSpesimen->spesimen_id)), array('class' => 'btn btn-danger', 'disabled' => true));
                }


                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl('InformasiDaftarSpesimen/Index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-green'));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
    function showPanel() {
        var id = <?php echo!empty($model2->idast_id) ? $model2->idast_id : 0 ?>;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadBarisKedua'); ?>',
            data: { id:id },
            dataType: "json",
            success: function (data) {
                $("#row2").html(data.html);
//                showAST2();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
        
    function hidePanel() {
        $("#row2").html("");
    }
    
    /**
     * Set verifikasi
     * @returns {undefined}
     */
    function setVerifikasi() {
        var id = <?php echo!empty($model->idast_id) ? $model->idast_id : 0 ?>;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setVerifikasi'); ?>',
            data: {id: id},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    toastr.success("Berhasil Verifikasi");
                    window.location.reload(true);
                } else {
                    toastr.error("Gagal Verifikasi", "Perhatian!");
                    window.location.reload(true);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }


    /**
     * Set Batal Verifikasi
     * @returns {undefined}
     */
    function setBatalVerifikasi() {
        var id = <?php echo!empty($model->idast_id) ? $model->idast_id : 0 ?>;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setBatalVerifikasi'); ?>',
            data: {id: id},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    toastr.success("Berhasil Membatalkan Verifikasi");
                    window.location.reload(true);
                } else {
                    toastr.error("Verifikasi Gagal Diubah", "Perhatian!");
                    window.location.reload(true);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }
    
    /**
     * Generate Detail AST
     * @returns {undefined}
     */
    function showUbahAST() {
        var panel = $("#IdastT_panel_nama").val();
        var id = <?php echo!empty($model->idast_id) ? $model->idast_id : 0 ?>;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('generateDetailAST'); ?>',
            data: {panel: panel, id: id},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    $("#AST").html(data.html);
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Generate Detail AST
     * @returns {undefined}
     */
    function showUbahAST2() {
        var panel = $("#MKIdastT_panel_nama").val();
        var id = <?php echo!empty($model2->idast_id) ? $model2->idast_id : 0 ?>;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('generateDetailAST2'); ?>',
            data: {panel: panel, id: id},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    $("#AST2").html(data.html);
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function hapusPanel() {
        var id = <?php echo!empty($model2->idast_id) ? $model2->idast_id : 0 ?>;
        myConfirm('Apakah anda yakin untuk menghapus data dibawah ini?', 'Perhatian!', function (r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusData'); ?>', {id: id}, function (data) {
                    if (data.ok == 1) {
                        $("#row2").html("");
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }

    $(document).ready(function () {
<?php if (!empty($model->idast_id)) { ?>
            showAST();
<?php } ?>
<?php if (!empty($model2->idast_id)) { ?>
            showAST2();
<?php } ?>
<?php if (isset($_GET['sukses'])) { ?>
            showUbahAST();
            showUbahAST2();
            $("#idast-t-form").find('input,select,textarea,dropdown').each(function () {
                $(this).attr('disabled', true);
            });
            $('.add-on').hide();
<?php } ?>
    });
</script>