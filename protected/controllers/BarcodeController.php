<?php
/**
 * agar bisa menampilkan barcode tanpa perlu mendaftarkan user role di SRBAC
 */
class BarcodeController extends Controller
{
    public function actions()
    {
            return array(
                    'myBarcode'=>array(
                        'class'=>'MyBarcodeAction',
                        'canvasWidth'=>'230',
                        'type'=>'code128',
                    ),
                    'myBarcodeKartuPasien'=>array(
                        'class'=>'MyBarcodeAction',
                        'canvasWidth'=>'150',
                        'canvasHeight'=>'60',
                        'type'=>'code128',
                        'is_text'=>true,
                    ),
                    'myBarcodeKarcis'=>array(
                        'class'=>'MyBarcodeAction',
                        'canvasWidth'=>'230',
                        'canvasHeight'=>'30',
                        'type'=>'code128',
                        'is_text'=>true,
                        'fontSize'=>7
                    ),
            );
    }
}
?>