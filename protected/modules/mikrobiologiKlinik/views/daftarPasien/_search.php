<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'daftarpasien-t-search',
    'type'=>'horizontal',
)); 
?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Masuk Penunjang", 'tglmasukpenunjang', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')) ?>                        
            <div class="controls">
                <?php
                $prefix = array(
                    0 => Params::PREFIX_RAWAT_DARURAT,
                    1 => Params::PREFIX_RAWAT_INAP,
                    2 => Params::PREFIX_RAWAT_JALAN,
                    3 => Params::PREFIX_LABORATORIUM
                );
                echo $form->dropDownList($model, 'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix), array('class' => 'numbers-only', 'style' => 'width:75px;'));
                ?>
                <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10, 'placeholder' => 'Ketik No. Pendaftaran')); ?>                                                                
            </div>                                                
        </div>                    

        <div class="control-group">
            <label class="control-label">No. Rekam Medik</label>
            <div class="controls">
                <?php echo $form->textField($model, 'no_rekam_medik', array('placeholder' => 'Ketik No. Rekam Medik', 'class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 8)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Ketik Nama Pasien', 'class' => 'span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>								
    </div>
    <div class="col-sm-6">
        <?php
        $instalasi = InstalasiM::model()->findAllByAttributes(array(
            'instalasi_id' => array(2, 3, 4, 14, 17, 38, 79),
        ));
        $ruangan = RuanganM::model()->findAllByAttributes(array(
            'instalasi_id' => array(2, 3, 4, 14, 17, 38, 79),
            'ruangan_aktif' => true,
                ), array(
            'order' => 'instalasi_id, ruangan_nama',
        ));
        ?>
        <div class="control-group">
            <label class="control-label">  Instalasi Asal </label>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'instalasiasal_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3',
                    'ajax' => array('type' => 'POST',
                        'url' => $this->createUrl('/actionDynamic/getRuanganAsalDariInstalasiAsal', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "ruanganasal_id") . '").html(data);  reloadRuangan();}',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"> Ruangan Asal </label>
            <div class="controls">
                <?php 
                    echo $form->dropDownList($model, 'ruanganasal_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));
                ?>
            </div>
        </div>
        <?php
        $carabayar = CarabayarM::model()->findAll(array(
            'condition' => 'carabayar_aktif = true',
            'order' => 'carabayar_nourut',
        ));
        foreach ($carabayar as $idx => $item) {
            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                'carabayar_id' => $item->carabayar_id,
                'penjamin_aktif' => true,
            ));
            if (empty($penjamins))
                unset($carabayar[$idx]);
        }
        $penjamin = PenjaminpasienM::model()->findAll(array(
            'condition' => 'penjamin_aktif = true',
            'order' => 'penjamin_nama',
        ));
        ?>
        <div class="control-group">
            <label class="control-label"> Jenis Penjamin </label>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                    'empty' => '-- Pilih --',
                    'class' => 'span3',
                    'ajax' => array('type' => 'POST',
                        'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);}',
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"> Penjamin</label>
            <div class="controls">
                <?php
                    echo $form->dropDownList($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));
                ?>		
            </div>
        </div>
    </div>
</div>															
<div class="form-actions">
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang'
    );
    ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index'), array(
        'class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('index') . '";}); return false;')) . "&nbsp;";
    $content = $this->renderPartial('mikrobiologiKlinik.views.tips.informasi_pencarian', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>

<script>

$(document).ready(function() {

var instalasiasal  = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
var ruanganasal  = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');

jQuery(instalasiasal).multiselect({
    includeSelectAllOption: true,
    buttonClass: "form-control",
    maxHeight: 300,
    buttonWidth: '240px',
    enableCaseInsensitiveFiltering: true
}).hide();

jQuery(ruanganasal).multiselect({
    includeSelectAllOption: true,
    buttonClass: "form-control",
    maxHeight: 300,
    buttonWidth: '240px',
    enableCaseInsensitiveFiltering: true
}).hide();



});

function reloadRuangan() {

    var ruanganasal  = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');

    console.log('reload mulitselect ruangan asal');
    jQuery(ruanganasal).multiselect('rebuild');
}

</script>