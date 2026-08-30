<div class="header">
    <div class="flex-1">
        <?php 
            $format = new MyFormatter();
        
            $url = Yii::app()->getBaseUrl('webroot').'/data/blank.png';
            $pathrs = Params::pathProfilRSDirectory();
            $ambildata = Yii::getPathOfAlias('webroot').'/data/blank.png';
            if (file_exists($pathrs.$profil->logo_rumahsakit)){
                $url = Params::urlProfilRSDirectory().$profil->logo_rumahsakit;
                $ambildata = $pathrs.$profil->logo_rumahsakit;
            }
            
            $content = file_get_contents($ambildata);
            $ext_data = pathinfo($ambildata);

            if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
                $ext = $ext_data['extension'];
            }

            $res = "data:image/" . $ext . ";base64," . base64_encode($content);
            
            
            echo CHtml::image($res,$profil->logo_rumahsakit,['width'=>'100px']); 
        ?>
    </div>
    <div class="flex-2 pt-2 text-center fs-15">
        <b>ANTRIAN PENDAFTARAN PASIEN</b><br/>
        <b>SILAHKAN PILIH ANTRIAN</b>
    </div>
    <div class="flex-1 pt-2 text-center fs-15">
        <?php
        
            $day = strtoupper($format->getDayUser(date('w'))).', '.date('d');
            $month = strtoupper($format->getMonthId(date('m')));
            $year = date('Y');
        ?>
        <b><?= $day.' '.$month.' '.$year ?></b><br/>
        <b id="clock"></b>
    </div>
</div>