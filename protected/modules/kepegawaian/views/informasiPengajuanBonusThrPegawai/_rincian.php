<style>
  body {
        color: black;
    }

    .border th, .border td{
        border:1px solid #000;
        padding:2px;
    }
    .table thead:first-child{
        border-top:1px solid #000;
    }

    thead th{
        background:none;
        color:#333;
    }

    .table tbody tr td, .table tbody tr th {
        background-color: none;
    }
    .table {
        box-shadow: none;
    }
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
                  <div class="judulcontent" style="text-align: center;">
                      <b>SLIP PEMBAYARAN <?php echo strtoupper($model->jenisgaji); ?></b>
                  </div>
                  <br>
                  <table class='table' style = "border: 0;">
                      <tr>
                          <td width="50%">
                              <table class='table' style = "border: 0;">
                                  <tr>
                                      <td width="180px"> Nama </td>
                                     <td>
                                         : <?php echo $modDetail->pegawai->namaLengkap; ?>
                                     </td>
                                  </tr>
                                  <tr>
                                      <td> NIP</td>
                                      <td>
                                         : <?php echo $modDetail->pegawai->nomorindukpegawai; ?>
                                     </td>
                                  </tr>
                                  <tr>
                                      <td> Jenis Gaji </td>
                                     <td>
                                         : <?php echo $model->jenisgaji; ?>
                                     </td>
                                  </tr>
                                  <tr>
                                      <td> Periode Pengajuan </td>
                                     <td>
                                         : <?php echo MyFormatter::getMonthId(date('m',strtotime($model->periodebonusthr))).' '.date('Y',strtotime($model->periodebonusthr)); ?>
                                     </td>
                                  </tr>
                              </table>
                          </td>
                          <td width="50%">
                              <table class='table' style = "border: 0;">
                                  <tr>
                                      <td width="150px"> No. Pengajuan </td>
                                     <td>
                                         : <?php echo $model->nopengajuan; ?>
                                     </td>
                                  </tr>

                                  <tr>
                                      <td> Tanggal Pengajuan </td>
                                     <td>
                                         : <?php echo MyFormatter::formatDateTimeForUser($model->tglpengajuan); ?>
                                     </td>
                                  </tr>
                                  <tr>
                                     <td> Keterangan </td>
                                     <td>
                                         : <?php echo $model->keteranganpengajuan; ?>
                                     </td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                  </table>
                      <br>
                      <?php if($model->jenisgaji == 'Bonus'){ ?>
                  <table width="85%" style='margin-left:auto; margin-right:auto;' class ="border">
                      <thead class="border">
                        <th>PPh 21</th>
                          <th>Total Bonus</th>
                          <th>PPh 21 Bonus</th>
                          <th>Tunjangan PPh 21 Bonus</th>
                          <th>THP</th>
                      </thead>
                      <tbody>
                           <tr class="border">
                             <td><?php echo $modDetail->pegawai->metode_pph_21; ?></td>
                              <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modDetail->nilaibonus,2); ?></td>
                              <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modDetail->pajakbonus,2); ?></td>
                              <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modDetail->tunjangan_pph_21_bonus,2); ?></td>
                              <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modDetail->thp_bonus,2); ?></td>
                              <!--<td><?php //echo $modDetail->keteranganbonus; ?></td>-->
                          </tr>
                      </tbody>
                  </table>
                <?php }else{ ?>
                  <table width="85%" style='margin-left:auto; margin-right:auto;' class ="border">
                      <thead class="border">
                          <th>Tanggal Masuk</th>
                          <th>PPh 21</th>
                          <th>Status Pegawai</th>
                          <th>Gaji Pokok</th>
                          <th>Tunjungan Tetap</th>
                          <th>Total THR</th>
                          <th>Tunjangan PPh 21</th>
                          <th>Total PPh 21 THR</th>
                          <th>THP</th>
                      </thead>
                      <tbody>
                        <tr class="border">
                          <td><?php echo MyFormatter::formatDateTimeForUser($modDetail->tglditerima); ?></td>
                          <td><?php echo $modDetail->pegawai->metode_pph_21; ?></td>
                          <td><?php echo $modDetail->statuspegawai; ?></td>
                           <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modDetail->gajipokok,2); ?></td>
                           <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modDetail->tunjangantetap,2); ?></td>
                           <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modDetail->totalthr,2); ?></td>
                           <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modDetail->tunjangan_pph_21_thr,2); ?></td>
                           <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modDetail->totalpajak,2); ?></td>
                           <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modDetail->thp_thr,2); ?></td>
                        </tr>
                      </tbody>
                  </table>
                  <?php } ?>
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
<?php
    if(!isset($_GET['caraPrint'])){
?>
        <div class="form-actions">
            <?php
                echo CHtml::link(
                    Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),
                    'javascript:void(0);',
                    array(
                        'class'=>'btn btn-info',
                        'onClick'=>'print("PRINT")'
                    )
                );
            ?>
		</div>
<?php
$urlPrint= $this->createUrl('rincian',array('pengbonusthrdetail_id'=>$modDetail->pengbonusthrdetail_id,'pengbonusthr_id'=>$model->pengbonusthr_id, 'caraPrint'=>'PRINT'));
$js = <<< JSCRIPT
function print(caraPrint)
{
window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');

}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);

}
?>
