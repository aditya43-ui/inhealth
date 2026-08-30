<?php

class PendaftaranCommand extends CConsoleCommand {

    public function actionPerbaikanNoPendaftaran() {
        
        $cr = new CDbCriteria;
        $cr->addCondition("char_length(no_pendaftaran) = 17");
        $cr->order = "pendaftaran_id asc";

        $daftar = PendaftaranT::model()->findAll($cr);

        foreach ($daftar as $item) {
            $no_lama = $item->no_pendaftaran;
            $item->generateNoPendaftaranDanSimpan();
            echo $no_lama." -> ".$item->no_pendaftaran." :: OK\n";
        }
    }

}

?>