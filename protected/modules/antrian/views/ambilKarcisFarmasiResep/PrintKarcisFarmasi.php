<style>
  
</style>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
<table style='width:100%; margin:0 auto;' >
    <tr>
       <td width="100%" colspan="1">
           <p style="margin: 0; text-align: center;">
           <b><h2><?php echo $judulLaporan;  ?></h2></b>  
           <br>
           </p>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="1">
           <p style="margin: 0; text-align: center;">
           <b><?php echo $format->formatDateTimeForUser($modAntrian->tglambilantrian); ?></b>  
           <br>
           </p>
        </td>
    </tr>

    <tr>
       <td width="100%" colspan="3">
           <div style="margin:10px;border: 0;">
           <p style="margin: 0; text-align: center;">
           <b><span style="font-size: 48px;"><?php 
           
           $modelantrian = "";
           $modModel = ModelantrianM::model()->findByPk($modAntrian->modelantrian_id);
           if (!empty($modModel)) {
               $modelantrian = $modModel->modelantrian_kode;
           }
           echo $modelantrian.$modAntrian->racikan->racikan_singkatan."-".$modAntrian->noantrian; ?></span></b>  
           <br>
           </p>
               </div>
        </td>
    </tr>
    <tr  style="margin:10px 0 0 20px;">
       <td width="100%" colspan="3">
           <p style="margin: 0; text-align: center;"><b>&nbsp;.</b></p>
        </td>
    </tr>
</table>
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
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>