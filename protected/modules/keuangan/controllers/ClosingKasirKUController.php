<?php

/**
 * @category		controllers
 * @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website		<piindonesia.co.id>
 * @wiki			<https://piiproject.atlassian.net/wiki/display/MDO>
 * - informasi closing kasir
 */
Yii::import('billingKasir.controllers.ClosingKasirController');
Yii::import('billingKasir.models.*');
Yii::import('billingKasir.views.*');

class ClosingKasirKUController extends ClosingKasirController
{
  public $modul_sk = 'KU';
  public $url_setor_bank = 'setoranBendaharaKeBank/index';
}
