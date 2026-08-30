<?php
/** 
 * form peminjam
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
?>

<div class="control-group">
    
    <div class="controls">
        <label><b>Teknik Induksi</b></label>
    </div>
</div>

<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'teknikinduksi_master_o2', array('class'=>'adaket')) ?>
        <label>Masker O<sub>2</sub></label>
    </div>   
    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'teknikinduksi_master_o2_keterangan', array('class' => 'span2 lainlain numbers-only master_o2','readonly'=>true)) ?>
        <label>Lpm</label>
    </div>    
</div>

<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'teknikinduksi_nasal_o2', array('class'=>'adaket')) ?>
        <label>Nasal O<sub>2</sub>&nbsp;&nbsp;&nbsp;</label>
    </div>   
    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'teknikinduksi_nasal_o2_keterangan', array('class' => 'span2 lainlain numbers-only nasal_o2','readonly'=>true)) ?>
        <label>Lpm</label>
    </div>    
</div>

<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'teknikinduksi_preoksigenasi', array()) ?>
        <label>Preoksigenasi</label>
    </div>   
</div>

<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'teknikinduksi_intravena', array()) ?>
        <label>Induksi Intravena</label>
    </div>   
</div>

<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'teknikinduksi_inhalasi', array()) ?>
        <label>Induksi Inhalasi</label>
    </div>   
</div>

<div class="control-group">
    <div class="controls">
       <label>Catatan</label>
    </div>   
    <div class="controls">
        <?php echo CHtml::activeTextArea($model, 'teknikinduksi_catatan', array()) ?>
    </div>
   
</div>