<?php
/**
 * issue RSST-1515
 * - digunakan sebagai view utama untuk menampilkan data atau form inputan untuk 
 *  
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * 
 */
?>
<style>        
    .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }        
</style>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pengujiankantongdarah-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Pengujian Konfirmasi Golongan Darah
        </div>
    </div>
    <div class="panel-body">        
        <div class="col-sm-6">
            <div class="control-group anti-a">
                <label class="control-label">Anti A :</label>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']anti_a', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']anti_a', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Negatif (-)</label>
                </div>
            </div>

            <div class="control-group anti-b">
                <label class="control-label">Anti B :</label>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']anti_b', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']anti_b', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Negatif (-)</label>
                </div>
            </div>

            <div class="control-group anti-ab">
                <label class="control-label">Anti AB :</label>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']anti_ab', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']anti_ab', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Negatif (-)</label>
                </div>
            </div>

            <div class="control-group anti-d">
                <label class="control-label">Anti D :</label>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']anti_d', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']anti_d', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Negatif (-)</label>
                </div>
            </div>


        </div>

        <div class="col-sm-6">
            <div class="control-group sel-a">
                <label class="control-label">Sel A :</label>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']sel_a', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']sel_a', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Negatif (-)</label>
                </div>
            </div>

            <div class="control-group sel-b">
                <label class="control-label">Sel B :</label>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']sel_b', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']sel_b', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Negatif (-)</label>
                </div>
            </div>                        

            <div class="control-group sel-o">
                <label class="control-label">Sel O :</label>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']sel_o', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']sel_o', array('class' => 'pilihData', 'uncheckValue' => null, 'value' => Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick' => 'hasilKesimpulan(this);', 'readonly' => true, 'disabled' => true)); ?> <label>Negatif (-)</label>
                </div>
            </div>
        </div>

        <div class="clear"></div>

        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label">Hasil Uji<span class="required">*</span></label>
                <div class="controls">                 
                    <?php echo $form->dropDownList($model, '[det][' . (isset($i) ? $i : 0) . ']gol_darah', LookupM::getItemsUrutan('golongandarah'), array('id' => 'golDarah', 'class' => 'span2 required golDarah', 'empty' => '-- Pilih --', 'onchange' => 'cekHasil(this);', 'readonly' => true, 'disabled' => true)) ?> 
                </div>
                <div class="controls">                 
                    <?php echo $form->dropDownList($model, '[det][' . (isset($i) ? $i : 0) . ']rhesus', LookupM::getItemsUrutan('rhesus'), array('id' => 'rhesus', 'class' => 'span2 required rhesus', 'empty' => '-- Pilih --', 'onchange' => 'cekHasil(this);', 'readonly' => true, 'disabled' => true)) ?> 
                </div>
            </div>

            <div class="control-group" onclick='return false;'>
                <label class="control-label">Keterangan</label>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']hasil_uji', array('class' => 'dataCocok', 'id' => 'dataCocok', 'uncheckValue' => null, 'value' => Params::HASIL_GOLDARAH_COCOK, 'readonly' => true, 'disabled' => true)); ?> <label>Cocok</label>
                    <?php echo CHtml::hiddenField('hasilUjiGol', '', array('id' => 'hasilUjiGol', 'readonly' => true)) ?>
                </div>
                <div class="controls">                    
                    <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']hasil_uji', array('class' => 'dataTidakCocok', 'id' => 'dataTidakCocok', 'uncheckValue' => null, 'value' => Params::HASIL_GOLDARAH_TIDAK, 'readonly' => true, 'disabled' => true)); ?> <label>Tidak Cocok</label>
                    <?php echo CHtml::hiddenField('hasilUjiRhesus', '', array('id' => 'hasilUjiRhesus', 'readonly' => true)) ?>
                </div>
            </div>

            <?php echo $form->hiddenField($model, '[det][' . (isset($i) ? $i : 0) . ']ket_hasiluji', array('readonly' => true, 'class' => 'ket', 'readonly' => true, 'disabled' => true)) ?>

        </div>

        <div class="col-sm-12">
            <?php
            if ($model->pengujian_ke == 2) {
                ?>
                <div id="pesan-ket" class="">
                    <span class="required">Hasil pengujian  golongan darah dan rhesus yang ke - 2, tidak sama dengan golongan darah dan rhesus pendonor. Tetapi sama dengan pengujian ke -1, maka golongan darah pendonor dan rhesusnya akan mengikuti hasil pengujian ini.</span>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Waktu Pengujian <span class="required">*</span></label>
        <div class="controls">
            <?php
            echo $form->textField($model, 'tglpengujian', array('readonly' => true));
            ?>
        </div>
    </div>                
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Petugas <span class="required">*</span></label>
        <div class="controls">
            <?php
            echo $form->hiddenField($model, 'petugaspengujian_id', array('readonly' => true));
            echo $form->textField($model, 'petugaspengujian_nama', array('readonly' => true));
            ?>
        </div>
    </div>
</div>

<?php
$this->endWidget();
?>                      