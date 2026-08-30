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
        <label><b>Airway</b></label>
    </div>
</div>

<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeRadioButton($model, 'airway_masker', array('class'=>'parent-radio','kel-data'=>'airway_masket',)) ?>
        <label>Masker</label>
    </div>   
</div>
<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeRadioButton($model, 'airway_sad', array('class'=>'parent-radio','kel-data'=>'airway_sad')) ?>
        <label>SAD</label>
    </div>
</div>
<div class="control-group">
    <div class="controls">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <?php echo CHtml::activeRadioButton($model, 'airway_sad_lma', array('onclick'=>'cekAirwaySAD(this);','disabled'=>true,'class'=>'airway_sad child-radio')) ?>
        <label>LMA</label>
    </div>   
    <div class="controls">
       <?php echo CHtml::activeRadioButton($model, 'airway_sad_igel', array('onclick'=>'cekAirwaySAD(this);','disabled'=>true,'class'=>'airway_sad child-radio')) ?>
        <label>I-Gel</label> 
    </div>
    <div class="controls">
       <?php echo CHtml::activeRadioButton($model, 'airway_sad_lainnya', array('onclick'=>'cekAirwaySAD(this);','disabled'=>true,'class'=>'airway_sad child-radio adaket')) ?>
        <label>Lainnya</label>        
    </div>   
    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'airway_sad_lainnya_keterangan',array('readonly' => true,'class' => 'span2 lainlain')) ?>
    </div>
</div>

<div class="control-group">
    <div class="controls">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="controls">       
        <label>Ukuran</label>
        <?php echo CHtml::activeTextField($model, 'airway_ukuran',array('readonly' => true,'class' => 'numbers-only ukuran','style'=>'width:110px;')) ?>
    </div>   
    <div class="controls">
       <label>Cuff</label>
        <?php echo CHtml::activeTextField($model, 'airway_cuff',array('readonly' => true,'class' => 'numbers-only cuff','style'=>'width:110px;')) ?>
       <label>ml</label>
    </div>    
</div>

<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeRadioButton($model, 'airway_intubasi', array('class'=>'parent-radio','kel-data'=>'airway_intubasi')) ?>
        <label>Intubasi</label>
    </div>    
</div>

<div class="control-group">
    <div class="controls">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label>Teknik</label>
    </div>    
</div>
<div class="control-group">
    <div class="controls">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo CHtml::activeCheckBox($model, 'airway_intubasi_sleep',array('disabled'=>true,'class'=>'airway_intubasi')) ?>
        <label>Sleep</label>
    </div>    
     <div class="controls">    
         &nbsp;
        <?php echo CHtml::activeCheckBox($model, 'airway_intubasi_apnae',array('disabled'=>true,'class'=>'airway_intubasi')) ?>
        <label>Apnae</label>
    </div>
     <div class="controls">        
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo CHtml::activeCheckBox($model, 'airway_intubasi_oral',array('disabled'=>true,'class'=>'airway_intubasi')) ?>
        <label>Oral</label>
    </div>
     <div class="controls">    
         &nbsp;
        <?php echo CHtml::activeCheckBox($model, 'airway_intubasi_direct',array('disabled'=>true,'class'=>'airway_intubasi')) ?>
        <label>Direct</label>
    </div>
     <div class="controls">       
        <?php echo CHtml::activeCheckBox($model, 'airway_intubasi_rsi',array('disabled'=>true,'class'=>'airway_intubasi')) ?>
        <label>RSI</label>
    </div>
</div>



<div class="control-group">
    <div class="controls">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo CHtml::activeCheckBox($model, 'airway_intubasi_awake',array('disabled'=>true,'class'=>'airway_intubasi')) ?>
        <label>Awake</label>
    </div>    
     <div class="controls">        
        <?php echo CHtml::activeCheckBox($model, 'airway_intubasi_non_apnae',array('disabled'=>true,'class'=>'airway_intubasi')) ?>
        <label>Non-Apnae</label>
    </div>
     <div class="controls">        
        <?php echo CHtml::activeCheckBox($model, 'airway_intubasi_nasal',array('disabled'=>true,'class'=>'airway_intubasi')) ?>
        <label>Nasal</label>
    </div>
     <div class="controls">        
        <?php echo CHtml::activeCheckBox($model, 'airway_intubasi_blind',array('disabled'=>true,'class'=>'airway_intubasi')) ?>
        <label>Blind</label>
    </div>
     <div class="controls">      
         &nbsp;
        <?php echo CHtml::activeCheckBox($model, 'airway_intubasi_croidpres',array('disabled'=>true,'class'=>'airway_intubasi')) ?>
        <label>Cricoid Pres</label>
    </div>
</div>