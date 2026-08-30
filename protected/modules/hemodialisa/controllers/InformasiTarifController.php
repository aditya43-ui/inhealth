<?php

class InformasiTarifController extends MyAuthController
{
    public function actionIndex()
    {
            $modTarifTindakanRuanganV = new HDTarifTindakanPerdaRuanganV('search');
			$modTarifTindakanRuanganV->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;

            if(isset($_GET['HDTarifTindakanPerdaRuanganV'])){
                $modTarifTindakanRuanganV->attributes=$_GET['HDTarifTindakanPerdaRuanganV'];
            }

             if (Yii::app()->request->isAjaxRequest) {
                echo $this->renderPartial('_tableTarif', array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
            }else{
                $this->render('index',array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
            }

    }
        
    public function actionDetailsTarif($kelaspelayanan_id,$daftartindakan_id, $kategoritindakan_id){

       $this->layout='//layouts/iframe';
       $kelaspelayanan_id = (isset($kelaspelayanan_id) ? $kelaspelayanan_id : null);
       $daftartindakan_id = (isset($daftartindakan_id) ? $daftartindakan_id : null);
       $kategoritindakan_id = (isset($kategoritindakan_id) ? $kategoritindakan_id : null);

       $modTarifTindakanform = new HDTarifTindakanPerdaRuanganV();
       if($kelaspelayanan_id!=''){
       $modTarifTindakan= HDTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id='.$kelaspelayanan_id.' AND 
                                                          daftartindakan_id='.$daftartindakan_id.'
                                                          AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'');
       }else{ 
           $modTarifTindakan=HDTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id='.$daftartindakan_id.'
                                                          AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'
                                                          AND kelaspelayanan_id isNull');
       }
       if(empty($kategoritindakan_id)){
           $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$daftartindakan_id.' and kelaspelayanan_id = '.$kelaspelayanan_id.'');
       }else{
           $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$daftartindakan_id.' and kelaspelayanan_id = '.$kelaspelayanan_id.' and kategoritindakan_id = '.$kategoritindakan_id);
       }
       $jumlahTarifTindakan=COUNT($modTarifTindakan);

       $this->render('detailsTarif',array(
                                           'modTarif'=>$modTarif,
                                           'modTarifTindakan'=>$modTarifTindakan,
                                           'modTarifTindakanform'=>$modTarifTindakanform,
                                           'jumlahTarifTindakan'=>$jumlahTarifTindakan));


   }

}