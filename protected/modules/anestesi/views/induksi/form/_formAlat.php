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
        <label><b>Alat</b></label>
    </div>
</div>

<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'alat_stylet', array('class'=>'parent-radio','kel-data'=>'alat',)) ?>
        <label>Stylet</label>
    </div>   
     <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'alat_magili', array('class'=>'parent-radio','kel-data'=>'alat',)) ?>
        <label>Magill</label>
    </div> 
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'alat_laryscope', array('class'=>'parent-radio','kel-data'=>'alat',)) ?>
        <label>Laryngoscope</label>
    </div> 
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'alat_videolaryngscope', array('class'=>'parent-radio','kel-data'=>'alat',)) ?>
        <label>Video Laryngoscope</label>
    </div> 
</div>

<div style="padding-left:20px;">   
    <div class="control-group" style="border:#333 1px solid;padding:10px;">    
            <div class="controls">
                <?php echo CHtml::activeCheckBox($model, 'jenis_alat_blade', array('disabled'=>true,'class'=>'alat')) ?>
                <label>Blade Machintosh</label>
            </div>   
             <div class="controls">
                <?php echo CHtml::activeCheckBox($model, 'jenis_alat_miler', array('disabled'=>true,'class'=>'alat')) ?>
                <label>Miler</label>
            </div> 
         <div class="controls">
                <?php echo CHtml::activeCheckBox($model, 'jenis_alat_mcoy', array('disabled'=>true,'class'=>'alat')) ?>
                <label>Mcoy</label>
            </div> 
            <div class="controls">
                <?php echo CHtml::activeCheckBox($model, 'jenis_alat_lainnya', array('disabled'=>true,'class'=>'alat adaket')) ?>
                <label>Lainnya</label>
            </div> 
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'jenis_alat_lainnya_keterangan', array('class'=>'span2 lainlain','readonly'=>true,'style'=>'width:100px;')) ?>                
            </div>            
            <div class="controls">
                <label>Ukuran</label>
                <?php echo CHtml::activeTextField($model, 'alat_ukuran', array('class'=>'span2 ukuran numbers-only','readonly'=>true)) ?>                                
            </div>            
    </div>
</div>

<div class="control-group">
    <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'alat_fiberoptik', array()) ?>
        <label>Fiber Optik</label>
    </div>   
     <div class="controls">
        <?php echo CHtml::activeCheckBox($model, 'alat_bonfil', array()) ?>
        <label>Bonfil</label>
    </div>   
</div>