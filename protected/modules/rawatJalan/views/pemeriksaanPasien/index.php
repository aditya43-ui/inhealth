<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fa fa-stethoscope"></i> Pemeriksaan Pasien <b><?php
             if($modPendaftaran->statusperiksa == 'SUDAH DI PERIKSA' || $modPendaftaran->statusperiksa == 'ANTRIAN' || $modPendaftaran->statusperiksa == 'SUDAH PULANG' || $modPendaftaran->statusperiksa == 'SEDANG DIRAWAT INAP' || $modPendaftaran->statusperiksa == 'BATAL PERIKSA' && $modPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ){
            echo 'RAWAT JALAN';
              }else if($modPendaftaran->statusperiksa == 'SUDAH DI PERIKSA' || $modPendaftaran->statusperiksa == 'ANTRIAN' || $modPendaftaran->statusperiksa == 'SUDAH PULANG' || $modPendaftaran->statusperiksa == 'SEDANG DIRAWAT INAP' || $modPendaftaran->statusperiksa == 'BATAL PERIKSA' && $modPendaftaran->instalasi_id == Params::INSTALASI_ID_RD){
                echo 'RAWAT DARURAT';
                }else if($modPendaftaran->statusperiksa == 'SUDAH DI PERIKSA' || $modPendaftaran->statusperiksa == 'ANTRIAN' || $modPendaftaran->statusperiksa == 'SUDAH PULANG' || $modPendaftaran->statusperiksa == 'SEDANG DIRAWAT INAP' || $modPendaftaran->statusperiksa == 'BATAL PERIKSA' && $modPendaftaran->instalasi_id == Params::INSTALASI_ID_RI){
                echo 'RAWAT INAP';
              }else{
                echo 'RAWAT JALAN';
                // echo $modPendaftaran->ruangan->ruangan_nama;
              }
                ?> </b>
        </div>
    </div> 
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Daftar Pasien' => Yii::app()->request->urlReferrer,
            'Pemeriksaan Pasien',
        );
        ?>
        <?php $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
        <?php
        $this->renderPartial($this->path_view . '_tabMenu', array('modPendaftaran'=>$modPendaftaran));
        $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien,"modPendaftaran"=>$modPendaftaran)); ?>
        <div>
            <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
        </div>
    </div>
</div>

<?php  // $this->renderPartial("rawatJalan.views.pemeriksaanPasien.validasi.handle-tab.index",[], true); ?>