<?php

/**
 * This is the model class for table "approvalotorisasi_m".
 *
 * The followings are the available columns in table 'approvalotorisasi_m':
 * @property integer $approvalotorisasi_id
 * @property integer $kepalagizi_id
 * @property integer $kepalafarmasi_id
 * @property integer $kepalaumum_id
 * @property integer $kasipersonalia_id
 * @property integer $managerumum_id
 * @property integer $managerkeuangan_id
 * @property integer $direkturrs_id
 * @property integer $direkturpt_id
 */
class ApprovalotorisasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ApprovalotorisasiM the static model class
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
		return 'approvalotorisasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kepalagizi_id, kepalafarmasi_id, kepalaumum_id, kasipersonalia_id, managerumum_id, managerkeuangan_id, direkturrs_id, direkturpt_id, bagiankepegawaian_id, managerumumpt_id, managerkeuanganpt_id, manageraccountingrs_id, accountingofficer_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('approvalotorisasi_id, kepalagizi_id, kepalafarmasi_id, kepalaumum_id, kasipersonalia_id, managerumum_id, managerkeuangan_id, direkturrs_id, direkturpt_id, bagiankepegawaian_id, managerumumpt_id, managerkeuanganpt_id, manageraccountingrs_id, accountingofficer_id', 'safe', 'on'=>'search'),
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
			'kepalagizi' => array(self::BELONGS_TO, 'PegawaiM', 'kepalagizi_id'),
			'kepalafarmasi' => array(self::BELONGS_TO, 'PegawaiM', 'kepalafarmasi_id'),
			'kepalaumum' => array(self::BELONGS_TO, 'PegawaiM', 'kepalaumum_id'),
			'kasipersonalia' => array(self::BELONGS_TO, 'PegawaiM', 'kasipersonalia_id'),
			'managerumum' => array(self::BELONGS_TO, 'PegawaiM', 'managerumum_id'),
			'managerkeuangan' => array(self::BELONGS_TO, 'PegawaiM', 'managerkeuangan_id'),
			'direkturrs' => array(self::BELONGS_TO, 'PegawaiM', 'direkturrs_id'),
			'direkturpt' => array(self::BELONGS_TO, 'PegawaiM', 'direkturpt_id'),
      'bagiankepegawaian' => array(self::BELONGS_TO, 'PegawaiM', 'bagiankepegawaian_id'),
      'managerumumpt' => array(self::BELONGS_TO, 'PegawaiM', 'managerumumpt_id'),
      'managerkeuanganpt' => array(self::BELONGS_TO, 'PegawaiM', 'managerkeuanganpt_id'),
			'manageraccountingrs' => array(self::BELONGS_TO, 'PegawaiM', 'manageraccountingrs_id'),
			'accountingofficer' => array(self::BELONGS_TO, 'PegawaiM', 'accountingofficer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'approvalotorisasi_id' => 'ID Approval',
			'kepalagizi_id' => 'Kepala Instalasi Gizi',
			'kepalafarmasi_id' => 'Kepala Instalasi Farmasi',
			'kepalaumum_id' => 'Kepala Instalasi Gudang Umum',
			'kasipersonalia_id' => 'Kasi Personalia',
			'managerumum_id' => 'Manager Umum',
			'managerkeuangan_id' => 'Manager Keuangan',
			'direkturrs_id' => 'Direktur RS',
			'direkturpt_id' => 'Direktur PT',
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

		$criteria->compare('approvalotorisasi_id',$this->approvalotorisasi_id);
		$criteria->compare('kepalagizi_id',$this->kepalagizi_id);
		$criteria->compare('kepalafarmasi_id',$this->kepalafarmasi_id);
		$criteria->compare('kepalaumum_id',$this->kepalaumum_id);
		$criteria->compare('kasipersonalia_id',$this->kasipersonalia_id);
		$criteria->compare('managerumum_id',$this->managerumum_id);
		$criteria->compare('managerkeuangan_id',$this->managerkeuangan_id);
		$criteria->compare('direkturrs_id',$this->direkturrs_id);
		$criteria->compare('direkturpt_id',$this->direkturpt_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getManagerUmum() {
        $model = new PegawaiM;
        if (empty($this->managerumum_id)) {
            return $model;
        }
        $model = PegawaiM::model()->findByPk($this->managerumum_id);
        if (empty($model)) {
            return new PegawaiM;
        }
        return $model;
    }
    public function getManagerKeuangan() {
        $model = new PegawaiM;
        if (empty($this->managerkeuangan_id)) {
            return $model;
        }
        $model = PegawaiM::model()->findByPk($this->managerkeuangan_id);
        if (empty($model)) {
            return new PegawaiM;
        }
        return $model;
    }
    public function getDirekturRS() {
        $model = new PegawaiM;
        if (empty($this->direkturrs_id)) {
            return $model;
        }
        $model = PegawaiM::model()->findByPk($this->direkturrs_id);
        if (empty($model)) {
            return new PegawaiM;
        }
        return $model;
    }
    public function getDirekturPT() {
        $model = new PegawaiM;
        if (empty($this->direkturpt_id)) {
            return $model;
        }
        $model = PegawaiM::model()->findByPk($this->direkturpt_id);
        if (empty($model)) {
            return new PegawaiM;
        }
        return $model;
    }
}
