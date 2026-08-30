<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
$logomui = 'logo_mui.png';
$logoslhs = 'logo_slhs.png';
?>
<style>       
    table.a  tr td 
    {
        vertical-align: top;
    }

    table.a  tr td label
    {
        font-size:7pt;
    }

    table.a  tr td 
    {
        font-size:7pt;
    }

    table  tr td label
    {
        font-size:5pt;
    }

    table  tr td 
    {
        font-size:7pt;
    }

    #base_catatan {
        border-top: 1px solid black;
        padding-top: 2px;
    }

    .akhir {
        page-break-after: always;
    }

    #catatan {
        margin: 0;
        
    }
    #catatan li {
        font-size: 4.5pt;
        float: right;
    }

    @media (min-width:0px) and (max-width: 1000px) {
        table
        {
            width:100%;
            padding:10px;
        }

    }
</style>

<?php

$jml_data = count($model->searchInformasiMenuPasienPrint()->data);

foreach($model->searchInformasiMenuPasienPrint()->data as $idx =>$items){
    // var_dump($caraPrint);die;
    // echo "<pre>"; 
    // var_dump($items);die;
    //$modJenisWaktu = JenisWaktuM::model()->findByPk($modDetail->jeniswaktu_id);
    $modPasien = PasienM::model()->findByAttributes(array('no_rekam_medik' => $items->no_rekam_medik));
    //$modPasienAdmisi = empty($modDetail->pendaftaran_id) ? new PasienadmisiT : PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $modDetail->pendaftaran_id));
    //$modKamarRuangan = KamarruanganM::model()->findByPk($modPasienAdmisi->kamarruangan_id);
    //$modMenuDiet = MenuDietM::model()->findByPk($modDetail->menudiet_id);
    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $items->pendaftaran_id));;
    $modJenis = JenisdietM::model()->findByPk($items->jenisdiet_id);
    $path = Params::pathProfilRSDirectory().$modProfilRs->logo_rumahsakit_2;

    $res = "";
    $ext = "png";

    if (file_exists($path)) {
        $content = file_get_contents($path);
        $ext_data = pathinfo($path);

        if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
            $ext = $ext_data['extension'];
        }

        $res = "data:image/".$ext.";base64,". base64_encode($content);
    }
?>


<?php if($idx > 0): ?>
    <div style="page-break-before: always;"></div>
<?php endif;?>
<?php

$model = PesanmenudietT::model()->findByPk($items->pesanmenudiet_id);
$modDet = PesanmenudetailT::model()->findAll("pesanmenudiet_id = " . $items->pesanmenudiet_id);

$modRuangan = RuanganM::model()->findByPk($modPendaftaran->pasienadmisi->ruangan_id);


echo $this->renderPartial($this->path_view . 'PrintEtiketNew2', array(
    'format' => $format,
    'judul_print' => $judul_print,
    'model' => $model,
    'modDet' => $modDet,
    'modPendaftaran'=>$modPendaftaran,
    'modRuangan'=>$modRuangan,
    'caraPrint' => $caraPrint
  ), true);

?>


<?php 
};

?>