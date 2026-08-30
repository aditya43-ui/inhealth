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

    .bordernonetopclass {
        border-top: none !important;
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
    .floatright{
      float: right;
    }
</style>

<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<div style="padding: 5px;">
  <div class="textbold headertext floatright">FRM/73C Rev 01/RSBM</div>
  <?php echo $this->renderPartial($this->path_view."_headerPrintRI", array(
       'modProfilRs'=>$modProfilRs,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran, 'header_print'=>'PENILAIAN AWAL KEPERAWATAN <br/>','header_print_title'=>'PASIEN RAWAT INAP ANAK'
   ), true); ?>
  <?php echo $this->renderPartial($this->path_view."anak/print/_printpage1_RI", array(
        'model'=>$model,'modPasienAdmisi'=>$modPasienAdmisi,'modPendaftaran'=>$modPendaftaran,'modAsesmenkebutuhanEdukasiT'=>$modAsesmenkebutuhanEdukasiT,'modAsesmenkebutuhanEdukasidetT'=>$modAsesmenkebutuhanEdukasidetT
    ), true); ?>

  <div style="page-break-before:always; page-break-after:always;">
    <div class="textbold headertext floatright">FRM/74C Rev 01/RSBM</div>
    <br/>
    <?php echo $this->renderPartial($this->path_view."anak/print/_printpage2_RI", array(
          'model'=>$model,'modBarthelindexadlT'=>$modBarthelindexadlT
      ), true); ?>
  </div>

  <div class="textbold headertext floatright">FRM/74C Rev 01/RSBM</div>
  <br/>
  <?php echo $this->renderPartial($this->path_view."anak/print/_printpage3_RI", array(
        'model'=>$model,'dataFlaCcs'=>$dataFlaCcs,'getFlaCcs' => $getFlaCcs,'modSkrinningnyerianakdetT'=>$modSkrinningnyerianakdetT,
    ), true); ?>
  </div>
  <div style="page-break-before:always; page-break-after:always;">
    <div class="textbold headertext floatright">FRM/73C Rev 01/RSBM</div>
    <br/>
    <?php echo $this->renderPartial($this->path_view."anak/print/_printpage4_RI", array(
          'model'=>$model
      ), true); ?>
    </div>
</div>
