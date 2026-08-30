<?php       
    //$cekKredit = PelayananrekM::model()->findByPk($pelayananrek_id);
    $cekDebit = PelayananrekM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'daftartindakan_id'=>$daftartindakan_id,'saldonormal'=>$saldonormal));
    
  if(count((array)$cekDebit)>0)
    {   
        foreach($cekDebit as $i=>$data)
        {
            echo "<pre>";
            if($saldonormal=="D"){ 
              if(isset($_GET['caraPrint'])){
                echo $data->rekening5->nmrekening5;
              }else{
				if (isset($data->rekening5->nmrekening5)){
                echo $data->rekening5->nmrekening5.CHtml::Link("<i class=\"icon-pencil\"></i>",
                            Yii::app()->controller->createUrl("pelayananRek/ubahRekeningDebit",array("id"=>$data->pelayananrek_id)),
                            array("class"=>"", 
                                  "target"=>"iframeEditRekeningDebitKredit",
                                  "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk ubah Rekening Debit",
                            ));
				}else{
					echo "-".CHtml::Link("<i class=\"icon-pencil\"></i>",
                            Yii::app()->controller->createUrl("pelayananRek/ubahRekeningDebit",array("id"=>$data->pelayananrek_id)),
                            array("class"=>"", 
                                  "target"=>"iframeEditRekeningDebitKredit",
                                  "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk ubah Rekening Debit",
                            ));;
				}
              }
            }
//			else{
//              if(isset($_GET['caraPrint'])){
//                echo $data->rekening5->nmrekening5;
//              }else{
//                echo $data->rekening5->nmrekening5.CHtml::Link("<i class=\"icon-pencil\"></i>",
//                            Yii::app()->controller->createUrl("pelayananRek/ubahRekeningKredit",array("id"=>$data->pelayananrek_id)),
//                            array("class"=>"", 
//                                  "target"=>"iframeEditRekeningDebitKredit",
//                                  "onclick"=>"$(\"#dialogUbahRekeningDebitKredit\").dialog(\"open\");",
//                                  "rel"=>"tooltip",
//                                  "title"=>"Klik untuk ubah Rekening Kredit",
//                            ));
//              }
//            }
            echo "</pre>";
        }
    }
    else
    {
        echo Yii::t('zii','Not set'); 
    }
?>