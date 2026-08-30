
<?php
    $modUser = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
    $modProfile = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
//    echo $modUser->nama_pemakai.' '.date('Y-m-d H:i:s');
?>
<br/><br/><br/><hr style="border-color: gray;">
<div>
<div style="margin-top:-15px;">
    <i>Printed at <?php echo date("d/m/y h:m:s");?></i>
</div>
</div>