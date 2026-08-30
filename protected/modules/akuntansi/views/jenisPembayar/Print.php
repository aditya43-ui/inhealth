<style>

    .tab_detail {
        border-collapse: collapse;
        width: 100%;
    }

    .tab_detail th {
        font-weight: bold;
    }

    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 5px;
        font-size: 12px;
    }

</style>

<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'tab_detail',
	'columns'=>array(
        array(
            'header'=>'No.',
            'value'=>'$row+1',
        ),
        //'jnspembayar_id',
        'jnspembayar_nama',
        //'jnspembayar_namalain',
        array(
            'name'=>'bank_id',
            'type'=>'raw',
            'value'=>function($data) {

                $bank_list = JnspembayarbankM::model()->findAllByAttributes(array(
                    'jnspembayar_id'=>$data->jnspembayar_id,
                ));

                if (count((array)$bank_list) == 0) {
                    return "";
                }

                $str = "<ul>";
                foreach ($bank_list as $item) {
                    $bank = BankM::model()->findByPk($item->bank_id);
                    if (empty($bank)) {
                        continue;
                    }

                    $str .= "<li>".$bank->bankDanAtasNama."</li>";
                }

                $str .= "</ul>";

                return $str;
            },
        ),
        array(
            'name'=>'jatuhtempo',
            'value'=>'empty($data->jatuhtempo) ? "-" : ($data->jatuhtempo." Hari")'
        ),
        'jnspembayar_cp',
        'jnspembayar_nomobile',
        array(
            'header'=>'Rekening Debit',
            'type'=>'raw',
            'value'=>function($data) {
              $rek_list = JnspembrekM::model()->findAllByAttributes(array(
                  'jnspembayar_id'=>$data->jnspembayar_id,
                  'debitkredit'=>'D'
              ));

              if (count((array)$rek_list) == 0) {
                  return "";
              }

              $str = "<ul>";
              foreach ($rek_list as $item) {
                  $rek = Rekening5M::model()->findByPk($item->rekening5_id);
                  if (empty($rek)) {
                      continue;
                  }

                  $str .= "<li>".$rek->nmrekening5."</li>";
              }

              $str .= "</ul>";


                return $str;
            }
        ),
        array(
            'header'=>'Rekening Kredit',
            'type'=>'raw',
            'value'=>function($data) {
              $rek_list = JnspembrekM::model()->findAllByAttributes(array(
                  'jnspembayar_id'=>$data->jnspembayar_id,
                  'debitkredit'=>'K'
              ));

              if (count((array)$rek_list) == 0) {
                  return "";
              }

              $str = "<ul>";
              foreach ($rek_list as $item) {
                  $rek = Rekening5M::model()->findByPk($item->rekening5_id);
                  if (empty($rek)) {
                      continue;
                  }

                  $str .= "<li>".$rek->nmrekening5."</li>";
              }

              $str .= "</ul>";

                return $str;
            }
        ),

        array(
            'name'=>'jnspembayar_aktif',
            'type'=>'raw',
            'value'=>function($data) {
                return $data->jnspembayar_aktif ? "Aktif" : "Tidak Aktif";
            }
        ),

	),
));
?>
