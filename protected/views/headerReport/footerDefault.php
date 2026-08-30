
<?php
    $modUser = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
    $modProfile = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
//    echo $modUser->nama_pemakai.' '.date('Y-m-d H:i:s');
?>
<br/><br/><br/>
<div>
<div>
    <?php echo $modProfile->kabupaten->kabupaten_nama." , ".date("d M Y"); ?>
    <?php //echo Yii::app()->user->getState('kabupaten_nama')." , ".date("d M Y"); ?>
    <br/><br/><br/><br/>
    <?php
        if (empty($modUser->nama_pemakai)) { 
            echo "( .............................. )";
        } else {
            echo "($modUser->nama_pemakai)";
        }
    ?>
</div>
</div>