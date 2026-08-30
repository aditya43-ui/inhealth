
<?php
$criteria = new CDbCriteria();
$criteria->with = array('pegawai');
$criteria->addCondition(" ruangan_id = '".$ruangan_id."' ");
$criteria->order = "nama_pegawai ASC";

$modRuanganPegawai=RuanganpegawaiM::model()->findAll($criteria);//'ruangan_id='.$ruangan_id.' ORDER BY nama_pegawai ASC'
if(count((array)$modRuanganPegawai)>0)
    {   
        echo "<ul>"; 
        foreach($modRuanganPegawai as $i=>$tampilData)
        {
            echo "<li>".$tampilData->pegawai->namalengkap;
            echo !empty($tampilData->pegawai->loginpemakai_id)?' - ('.$tampilData->pegawai->loginpemakai->nama_pemakai.')':'';
            echo "</li>";
        }
        echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
?>
