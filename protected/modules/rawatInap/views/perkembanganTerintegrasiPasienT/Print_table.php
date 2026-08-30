
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasienpulang-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)',), //'onSubmit'=>'return cekValidasi()'
    'focus' => '#',
        ));
?>


<table width="100%" id="table-dalam" >
    <thead>
    <tr>
        <th class="headertd" style="background-color:#afdc7e" colspan='5'><b>Diisi oleh Dokter / Keperawatan / Keterapian Fisik / Tenaga Gizi / Apoteker</b></th>
    </tr>
    <tr>
        <th width="10%" rowspan="2" style="vertical-align:middle;text-align:center"><b>TANGGAL / JAM</b></th>
        <th width="5%" rowspan="2" style="vertical-align:middle;text-align:center">
            <div class="control-group">
                <div class="controls">
                   <?php echo "<div id='breakfloat'><b> PROFESI(Dokter,Perawat,Bidan,<br> Gizi,Farmasi,Fisioterapis)</b></div>"; ?>
                </div>
            </div>
        </th>
        <th width="55%">
            <div class="control-group">  
                <?php  echo CHtml::label('<span class="">1.</span>', '', array('class' => 'control-label ', 'style' => 'width: 20px;')); ?>
                <div class="controls" style="text-align:left">
                   <?php  echo '<div id="breakfloat"><b> SOAPI(Instruksi) Dokter</b></div>' ?>
                </div>
                
           </div>
            <div class="control-group">  
                <?php  echo CHtml::label('<span class="">2.</span>', '', array('class' => 'control-label ', 'style' => 'width: 20px;')); ?>
                <div class="controls" style="text-align:left">
                   <?php  echo '<div id="breakfloat"> SOAPI(Intervensi-Implementasi) Keperawatan / Ketarapian Fisik/ Tenaga Gizi / Apoteker</div>' ?>
                </div>
               
           </div>
            
            <div class="control-group">  
                 <?php  echo CHtml::label('<span class="">3.</span>', '', array('class' => 'control-label ', 'style' => 'width: 20px;')); ?>
               
                <div class="controls" style="text-align:left">
                   <?php  echo '<div id="breakfloat"><b> Kominikasi Media elektronik (TBAK) </b></div>' ?>
                </div>
                
           </div>
            
         </th>
         <th width="30%" style="vertical-align:middle;text-align:center" colspan="2"><b>NAMA & TTD</b></th>
       
    </tr>
    <tr>
        <td style="vertical-align:middle;text-align:center"><b>S= Subyektif, O= Obyektif, A=Asesmen, P=Perencanaan, I=Instruksi</b></td>
        <td style="vertical-align:middle;text-align:center"><b>Pemberi Layanan</b></td>
        <td style="vertical-align:middle;text-align:center"><b>Verivikasi DPJP Utama</b></td>
       
    </tr>
    </thead>
    <tbody>
    <?php
        foreach($model as $data){
    ?>
    <tr>
        <td  style="text-align:center;vertical-align:middle"><?php echo MyFormatter::formatDateTimeForUser($data->tgltransaksi)  ?></td>
        <td  style="text-align:center;vertical-align:middle"><?php echo $data->profesi  ?></td>
        <td>
            <div class="control-group">  
                <?php  echo CHtml::label('<span class="">S</span>', '', array('class' => 'control-label ', 'style' => 'width: 20px;')); ?>
               <?php  echo CHtml::label('<span class="">:</span>', '', array('class' => 'control-label ', 'style' => 'text-align:center; width: 10px;')); ?>
                <div class="controls">
                   <?php  echo "<div id='breakfloat'>".$data->subyektif."</div>" ?>
                </div>
                
           </div>
            <div class="control-group">  
                <?php  echo CHtml::label('<span class="">O</span>', '', array('class' => 'control-label ', 'style' => 'width: 20px;')); ?>
               <?php  echo CHtml::label('<span class="">:</span>', '', array('class' => 'control-label ', 'style' => 'text-align:center; width: 10px;')); ?>
                <div class="controls">
                    <?php  echo "<div id='breakfloat'>".$data->obyektif."</div>"; ?>
                </div>
                
           </div>
            <div class="control-group">  
                <?php  echo CHtml::label('<span class="">A</span>', '', array('class' => 'control-label ', 'style' => 'width: 20px;')); ?>
               <?php  echo CHtml::label('<span class="">:</span>', '', array('class' => 'control-label ', 'style' => 'text-align:center; width: 10px;')); ?>
                <div class="controls"> 
                  <?php  echo "<div id='breakfloat'>".$data->asesmen."</div>"; ?>
                </div>
                
           </div>
            <div class="control-group">  
                <?php  echo CHtml::label('<span class="">P</span>', '', array('class' => 'control-label ', 'style' => 'width: 20px;')); ?>
               <?php  echo CHtml::label('<span class="">:</span>', '', array('class' => 'control-label ', 'style' => 'text-align:center; width: 10px;')); ?>
                <div class="controls">
         
                <?php    echo "<div id='breakfloat'>".$data->perencanaan."</div>"; ?>
                </div>
                
           </div>
            <div class="control-group">  
                <?php  echo CHtml::label('<span class="">I</span>', '', array('class' => 'control-label ', 'style' => ' width: 20px;')); ?>
               <?php  echo CHtml::label('<span class="">:</span>', '', array('class' => 'control-label ', 'style' => 'text-align:center; width: 10px;')); ?>
                <div class="controls">
                    <?php  echo "<div id='breakfloat'>".$data->instruksi."</div>"; ?>
                </div>
                
           </div>
            
        </td>
        <td style="vertical-align:bottom;text-align:center">
            <?php  
               if (!empty($data->pegawai_id)) {
                    echo PegawaiM::model()->findByPk($data->pegawai_id)->namaLengkap;
                }else if(!empty($data->ppds_id)){
                    echo PpdsM::model()->findByPk($data->ppds_id)->ppds_nama;
                }
            ?>
        </td>
        <td style="vertical-align:bottom;text-align:center"><?php  
               if (!empty($data->dpjp_id)) {
                    echo PegawaiM::model()->findByPk($data->dpjp_id)->namaLengkap;
                }
        ?></td>
    </tr>
    <?php
        }
    ?>
    </tbody>
</table>
  
<?php $this->endWidget(); ?>

