<style>
    .h-load{
        height:50px;
    }
    
    .table-verifikasi td{
        font-size: 1.2em !important;
    }
</style>


<div id="form-tab" style="margin-bottom:10px;">
    <div class="col-sm-12" style="text-align:center;">    
    </div>
</div>
<div id="form-body" class="form-horizontal">
    <div class="col-sm-3">
    </div>
    <div class="col-sm-6">
        <h2 align="center"><b>Pendaftaran Pasien Mandiri</b></h2>

        <div class="control-group">
           
                <?= CHtml::activeTextField($model,'no_rekam_medik',['placeholder'=>'Nomor Rekam Medis','class'=>'form-control','id'=>'norm']) ?>
        </div>
        <div class="form-actions">        
            <?= CHtml::button('Lanjutkan',['class'=>'btn btn-success', 'onclick'=>'cariPasien();', 'id'=>'btn-cari-pasien']) ?>        
        </div>
    </div>
    <div class="col-sm-3">
    </div>
    <div class="clear"></div>    
</div>


<?php
    $this->renderPartial('_jsFunction');
?>