<?php
//Di kasih else dulu saya tidak tau kelas pelayannya itu boleh kosong atw ngak???? 
//Alna dari dummi data yang ada ada yang kosong
if($kelaspelayanan_id!=''){
$modTarifTindakan=PITariftindakanM::model()->find('kelaspelayanan_id='.$kelaspelayanan_id.' AND 
                                                   daftartindakan_id='.$daftartindakan_id.'
                                                   AND komponentarif_id='.Params::KOMPONENTARIF_ID_TOTAL.''
		. '											AND jenistarif_id = '.$jenistarif_id.'');
}else{ 
    $modTarifTindakan=PITariftindakanM::model()->find('daftartindakan_id='.$daftartindakan_id.'
                                                   AND komponentarif_id='.Params::KOMPONENTARIF_ID_TOTAL.''
			. '										AND jenistarif_id = '.$jenistarif_id.'');
    $modTarifTindakan->harga_tariftindakan=0;//Belum Disetting dr masternya Berarti
}
echo $modTarifTindakan->harga_tariftindakan;
?>
