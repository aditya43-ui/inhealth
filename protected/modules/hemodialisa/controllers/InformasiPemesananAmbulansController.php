<?php

class InformasiPemesananAmbulansController extends MyAuthController
{	

	
	public function actionIndex()
	{
            $format = new MyFormatter();
            $modPemesanan = new HDPesanambulansT('search');
            $modPemesanan->tgl_awal  = date('Y-m-d');
            $modPemesanan->tgl_akhir  = date('Y-m-d');
            if(isset($_GET['HDPesanambulansT'])){
                $modPemesanan->unsetAttributes();
                $modPemesanan->attributes = $_GET['HDPesanambulansT'];
                $modPemesanan->tgl_awal  = $format->formatDateTimeForDb($_GET['HDPesanambulansT']['tgl_awal']);
                $modPemesanan->tgl_akhir  = $format->formatDateTimeForDb($_GET['HDPesanambulansT']['tgl_akhir']);
            }
            $this->render('index',array('format'=>$format,'modPemesanan'=>$modPemesanan));
            
	}
        
}