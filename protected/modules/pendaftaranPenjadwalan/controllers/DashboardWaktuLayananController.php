<?php
class DashboardWaktuLayananController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'pendaftaranPenjadwalan.views.dashboardWaktuLayanan.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Waktu Layanan";
    $format = new MyFormatter();
    $model = new WaktutunggupelayananT();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->sumberantrian = "rs";

    $isfilter = false;
    if (!empty($_GET['WaktutunggupelayananT'])) {
      $model->jns_periode = $_GET['WaktutunggupelayananT']['jns_periode'];
      $model->sumberantrian = $_GET['WaktutunggupelayananT']['sumberantrian'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['WaktutunggupelayananT']['tgl_awal']);
      $model->bln_awal = $format->formatMonthForDb($_GET['WaktutunggupelayananT']['bln_awal']);

      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal;
      $isfilter = true;
    }

    $antrianonlinebpjs = new AntrianOnlineBpjs();

    $rata_all = 0;
    $rata_taks1 = 0;
    $rata_taks2 = 0;
    $rata_taks3 = 0;
    $rata_taks4 = 0;
    $rata_taks5 = 0;
    $rata_taks6 = 0;
    $trend = array();

    if ($isfilter) {
      if ($model->jns_periode == 'hari') {

        $body = $model->tgl_awal . '/' . $model->sumberantrian;
        $response = CJSON::decode($antrianonlinebpjs->dashboard_harian($body));
        $loadTrend = array();

        if (!empty($response['metaData']) && $response['metaData']['code'] == '200' && !empty($response['response'])) {
          foreach ($response['response']['list'] as $resp_dasboard) {
            $ratataks1 = (!empty($resp_dasboard['avg_waktu_task1']) ? $resp_dasboard['avg_waktu_task1'] : 0);
            $ratataks2 = (!empty($resp_dasboard['avg_waktu_task2']) ? $resp_dasboard['avg_waktu_task2'] : 0);
            $ratataks3 = (!empty($resp_dasboard['avg_waktu_task3']) ? $resp_dasboard['avg_waktu_task3'] : 0);
            $ratataks4 = (!empty($resp_dasboard['avg_waktu_task4']) ? $resp_dasboard['avg_waktu_task4'] : 0);
            $ratataks5 = (!empty($resp_dasboard['avg_waktu_task5']) ? $resp_dasboard['avg_waktu_task5'] : 0);
            $ratataks6 = (!empty($resp_dasboard['avg_waktu_task6']) ? $resp_dasboard['avg_waktu_task6'] : 0);
            $rata = ($ratataks1 + $ratataks2 + $ratataks3 + $ratataks4 + $ratataks5 + $ratataks6);

            $rata_all += $rata;
            $rata_taks1 += $ratataks1;
            $rata_taks2 += $ratataks2;
            $rata_taks3 += $ratataks3;
            $rata_taks4 += $ratataks4;
            $rata_taks5 += $ratataks5;
            $rata_taks6 += $ratataks6;
            $bulan = date('m', strtotime($resp_dasboard['tanggal']));
            $loadTrend[$bulan]['bulan'] = $bulan;
            $loadTrend[$bulan]['bulan'] = MyFormatter::getMonthId($bulan);

            if (!empty($loadTrend[$bulan]['jumlah'])) {
              $loadTrend[$bulan]['jumlah'] += $rata;
            } else {
              $loadTrend[$bulan]['jumlah'] = $rata;
            }
          }
          $rata_all = $rata_all / count($response['response']['list']);
          $rata_taks1 = $rata_taks1 / count($response['response']['list']);
          $rata_taks2 = $rata_taks2 / count($response['response']['list']);
          $rata_taks3 = $rata_taks3 / count($response['response']['list']);
          $rata_taks4 = $rata_taks4 / count($response['response']['list']);
          $rata_taks5 = $rata_taks5 / count($response['response']['list']);
          $rata_taks6 = $rata_taks6 / count($response['response']['list']);
        }

        if (!empty($loadTrend)) {
          foreach ($loadTrend as $trenddata) {
            $trend[$trenddata['bulan']]['bulan'] = MyFormatter::getMonthId($trenddata['bulan']);
            $waktu = "";
            if (!empty($trenddata['jumlah'])) {
              $waktu = floor($trenddata['jumlah'] / 3600) . '.' . (($trenddata['jumlah'] / 60) % 60);
            }

            $trend[$trenddata['bulan']]['jumlah'] = $waktu;
          }
        }
      } else if ($model->jns_periode == 'bulan') {
        $body = date('m', strtotime($model->tgl_awal)) . '/' . date('Y', strtotime($model->tgl_awal)) . '/' . $model->sumberantrian;
        $response = CJSON::decode($antrianonlinebpjs->dashboard_bulanan($body));
        $loadTrend = array();

        if (!empty($response['metaData']) && $response['metaData']['code'] == '200' && !empty($response['response'])) {
          foreach ($response['response']['list'] as $resp_dasboard) {
            $ratataks1 = (!empty($resp_dasboard['avg_waktu_task1']) ? $resp_dasboard['avg_waktu_task1'] : 0);
            $ratataks2 = (!empty($resp_dasboard['avg_waktu_task2']) ? $resp_dasboard['avg_waktu_task2'] : 0);
            $ratataks3 = (!empty($resp_dasboard['avg_waktu_task3']) ? $resp_dasboard['avg_waktu_task3'] : 0);
            $ratataks4 = (!empty($resp_dasboard['avg_waktu_task4']) ? $resp_dasboard['avg_waktu_task4'] : 0);
            $ratataks5 = (!empty($resp_dasboard['avg_waktu_task5']) ? $resp_dasboard['avg_waktu_task5'] : 0);
            $ratataks6 = (!empty($resp_dasboard['avg_waktu_task6']) ? $resp_dasboard['avg_waktu_task6'] : 0);
            $rata = ($ratataks1 + $ratataks2 + $ratataks3 + $ratataks4 + $ratataks5 + $ratataks6);

            $rata_all += $rata;
            $rata_taks1 += $ratataks1;
            $rata_taks2 += $ratataks2;
            $rata_taks3 += $ratataks3;
            $rata_taks4 += $ratataks4;
            $rata_taks5 += $ratataks5;
            $rata_taks6 += $ratataks6;
            $bulan = date('m', strtotime($resp_dasboard['tanggal']));
            $loadTrend[$bulan]['bulan'] = $bulan;
            $loadTrend[$bulan]['bulan'] = MyFormatter::getMonthId($bulan);

            if (!empty($loadTrend[$bulan]['jumlah'])) {
              $loadTrend[$bulan]['jumlah'] += $rata;
            } else {
              $loadTrend[$bulan]['jumlah'] = $rata;
            }
          }
          $rata_all = $rata_all / count($response['response']['list']);
          $rata_taks1 = $rata_taks1 / count($response['response']['list']);
          $rata_taks2 = $rata_taks2 / count($response['response']['list']);
          $rata_taks3 = $rata_taks3 / count($response['response']['list']);
          $rata_taks4 = $rata_taks4 / count($response['response']['list']);
          $rata_taks5 = $rata_taks5 / count($response['response']['list']);
          $rata_taks6 = $rata_taks6 / count($response['response']['list']);
        }

        if (!empty($loadTrend)) {
          foreach ($loadTrend as $trenddata) {
            $trend[$trenddata['bulan']]['bulan'] = MyFormatter::getMonthId($trenddata['bulan']);
            $waktu = "";
            if (!empty($trenddata['jumlah'])) {
              $waktu = floor($trenddata['jumlah'] / 3600) . '.' . (($trenddata['jumlah'] / 60) % 60);
            }
            $trend[$trenddata['bulan']]['jumlah'] = $waktu;
          }
        }
      }
    }

    $waktu_rata_all = "";
    $waktu_rata_task1 = "";
    $waktu_rata_task2 = "";
    $waktu_rata_task3 = "";
    $waktu_rata_task4 = "";
    $waktu_rata_task5 = "";
    $waktu_rata_task6 = "";

    if (!empty($rata_all)) {
      $waktu_rata_all = floor($rata_all / 3600) . ':' . (($rata_all / 60) % 60) . ':' . ($rata_all % 60);
    }
    if (!empty($rata_taks1)) {
      $waktu_rata_task1 = floor($rata_taks1 / 3600) . ':' . (($rata_taks1 / 60) % 60) . ':' . ($rata_taks1 % 60);
    }
    if (!empty($rata_taks2)) {
      $waktu_rata_task2 = floor($rata_taks2 / 3600) . ':' . (($rata_taks2 / 60) % 60) . ':' . ($rata_taks2 % 60);
    }
    if (!empty($rata_taks3)) {
      $waktu_rata_task3 = floor($rata_taks3 / 3600) . ':' . (($rata_taks3 / 60) % 60) . ':' . ($rata_taks3 % 60);
    }
    if (!empty($rata_taks4)) {
      $waktu_rata_task4 = floor($rata_taks4 / 3600) . ':' . (($rata_taks4 / 60) % 60) . ':' . ($rata_taks4 % 60);
    }
    if (!empty($rata_taks5)) {
      $waktu_rata_task5 = floor($rata_taks5 / 3600) . ':' . (($rata_taks5 / 60) % 60) . ':' . ($rata_taks5 % 60);
    }
    if (!empty($rata_taks6)) {
      $waktu_rata_task6 = floor($rata_taks6 / 3600) . ':' . (($rata_taks6 / 60) % 60) . ':' . ($rata_taks6 % 60);
    }



    $dashboard['rata_rata_all'] = $waktu_rata_all;
    $dashboard['rata_rata_task1'] = $waktu_rata_task1;
    $dashboard['rata_rata_task2'] = $waktu_rata_task2;
    $dashboard['rata_rata_task3'] = $waktu_rata_task3;
    $dashboard['rata_rata_task4'] = $waktu_rata_task4;
    $dashboard['rata_rata_task5'] = $waktu_rata_task5;
    $dashboard['rata_rata_task6'] = $waktu_rata_task6;
    $dashboard['trend_rata'] = $trend;

    // echo '<pre>';
    // print_r($dashboard);
    // exit();

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'dashboard' => $dashboard
    ));
  }
}
