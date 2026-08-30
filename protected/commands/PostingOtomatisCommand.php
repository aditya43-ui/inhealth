<?php


/**
 * Fungsi untuk posting otomatis disetiap hari-nya.
 * Digunakan dalam cronjob disetiap jam tertentu.
 * 
 */

class PostingOtomatisCommand extends CConsoleCommand {
	public function run($args) {
        $tgl = date('Y-m-d', strtotime('-1 day'));
        
        echo("Posting jurnal untuk tanggal ".$tgl."...\n");
        
        $cr = new CDbCriteria;
        $cr->join = "left join tandabuktibayar_t b on b.tandabuktibayar_id = t.tandabuktibayar_id";
        $cr->addCondition('b.pembayaranpelayanan_id is null');
        $cr->addCondition("tglbuktijurnal::date <= '".$tgl."'::date");
        
        $bayar = JurnalrekeningT::model()->findAll($cr);
        
        foreach ($bayar as $item) {
            echo "NO : ".$item->nobuktijurnal." \n";
            
            $res = Yii::app()->db
            ->createCommand("select ins_jurnalpostingotomatisbilling_fix_jurnal(".$item->jurnalrekening_id.") as simpan")
            ->queryRow();
        
            if (count($res) != 0) {
                var_dump("Done!", $res);
            } else {
                var_dump("Nope!");
            }
        }
    }

}
