<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'sainstalasi-m-search',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jenisdokumen', LookupM::getItemsUrutan('jenisdokumenkelengkapan_rm'), ['empty' => '--- Pilih ---']) ?>
        <?php echo $form->textFieldRow($model, 'nama_dokumen', array('placeholder' => 'Nama Dokumen', 'class' => 'span4')); ?>
        <?php echo $form->textFieldRow($model, 'urutan_dokumen', array('placeholder' => 'Urutan Dokumen', 'class' => 'span4')); ?>
       
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'level_dokumen', ['1' => '1', '2' => '2'], ['empty' => '--- Pilih ---', 'onchange' => 'setKelompokDokumen(this)']) ?>
        <?php 
            
            $kelompoks = KelengkapandokumenRmM::model()->findAll('level_dokumen = 1 and kelengkapandokumen_aktif = true');
            $listKelompok = CHtml::listData($kelompoks, 'nama_dokumen', 'nama_dokumen');
            
        ?>
        <?php echo $form->dropDownListRow($model, 'kelompok_dokumen', $listKelompok, ['empty' => '--- Pilih ---', 'id' => 'kelompok_dokumen']) ?>
        <?php echo $form->dropDownListRow($model, 'tipe', ['Ada/Tidak Ada' => 'Ada/Tidak Ada', 'Lengkap/Tidak Lengkap' => 'Lengkap/Tidak Lengkap'], ['empty' => '--- Pilih ---']) ?>
        <div class="control-group">
            <label class="control-label">Aktif</label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kelengkapandokumen_aktif') ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>