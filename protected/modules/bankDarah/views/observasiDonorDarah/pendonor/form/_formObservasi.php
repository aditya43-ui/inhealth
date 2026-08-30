<?php
/**
 * form utama untuk menginput observasi donor darah
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<style>
    .kel-tekanan{
        width:70px !important;
    }

    .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }
</style>

<?php
$sample = '-';
$utama = ' - ';

if (!empty($cekKantong->kantongdarah_id)) {
    $sample = $cekKantong->nomorbarcode_sample;
    $utama = $cekKantong->nomorbarcode_utama;
}
?>
<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label">Tanggal</label>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tanggalobservasi_setelahpenyadapan',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 ', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                ),
            ));
            ?>
        </div>        
    </div>    
</div>
<div class="clear"></div>
<div class="col-sm-6">
    <div class="control-group">        
        <label class="control-label">Kelancaran Aliran Darah</label>
        <?php
        $alasan = LookupM::getItems('kelancarandarah');
        $get = array();
        foreach ($alasan as $key => $val) {
            echo "<div class='controls'>";
            echo $form->radioButton($model, 'kelancarandarah_setelahpenyadapan', array('uncheckValue' => null, 'value' => $key)) . '<label>' . $val . '</label>';
            echo "</div>";
        }
        ?>                        
    </div>
    <div class="control-group">        
        <label class="control-label">Keluhan</label>
        <div class="controls">
            <?php
            echo $form->radioButton($model, 'adakeluhan_setelahpenyadapan', array('uncheckValue' => null, 'value' => true, 'onclick' => 'cekKeluhan(this);')) . '<label>Ya</label>';
            ?>                        
        </div>

        <div class="controls">
            <?php
            echo $form->radioButton($model, 'adakeluhan_setelahpenyadapan', array('uncheckValue' => null, 'value' => false, 'onclick' => 'cekKeluhan(this);')) . '<label>Tidak</label>';
            ?>                        
        </div>
    </div>   
    <div class="control-group" id="fieldkeluhan" style="display:<?php echo ($model->adakeluhan_setelahpenyadapan == true) ? 'block;' : 'none;'; ?>">
        <label class="control-label"></label>
        <div class="controls">
            <?php
            $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                'model' => $model,
                'attribute' => 'keluhan_setelahpenyadapan',
                'data' => explode(',', $model->keluhan_setelahpenyadapan),
                'debugMode' => true,
                'options' => array(
                    //'bricket'=>false,
                    //'json_url'=>$this->createUrl('MasterKeluhan'),
                    'addontab' => true,
                    'maxitems' => 10,
                    'input_min_size' => 0,
                    'cache' => true,
                    'newel' => true,
                    'addoncomma' => true,
                    'select_all_text' => "",
                    'autoFocus' => true,
                ),
            ));
            ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            &nbsp;
        </div>
    </div>       


</div>
<div class="clear"></div>
<p>&nbsp;</p>
<?php
?>
<div class="panel panel-darkk" id="adakeluhan" style="display:<?php echo ($model->adakeluhan_setelahpenyadapan == true) ? 'block;' : 'none;'; ?>">
    <span class="group-title">
        Tanda Vital
    </span>
    <div class="panel-body" id="tandavital">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Nadi</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'nadi_setelahpenyadapan', array('class' => 'span2 numbers-only')); ?>
                </div>
                <div class="controls">
                    <label>x/mnt</label>
                </div>
            </div>                        

            <div class="control-group">
                <label class="control-label">Suhu</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'suhu_setelahpenyadapan', array('class' => 'span2 integer-decimal')); ?>
                </div>
                <div class="controls">
                    <label><sup>o</sup>C</label>
                </div>
            </div>

            <div class="control-group" >
                <label class="control-label">Tekanan Darah</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'td_systolic_setelahpenyadapan', array('class' => 'kel-tekanan numbers-only')); ?>
                </div>
                <div class="controls">
                    <label>/</label>
                </div>
                <div class="controls">
                    <?php echo $form->textField($model, 'td_diastolic_setelahpenyadapan', array('class' => 'kel-tekanan numbers-only')); ?>
                </div>
                <div class="controls">
                    <label>mm/Hg</label>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Pernapasan</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'pernafasan_setelahpenyadapan', array('class' => 'span2')); ?>
                </div>
                <div class="controls">
                    <label>x/mnt</label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Kesadaran</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'kesadaran_setelahpenyadapan', array('class' => 'span2')); ?>
                </div>               
            </div>
        </div>
    </div>
</div>

<div class="clear">
</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Keterangan</label>
        <div class="controls">
            <?php echo $form->textArea($model, 'keterangan_setelahpenyadapan', array()); ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Tindakan</label>
        <div class="controls">
            <?php echo $form->textArea($model, 'tindakan_setelahpenyadapan', array()); ?>
        </div>
    </div>
</div>
<div class="clear">
</div>
<br>
<?php // echo $this->renderPartial($this->path_view.'pendonor/form/_formkantong',array('model'=>$model, 'modPenggunaan'=>$modPenggunaan,'form'=>$form),true); ?>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Petugas Penyadap</label>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'petugaspenyadapan_id', array('readonly' => true)); ?>
            <?php echo $form->textField($model, 'petugaspenyadapan_nama', array('readonly' => true)); ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Nama Petugas</label>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true)); ?>
            <?php echo $form->textField($model, 'nama_pegawai', array('readonly' => true)); ?>
        </div>
    </div>
</div>
<div class="clear">
</div>
<br>
<div class="panel">    
    <div class="panel-body">
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('onclick' => 'cekForm();', 'class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/observasiDonorDarah/penyadapan', array('daftardonasi_id' => $modDaftarDonasi->daftardonasi_id)), array('class' => 'btn btn-danger',
            'onclick' => 'if(!confirm("Apakah Anda yakin ingin mengulang form ini ?")) return false;'));
        ?>
        <?php
        $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>
    </div>
</div>