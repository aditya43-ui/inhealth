<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'ppbuat-janji-poli-t-search',
            'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
            'type' => 'horizontal',
        ));
        ?>
        <div class="row">
            <div class="col-sm-6">
                 <div class="control-group">
                    <?php  echo CHtml::label(" <label for='PPBuatJanjiPoliT_is_janji'>Tanggal Janji</label>", 'tgl_janji', array('class' => 'control-label')) ?>
                     <div class="controls">
                        <div class="daterange daterange-inline add-ranges input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal_janji)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir_janji)) ?>"> 
                             <i class="entypo-calendar"></i>
                            <span><?php  echo date('d M Y', strtotime($model->tgl_awal_janji)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir_janji)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal_janji', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir_janji', array('class' => 'end')) ?>
                        </div>
                    </div> 
                 </div>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'numberOnly span4')); ?>
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'hurufs-only span4')); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nama_pegawai', array('placeholder' => 'Nama Dokter', 'class' => 'hurufs-only span4')); ?>
                <div class="control-group">
                    <?php echo Chtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        //echo $form->textFieldRow($model,'ruangan_nama',array('placeholder'=>'Nama Ruangan')); 
                        echo $form->dropDownList($model, 'ruangan_id', Chtml::listData(PPRuanganM::model()->findAll('ruangan_aktif = TRUE ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Penjamin', ' carabayar_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('GetPenjaminPasien', array('encode' => false, 'namaModel' => 'PPBuatJanjiPoliT')),
                                'update' => '#PPBuatJanjiPoliT_penjamin_id'  //selector to update
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Penjamin', ' Penjamin', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php $controller = Yii::app()->controller->id; ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'title' => 'Cari')); ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/Admin'), array(
                'class' => 'btn btn-default', 'title' => 'Ulang',
                'onclick' => 'return refreshForm(this);'
            ));
            ?>
            <?php
            $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiBuatJanjiPoli', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>

$(document).ready(function() {
    var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

    jQuery(penj).multiselect({
        includeSelectAllOption: true,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '240px',
        enableCaseInsensitiveFiltering: true
    }).hide();
});
</script>
<?php
$js = <<< JS
$('.numberOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";
if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}
if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>