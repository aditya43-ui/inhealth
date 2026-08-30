<?php

class InformasiTarifController extends MyAuthController
{
	public function actionIndex()
	{
                //$instalasi_id=Yii::app()->user->getState('instalasi_id');
//                $idRuangan=Yii::app()->user->getState('ruangan_id');
                $modTarifTindakanRuanganV = new RMTariftindakanperdaruanganV;
//                $modTarifTindakanRuanganV->instalasi_id=$instalasi_id;
//                $modTarifTindakanRuanganV->ruangan_id=$idRuangan;
                
                if(isset($_GET['RMTariftindakanperdaruanganV'])){
                    $modTarifTindakanRuanganV->attributes=$_GET['RMTariftindakanperdaruanganV'];
                   
                }
		$this->render('index',array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
	}
        
        public function actionDetailsTarif($idKelasPelayanan,$idDaftarTindakan, $idKategoriTindakan){
            
            $this->layout='//layouts/iframe';
            if($idKelasPelayanan!=''){
            $modTarifTindakan= RMTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id='.$idKelasPelayanan.' AND 
                                                               daftartindakan_id='.$idDaftarTindakan.'
                                                               AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'');
            }else{ 
                $modTarifTindakan=RMTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id='.$idDaftarTindakan.'
                                                               AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'
                                                               AND kelaspelayanan_id isNull');
            }
            $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$idDaftarTindakan.' and kelaspelayanan_id = '.$idKelasPelayanan.' and kategoritindakan_id = '.$idKategoriTindakan);
            $jumlahTarifTindakan=COUNT($modTarifTindakan);
            
            $this->render('detailsTarif',array('modTarif'=>$modTarif,
                                                'modTarifTindakan'=>$modTarifTindakan,
                                                'jumlahTarifTindakan'=>$jumlahTarifTindakan));
            
            
        }

}