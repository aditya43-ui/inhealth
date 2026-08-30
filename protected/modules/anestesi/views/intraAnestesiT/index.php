<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'intraanestesi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>

<?php
$hide = '';
if (!empty($_GET['frame'])) {
    $hide = 'hide';
}

$myicon = new MyIcon;
?>
<div class="panel panel-gradient">
    <div class="panel-heading">    
        <div class="panel-title">Intra Anestesia</div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN ANESTESI ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Intra Anestesia berhasil disimpan");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>



        <div class="panel panel-success <?= $hide; ?>">
            <div class="panel-heading">
                <div class="panel-title judul">Data Pasien </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_dataPasien', array('modKunjungan' => $modKunjungan, 'modIntraAnastesi' => $modIntraAnastesi)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Data Waktu Anestesi / Sedasi </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formWaktuAnastesi', array('modObatCairanAnastesi' => $modObatCairanAnastesi, 'modIntraAnastesi' => $modIntraAnastesi, 'format' => $format, 'form' => $form)); ?>	
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Data Awal Anestesi / Sedasi</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formAwalAnastesi', array('modObatCairanAnastesi' => $modObatCairanAnastesi, 'modIntraAnastesi' => $modIntraAnastesi, 'format' => $format, 'form' => $form)); ?>	
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => (isset($_GET['sukses'])) ? true : false));
            echo "&nbsp;";

            if (!isset($_GET['frame'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'));
            }
            echo "&nbsp;";

            if (isset($_GET['id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printHasil();return false"));
                echo "&nbsp;";
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printHasil();return false", 'disabled' => true));
                echo "&nbsp;";
            }

            $content = $this->renderPartial($this->path_view . 'tips/tipsIntraAnestesi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?> 
            <?php
            if (!empty($_GET['pasienanastesi_id']) || !empty($_GET['monitoringintraanastesi_id'])) {
                echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
            }
            ?>
        </div>	
    </div>
</div>
<?php
$this->renderPartial($this->path_view . '_jsFunctions', array(
    'modKunjungan' => $modKunjungan,
    'modIntraAnastesi' => $modIntraAnastesi,
    'modPraAnastesi' => $modPraAnastesi,
    'modObatCairanAnastesi' => $modObatCairanAnastesi,
    'form' => $form,
));
?>
<?php $this->endWidget(); ?>