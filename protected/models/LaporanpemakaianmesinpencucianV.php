<?php

/**
 * This is the model class for table "laporanpemakaianmesinpencucian_v".
 *
 * The followings are the available columns in table 'laporanpemakaianmesinpencucian_v':
 * @property integer $pencucianlinen_id
 * @property string $tglpencucianlinen
 * @property string $mesinpencucian_nama
 * @property string $bahanperawatan_nama
 */
class LaporanpemakaianmesinpencucianV extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanpemakaianmesinpencucian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pencucianlinen_id', 'numerical', 'integerOnly'=>true),
			array('mesinpencucian_nama', 'length', 'max'=>25),
			array('bahanperawatan_nama', 'length', 'max'=>100),
			array('beratlinen, tglpencucianlinen', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pencucianlinen_id, tglpencucianlinen, mesinpencucian_nama, bahanperawatan_nama', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pencucianlinen_id' => 'Pencucianlinen',
			'tglpencucianlinen' => 'Tglpencucianlinen',
			'mesinpencucian_nama' => 'Mesin Pencucian',
			'bahanperawatan_nama' => 'Bahan Perawatan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = " pencucianlinen_id, tglpencucianlinen, mesinpencucian_nama, json_agg(distinct bahanperawatan_nama) as bahanperawatan_nama ";
                $criteria->group = "pencucianlinen_id, tglpencucianlinen, mesinpencucian_nama";
                if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)){
                    $criteria->addBetweenCondition('DATE(tglpencucianlinen)', $this->tgl_awal, $this->tgl_akhir);
                }
				
		$criteria->compare('LOWER(mesinpencucian_nama)', strtolower($this->mesinpencucian_nama), true);
		$criteria->compare('LOWER(bahanperawatan_nama)', strtolower($this->bahanperawatan_nama), true);
                $criteria->limit = 10;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LaporanpemakaianmesinpencucianV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
