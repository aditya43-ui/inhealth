<?php

/**
 *   - controller ini untuk extends ke controller surat keterangan yang ada di modul rekam medis
 *   @author	Andyka <andykaputra@.com>
 *   @website	<.com>
 */

Yii::import('rekamMedis.controllers.SuratKeteranganController');
Yii::import('rekamMedis.models.*');
class SuratKeteranganMCController extends SuratKeteranganController
{
  public $init = 'MC';
}
