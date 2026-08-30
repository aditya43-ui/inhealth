<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();
?>
<style>
    body {
        /*        font-size: 8pt;*/
        
    }

    p{
        margin-left: 0px;
        text-align: justify;
    }

    .tab-foot, .tab-foot td {
        /*        font-size: 6pt;*/
    }
    #setfon{
        font-size:10px!important;
        color:#c33193;
        font-weight:bold;
    }
    /* .header{
        width:70%;
    } */
 
    @media print {
      
        .footer, .footer-space {
                    height: 4cm;
                }
        td{
            vertical-align:top;
            font-size:9px!important;
        }
    }
</style>

<table width="100%">
    <thead>
        <tr>
        <td>
                <?php if(isset($caraPrint)) {?>
                    <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultA5', array());
                    ?>
                <hr>
                <small>Tanggal <?php echo MyFormatter::formatDateTimeForUser($modReseptur->tglreseptur)  ?></small>
                </div>  
                <?php }else{?>
                    <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?>
                     <hr style="border-top: 3px solid #c33193;">
                   <div class="judulcontent"> Tanggal <?php echo MyFormatter::formatDateTimeForUser($modReseptur->tglreseptur)  ?></div>
                </div>  
                <?php } ?>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                  
                           <?php
                                foreach ($modEresep as $i => $e){
                            ?>
                                <img    src="<?php echo Params::urlResepturDirectory().$e->eresep_image.".png"; ?>">
                                <br>
		
                        <?php
                                }
                        ?>
                </div>		
                
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    
 
    <?php   if (isset($caraPrint) && $caraPrint=="PDF"){  ?>
    <table width="70%" style="text-align:center;font-size:12px!important;">
        <tr>
            <td width="50%">
                <table>
                    <tr>
                        <td id="setfon">Pro </td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td id="setfon">  
                        Umur </td>
                        <td>:</td>
                        <td id="setfon">
                             <?php
                            if(!empty($modReseptur->pendaftaran_id)){
                                $modpendaftaran= PendaftaranT::model()->findByPk($modReseptur->pendaftaran_id);
                                echo $modpendaftaran->umur;
                            }
                        ?>    
                            
                        </td>
                    </tr>
                    <tr>
                        <td id="setfon">Dokter </td>
                        <td>:</td>
                        <td id="setfon">
                            <?php
                              if(!empty($modReseptur->pegawai_id)){
                                $moddokter= PegawaiM::model()->findByPk($modReseptur->pegawai_id);
                                echo $moddokter->namaLengkap;
                            }
                            ?>
                        </td>
                        
                    </tr>
                </table>
            </td>
            <td width="50%">
                   <table width="100%" >
                    <tr>
                        <td   id="setfon" style="text-align:left">Tanggal</td>
                        <td>:</td>
                        <td id="setfon" style="text-align:right"> <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh')); ?></td>
                    </tr>
                    <tr>
                        <td   id="setfon" style="text-align:left">  
                          Urutan Ke 
                        </td>
                        <td>:</td>
                        <td id="setfon" style="text-align:right"> <div id="pageFooter"></div></td>
                    </tr>
                    <tr>
                        <td  id="setfon"></td>
                        <td>
                          
                        </td>
                        
                    </tr>
                </table> 
            </td>
        <tr>
         <td>
            
        </td>
    </table>

    <?php if(isset($caraPrint)) {?>
    <!-- <div> -->
    
    <!-- </div> -->
    <?php }?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
        <?php
        if (empty($caraPrint)) {
            if (!empty($modReseptur->reseptur_id)) {
                $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/PrintEresep&reseptur_id=' . $modReseptur->reseptur_id);
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-primary', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
            } else {
                $urlPrint = '';
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-primary', 'disabled' => true, 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
            }
            ?>
            <script>
                function print(caraPrint)
                {
                    window.open("<?php echo $urlPrint ?>&caraPrint=" + caraPrint, "", 'location=_new, width=980px');
                }
            </script>
            <?php
        }
        ?>
        
