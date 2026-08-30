<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'detail-kantong-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#no_kantongdarah',
        ));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Detail <b>Kantong Darah</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Data Pendonor </span></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="panel-body overflow-x">
                        <div class="col-md-4">
                            <div class="control-group">
                                    <?php echo CHtml::label("No. Formulir &nbsp;", 'no_formulir', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::activeHiddenField($modPendonor, 'pendonor_id', array('readonly' => true)); ?>
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modDaftarDonasi, 'no_formulir', array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("No. Registrasi &nbsp;", 'no_pendonor', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'no_pendonor', array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Nama Pendonor &nbsp;", 'nama_lengkap', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'nama_lengkap', array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Tanggal Lahir &nbsp;", 'tgllahir', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php 
                                    $modPendonor->tgllahir = MyFormatter::formatDateTimeForUser($modPendonor->tgllahir);
                                    echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'tgllahir', array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                    <?php echo CHtml::label("Umur &nbsp;", 'umur', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo '&nbsp;' . CHtml::textField('tgllahir', (!empty($modPendonor->tgllahir)) ? CustomFunction::hitungUmur($modPendonor->tgllahir) : "-", array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                    <?php echo CHtml::label("Jenis Kelamin &nbsp;", 'jenis_kelamin', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'jenis_kelamin', array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="control-group">
                                <?php echo CHtml::label("Agama &nbsp;", 'agama', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'agama', array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                    <?php echo CHtml::label("Status &nbsp;", 'statusperkawinan', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'statusperkawinan', array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Golongan Darah &nbsp;", 'gol_darah', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'gol_darah', array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                    <?php echo CHtml::label("Rhesus &nbsp;", 'rhesus', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'rhesus', array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                    <?php echo CHtml::label("&nbsp; Riwayat Donor &nbsp; <br>Terakhir &nbsp;", 'waktu_observasi', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo '&nbsp;' . CHtml::activeTextField($modPendonor, 'waktu_observasi', array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php $url_photopasien = (!empty($modPendonor->photopendonor) ? Params::urlPendonorDirectory() . $modPendonor->photopendonor : Params::urlPendonorDirectory() . "no_photo.jpeg"); ?>
                            <img id="photo-preview" src="<?php echo $url_photopasien ?>"width="184px" style="position: absolute"/>   

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Detail Kantong Darah </span></div>
            </div>
            <div class="panel-body">
                <?php 
                    $modKantongDarah = KantongdarahT::model()->findByAttributes(array('daftarpendonor_id' => $_GET['daftardonasi_id']));
                    //if (empty($modKantongDarah)) {
                        $this->renderPartial($this->path_view_detailkantong . '_formKantongDarah', array('modPendonor' => $modPendonor)); 
                    //} else {
                      //  $this->renderPartial($this->path_view_detailkantong . '_rowKantongSimpan', array('modPendonor' => $modPendonor)); 
                    //}
                ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit', 'disabled' => true));
                echo "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                    'id'=>'btn_submit','type' => 'button', 'onclick' => 'cekForm();', 'onkeypress' => 'formSubmit(this,event);'));
                echo "&nbsp;";
            }
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('id' => $_GET['pendonor_id'])), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
            
            echo "&nbsp;";
            echo CHtml::htmlButton(Yii::t('mds','{icon} Tutup',array('{icon}'=>'<i class="fa fa-chevron-left"></i>')),array(
                                'class'=>'btn btn-primary submit', 
                                'type'=>'button',
                                'onclick'=>'closeDialog();return false;',
                                'onKeypress'=>'return formSubmit(this,event)'
                            )); 
            ?>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view_detailkantong . '_jsFunctions', array('modPendonor' => $modPendonor)); ?>
<?php $this->renderPartial($this->path_view_detailkantong . '_dialog', array('modPendonor' => $modPendonor)); ?>
<?php $this->endWidget(); ?>