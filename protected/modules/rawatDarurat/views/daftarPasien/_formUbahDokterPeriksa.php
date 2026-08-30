
<style>
  .active {
    background-color: #79e0cb !important;
    color: black !important;
  }
  .tab {
    margin-top: 10px;
  }
</style>
<div class="panel panel-gradient">
   
    <div class="panel-body">
        <?php
                $this->breadcrumbs = array(
                    'Ubah Dokter' => array('index'),
                    'Update',
                );
   

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo $this->renderPartial('_formRiwayatDPJP', array('modRiwayatUbahDokter' => $modRiwayatUbahDokter)); ?>
   
        <div class="tab">
          <button class="tablinks btn btn-success active" onclick="openCity(event, 'Disposisi')" id="defaultOpen">Disposisi</button>
          <button class="tablinks btn btn-success" onclick="openCity(event, 'Leader')">Persetujuan Alih Leader</button>
        </div>
        
        <div id="Disposisi" class="tabcontent">
        <?php echo $this->renderPartial('_formUbahDokter', array('modPendaftaran'=>$modPendaftaran,'modUbahDokter'=>$modUbahDokter,'modDokter' => $modDokter)); ?>
        </div>
        
        <div id="Leader" class="tabcontent">
        <?php echo $this->renderPartial('_formLeader', array('modPendaftaran'=>$modPendaftaran,'modUbahDokter'=>$modUbahDokter,'modDokter' => $modDokter, 'modAlihLeader' => $modAlihLeader)); ?>
        
        </div>
    </div>
</div>
<div style="line-height: 100px;">.</div>

<?php 
$count = UbahdokterR::model()->findAllByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')], 'is_approve is true');


$dispos = count($count);

$countAlihLeader = UbahdokterR::model()->findAllByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')], "is_approve is null and alasanperubahandokter = 'ALIH LEADER'");

$alihleader = count($countAlihLeader);

?>


 <script>
       
  function openCity(evt, cityName) {

    if(cityName == 'Leader') {
      if(<?= $dispos ?> < 1) {
        myAlert('Belum Disposisi');
        return false;
      }

      if(<?= $alihleader ?> > 0) {
        myAlert('Tidak dapat melakukan alih leader karena persetujuan alih leader sebelumnya masih dalam status belum persetujuan');
        return false;
      }
    }
    

    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

    </script>