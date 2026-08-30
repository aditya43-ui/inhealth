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
                <div class="panel-title"> Revisi <strong> Rencana Umum Pengadaan</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'rup-t-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                ));
                ?>
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                }
                $this->widget('bootstrap.widgets.BootAlert');
                ?>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <b> Detil Pekerjaan </b> </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view_detail . '_formRUP', array('model' => $model, 'modLokasi' => $modLokasi, 'arrLokasi' => $arrLokasi, 'lokasi' => $lokasi, 'form' => $form), true); ?>
                    </div>
                </div>
                <?php echo CHtml::hiddenField("noRow", 0, array('readonly' => true)); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <b> RAB/HPS </b></div>
                    </div>
                    <div class="panel-body overflow-x">
                        <?php echo $this->renderPartial($this->path_view_revisi . '_formRAB', array('modRAB' => $modRAB, 'form' => $form, 'model' => $model), true); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <b> Dana </b> </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view_detail . '_formDana', array('model' => $model, 'jenis' => $jenis, 'modSumberDana' => $modSumberDana, 'modDana' => $modDana, 'modJenis' => $modJenis, 'arrSumberDana' => $arrSumberDana, 'arrJenis' => $arrJenis, 'form' => $form), true); ?>
                        <?php echo CHtml::hiddenField('jenis_trans', 'paket', array('readonly' => true, 'class' => '')); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><b> Jadwal </b></div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view_detail . '_formJadwal', array('model' => $model, 'form' => $form), true); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <b> Pejabat Pengadaan </b> </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view_detail . '_formPejabat', array('model' => $model, 'form' => $form), true); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <b> Alasan Revisi </b></div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view_revisi . '_formCatatan', array('model' => $model, 'form' => $form, 'modRiwayatPengadaan' => $modRiwayatPengadaan, 'modRevisi' => $modRevisi), true); ?>
                    </div>
                </div>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-riwayat',
                    'content' => array(
                        'content-riwayat' => array(
                            'header' => CHtml::htmlButton("<i class='icon-accordion icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat pengadaan')) . '<b> Riwayat</b>',
                            'isi' => $this->renderPartial($this->path_view_ubah . '_riwayat', array('form' => $form, 'model' => $modRiwayat), true),
                            'active' => false,
                        ),
                    ),
                ));
                ?>
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php // echo $form->hiddenField($model, 'statusnya', array('class' => 'span4')); ?>

                        <?php
                        if (!empty($_GET['sukses'])) {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary',
                                'type' => 'button', 'disabled' => true));
                        } else {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('id' => 'btn_submit', 'class' => 'btn btn-primary', 'onclick' => 'cekSimpanRUP(); return false;',
                                'type' => 'button'));
                        }
                        echo "&nbsp";
                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('revisi&id=' . $_GET['id'].'&revisi=1'), array('class' => 'btn btn-danger',
                            'onclick' => 'return refreshForm(this);'));
                        echo "&nbsp";
                        ?>

                        <?php
                        echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-success', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
                        ?>
                    </div>
                </div>
            </div>
            <?php
            echo $this->renderPartial($this->path_view_revisi . '_jsFunction', array(
                'model' => $model,
                'lokasi' => $lokasi,
                'jenis' => $jenis,
                'modLokasi' => $modLokasi,
                'modSumberDana' => $modSumberDana,
                'modDana' => $modDana,
                'modJenis' => $modJenis,
                'form' => $form), true);
            echo $this->renderPartial($this->path_view_revisi . '_dialog', array());
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>