<?php

class KonfigsystemKController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public function actionIndex($id = null)
  {
    if ($id == null) {
      $id = 1;
    }

    $this->pageTitle = Yii::app()->name . " - Konfigurasi System";
    $model = $this->loadModel($id);
    $temLogo = $model->logolayarantrian;
    // $temVideo = $model->videoantrian;

    if (!empty($model->klinikgigi_id) && trim($model->klinikgigi_id) != "") {
      $model->klinikgigi_id = explode(",", $model->klinikgigi_id);
    }

    if (isset($_POST['SAKonfigsystemK'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $model->attributes = $_POST['SAKonfigsystemK'];
      $model->jatuhtempoklaim=(!empty($_POST['SAKonfigsystemK']['jatuhtempoklaim'])? $_POST['SAKonfigsystemK']['jatuhtempoklaim']: null);
			$model->jatuhtempotagihan=(!empty($_POST['SAKonfigsystemK']['jatuhtempotagihan'])?$_POST['SAKonfigsystemK']['jatuhtempotagihan'] : null);
      $model->jam_jobakomodasiranap=(!empty($_POST['SAKonfigsystemK']['jam_jobakomodasiranap'])?$_POST['SAKonfigsystemK']['jam_jobakomodasiranap'] : null);

      if(!empty($model->labelnomorpegawai)){
        $findLookupNo = LookupM::model()->findAllByAttributes(array('lookup_type'=>Params::LOOKUP_KEPEGAWAIAN_LABELNOMORPEGAWAI));
        $cekLookupNo = LookupM::model()->findAllByAttributes(array('lookup_type'=>Params::LOOKUP_KEPEGAWAIAN_LABELNOMORPEGAWAI,'lookup_name'=>$model->labelnomorpegawai));
        if(empty($cekLookupNo)){
          $modLookupNomor = new LookupM();
          $modLookupNomor->lookup_type = Params::LOOKUP_KEPEGAWAIAN_LABELNOMORPEGAWAI;
          $modLookupNomor->lookup_name = $model->labelnomorpegawai;
          $modLookupNomor->lookup_value = $model->labelnomorpegawai;
          $modLookupNomor->lookup_urutan = (count((array) $findLookupNo) +1);
          $modLookupNomor->lookup_aktif = true;
          $modLookupNomor->save();
        }
        
      }

      if(!empty($model->labelpegawai)){
        $findLookupLabel = LookupM::model()->findAllByAttributes(array('lookup_type'=>Params::LOOKUP_KEPEGAWAIAN_LABELPEGAWAI));
        $cekLookupLabel = LookupM::model()->findAllByAttributes(array('lookup_type'=>Params::LOOKUP_KEPEGAWAIAN_LABELPEGAWAI,'lookup_name'=>$model->labelpegawai));

        if(empty($cekLookupLabel)){
          $modLookupLabel = new LookupM();
          $modLookupLabel->lookup_type = Params::LOOKUP_KEPEGAWAIAN_LABELPEGAWAI;
          $modLookupLabel->lookup_name = $model->labelpegawai;
          $modLookupLabel->lookup_value = $model->labelpegawai;
          $modLookupLabel->lookup_urutan = (count((array) $findLookupLabel) +1);
          $modLookupLabel->lookup_aktif = true;
          $modLookupLabel->save();
        }
      }
      
      if (isset($_POST['ruangan_id'])) {
        $model->klinikgigi_id = implode(", ", $_POST['ruangan_id']);
      } else {
        $model->klinikgigi_id = null;
      }



      if ($model->validate()) {
        try {

          $random = rand(0000000, 9999999);
          $model->logolayarantrian = CUploadedFile::getInstance($model, 'logolayarantrian');
          // $model->videoantrian = CUploadedFile::getInstance($model, 'videoantrian');
          $gambar = $model->logolayarantrian;
          // $video = $model->videoantrian;

          if (isset($model->logolayarantrian) && ($model->logolayarantrian != $temLogo)) {
            $model->logolayarantrian = $random . $model->logolayarantrian;
            Yii::import("ext.EPhpThumb.EPhpThumb");
            $fullImgName = $model->logolayarantrian;
            $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
            $fullThumbSource = Params::pathProfilRSTumbsDirectory() . 'kecil_' . $fullImgName;

            if (!isset($model->logolayarantrian)) {
              $model->logolayarantrian = $temLogo;
            } else {
              $model->logolayarantrian = $fullImgName;
            }

            if ($model->save()) {
              $gambar->saveAs($fullImgSource);
            }
          } else {
            $model->save();
          }


          // if (isset($model->videoantrian) && ($model->videoantrian != $temVideo)) {
          //   $model->videoantrian = $random . $model->videoantrian;
          //   Yii::import("ext.EPhpThumb.EPhpThumb");
          //   $fullImgName = $model->videoantrian;
          //   $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
          
          //   if (!isset($model->videoantrian)) {
          //     $model->videoantrian = $temVideo;
          //   } else {
          //     $model->videoantrian = $fullImgName;
          //   }

          //   if ($model->save()) {
          //     $video->saveAs($fullImgSource);
          //   }
          // } else {
          //   $model->save();
          // }

          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('index', 'id' => $id));
        } catch (Exception $e) {
          var_dump($e->getMessage());
          die;
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
        }
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
      }
    }

    $this->render('index', array(
      'model' => $model,
    ));
  }

  public function loadModel($id)
  {
    $model = SAKonfigsystemK::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * method import excel file into database
   * used in : 
   * 1. systemAdministrator -> konfig system -> import excel
   */
  public function actionImportExcel()
  {
    $this->pageTitle = Yii::app()->name . " - Import Excel";
    $files = dirname(__FILE__) . '/test.xls';

    /**
     * ajax request handlers
     */
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_FILES['upload'])) {
        $tableName = $_POST['tableName'];
        $files = CUploadedFile::getInstanceByName('upload');
        $object = Yii::app()->yexcel->readActiveSheet($files->tempName);
        $table = Yii::app()->db->getSchema()->getTable($tableName);
        echo $this->renderTable($object, $table);
      }
      Yii::app()->end();
    }

    /**
     * form method post handlers
     */
    if (isset($_POST['tableName'], $_POST['Hasil'])) {
      $tableName = $_POST['tableName'];
      if (isset($_POST['Hasil']))
        $value = $_POST['Hasil'];
      $files = $files = CUploadedFile::getInstanceByName('upload');
      $object = Yii::app()->yexcel->readActiveSheet($files->tempName);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $result = $this->saveMassTable($object, $tableName, $value);
        if ($result) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong>, data berhasil disimpan!');
          $this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong>, data gagal disimpan!');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        var_dump($exc->getMessage(), $exc->getTrace()); die;
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong>, data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
      }
    }
    $this->render('test');
  }

  /**
   * rendering table based on excel files
   * @param array $object excel file that's already converted into array
   * @param object $table table schema
   */
  protected function renderTable($object, $table)
  {
    $foreignKey = $table->foreignKeys;
    $kolom = $table->columns;
    echo '<table class="table table-bordered table-condensed">
		  	<thead><th>Pilih</th>';
    foreach ($object[1] as $key2 => $value2) {
      echo '<th>' . $key2 . '</th>';
    }
    echo '</thead><tbody>';
    $jumlahFK = count((array)$foreignKey);
    $findKey = ($jumlahFK > 0) ? true : (($jumlahFK == 0) ? true : false);
    $list = array();
    foreach ($object as $key => $value) {
      echo '<tr valueField = "' . $key . '">';
      if (!$findKey) {
        echo '<td><input type="checkbox" name="Hasil[' . $key . '][cek]"></td>';
      } else {
        echo '<td></td>';
      }

      foreach ($value as $counter => $value2) {
        if (isset($list[$counter]) && !$findKey && (empty($value2))) {
          echo '<td columnField="' . $counter . '">
						  <div class="input-append">
							  <input type="hidden" name="Hasil[' . $key . '][' . $list[$counter][1] . ']" class="id"/>
							  <input type="text" name="Hasil[' . $key . '][' . $list[$counter][1] . '_nama]" id="tableName" style="float:left;">
								  <span class="add-on"><i class="icon-list-alt"></i></span>
						  </div>
						</td>';
        } else {
          echo '<td columnField="' . $counter . '">' . $value2 . '</td>';
        }


        if ($findKey) {
          if (isset($foreignKey[$value2]) && count((array)$foreignKey[$value2]) == 2) {
            $list[$counter] = $foreignKey[$value2];
            unset($foreignKey[$value2]);
          }
          $findKey = (count((array)$foreignKey) > 0) ? true : false;
        }
      }
      echo '</tr>';
    }
    echo '</tbody></table>';
    $this->renderJavascript($list);
  }

  /**
   * rendering javascript file to be used in table view
   * @param array $list 
   */
  protected function renderJavascript($list)
  {
    echo "<script>
		  $(document).ready(function(){
			var isMouseDown = false;
			$('#excel table td')
			  .mousedown(function () {
				isMouseDown = true;
				$(this).parents('tr').toggleClass('yellow_background').find('input[name*=\'[cek]\']').attr('checked', function(idx, oldAttr) {
					  return !oldAttr;
				});
			  })
			  .mouseover(function () {
				if (isMouseDown) {
				  $(this).parents('tr').toggleClass('yellow_background').find('input[name*=\'[cek]\']').attr('checked', function(idx, oldAttr) {
					  return !oldAttr;
				  });
				}
			  })
			  .bind('selectstart', function () {
				return false; 
			  });

			$(document)
			  .mouseup(function () {
				isMouseDown = false;
			  });
		  });
	   ";
    if (count((array)$list) > 0) {
      foreach ($list as $value) {
        echo '$("input[name*=\'[' . $value[1] . '_nama]\']").autocomplete({"minLength":"3","source":"/simrs/index.php?r=actionAutoComplete/getValuePrimaryKey&table=' . $value[0] . '&primaryKey=' . $value[1] . '","select":function(event,ui){$(this).parents("td").find(".id").val(ui.item.id);}});';
      }
    }
    echo '</script>';
  }

  /**
   * method to save into table 
   * @param array $objects
   * @param string $tableName table name
   * @param values $values variable contains post method 
   * @return boolean result
   */
  protected function saveMassTable($objects, $tableName, $values)
  {
    $kolom = array();
    $table = Yii::app()->db->getSchema()->getTable($tableName);
    $columns = $table->columns;
    $listBoolean = array('Ya' => 'true', 'Tidak' => 'false');
    $builder = Yii::app()->db->schema->getCommandBuilder();
    $primaryKeys = $table->primaryKey;

    if (is_array($columns) && count($columns) > 0) {
      foreach ($columns as $counter => $column) {
        $kolom[] = $column->name;
      }
    }

    $data = array();
    $aktifPrimaryKey = false;
    $result = true;
    if (count((array)$values) > 0) {
      foreach ($values as $counter => $row) {
        if (isset($objects[$counter])) {
          $i = 0;
          foreach ($objects[$counter] as $key => $value) {
            if (!empty($kolom[$i])) {
              $data[$kolom[$i]] = (isset($value)) ? ((isset($listBoolean[trim($value)])) ? $listBoolean[trim($value)] : $value) : null;
              if (!empty($row[$kolom[$i]])) {
                $data[$kolom[$i]] = $row[$kolom[$i]];
              }

            }
            $i++;
          }
          
          if (!$aktifPrimaryKey) {
            if (is_string($primaryKeys)) {
              unset($data[$primaryKeys]);
            } else if (is_array($primaryKeys)) {
              foreach ($primaryKeys as $key => $primaryKey) {
                unset($data[$primaryKey]);
              }
            }
          }
          //var_dump($kolom, $data, $row, $objects[$counter]);
          //die;

          $command = $builder->createInsertCommand($table, $data);
          $result = $command->execute() && $result;
          echo $result;
        }
      }
    }
    return $result;
  }

  /**
   * output method of file excel contains template of table 
   */
  public function actionCreateTemplateXcel()
  {
    if (isset($_GET['tableName'])) {
      $this->layout = '//layouts/printExcel';
      $tableName = $_GET['tableName'];
      $table = Yii::app()->db->getSchema()->getTable($tableName);
      $dt = array();
      $model = null;
      if (!empty($table->name)) {

        $sql = "select *from {$table->name}";
        $model = Yii::app()->db->createCommand($sql)->queryAll();

        $sqlType = "SELECT
					a.attname as kolom ,
					pg_catalog.format_type(a.atttypid, a.atttypmod) as datatype
				FROM
					pg_catalog.pg_attribute a
				WHERE
					a.attnum > 0
					AND NOT a.attisdropped
					AND a.attrelid = (
						SELECT c.oid
						FROM pg_catalog.pg_class c
							LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
						WHERE c.relname  = '" . $table->name . "'
							AND pg_catalog.pg_table_is_visible(c.oid)
					);";
        $sqlType = Yii::app()->db->createCommand($sqlType)->queryAll();

        foreach ($sqlType as $type) {
          $dt[$type['kolom']] = $type['datatype'];
        }
      }

      $judul = "Template Excel $tableName";
      $this->render('_template', array('table' => $table, 'judul' => $judul, 'model' => $model, 'tipe' => $dt));
    }
  }

  public function actionAutocompletePelabelanNomorKepegawaian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $term = (!empty($_GET['term']) ? $_GET['term'] : null);

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(lookup_type)', Params::LOOKUP_KEPEGAWAIAN_LABELNOMORPEGAWAI, false);
      $criteria->compare('LOWER(lookup_name)', strtolower($term), true);
      $criteria->addCondition('lookup_aktif = true');
      $criteria->order = 'lookup_urutan ASC';
      $criteria->limit = 5;
      $models = LookupM::model()->findAll($criteria);

      if(!empty($models)){
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
  
          $returnVal[$i]['label'] = $model->lookup_name;
          $returnVal[$i]['value'] = $model->lookup_name;
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePelabelanKepegawaian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $term = (!empty($_GET['term']) ? $_GET['term'] : null);

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(lookup_type)', Params::LOOKUP_KEPEGAWAIAN_LABELPEGAWAI, false);
      $criteria->compare('LOWER(lookup_name)', strtolower($term), true);
      $criteria->addCondition('lookup_aktif = true');
      $criteria->order = 'lookup_urutan ASC';
      $criteria->limit = 5;
      $models = LookupM::model()->findAll($criteria);

      if(!empty($models)){
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
  
          $returnVal[$i]['label'] = $model->lookup_name;
          $returnVal[$i]['value'] = $model->lookup_name;
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
