<?php

class PanggilExcelController extends MyAuthController
{
  public function actionA1()
  {
    $this->redirect(Params::urlExcel() . 'RL 1.2_Indikator Pelayanan.xls');
  }
  public function actionTempatTidur()
  {
    $this->redirect(Params::urlExcel() . 'RL 1.3_Tempat Tidur.xls');
  }
  public function actionKetenagaan()
  {
    $this->redirect(Params::urlExcel() . 'RL 2_Ketenagaan.xls');
  }
  public function actionRawatInap()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.1_Rawat inap.xls');
  }
  public function actionRawatDarurat()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.2_Rawat darurat.xls');
  }
  public function actionGigi()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.3_gigi mulut.xls');
  }
  public function actionBidan()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.4_kebidanan.xls');
  }
  public function actionParinatologi()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.5_perinatologi.xls');
  }
  public function actionBedah()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.6_pembedahan.xls');
  }
  public function actionRad()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.7_radiologi.xls');
  }
  public function actionLab()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.8_laboratorium.xls');
  }
  public function actionRehab()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.9_rehab medik.xls');
  }
  public function actionPelayanan()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.10_pelayanan khusus.xls');
  }
  public function actionJiwa()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.11_kesehatan jiwa.xls');
  }
  public function actionKB()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.12_keluarga berencana.xls');
  }
  public function actionObat()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.13_Obat.xls');
  }
  public function actionRujukan()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.14_rujukan.xls');
  }
  public function actionCaraBayar()
  {
    $this->redirect(Params::urlExcel() . 'RL 3.15_cara bayar.xls');
  }
  public function actionPenyakitRI10()
  {
    $this->redirect(Params::urlExcel() . 'RL 5.3 10_Besar Penyakit Rawat Inap.xls');
  }
  public function actionPenyakitRJ10()
  {
    $this->redirect(Params::urlExcel() . 'RL 5.4 10_Besar Penyakit Rawat Jalan.xls');
  }
  public function actionPenyakitRI()
  {
    $this->redirect(Params::urlExcel() . 'RL 4A_penyakit rawat inap.xls');
  }
  public function actionPenyakitRJ()
  {
    $this->redirect(Params::urlExcel() . 'RL 4B_penyakit rawat jalan.xls');
  }
  public function actionPengunjung()
  {
    $this->redirect(Params::urlExcel() . 'RL 5.1_Pengunjung.xls');
  }
  public function actionKunjungan()
  {
    $this->redirect(Params::urlExcel() . 'RL 5.2_Kunjungan Rawat Jalan.xls');
  }
}
