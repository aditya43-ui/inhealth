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
                <div class="panel-title"><strong>Detil Rencana Umum Pengadaan</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('bootstrap.widgets.BootAlert');

                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'rup-t-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
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
                        <div class="panel-title">Detil Pekerjaan</div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial('detail/_formRUP', array('model' => $model, 'modLokasi' => $modLokasi, 'arrLokasi' => $arrLokasi, 'form' => $form), true); ?>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">RAB/HPS</div>
                        </div>
                        <div class="panel-body">
                            <div class="panel-body overflow-x">
                                <?php echo $this->renderPartial('detail/_formRAB',array('modRAB'=>$modRAB,'form'=>$form),true); ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">Dana</div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial('detail/_formDana', array('model' => $model, 'modSumberDana' => $modSumberDana, 'modJenis' => $modJenis, 'arrSumberDana' => $arrSumberDana, 'arrJenis' => $arrJenis, 'form' => $form), true); ?>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">Jadwal</div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial('detail/_formJadwal', array('model' => $model, 'form' => $form), true); ?>
                        </div>
                    </div>                    
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">Dokumen Pendukung</div>
                        </div>
                        <div class="panel-body">
                            <div class="panel-body overflow-x">
                                <?php echo $this->renderPartial('detail/_formDokDukung',array('model'=>$model,'form'=>$form),true); ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">Pejabat Pengadaan</div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial('detail/_formPejabat',array('model'=>$model,'form'=>$form),true); ?>
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
                    
                <?php 
                    echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-left-bold"></i>')), 
                        Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/index'),
                        array('class'=>'btn btn-success')); 
                ?>
                </div>
            <?php echo $this->renderPartial('detail/_jsFunction', array('model' => $model, 'modLokasi' => $modLokasi, 'modSumberDana' => $modSumberDana, 'modJenis' => $modJenis, 'form' => $form), true); ?>
            <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
    });
</script>