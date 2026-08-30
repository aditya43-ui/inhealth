<?php
/**   command ini digunakan pada cronjob (realtime proses), fungsi ini digunakan untuk update notifikasi 
 * 
 *	@category	Notifikasi
 *	@author		Deni Hamdani <denihamdani@piindonesia.co.id>
 *	@website	<https://piindonesia.co.id>
 */

class UpdateKamarApplicareCommand extends CConsoleCommand {
    public function actionUpdateKamar() {
        KamaraplicareR::updateKamarAplicare();
        echo "Kamar sudah di-update.\n";
    }
}

