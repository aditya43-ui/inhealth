<?php

$modReferensiHasil = new ROReferensiHasilRadM;
$hideBanyak = "none";
$hideSingle = "block";
if (isset($refHasil)) {
    if (!empty($refHasil)) {
        $modReferensiHasil->refhasilrad_id = $refHasil->refhasilrad_id;
        $modReferensiHasil->refhasilrad_aktif = $refHasil->refhasilrad_aktif;
        $modReferensiHasil->refhasilrad_banyak = $refHasil->refhasilrad_banyak;
        $modReferensiHasil->refhasilrad_kode = $refHasil->refhasilrad_kode;
        $modReferensiHasil->refhasilrad_hasil = $refHasil->refhasilrad_hasil;
        $modReferensiHasil->refhasilrad_kesimpulan = $refHasil->refhasilrad_kesimpulan;
        $modReferensiHasil->refhasilrad_kesan = $refHasil->refhasilrad_kesan;
        $modReferensiHasil->refhasilrad_keterangan = $refHasil->refhasilrad_keterangan;

        if ($modReferensiHasil->refhasilrad_banyak) {
            $hideBanyak = "block";
            $hideSingle = "none";
        } else {
            $hideBanyak = "none";
            $hideSingle = "block";
        }
    }
}

?>
<div class="row">
    <div class="col-sm-6">
        <?php echo CHtml::css('ul.redactor_toolbar{z-index:10;}'); ?>
        <?php echo $form->HiddenField($modReferensiHasil, 'pemeriksaanrad_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->HiddenField($modReferensiHasil, 'refhasilrad_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($modReferensiHasil, 'refhasilrad_kode', array('placeholder' => 'Kode Referensi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("", "", array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($modReferensiHasil, 'refhasilrad_banyak', array('onchange' => 'cekBanyak(this);')) ?> <label for="ROReferensiHasilRadM_refhasilrad_banyak">Banyak Pemeriksaan</label>
            </div>
        </div>
    </div>
</div>
<div class="row" id="form-referensirad" style="display: <?php echo $hideSingle; ?>;">
    <div class="col-sm-6">
        <div class="control-label">Hasil</div>
        <div class="controls">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modReferensiHasil, 'attribute' => 'refhasilrad_hasil', 'toolbar' => 'mini', 'height' => '100px')) ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-label">Kesimpulan</div>
        <div class="controls">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modReferensiHasil, 'attribute' => 'refhasilrad_kesimpulan', 'toolbar' => 'mini', 'height' => '100px')) ?>
        </div>
    </div>
    <div class="col-sm-6">
        <!--
		<div class="control-label">Kesan</div>
		<div class="controls">
			<?php //$this->widget('ext.redactorjs.Redactor',array('model'=>$modReferensiHasil,'attribute'=>'refhasilrad_kesan','toolbar'=>'mini','height'=>'100px')) 
            ?>
		</div>-->
        <div class="control-label">Keterangan</div>
        <div class="controls">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $modReferensiHasil, 'attribute' => 'refhasilrad_keterangan', 'toolbar' => 'mini', 'height' => '100px')) ?>
        </div>
    </div>
</div>

<div class="row" id="form-referensidet" style="display: <?php echo $hideBanyak; ?>;">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-credit-card"></i> Tabel <b>Detail Hasil Pemeriksaan</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <table class="table table-condensed table-bordered" id="table-referensidet">
                <thead>
                    <tr>
                        <th>Nama Hasil Pemeriksaan</th>
                        <th>Jenis Kelamin</th>
                        <th>Isi Pemeriksaan</th>
                        <th>Urut</th>
                        <th>Status</th>
                        <th><?php echo CHtml::link('<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>', 'javascript:;', array('class' => 'btn btn-primary white', 'onclick' => 'tambahLookup();', "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Klik Icon ini, untuk menambahkan data <b>hasil pemeriksaan</b>", "data-html" => true)); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($refHasil)) {
                        if (!empty($refHasil)) {
                            $modRefDet = ROReferensihasildetM::model()->findAllByAttributes(array('refhasilrad_id' => $refHasil->refhasilrad_id));
                            $i = 0;
                            foreach ($modRefDet as $det) {
                                echo $this->renderPartial($this->path_view . '_formItems', array('model' => $det, 'modReferensiHasil' => $modReferensiHasil, 'i' => $i), true);
                                $i++;
                            }
                        }
                    }
                    //echo $this->renderPartial($this->path_view.'_formItems',array('model'=>$modRefDet, 'modReferensiHasil'=>$modReferensiHasil,'i'=>0),true); 

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>