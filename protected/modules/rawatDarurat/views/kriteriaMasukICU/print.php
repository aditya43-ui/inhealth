<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<style>
    @page {
    size: A4;
    margin: 0;
    }
    @media print {
      html, body {
        width: 210mm;
        height: 297mm;
      }

      body {
          color: black;
          font-size: 8pt !important;
      }
    }
    html{
      font-size: 11pt !important;
      color: black;
    }

    body{
        color: black !important;
        margin: 0;
        padding: 0;
        font-size: 11pt !important;
    }

    table{
      font-size: 11pt !important;
      color: black;
    }

    p {
        text-align: justify;
    }

    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }

    .padding5{
        padding: 5px;
    }

    .padding10{
        padding: 10px;
    }

    header, footer {
        height: 30px;
    }

    .tablefont td{
        color: black;
        padding: 5px;
    }

    .fa{
        font-size: 12pt;
    }
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:96%;width:97%;
    }

    select[disabled]{
        background:#eeeeee;
    }

    .textbold {
        font-weight: bold;
    }
    .textcenter {
        text-align: center;
    }

    .textright {
        text-align: right;
    }

    .tableBorder th, .tableBorder td {
        border:1px solid #000;
        padding: 10px;
    }

    .headertext{
      padding-bottom: 10px !important;
    }
</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<?php echo $this->renderPartial($this->path_view."_headerPrint", array(
     'modProfilRs'=>$modProfilRs,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'model'=>$model
 ), true); ?>
<br/>
<table class="tableBorder" width="100%">
    <thead>
        <tr>
            <th style="text-align: center;" colspan="3">Kriteria Fisiologi</th>
            <th style="text-align: center;" width="10%">Ya</th>
            <th style="text-align: center;" width="10%">Tidak</th>
        </tr>
     </thead>
     <tbody>
       <?php
         $abcd=array(0=>'a',1=>'b',2=>'c',3=>'d',4=>'e',5=>'f',6=>'g',7=>'h',8=>'i',9=>'j',10=>'k',11=>'l',12=>'m',13=>'n',14=>'0',15=>'p',16=>'q',17=>'r',18=>'s',19=>'t',20=>'u',21=>'v',22=>'w',23=>'x',24=>'y',25=>'z');
         $nourutParent = 0;
         $nourutChild = 0;

         $parentKriteriaIcu = KriteriaicuM::model()->findAllByAttributes(array('jenis_kriteria'=>'Masuk ICU','berhubungan_dengan'=>null,'level_kriteria'=>1),array('order'=>'urutan ASC'));

         if(count($parentKriteriaIcu)){
           foreach($parentKriteriaIcu as $i => $parent){
             $nourutParent += 1;
             $ischeckParent = null;

             if(count($modDetail) > 0){
               foreach($modDetail as $dataDetail){
                 if($dataDetail->kriteriaicu_id == $parent->kriteriaicu_id){
                   if($dataDetail->is_kriteria == true){
                     $ischeckParent = 1;
                   }else if($dataDetail->is_kriteria == false){
                     $ischeckParent = 2;
                   }

                 }
               }
             }

             $childKriteriaIcu = KriteriaicuM::model()->findAllByAttributes(array('jenis_kriteria'=>'Masuk ICU','berhubungan_dengan'=>$parent->kriteriaicu_id,'level_kriteria'=>2),array('order'=>'urutan ASC'));
             ?>
             <tr>
               <td style="text-align: center; vertical-align: middle;" rowspan="<?php echo (count($childKriteriaIcu)+1); ?>"><?php echo $nourutParent.'.'; ?></td>
               <td colspan="2" style="font-weight: bold">
                 <?php echo $parent->deskripsi; ?>
               </td>
               <td style="text-align: center;">
                 <span class="<?php echo (($ischeckParent != null && $ischeckParent == 1)? "fa fa-check":""); ?>"></span>
               </td>
               <td style="text-align: center;">
                 <span class="<?php echo (($ischeckParent != null && $ischeckParent == 2)? "fa fa-check":""); ?>"></span>
               </td>
             </tr>
             <?php
             if(count($childKriteriaIcu) > 0){
               $nourutChild = 0;
               foreach ($childKriteriaIcu as $j => $child) {
                 $ischeckChild = null;

                 if(count($modDetail) > 0){
                   foreach($modDetail as $dataDetail){
                     if($dataDetail->kriteriaicu_id == $child->kriteriaicu_id){
                       if($dataDetail->is_kriteria == true){
                         $ischeckChild = 1;
                       }else if($dataDetail->is_kriteria == false){
                         $ischeckChild = 2;
                       }
                     }
                   }
                 }

                 ?>
                 <tr>
                   <td style="text-align: center; width: 35px"><?php echo $abcd[$nourutChild].'.'; ?></td>
                   <td>
                     <?php echo $child->deskripsi; ?>
                   </td>
                   <td style="text-align: center;">
                     <span class="<?php echo (($ischeckChild != null && $ischeckChild == 1)? "fa fa-check":""); ?>"></span>
                   </td>
                   <td style="text-align: center;">
                     <span class="<?php echo (($ischeckChild != null && $ischeckChild == 2)? "fa fa-check":""); ?>"></span>
                   </td>
                 </tr>
                 <?php
                 $nourutChild++;
               }
             }
           }
         }
        ?>
     </tbody>
</table>
<br/><br/>
<table width="100%">
    <tr>
        <td style="width:65%"></td>
        <td style="width:35%">
          <center>
            Petugas Pemeriksa
            <br/><br/><br/><br/>
            (<?php echo $model->petugas_pemeriksa; ?>)
          </center>
        </td>
    </tr>
</table>
