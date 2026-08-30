<?php

/**
 * This is the model class for table "prevmainten_t".
 *
 * The followings are the available columns in table 'prevmainten_t':
 * @property integer $prevmainten_id
 * @property integer $invperalatan_id
 * @property string $tglprevmainten
 * @property string $frekuansi_prev
 * @property integer $frekuensi_jml_prev
 * @property string $frekuensi_sat_prev
 * @property integer $ipmchecklist_id
 * @property string $ipmchecklist_list_prev
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * 
 * @package  application.models
 * 
 */
class PrevmaintenT extends CActiveRecord
{

        public $kontrakpemeliharaan_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrevmaintenT the static model class
	 */

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prevmainten_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(			
			array('invperalatan_id, tglprevmainten, frekuansi_prev, frekuensi_jml_prev, frekuensi_sat_prev, create_time, create_loginpemakai_id, create_ruangan', 'required'),

			array('invperalatan_id, frekuensi_jml_prev, ipmchecklist_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('frekuansi_prev', 'length', 'max'=>20),
			array('frekuensi_sat_prev, ipmchecklist_list_prev', 'length', 'max'=>255),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prevmainten_id, invperalatan_id, tglprevmainten, frekuansi_prev, frekuensi_jml_prev, frekuensi_sat_prev, ipmchecklist_id, ipmchecklist_list_prev, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prevmainten_id' => 'Prevmainten',
			'invperalatan_id' => 'Invperalatan',
			'tglprevmainten' => 'Tglprevmainten',
			'frekuansi_prev' => 'Frekuansi Prev',
			'frekuensi_jml_prev' => 'Frekuensi Jml Prev',
			'frekuensi_sat_prev' => 'Frekuensi Sat Prev',
			'ipmchecklist_id' => 'Ipmchecklist',
			'ipmchecklist_list_prev' => 'Ipmchecklist List Prev',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria=new CDbCriteria;
		$criteria->compare('t.prevmainten_id',$this->prevmainten_id);
		$criteria->compare('t.invperalatan_id',$this->invperalatan_id);
		$criteria->compare('t.tglprevmainten',$this->tglprevmainten,true);
		$criteria->compare('t.frekuansi_prev',$this->frekuansi_prev,true);
		$criteria->compare('t.frekuensi_jml_prev',$this->frekuensi_jml_prev);
		$criteria->compare('t.frekuensi_sat_prev',$this->frekuensi_sat_prev,true);
		$criteria->compare('t.ipmchecklist_id',$this->ipmchecklist_id);
		$criteria->compare('t.ipmchecklist_list_prev',$this->ipmchecklist_list_prev,true);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('t.create_ruangan',$this->create_ruangan);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Untuk tabel preventive maintenance pada Detail Peralatan
     */
    public function searchPrev() {
        $prov = $this->search();
        
        $prov->criteria->order = 't.tglprevmainten asc';
        
        return $prov;
    }

}