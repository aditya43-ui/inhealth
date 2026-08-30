<?php

if (count((array)$model) == 0) {
    echo "Data belum ditemukan";
}

foreach ($model as $item) {
    echo $this->renderPartial('application.modules.gizi.views.asesmenGizi.detail', array(
        'model'=>$item,
        'riwayat'=>true,
    ), true);
}

?>