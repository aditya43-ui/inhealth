<?php
/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - digunakan sebagai form inputan observasi donor darah
 * RSST-1515
 */
?><p>&nbsp;</p>
<!--<div class="panel panel-darkk">
    <span class="group-title">
       Hasil Pengujian Konfirmasi Golongan Darah
    </span>
    <div class="panel-body">-->
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Hasil Uji<span class="required">*</span></label>
        <div class="controls">                 
            <?php //echo CHtml::dropDownList('golDarah', '', LookupM::getItemsUrutan('golongandarah'),array('class'=>'span2 required','empty' => '-- Pilih --','onchange'=>'cekHasil();')) ?> 
            <?php echo $form->dropDownList($model, '[det][' . (isset($i) ? $i : 0) . ']gol_darah', LookupM::getItemsUrutan('golongandarah'), array('id' => 'golDarah', 'class' => 'span2 required golDarah', 'empty' => '-- Pilih --', 'onchange' => 'cekHasil(this);')) ?> 
        </div>
        <div class="controls">                 

            <?php //echo CHtml::dropDownList('rhesus', '', LookupM::getItemsUrutan('rhesus'),array('class'=>'span2 required','empty' => '-- Pilih --','onchange'=>'cekHasil();')) ?>
            <?php echo $form->dropDownList($model, '[det][' . (isset($i) ? $i : 0) . ']rhesus', LookupM::getItemsUrutan('rhesus'), array('id' => 'rhesus', 'class' => 'span2 required rhesus', 'empty' => '-- Pilih --', 'onchange' => 'cekHasil(this);')) ?> 
        </div>
    </div>

    <div class="control-group" onclick='return false;'>
        <label class="control-label">Keterangan</label>
        <div class="controls">                    
            <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']hasil_uji', array('class' => 'dataCocok', 'id' => 'dataCocok', 'uncheckValue' => null, 'value' => Params::HASIL_GOLDARAH_COCOK)); ?> <label>Cocok</label>
            <?php echo CHtml::hiddenField('hasilUjiGol', '', array('id' => 'hasilUjiGol', 'readonly' => true)) ?>
        </div>
        <div class="controls">                    
            <?php echo $form->radioButton($model, '[det][' . (isset($i) ? $i : 0) . ']hasil_uji', array('class' => 'dataTidakCocok', 'id' => 'dataTidakCocok', 'uncheckValue' => null, 'value' => Params::HASIL_GOLDARAH_TIDAK)); ?> <label>Tidak Cocok</label>
            <?php echo CHtml::hiddenField('hasilUjiRhesus', '', array('id' => 'hasilUjiRhesus', 'readonly' => true)) ?>
        </div>
    </div>

    <?php echo $form->hiddenField($model, '[det][' . (isset($i) ? $i : 0) . ']ket_hasiluji', array('readonly' => true, 'class' => 'ket')) ?>

</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Tgl Kadaluarsa</label>
        <div class="controls">                 
            <?php 
            $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => '[det][' . (isset($i) ? $i : 0) . ']tgl_kadaluarsa',
                    'mode' => 'datetime',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            //'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:150px;'
                    ),
                ));
             ?> 
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-12">
    <div id="pesan-ket" class="">
    </div>
</div>
<!--</div>
</div>-->

