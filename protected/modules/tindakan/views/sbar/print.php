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

    .table-costum th, .table-costum td {
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
  <div class="textright textbold headertext">FRM/11/RSBM</div>
  <?php echo $this->renderPartial($this->path_view."_headerPrint", array(
       'modProfilRs'=>$modProfilRs,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran
   ), true); ?>


  <table width="100%">
    <tr>
        <td class="padding5 borderleftclass borderrightclass" style="padding-left: 20px">
            RUANGAN : <?php
            $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
            echo (isset($ruangan)?$ruangan->ruangan_nama : "") ?>
        </td>
    </tr>
  </table>
  <table width="100%" class="table-costum">
    <thead>
      <tr>
        <th class="textcenter" style="width: 100px">TANGGAL</th>
        <th class="textcenter" style="width: 80px">JAM</th>
        <th class="textcenter">S(SITUATION)</th>
        <th class="textcenter">B(BACKGROUND)</th>
        <th class="textcenter">A(ASSESMENT)</th>
        <th class="textcenter">R(RECOMENDATION)</th>
        <th class="textcenter">NAMA & TTD</th>
      </tr>
    </thead>
    <tbody>
      <?php
          if(count($model) > 0){
            foreach ($model as $mod) {
              ?>
                <tr>
                  <td><?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d',strtotime($mod->tgl_sbar))); ?></td>
                  <td><?php echo date('H:i:s',strtotime($mod->tgl_sbar)); ?></td>
                  <td><?php echo $mod->situation; ?></td>
                  <td><?php echo $mod->background; ?></td>
                  <td><?php echo $mod->assesmen; ?></td>
                  <td><?php echo $mod->rekomendasi; ?></td>
                  <td><?php echo $mod->pegawaiSbar->namaLengkap; ?></td>
                </tr>
              <?php
            }
          }
       ?>
    </tbody>
  </table>
</div>
