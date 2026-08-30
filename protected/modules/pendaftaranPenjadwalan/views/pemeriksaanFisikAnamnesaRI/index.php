<div class="white-container">
    <?php 
    $this->breadcrumbs=array(
            'Sapendidikan Ms'=>array('index'),
            'Manage',
    );
    ?>
    <legend class="rim2">Pemeriksaan Fisik <b>& Anamnesa Pasien</b></legend>
    <?php 
        $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
        $this->renderPartial($this->path_view.'_tabMenu',array());
        $this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien));
    ?>
    <div>
        <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
    </div>
</div>