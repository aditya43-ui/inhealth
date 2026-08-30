<?php
  $totalMasuk = 0;
  $totalkeluar = 0;
  $totalIWL = 0;
 ?>
<div class="row">
  <div class="col-sm-12">
    <div class="control-group ">
        <?php echo CHtml::label('Cairan Masuk dalam 24 Jam :','', array('class'=>'control-label','style'=>'width: 150px')) ?>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td style="font-weight: bold;">Nama Cairan</td>
          <td style="font-weight: bold;">Jumlah</td>
        </tr>
      </thead>
      <?php
        $criteriaMasuk = new CDbCriteria();
        $criteriaMasuk->select = "t.nama_cairan, t.satuan_jumlah, sum(t.jumlah) as jumlah";
        $criteriaMasuk->group = "t.nama_cairan, t.satuan_jumlah";
        $criteriaMasuk->join = 'JOIN balancecairan_t on balancecairan_t.balancecairan_id = t.balancecairan_id';
        if(!empty($model->balancecairan_tanggal)){
            $criteriaMasuk->addcondition("date(balancecairan_t.tanggal_pencatatan) = '".MyFormatter::formatDateTimeForDb($model->balancecairan_tanggal)."'");
        }
        if(!empty($model->pasienadmisi_id)){
            $criteriaMasuk->addcondition("balancecairan_t.pasienadmisi_id= ".$model->pasienadmisi_id);
        }

        $riwayatCairanMasuk = BalancecairanmasukT::model()->findAll($criteriaMasuk);
       ?>
       <tbody>
         <?php
            if(!empty($riwayatCairanMasuk)){
              foreach($riwayatCairanMasuk as $rw_masuk){
                $totalMasuk += $rw_masuk->jumlah;
                ?>
                <tr>
                  <td><?php echo $rw_masuk->nama_cairan; ?></td>
                  <td><?php echo $rw_masuk->jumlah.' '.$rw_masuk->satuan_jumlah; ?></td>
                </tr>
                <?php
              }
            }
          ?>
       </tbody>
       <tfoot>
         <tr>
           <td style="font-weight: bold;">Total</td>
           <td><?php echo $totalMasuk; ?></td>
        </tr>
       </tfoot>
    </table>
    <div class="control-group ">
        <?php echo CHtml::label('Cairan Keluar dalam 24 Jam :','', array('class'=>'control-label','style'=>'width: 150px')) ?>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td style="font-weight: bold;">Nama Cairan</td>
          <td style="font-weight: bold;">Jumlah</td>
        </tr>
      </thead>
      <?php
        $criteriaKeluar = new CDbCriteria();
        $criteriaKeluar->select = "t.nama_cairan, t.satuan_jumlah, sum(t.jumlah) as jumlah";
        $criteriaKeluar->group = "t.nama_cairan, t.satuan_jumlah";
        $criteriaKeluar->join = 'JOIN balancecairan_t on balancecairan_t.balancecairan_id = t.balancecairan_id';
        if(!empty($model->balancecairan_tanggal)){
            $criteriaKeluar->addcondition("date(balancecairan_t.tanggal_pencatatan) = '".MyFormatter::formatDateTimeForDb($model->balancecairan_tanggal)."'");
        }
        if(!empty($model->pasienadmisi_id)){
            $criteriaKeluar->addcondition("balancecairan_t.pasienadmisi_id= ".$model->pasienadmisi_id);
        }

        $riwayatCairankeluar = BalancecairankeluarT::model()->findAll($criteriaKeluar);
       ?>
       <tbody>
         <?php
            if(!empty($riwayatCairankeluar)){
              foreach($riwayatCairankeluar as $rw_keluar){
                $totalkeluar += $rw_keluar->jumlah;
                ?>
                <tr>
                  <td><?php echo $rw_keluar->nama_cairan; ?></td>
                  <td><?php echo $rw_keluar->jumlah.' '.$rw_keluar->satuan_jumlah; ?></td>
                </tr>
                <?php
              }
            }
          ?>
       </tbody>
       <tfoot>
         <tr>
           <td style="font-weight: bold;">Total</td>
           <td><?php echo $totalkeluar; ?></td>
        </tr>
       </tfoot>
    </table>
    <div class="control-group ">
        <?php echo CHtml::label('Total IWL dalam 24 Jam :','', array('class'=>'control-label','style'=>'width: 150px')) ?>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td style="font-weight: bold;">Jumlah Jam Perhitungan</td>
          <td style="font-weight: bold;">Terjadi Kenaikan Suhu</td>
          <td style="font-weight: bold;">Nilai IWL</td>
        </tr>
      </thead>
      <?php
        $criteriaIWL = new CDbCriteria();
        $criteriaIWL->select = "t.jmljam_pemeriksaan, t.isterjadikenaikansuhu, t.iwl_nilaiakhir";
        $criteriaIWL->join = 'JOIN balancecairan_t on balancecairan_t.balancecairan_id = t.balancecairan_id';
        if(!empty($model->balancecairan_tanggal)){
            $criteriaIWL->addcondition("date(balancecairan_t.tanggal_pencatatan) = '".MyFormatter::formatDateTimeForDb($model->balancecairan_tanggal)."'");
        }
        if(!empty($model->pasienadmisi_id)){
            $criteriaIWL->addcondition("balancecairan_t.pasienadmisi_id= ".$model->pasienadmisi_id);
        }

        $riwayatIWL = PerhitunganiwlT::model()->findAll($criteriaIWL);
       ?>
       <tbody>
         <?php
            if(!empty($riwayatIWL)){
              foreach($riwayatIWL as $rw_iwl){
                $totalIWL += $rw_iwl->iwl_nilaiakhir;
                ?>
                <tr>
                  <td><?php echo $rw_iwl->jmljam_pemeriksaan; ?></td>
                  <td><?php echo (($rw_iwl->isterjadikenaikansuhu==true)?"Ya":"Tidak"); ?></td>
                  <td><?php echo $rw_iwl->iwl_nilaiakhir.' cc'; ?></td>
                </tr>
                <?php
              }
            }
          ?>
       </tbody>
       <tfoot>
         <tr>
           <td colspan="2" style="font-weight: bold;">Total</td>
           <td><?php echo $totalIWL.' cc'; ?></td>
        </tr>
       </tfoot>
    </table>
  </div>
</div>
<?php
  $model->totalcairanmasuk = $totalMasuk;
  $model->totalcairankeluar = $totalkeluar;
  $model->totaliwl = $totalIWL;
?>
