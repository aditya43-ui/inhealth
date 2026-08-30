<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rootwizard',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)'
    ),
        //'focus' => '#'.CHtml::activeId($model, 'tgl_publikasi').'',
        ));
?>
<style>
    .control-label{
        /**text-align:left !important;
        vertical-align: top !important;**/
    }        

    .form-wizard > ul > li.active a span{
        background: #0066cc;        
    }

    .form-wizard > ul > li.active a{        
        color: #0066cc;
    }

    .form-wizard > ul > li a span{
        color:#333;
    }

    .form-wizard > ul > li a{        
        color:#333;
    }

    li.next > a, li.previous > a{
        border:1px solid #333;
        border-radius: 70%; 
        background: #333;
        color:#fff; 
        padding:0px;

    }        

    li.next > a:hover, li.previous > a:hover{
        border:1px solid #333;
        border-radius: 70%; 
        background: #333;
        color:#fff; 
        padding:0px;

    }   

    li.next > a > span, li.previous > a > span{
        font-size: 30px;
    }

    .tab-content > .tab-pane > .col-sm-2, .tab-content > .tab-pane > .col-sm-10{
        padding:2px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <span class="panel-title judul">Data Monitoring Intra Anastesi</span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <span class="panel-title judul"><?php echo!empty($_GET['monitoringintraanastesi_id']) ? 'Ubah' : 'Tambah'; ?> Data Monitoring Intra Anastesi</span>
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-md-6">
                        <?php
                        $cekPendaftaran = InformasipasienanestesiV::model()->findByAttributes(array('pasienanastesi_id' => $_GET['pasienanastesi_id']));
                        if (!empty($cekPendaftaran)) {
                            $model->pasienanastesi_id = $cekPendaftaran->pasienanastesi_id;
                            $model->pasien_id = $cekPendaftaran->pasien_id;
                            $model->pendaftaran_id = $cekPendaftaran->pendaftaran_id;
                        } else {
                            $model->pasienanastesi_id = null;
                            $model->pasien_id = null;
                            $model->pendaftaran_id = null;
                        }
                        echo CHtml::activeHiddenField($model, 'pasienanastesi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo CHtml::activeHiddenField($model, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        echo CHtml::activeHiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                        ?>
                        <div class="control-group menit-ke">
                            <label class="control-label">Menit Ke - </label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'menit_ke', array('class' => 'numbers-only span4')) ?>
                            </div>
                        </div>      
                        <div class="control-group">
                            <label class="control-label">Nadi</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'nadi', array('class' => 'numbers-only span4')); ?>
                            </div>
                            <div class="controls">
                                <label> x/menit</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Sistolik</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'tekanandarah_sistolik', array('class' => 'numbers-only span4', 'onchange' => 'hitungMAP();')); ?>
                            </div>
                            <div class="controls">
                                <label> mmHg</label>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Diastolik</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'tekanandarah_diastolik', array('class' => 'numbers-only span4', 'onchange' => 'hitungMAP();')); ?>
                            </div>
                            <div class="controls">
                                <label> mmHg</label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Mean Arterial Press</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'mean_arterial_press', array('placeholder' => '-- Otomatis --', 'class' => 'numbers-only span4', 'readonly' => true)); ?>
                            </div>              
                        </div>
                        <div class="control-group">
                            <label class="control-label">Spont. Respiration</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'spont_respiration', array('class' => 'numbers-only span4', 'onchange' => 'hitungMAP();')); ?>
                            </div>
                            <div class="controls">

                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Assisted Respiration</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'assissted_respiration', array('class' => 'numbers-only span4', 'onchange' => 'hitungMAP();')); ?>
                            </div>
                            <div class="controls">

                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Controlled Respiration</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'controlled_respiration', array('class' => 'numbers-only span4', 'onchange' => 'hitungMAP();')); ?>
                            </div>
                            <div class="controls">

                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tourniquet</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'tourniquet', array('class' => 'numbers-only span4')); ?>
                            </div>
                            <div class="controls">
                                <label> mmHg</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="control-group">
                            <label class="control-label">SpO2</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'spo2', array('class' => 'numbers-only span4')); ?>
                            </div>
                            <div class="controls">

                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">ETCO2</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'etco2', array('class' => 'numbers-only span4')); ?>
                            </div>
                            <div class="controls">

                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">CVP/ScVO2</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'cvp_spo2', array('class' => 'numbers-only span4')); ?>
                            </div>
                            <div class="controls">

                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">BIS</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'bis', array('class' => 'numbers-only span4')); ?>
                            </div>
                            <div class="controls">

                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Temp</label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'temp', array('class' => 'numbers-only span4')); ?>
                            </div>
                            <div class="controls">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="col-md-6">
                        <div class="control-group">
                            <label class="control-label"><b>Input/Cairan Masuk</b></label>
                            <div class="controls">

                            </div>
                        </div>
                        <div class="col-md-12" id='form-input-anestesi'>
                            <?php
                            $cekObat = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'OBAT'));
                            if (!empty($cekObat)) {
                                foreach ($cekObat as $i => $det) {
                                    echo $this->renderPartial($this->path_view . 'form._rowTabelObat', array('model' => $det, 'i' => $i));
                                }
                            } else {
                                echo $this->renderPartial($this->path_view . 'form._rowTabelObat', array('model' => $modInput, 'i' => 0));
                            }

                            $cekKristaloid = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'KRISTALOID'));
                            if (!empty($cekKristaloid)) {
                                foreach ($cekKristaloid as $i => $det) {
                                    echo $this->renderPartial($this->path_view . 'form._rowTabelKristaloid', array('model' => $det, 'i' => $i));
                                }
                            } else {
                                echo $this->renderPartial($this->path_view . 'form._rowTabelKristaloid', array('model' => $modInput, 'i' => 0));
                            }

                            $cekKolloid = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'KOLLOID'));
                            if (!empty($cekKolloid)) {
                                foreach ($cekKolloid as $i => $det) {
                                    echo $this->renderPartial($this->path_view . 'form._rowTabelKolloid', array('model' => $det, 'i' => $i));
                                }
                            } else {
                                echo $this->renderPartial($this->path_view . 'form._rowTabelKolloid', array('model' => $modInput, 'i' => 0));
                            }

                            $cekInputDarah = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'DARAH'));
                            if (!empty($cekInputDarah)) {
                                foreach ($cekInputDarah as $i => $det) {
                                    echo $this->renderPartial($this->path_view . 'form._rowTabelDarah', array('model' => $det, 'i' => $i));
                                }
                            } else {
                                echo $this->renderPartial($this->path_view . 'form._rowTabelDarah', array('model' => $modInput, 'i' => 0));
                            }

                            $cekLain = ATInputintraanastesiT::model()->findAllByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_input' => 'LAIN_LAIN'));
                            if (!empty($cekLain)) {
                                foreach ($cekLain as $i => $det) {
                                    echo $this->renderPartial($this->path_view . 'form._rowTabelLain', array('model' => $det, 'i' => $i));
                                }
                            } else {
                                echo $this->renderPartial($this->path_view . 'form._rowTabelLain', array('model' => $modInput, 'i' => 0));
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="control-group">
                            <label class="control-label"><b>Output/Cairan Keluar</b></label>
                            <div class="controls">

                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Jam Ke -</label>
                            <div class="controls">
                                <?php
                                if (!empty($_GET['monitoringintraanastesi_id'])) {
                                    $cekOutput = OutputintraanastesiT::model()->findByAttributes(array('monitoringintraanastesi_id' => $_GET['monitoringintraanastesi_id']));
                                    $modOutput->jam_ke = !empty($cekOutput) ? $cekOutput->jam_ke : null;
                                    $modOutput->monitoringintraanastesi_id = !empty($cekOutput) ? $cekOutput->monitoringintraanastesi_id : null;
                                }
                                echo CHtml::activeHiddenField($modOutput, 'monitoringintraanastesi_id', array('class' => 'numbers-only span1'));
                                echo CHtml::activeTextField($modOutput, 'jam_ke', array('class' => 'numbers-only span1'));
                                ?>
                            </div>
                        </div>
                        <?php
                        $output = LookupM::getItemsUrutan('monitorintraanestesi_outcairankeluar');

                        if (!empty($output)) {
                            $i = 0;
                            foreach ($output as $key => $val) {
                                $modOutput->jenis_output2 = $key;
                                if (!empty($_GET['monitoringintraanastesi_id'])) {
                                    $cekOutput = OutputintraanastesiT::model()->findByAttributes(array('monitoringintraanastesi_id' => $_GET['monitoringintraanastesi_id'], 'jenis_output2' => $key));
                                    $modOutput->nama_output2 = !empty($cekOutput) ? $cekOutput->nama_output2 : null;
                                    $modOutput->outputintraanastesi_id = !empty($cekOutput) ? $cekOutput->outputintraanastesi_id : null;
                                }
                                ?>
                                <div class="control-group">
                                    <label class="control-label"><?php echo $val ?></label>
                                    <div class="controls">
                                        <?php
                                        echo CHtml::activeHiddenField($modOutput, '[det][' . $i . ']outputintraanastesi_id', array('class' => 'span4'));
                                        echo CHtml::activeTextField($modOutput, '[det][' . $i . ']nama_output2', array('class' => 'span4'));
                                        echo CHtml::activeHiddenField($modOutput, '[det][' . $i . ']jenis_output2', array('class' => 'span4', 'readonly' => true));
                                        ?>
                                    </div>
                                    <div class="controls">
                                        <?php
                                        if ($key == Params::MONITOR_INTRAANESTESI_OUTCAIRANKELUAR_EBL) {
                                            echo '<label>%</label>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

        if (!isset($_GET['sukses'])) {
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'cekForm();'));
        } else {
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => '', 'disabled' => true));
        }
        echo '&nbsp;';
        if(!empty($_GET['frame'])){
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl('/' . $module . '/' . $controller . '/tambah', array('pasienanastesi_id' => $_GET['pasienanastesi_id'], 'monitoringintraanastesi_id' => (!empty($_GET['monitoringintraanastesi_id']) ? $_GET['monitoringintraanastesi_id'] : ''), 'frame' => 1)), array('class' => 'btn btn-danger',
                'onclick' => 'if(!confirm("Apakah Anda yakin ingin mengulang form ini ?")) return false;'));
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl('/' . $module . '/' . $controller . '/tambah', array('pasienanastesi_id' => $_GET['pasienanastesi_id'], 'monitoringintraanastesi_id' => !empty($_GET['monitoringintraanastesi_id']) ? $_GET['monitoringintraanastesi_id'] : '')), array('class' => 'btn btn-danger',
                'onclick' => 'if(!confirm("Apakah Anda yakin ingin mengulang form ini ?")) return false;'));
        }
        echo '&nbsp;';
        $cekPasienAnestesi = PasienanastesiT::model()->findByPk($_GET['pasienanastesi_id']);
        if(!empty($_GET['frame'])){
            echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl('grafikMonitoringIntraAnastesi/index', array('pasienanastesi_id' => $cekPasienAnestesi->pasienanastesi_id, 'pendaftaran_id' => $cekPasienAnestesi->pendaftaran_id, 'pasienmasukpenunjang_id' => $cekPasienAnestesi->pasienmasukpenunjang_id, 'frame' => 1)), array('class' => 'btn btn-danger'));
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl('grafikMonitoringIntraAnastesi/index', array('pasienanastesi_id' => $cekPasienAnestesi->pasienanastesi_id, 'pendaftaran_id' => $cekPasienAnestesi->pendaftaran_id, 'pasienmasukpenunjang_id' => $cekPasienAnestesi->pasienmasukpenunjang_id)), array('class' => 'btn btn-danger'));
        }
        $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
        echo '&nbsp;';
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>

    </div>
</div>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modKunjungan' => $modKunjungan), true); ?>   
<?php $this->endWidget(); ?>   