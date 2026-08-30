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
<div style="padding: 5px;">
  <div class="textright textbold headertext">FRM/73F/RSBM</div>
  <?php echo $this->renderPartial($this->path_view."_headerPrint", array(
       'modProfilRs'=>$modProfilRs,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran, 'header_print'=>'ASESMEN AWAL KEPERAWATAN <br/>','header_print_title'=>'PASIEN RAWAT JALAN ANAK'
   ), true); ?>
  <?php echo $this->renderPartial($this->path_view."anak/_printpage1", array(
       'model'=>$model,'modPendaftaran'=>$modPendaftaran,'dataFlaCcs'=>$dataFlaCcs
   ), true); ?>

  <div style="page-break-before:always; page-break-after:always;">
    <?php echo $this->renderPartial($this->path_view."anak/_printpage2", array(
         'modPendaftaran'=>$modPendaftaran,'model'=>$model,'modAsesmenkebutuhanEdukasiT'=>$modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT'=>$modAsesmenkebutuhanEdukasidetT,'masalahKeperawatan'=>$masalahKeperawatan,'rencanaKeperawatan'=>$rencanaKeperawatan,'tindakanKeperawatan'=>$tindakanKeperawatan
     ), true); ?>
  </div>
</div>
