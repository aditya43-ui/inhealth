<?php

/**
 * Extend dari Kirim Pesan.
 * untuk melakukan Pengiriman pesan melalui API SMS Blast.
 *
 * @author Deni Hamdani
 * @email	<denihamdani@piindonesia.co.id>
 */

Yii::import('smsCenter.controllers.KirimPesanController');

class KirimPesanBlastController extends KirimPesanController
{
  public $is_blast = true;
}
