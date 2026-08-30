<?php
	$saldonormal = isset($saldonormal) ? $saldonormal : "D";
    $debet = 'D';
//    $modRekSupplier = SupplierrekM::model()->findAllByAttributes(array('supplier_id'=>$supplier_id));
    $modRekSupplier = SupplierrekM::model()->findAllBySql("SELECT * 
FROM supplierrek_m 
JOIN rekening5_m as rekeningdebit ON supplierrek_m.rekening5_id = rekeningdebit.rekening5_id AND supplierrek_m.debitkredit = 'D'
WHERE
supplierrek_m.supplier_id = $supplier_id");
    if(count((array)$modRekSupplier)>0)
    {   
        $grek = array(1 => array(
            'nama'=>'Faktur Pembelian',
            'det'=>array(),
        ), 2 => array(
            'nama'=>'Bayar ke Supplier',
            'det'=>array(),
        ));
        foreach ($modRekSupplier as $data) {
            if ($data->isfakturpembelian) {
                $grek[1]['det'][] = $data;
            } else if ($data->isbayarkesupplier) {
                $grek[2]['det'][] = $data;
            }
        }
        
        foreach ($grek as $item) {
            if (count((array)$item['det']) == 0) continue;
            echo $item['nama'].'<br>';
            echo '<ul>';
            foreach ($item['det'] as $item2) {
                 echo '<li>'.$item2->rekening5->kdrekening5.' '.$item2->rekening5->nmrekening5.'</li>';
            }
            echo '</ul>';
        }
    }
    else
    {
        echo Yii::t('zii','-'); 
    }   
?>