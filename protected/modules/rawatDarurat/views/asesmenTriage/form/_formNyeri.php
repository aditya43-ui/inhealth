<?php
/**
* - digunakan untuk menginput data asesmen nyeri
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<table class="table noborder paddingtext" style="text-align: center;">                    
    <tr>                       
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/0.png','',array('style'=>'max-width:100%;width:125px;')); ?>
            <br>
            0
            <br>
            Tidak Sakit
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            
        </td>       
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/2.png','',array('style'=>'max-width:100%;width:125px;')); ?>
            <br>
            2
            <br>
            Sedikit Sakit 
        </td>
          <td style="text-align: center;line-height: 1.42857143 !important;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/4.png','',array('style'=>'max-width:100%;width:125px;')); ?>
            <br>
            4
            <br>
            Agak Menganggu
        </td>
          <td style="text-align: center;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/6.png','',array('style'=>'max-width:100%;width:125px;')); ?>
            <br>
            6
            <br>
            Menganggu Aktifitas
        </td>
          <td style="text-align: center;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/8.png','',array('style'=>'max-width:100%;width:125px;')); ?>
            <br>
            8
            <br>
            Sangat Menganggu
        </td>
          <td style="text-align: center;">
            
        </td> 
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <?php echo CHtml::image('images/icon_nyeri/10.png','',array('style'=>'max-width:100%;width:125px;')); ?>
            <br>
            10
            <br>
            Tak Tertahankan
        </td>
    </tr>   
     <tr>       
         <?php
            for ($i=0;$i<=10;$i++){
         ?>
            <td style="text-align: center;line-height: 1.42857143 !important;">
                <?php echo CHtml::radioButton('gambarNyeri',($modFisik->skala_wongbaker_nrs == $i)?true:false,array('onclick'=>'getScalaNyeri(this);','value'=>$i)); ?>               
                <br>
                <?php echo $i; ?>
             </td> 
         <?php
            }
         ?>
                        
    </tr>   
    <tr>       
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <div style="width:90%;height:10px;border:none;"></div>
            <br>
            Tidak Nyeri
        </td>      
        <td style="text-align: center;line-height: 1.42857143 !important;" colspan="3">
            <div class="nyeri-scala"></div>            
            <br>
            Nyeri Ringan
            
            
        </td>      
        <td class="scala-tengah" colspan="3" style="line-height: 1.42857143 !important;">
            <div class="nyeri-scala-tengah"></div>     
            <br>
            Nyeri Sedang
        </td>      
        <td style="text-align: center;line-height: 1.42857143 !important;" colspan="3">
            <div class="nyeri-scala"></div>     
            <br>
            Nyeri Berat Terkontrol
        </td>    
        <td style="text-align: center;line-height: 1.42857143 !important;">
            <div style="width:90%;height:10px;border:none;"></div>
            <br>
            Nyeri Berat Tidak Terkontrol
        </td> 
    </tr>
</table>

<table class="table noborder">
    <tr>
        <td colspan="3">
            Apakah Terdapat Kelurahan Nyeri ?
        </td>
        <td>     
            
            <?php                            
                echo $form->radioButtonList($modFisik, 'keluhan_nyeri', array(1=>'Ya',0=>'Tidak'));
            ?>            
            
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Skala Wong Baker / NSR
        </td>
        <td>
            <?php echo $form->textField($modFisik,'skala_wongbaker_nrs',array('readonly'=>true,'class'=>'col-sm-2','style'=>'text-align:right;')) ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Apakah Terdapat Nyeri Berpindah - pindah
        </td>
        <td>
             
            <?php
                echo $form->radioButtonList($modFisik, 'rasanyeri_berpindah', array(1=>'Ya',0=>'Tidak'));
                ?>
             
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Berapa Lama Nyeri
        </td>
        <td >
            <?php //echo $form->dropDownList($modFisik,'lama_nyeri', LookupM::getItems('lama_nyeri'),array('empty' => '-- Pilih --')); ?>
            <?php echo $form->textField($modFisik,'lama_nyeri',array()); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Seberapa Sering Mengalami Nyeri ? Berapa Lama
        </td>
        <td >
            <?php //echo $form->dropDownList($modFisik,'seringmengalami_nyeri', LookupM::getItems('seringmengalami_nyeri'),array('empty' => '-- Pilih --')); ?>
            <?php echo $form->textField($modFisik,'seringmengalami_nyeri',array()); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Apa yang Membuat Nyeri Berkurang atau Bertambah Parah ?
        </td>
        <td>
            <?php //echo $form->dropDownList($modFisik,'penyebabberkurang_nyeri', LookupM::getItems('penyebabberkurang_nyeri'),array('empty' => '-- Pilih --')); ?>
            <?php echo $form->textField($modFisik,'penyebabberkurang_nyeri',array()); ?>
        </td>
    </tr>
    <tr>
        <td>
            Rasa Nyeri
        </td>
        <td>
            <label class="checkbox inline">
                <span>Tajam</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_tajam') ?>                
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Ditusuk</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_ditusuk') ?>
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Berdenyut</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_berdenyut') ?>
          </label>
        </td>
        <td>
            <label class="checkbox inline">
                <span>Nyeri Tumpul</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_tumpul') ?>                
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Dibakar</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_dibakar') ?>
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Ditikam</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_ditikam') ?>
          </label>
        </td>
        <td>
            <label class="checkbox inline">
                <span>Seperti Ditarik</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_ditarik') ?>                
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Dipukul</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_dipukul') ?>
          </label>
            <br>
            <label class="checkbox inline">
                <span>Seperti Kram</span>
                <?php echo $form->checkBox($modFisik,'rasanyeri_kram') ?>
          </label>
        </td>
    </tr>
</table>

