<div class="panel panel-gradient">
    <div class="panel-heading">    
        <div class="panel-title">Pasca Anestesia</div>
    </div>
    <div class="panel-body">

        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN ANESTESI ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Pasca Anestesia berhasil disimpan");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pascaanestesi-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#' . CHtml::activeId($modKunjungan, 'nointraanestesi'),
        ));
        ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Data Pasien </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_dataPasien', array('modKunjungan' => $modKunjungan, 'modPascaAnestesi' => $modPascaAnestesi, 'modPraAnestesi' => $modPraAnestesi,)); ?>
            </div>
        </div> 

        <div class="row-fluid">		
            <div class="span12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title judul">Data Anestesi</div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial($this->path_view . '_formAnestesi', array('model' => $model, 'modPraAnestesi' => $modPraAnestesi, 'modPascaAnestesi' => $modPascaAnestesi, 'format' => $format, 'form' => $form)); ?>	
                    </div>
                </div>
            </div>
            <div class="span12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title judul">Data Ruangan Tujuan</div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial($this->path_view . '_formRuanganTujuan', array('model' => $model, 'modPraAnestesi' => $modPraAnestesi, 'modPascaAnestesi' => $modPascaAnestesi, 'format' => $format, 'form' => $form)); ?>	
                    </div>
                </div>
            </div>
            <div class="span12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title judul">Pemantauan Kondisi Pasien</div>
                    </div>
                    <div class="panel-body" style="overflow-y: auto;">
                        <?php $this->renderPartial($this->path_view . '_formPemantauanKondisi', array('modKondisiPasienAnestesi' => $modKondisiPasienAnestesi, 'modDetails' => $modDetails, 'format' => $format, 'form' => $form)); ?>	
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
//			if(isset($_GET['pascaanestesi_id'])){
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => (isset($_GET['sukses'])) ? true : false
            ));
            echo "&nbsp;";
//			}else{
//				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);'));
//				echo "&nbsp;";
//			}

            if (!isset($_GET['frame'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
                    'onclick' => 'return refreshForm(this);'));
            }

            echo "&nbsp;";

            if (isset($_GET['pascaanestesi_id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printHasil();return false"));
                echo "&nbsp;";
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printHasil();return false", 'disabled' => true));
                echo "&nbsp;";
            }

            $content = $this->renderPartial($this->path_view . 'tips/tipsPascaAnestesi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?> 
        </div>	
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$this->renderPartial($this->path_view . '_jsFunctions', array(
    'model' => $model,
    'modKunjungan' => $modKunjungan,
    'modPraAnestesi' => $modPraAnestesi,
    'modPascaAnestesi' => $modPascaAnestesi,
    'modKondisiPasienAnestesi' => $modKondisiPasienAnestesi,
));
?>


<div style='display:none;'>
    <?php
    $this->widget('MyDateTimePicker', array(
        'name' => 'tgl',
        'mode' => 'datetime',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
            'maxDate' => 'd',
        ),
        'htmlOptions' => array('readonly' => true,
            'onkeypress' => "return $(this).focusNextInputField(event)"),
    ));
    ?>
</div>