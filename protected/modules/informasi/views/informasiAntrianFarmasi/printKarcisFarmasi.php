
<table style='width:100%; margin-left:20%; margin-top:7%;' >
    <tr>
        <td colspan="3" style="font-size: 50px;">
            <?php echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>'Antrian Farmasi')); ?>
        </td>
        </tr>
    <tr>
       <td width="30%" colspan="1">
           <p style="margin: 0; text-align: center;">
           <b><?=date('d M Y'); ?></b>   
           <br>
           </p>
        </td>
       <td colspan="1">
           <p style="margin: 0; text-align: center;">
           <br>
           </p>
        </td>
       <td width="50%" colspan="1">
           <p style="margin: 0; text-align: center;">
           <b><?=date('H:i:s'); ?></b>  
           <br>
           </p>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <p style="margin: 0; text-align: center;">
           <b>No. Antrian <?php echo $modAntrian->racikan->racikan_singkatan; ?></b>  
           <br>
           </p>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <div style="padding:20px;margin:10px;border: 0;">
           <p style="margin: 0; text-align: center;">
           <b><span style="font-size: 50px;"><?php echo $modAntrian->racikan->racikan_singkatan."-".$modAntrian->noantrian; ?></span></b>  
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
</b></span>
</p>


<?php 

Yii::app()->clientScript->registerScript('onend','
//        var printContents = document.getElementById("printArea").innerHTML;
     var originalContents = document.body.innerHTML;

//     document.body.innerHTML = printContents;

     window.print();

     

     ', CClientScript::POS_END); ?>
    