<div class="new-container">
    <?php $this->pageTitle=Yii::app()->name; 
                $this->widget('bootstrap.widgets.BootAlert');
    ?>

    <?php // $this->widget('MyDashboard');?>

    <?php
    //$tabs UNTUK APA ? >> RND-4483
    //$tabs = array();
    $userModul = Yii::app()->user->getState('usersModul');
    foreach ($kategoriModuls as $katValue=>$katName){
        echo "<div class='dashboard'>";
        echo "<div class='block'>";
        echo "<div><h6>".$katValue."</h6></div>";
    //    foreach ($kelompokModuls as $j=>$kelompokModul) {
    //        $tabs[$j]['label'] = $kelompokModul->kelompokmodul_nama;
    //        $tabs[$j]['content'] = "<div class='dashboard'>";

            foreach ($moduls as $i=>$modul){
                if(!empty($userModul[$modul->modul_id])){
                    if($katValue == $modul->modul_kategori) { // && $kelompokModul->kelompokmodul_id == $modul->kelompokmodul_id
                        echo "<a href=".Yii::app()->createUrl($modul->url_modul,array('modul_id'=>$modul->modul_id))." class='shortcut'>";
                        echo "<img alt='' src='".Params::urlIconModulDirectory().$modul->icon_modul."'>";
                        echo "$modul->modul_namalainnya</a>";

                        $content = "<a href=".Yii::app()->createUrl($modul->url_modul,array('modul_id'=>$modul->modul_id))." class='shortcut'>".
                                   "<img alt='' src='".Params::urlIconModulDirectory().$modul->icon_modul."'>".
                                   "$modul->modul_namalainnya</a>";
    //                    $tabs[$j]['content'] .= $content;
                    }
                } else {
                    if($katValue == $modul->modul_kategori) { //&& $kelompokModul->kelompokmodul_id == $modul->kelompokmodul_id
                        echo "<a href='javascript:myAlert(\"Anda tidak bisa mengakses Modul : ".$modul->modul_namalainnya."\");' class='shortcut disable'>";
                        echo "<img alt='' src='".Params::urlIconModulDirectory().$modul->icon_modul."'>";
                        echo "$modul->modul_namalainnya</a>";

                        $content = "<a href='javascript:myAlert(\"Anda tidak bisa mengakses Modul : ".$modul->modul_namalainnya."\");' class='shortcut disable'>".
                                   "<img alt='' src='".Params::urlIconModulDirectory().$modul->icon_modul."'>".
                                   "$modul->modul_namalainnya</a>";
    //                    $tabs[$j]['content'] .= $content;
                    }
                }
            }
    //        $tabs[$j]['content'] .= "</div>";
    //    }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>