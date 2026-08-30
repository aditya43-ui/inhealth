<?php

/**
 * This is the model class for table "rl5_4_10bsrpenyakitrwtjalan_v".
 *
 * The followings are the available columns in table 'rl5_4_10bsrpenyakitrwtjalan_v':
 * @property string $tglmorbiditas
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property string $kasusdiagnosa
 * @property string $jeniskelamin
 * @property string $jmlkasus
 * @property string $jmlpasien
 */
class Rl5410bsrpenyakitrjV extends CActiveRecord
{
	public $jmlkunjungan, $lakilaki, $perempuan,$tahun;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl5410bsrpenyakitrwtjalanV the static model class
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
		return 'rl5_4_10bsrpenyakitrj_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosa_id', 'numerical', 'integerOnly'=>true),
			array('diagnosa_kode', 'length', 'max'=>10),
			array('diagnosa_nama', 'length', 'max'=>200),
			array('kasusdiagnosa, jeniskelamin', 'length', 'max'=>20),
			array('tglmorbiditas, jmlkasus, jmlpasien', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglmorbiditas, diagnosa_id, diagnosa_kode, diagnosa_nama, kasusdiagnosa, jeniskelamin, jmlkasus, jmlpasien', 'safe', 'on'=>'search'),
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
			'tglmorbiditas' => 'Tglmorbiditas',
			'diagnosa_id' => 'Diagnosa',
			'diagnosa_kode' => 'Diagnosa Kode',
			'diagnosa_nama' => 'Diagnosa Nama',
			'kasusdiagnosa' => 'Kasusdiagnosa',
			'jeniskelamin' => 'Jenis Kelamin',
			'jmlkasus' => 'Jmlkasus',
			'jmlpasien' => 'Jmlpasien',
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

		$criteria->compare('tglmorbiditas',$this->tglmorbiditas,true);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('diagnosa_kode',$this->diagnosa_kode,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('kasusdiagnosa',$this->kasusdiagnosa,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('jmlkasus',$this->jmlkasus,true);
		$criteria->compare('jmlpasien',$this->jmlpasien,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
       public function getSumKasus($diagnosa_kode, $jeniskelamin)
        {         
                      
           $criteria=new CDbCriteria();
           $criteria->select = "SUM(jmlpasien) as jmlpasien, SUM(jmlkasus) as jmlkasus";
           $criteria->group = 'diagnosa_kode, jeniskelamin';
           $criteria->addCondition("diagnosa_kode = '$diagnosa_kode' ");          
           $criteria->addCondition("jeniskelamin = '$jeniskelamin' ");
                                 
           $totPasien = $this->findAll($criteria);
              //var_dump($totPasien);die;
           $tot = '0'.'-'.'0';
           foreach($totPasien as $data){
               $tot = $data->jmlkasus.'-'.$data->jmlkasus;
           }
           return $tot;
        
        }
}