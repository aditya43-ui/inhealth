<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai view detail seleksi donor darah
* RSST-1498
*/
?>

<div class="panel panel-success">
    <!--<span class="group-title">
        Data Seleksi Donor Darah
    </span>-->
    <div class="panel-heading">
        <div class="panel-title">
            Data Seleksi Donor Darah
        </div>
    </div>
    <div class="panel-body" id="data-seleksi">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Tekanan Darah</label>
                <div class="controls">
                    <?php echo $form->textField($modSeleksi,'td_systolic',array('class'=>'numbers-only span2','readonly'=>true)) ?>
                </div>
                
                <div class="controls">
                    <label>/</label>
                </div>
                
                <div class="controls">
                    <?php echo $form->textField($modSeleksi,'td_diastoliic',array('class'=>'numbers-only span2','readonly'=>true)) ?>
                </div>
                
                <div class="controls">
                    <label> mmHg</label>
                </div>
            </div>
      
            <div class="control-group">
                <label class="control-label">Kadar Hemoglobin</label>
                <div class="controls">
                    <?php echo $form->textField($modSeleksi,'kadar_hb',array('readonly'=>true,'class'=>'numbers-only')); ?> <label> g/dl</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Suhu</label>
                <div class="controls">
                    <?php echo $form->textField($modSeleksi,'suhu_tubuh',array('readonly'=>true,'class'=>'numbers-only')); ?> <label> <sup>o</sup>C</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Nadi</label>
                <div class="controls">
                    <?php echo $form->textField($modSeleksi,'detaknadi',array('readonly'=>true,'class'=>'numbers-only')); ?>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Dokter</label>
                <div class="controls">
                    <?php                     
                    echo $form->textField($modSeleksi,'dokter_nama',array('readonly'=>true)); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Petugas</label>
                <div class="controls">
                    <?php echo $form->textField($modSeleksi,'petugas_nama',array('readonly'=>true)); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Lokasi Rekruitmen</label>
                <div class="controls">
                    <?php echo $form->textField($modDaftarDonasi,'ruangrekrutmen_nama',array('readonly'=>true)); ?>
                </div>
            </div>
            
             <div class="control-group">
                <label class="control-label">Catatan Dokter</label>
                <div class="controls">
                    <?php echo $form->textArea($modSeleksi,'catatan_dokter',array('readonly'=>true)); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="clear"></div>