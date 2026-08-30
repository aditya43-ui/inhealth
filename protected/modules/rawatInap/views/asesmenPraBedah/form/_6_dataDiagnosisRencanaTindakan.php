<?php
    echo $this->renderPartial('rawatInap.views.asesmenPraBedah/grid/_daftarRiwayatMorbiditas',['model'=>$model], true);
    echo '<hr/>';
    echo $this->renderPartial('rawatInap.views.asesmenPraBedah/grid/_daftarDiagnosaicd9',['model'=>$model], true);
    echo '<hr/>';
    echo $this->renderPartial('rawatInap.views.asesmenPraBedah/grid/_daftarRiwayatPermintaan',['model'=>$model], true);
?>