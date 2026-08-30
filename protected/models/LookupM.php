<?php

/**
 * This is the model class for table "lookup_m".
 *
 * The followings are the available columns in table 'lookup_m':
 * @property integer $lookup_id
 * @property string $lookup_type
 * @property string $lookup_name
 * @property string $lookup_value
 * @property integer $lookup_urutan
 * @property string $lookup_kode
 * @property boolean $lookup_aktif
 */
class LookupM extends CActiveRecord
{
    public $temp_file, $nama_lantai;
    public $default;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LookupM the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lookup_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lookup_type, lookup_name, lookup_value, lookup_urutan', 'required'),
            array('lookup_urutan', 'numerical', 'integerOnly' => true),
            array('lookup_type', 'length', 'max' => 100),
            array('lookup_name, lookup_value', 'length', 'max' => 200),
            array('lookup_kode', 'length', 'max' => 50),
            array('lookup_urutan', 'length', 'max' => 10),
            array('lookup_urutan', 'compare', 'operator' => '<=', 'compareValue' => 2147483647),
            array('lookup_urutan', 'compare', 'operator' => '>=', 'compareValue' => -2147483648),
            array('lookup_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('lookup_id, lookup_type, lookup_name, lookup_value, lookup_urutan, lookup_kode, lookup_aktif', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'lookup_id' => 'ID',
            'lookup_type' => 'Tipe',
            'lookup_name' => 'Nama',
            'lookup_value' => 'Value',
            'lookup_urutan' => 'Urutan',
            'lookup_kode' => 'Kode',
            'lookup_aktif' => 'Aktif',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('lookup_id', $this->lookup_id);
        $criteria->compare('lookup_type', $this->lookup_type, true);
        $criteria->compare('lookup_name', $this->lookup_name, true);
        $criteria->compare('lookup_value', $this->lookup_value, true);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('lookup_kode', $this->lookup_kode, true);
        if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_SIMRS) {
            $criteria->compare('lookup_aktif', $this->lookup_aktif);
        } else {
            $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        }

        if (!empty($this->default)){
            $criteria->addCondition(" lookup_id  IS NULL ");
        }
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchStrict()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('lookup_id', $this->lookup_id);
        //$criteria->compare('lookup_type',$this->lookup_type,true);
        $criteria->compare('lookup_name', $this->lookup_name, true);
        $criteria->compare('lookup_value', $this->lookup_value, true);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('lookup_kode', $this->lookup_kode, true);
        $criteria->compare('lookup_aktif', $this->lookup_aktif);

        $criteria->addCondition("lookup_type = '" . $this->lookup_type . "'");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchStrictPrint()
    {
        $provider = $this->searchStrict();
        $provider->pagination = false;
        $provider->criteria->limit = -1;
        return $provider;
    }

    /**
     * manampilkan list lookup
     * @param type $lookup_type
     * @return array $data[$lookup_value] = $lookup_name
     */
    public static function getItems($lookup_type = null, $lower = false)
    {
        $data = array();
        $criteria = new CDbCriteria();
        if (is_array($lookup_type))
            $criteria->addInCondition('lookup_type', $lookup_type);
        else {
            $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
            $criteria->compare('lookup_type', $lookup_type);
        }
        $criteria->order = "lookup_name ASC";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        if (count((array)$models) > 0) {
            foreach ($models as $model)
                $data[$model->lookup_value] = ucwords(strtolower($model->lookup_name));
            if ($lower == true) {
                $data[strtolower($model->lookup_value)] = ($model->lookup_name);
            } else {
                $data[$model->lookup_value] = ($model->lookup_name);
            }
        } else {
            $data = array();
        }

        return $data;
    }


    public static function getItemstoName2($lookup_type = null, $lower = false)
    {
        $data = array();
        $criteria = new CDbCriteria();
        if (is_array($lookup_type))
            $criteria->addInCondition('lookup_type', $lookup_type);
        else {
            $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
            $criteria->compare('lookup_type', $lookup_type);
        }
        $criteria->order = "lookup_name ASC";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        if (count((array)$models) > 0) {
            foreach ($models as $model)
                // $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
                if ($lower == true) {
                    // $data[strtolower($model->lookup_value)]= ($model->lookup_name);
                    $data[strtolower($model->lookup_value)] = ($model->lookup_name);
                } else {
                    // $data[$model->lookup_value]= ($model->lookup_name);
                    $data[$model->lookup_value] = ($model->lookup_name);
                }
        } else {
            // $data[""] = array();
        }

        return $data;
    }

    public static function getItemstoName($lookup_type = null, $lower = false)
    {
        $data = array();
        $criteria = new CDbCriteria();
        if (is_array($lookup_type))
            $criteria->addInCondition('lookup_type', $lookup_type);
        else {
            $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
            $criteria->compare('lookup_type', $lookup_type);
        }
        $criteria->order = "lookup_name ASC";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        if (count((array)$models) > 0) {
            foreach ($models as $model)
                // $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
                if ($lower == true) {
                    // $data[strtolower($model->lookup_value)]= ($model->lookup_name);
                    $data[strtolower($model->lookup_name)] = ($model->lookup_name);
                } else {
                    // $data[$model->lookup_value]= ($model->lookup_name);
                    $data[$model->lookup_name] = ($model->lookup_name);
                }
        } else {
            // $data[""] = array();
        }

        return $data;
    }
     /**
     * manampilkan list lookup
     * @param type $lookup_type
     * @return array $data[$lookup_value] = $lookup_name
     */
    public static function getItemsById($lookup_type = null, $lower = false)
    {
        $data = array();
        $criteria = new CDbCriteria();
        if (is_array($lookup_type))
            $criteria->addInCondition('lookup_type', $lookup_type);
        else {
            $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
            $criteria->compare('lookup_type', $lookup_type);
        }
        $criteria->order = "lookup_id ASC";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        if (count((array)$models) > 0) {
            foreach ($models as $model)
                $data[$model->lookup_value] = ucwords(strtolower($model->lookup_name));
            if ($lower == true) {
                $data[strtolower($model->lookup_value)] = ($model->lookup_name);
            } else {
                $data[$model->lookup_value] = ($model->lookup_name);
            }
        } else {
            $data = array();
        }

        return $data;
    }

    public static function getItems1($lookup_type = null, $lower = false)
    {
        $data = array();
        $criteria = new CDbCriteria();
        if (is_array($lookup_type))
            $criteria->addInCondition('lookup_type', $lookup_type);
        else {
            $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
            $criteria->compare('lookup_type', $lookup_type);
        }
        $criteria->order = "lookup_name ASC";
        $criteria->addCondition('lookup_id='.Params::STATUS_BOOKING_ANTRI_ID);
        $criteria->addCondition("lookup_aktif IS TRUE");
        // $models=self::model()->findByAttributes($criteria);
        $models = self::model()->findAll($criteria);
        if (count((array)$models) > 0) {
            foreach ($models as $model)
                $data[$model->lookup_value] = ucwords(strtolower($model->lookup_name));
            if ($lower == true) {
                $data[strtolower($model->lookup_value)] = ($model->lookup_name);
            } else {
                $data[$model->lookup_value] = ($model->lookup_name);
            }
        } else {
            $data = array();
        }

        return $data;
    }

   

    public static function getItemsUrutan($lookup_type = null)
    {
        $data = array();
        $criteria = new CDbCriteria();
        if (is_array($lookup_type))
            $criteria->addInCondition('lookup_type', $lookup_type);
        else {
            $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
            $criteria->compare('lookup_type', $lookup_type);
        }
        $criteria->order = "lookup_urutan ASC";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        if (count((array)$models) > 0) {
            foreach ($models as $model)
                // $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
                $data[$model->lookup_value] = ($model->lookup_name);
        } else {
            $data = [];
        }

        return $data;
    }

    public static function getItemsUrutanExtra($lookup_type = null, $value_col = null, $option_param = null)
    {
        $data = array();
        $option = array();

        $criteria = new CDbCriteria();
        if (is_array($lookup_type))
            $criteria->addInCondition('lookup_type', $lookup_type);
        else {
            $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
            $criteria->compare('lookup_type', $lookup_type);
        }
        $criteria->order = "lookup_urutan ASC";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        if (count((array)$models) > 0) {
            foreach ($models as $model) {
                $val = $model->lookup_value;

                if (!empty($value_col) && !empty($model[$value_col])) {
                    $val = $model[$value_col];
                }

                $data[$val] = ($model->lookup_name);
                if (!empty($option_param) && is_array($option_param)) {
                    $option[$val] = array();

                    foreach ($option_param as $param => $col) {
                        if (!empty($model[$col])) {
                            $option[$val][$param] = $model[$col];
                        }
                    }
                }
            }
        } else {
            $data[""] = null;
        }

        return array(
            'data' => $data,
            'option' => $option,
        );
    }
    /**
     * manampilkan list kode lookup
     * @param type $lookup_type
     * @return array $data[$lookup_kode] = $lookup_kode
     */
    public static function getKodeItems($lookup_type = null)
    {

        $data = array();
        $criteria = new CDbCriteria();
        if (is_array($lookup_type))
            $criteria->addInCondition('lookup_type', $lookup_type);
        else {
            $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
            $criteria->compare('lookup_type', $lookup_type);
        }
        $criteria->order = "lookup_kode";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        if (count((array)$models) > 0) {
            foreach ($models as $model)
                $data[$model->lookup_kode] = ucwords(strtolower($model->lookup_kode));
        } else {
            $data[""] = null;
        }

        return $data;
    }
    /**
     * menampilkan semua lookup_type
     * @return models
     */
    public static function getAllLookupType()
    {
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->order = "lookup_type,lookup_urutan";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        return $models;
    }
    public static function getLookupTypeFarmasi()
    {
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->addInCondition('lookup_type',  array('etiket', 'etiket_1', 'etiket_2', 'etiket_3', 'etiket_4'));
        $criteria->order = "lookup_type,lookup_urutan";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        return $models;
    }

    public static function getNama($lookup_type = null)
    {
        $data = '';
        $criteria = new CDbCriteria();

        $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
        $criteria->compare('lookup_type', $lookup_type);
        $criteria->order = "lookup_name ASC";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        if (count((array)$models) > 0) {
            foreach ($models as $model)
                // $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
                $data = $model->lookup_name;
        } else {
            $data = null;
        }

        return $data;
    }

    public function getNoUrutan($type)
    {
        $cri = new CDbCriteria();
        $cri->addCondition(" lookup_type ilike '" . strtolower($type) . "' ");
        $cri->order = " lookup_urutan DESC ";

        $no = LookupM::model()->find($cri);

        return $no->lookup_urutan + 1;
    }

    /**
     * manampilkan list kode lookup
     * @param type $lookup_type
     * @return array $data[$lookup_kode] = $lookup_kode
     */
    public static function getDropUrutan($lookup_type = null)
    {

        $data = '<option = "">-- Pilih --</option>';
        $criteria = new CDbCriteria();
        if (is_array($lookup_type))
            $criteria->addInCondition('lookup_type', $lookup_type);
        else {
            $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
            $criteria->compare('lookup_type', $lookup_type);
        }
        $criteria->order = "lookup_urutan ASC";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);
        if (count((array)$models) > 0) {
            foreach ($models as $model)
                $data .= "<option value='" . $model->lookup_value . "'>" . $model->lookup_name . "</option>";
        } else {
            $data = null;
        }

        return $data;
    }

    /**
     * digunakan untuk pencarian admin tipe komponen
     * @return \CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchSP()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('lookup_id', $this->lookup_id);
        $criteria->compare('lookup_type', $this->lookup_type, true);
        $criteria->compare('lower(lookup_name)', strtolower($this->lookup_name), true);
        $criteria->compare('lower(lookup_value)', strtolower($this->lookup_value), true);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('lookup_kode', $this->lookup_kode, true);
        $criteria->compare('lookup_aktif', $this->lookup_aktif);



        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getDropManual($lookup_type = null, $value = null)
    {

        $data = "<option value=''>-- Pilih --</option>";
        $criteria = new CDbCriteria();
        if (is_array($lookup_type))
            $criteria->addInCondition('lookup_type', $lookup_type);
        else {
            $lookup_type = isset($lookup_type) ? trim(strtolower($lookup_type)) : null;
            $criteria->compare('lookup_type', $lookup_type);
        }
        $criteria->order = "lookup_urutan ASC";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $models = self::model()->findAll($criteria);

        if (count($models) > 0) {
            foreach ($models as $model) {
                $selection = "";
                if (!empty($value)) {
                    if ($value == $model->lookup_name) {
                        $selection = 'selected="selected"';
                    }
                }
                $data .= "<option value='" . $model->lookup_value . "' " . $selection . ">" . $model->lookup_name . "</option>";
            }
        } else {
            $data = null;
        }

        return $data;
    }

    /**
     * 
     * @param type $model
     * @param type $post
     * @return type
     */
    public static function simpanData($model, $post)
    {
        $ok = true;
        $pesan = '';
        $format = new MyFormatter();

        $model->attributes = $post;

        if (empty($model->lookup_id)) {
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            if (empty($model->lookup_urutan)) {
                $model->lookup_urutan = $model->genUrutan;
            }
            $model->lookup_aktif = true;
        } else {
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        }

        $ok &= $model->save();

        if (!$ok) {
            $pesan .= 'Lookup : <br/>' . MyExceptionMessage::getErrorMessage($model);
        }

        $data['sukses'] = $ok;
        $data['model'] = $model;
        $data['pesan'] = $pesan;

        return $data;
    }

    public function getGenUrutan()
    {
        $urut = Yii::app()->db->createCommand("SELECT max(lookup_urutan) as jumlah FROM lookup_m WHERE lookup_type = '" . $this->lookup_type . "' AND lookup_aktif = TRUE ")->queryRow();

        return !empty($urut['jumlah']) ? $urut['jumlah'] : 1;
    }
}
