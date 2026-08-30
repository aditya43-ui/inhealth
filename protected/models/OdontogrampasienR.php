<?php

/**
 * This is the model class for table "odontogrampasien_r".
 *
 * The followings are the available columns in table 'odontogrampasien_r':
 * @property integer $odontogrampasien_id
 * @property integer $pasien_id
 * @property string $no_11
 * @property string $no_12
 * @property string $no_13
 * @property string $no_14
 * @property string $no_15
 * @property string $no_16
 * @property string $no_17
 * @property string $no_18
 * @property string $no_21
 * @property string $no_22
 * @property string $no_23
 * @property string $no_24
 * @property string $no_25
 * @property string $no_26
 * @property string $no_27
 * @property string $no_28
 * @property string $no_51
 * @property string $no_52
 * @property string $no_53
 * @property string $no_54
 * @property string $no_55
 * @property string $no_61
 * @property string $no_62
 * @property string $no_63
 * @property string $no_64
 * @property string $no_65
 * @property string $no_71
 * @property string $no_72
 * @property string $no_73
 * @property string $no_74
 * @property string $no_75
 * @property string $no_81
 * @property string $no_82
 * @property string $no_83
 * @property string $no_84
 * @property string $no_85
 * @property string $no_31
 * @property string $no_32
 * @property string $no_33
 * @property string $no_34
 * @property string $no_35
 * @property string $no_36
 * @property string $no_37
 * @property string $no_38
 * @property string $no_41
 * @property string $no_42
 * @property string $no_43
 * @property string $no_44
 * @property string $no_45
 * @property string $no_46
 * @property string $no_47
 * @property string $no_48
 */
class OdontogrampasienR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OdontogrampasienR the static model class
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
		return 'odontogrampasien_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, no_11, no_12, no_13, no_14, no_15, no_16, no_17, no_18, no_21, no_22, no_23, no_24, no_25, no_26, no_27, no_28, no_51, no_52, no_53, no_54, no_55, no_61, no_62, no_63, no_64, no_65, no_71, no_72, no_73, no_74, no_75, no_81, no_82, no_83, no_84, no_85, no_31, no_32, no_33, no_34, no_35, no_36, no_37, no_38, no_41, no_42, no_43, no_44, no_45, no_46, no_47, no_48', 'required'),
			array('pasien_id', 'numerical', 'integerOnly'=>true),
			array('no_11, no_12, no_13, no_14, no_15, no_16, no_17, no_18, no_21, no_22, no_23, no_24, no_25, no_26, no_27, no_28, no_51, no_52, no_53, no_54, no_55, no_61, no_62, no_63, no_64, no_65, no_71, no_72, no_73, no_74, no_75, no_81, no_82, no_83, no_84, no_85, no_31, no_32, no_33, no_34, no_35, no_36, no_37, no_38, no_41, no_42, no_43, no_44, no_45, no_46, no_47, no_48', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('odontogrampasien_id, pasien_id, no_11, no_12, no_13, no_14, no_15, no_16, no_17, no_18, no_21, no_22, no_23, no_24, no_25, no_26, no_27, no_28, no_51, no_52, no_53, no_54, no_55, no_61, no_62, no_63, no_64, no_65, no_71, no_72, no_73, no_74, no_75, no_81, no_82, no_83, no_84, no_85, no_31, no_32, no_33, no_34, no_35, no_36, no_37, no_38, no_41, no_42, no_43, no_44, no_45, no_46, no_47, no_48', 'safe', 'on'=>'search'),
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
			'odontogrampasien_id' => 'Odontogrampasien',
			'pasien_id' => 'Pasien',
			'no_11' => 'No. 11',
			'no_12' => 'No. 12',
			'no_13' => 'No. 13',
			'no_14' => 'No. 14',
			'no_15' => 'No. 15',
			'no_16' => 'No. 16',
			'no_17' => 'No. 17',
			'no_18' => 'No. 18',
			'no_21' => 'No. 21',
			'no_22' => 'No. 22',
			'no_23' => 'No. 23',
			'no_24' => 'No. 24',
			'no_25' => 'No. 25',
			'no_26' => 'No. 26',
			'no_27' => 'No. 27',
			'no_28' => 'No. 28',
			'no_51' => 'No. 51',
			'no_52' => 'No. 52',
			'no_53' => 'No. 53',
			'no_54' => 'No. 54',
			'no_55' => 'No. 55',
			'no_61' => 'No. 61',
			'no_62' => 'No. 62',
			'no_63' => 'No. 63',
			'no_64' => 'No. 64',
			'no_65' => 'No. 65',
			'no_71' => 'No. 71',
			'no_72' => 'No. 72',
			'no_73' => 'No. 73',
			'no_74' => 'No. 74',
			'no_75' => 'No. 75',
			'no_81' => 'No. 81',
			'no_82' => 'No. 82',
			'no_83' => 'No. 83',
			'no_84' => 'No. 84',
			'no_85' => 'No. 85',
			'no_31' => 'No. 31',
			'no_32' => 'No. 32',
			'no_33' => 'No. 33',
			'no_34' => 'No. 34',
			'no_35' => 'No. 35',
			'no_36' => 'No. 36',
			'no_37' => 'No. 37',
			'no_38' => 'No. 38',
			'no_41' => 'No. 41',
			'no_42' => 'No. 42',
			'no_43' => 'No. 43',
			'no_44' => 'No. 44',
			'no_45' => 'No. 45',
			'no_46' => 'No. 46',
			'no_47' => 'No. 47',
			'no_48' => 'No. 48',
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

		$criteria->compare('odontogrampasien_id',$this->odontogrampasien_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_11)',strtolower($this->no_11),true);
		$criteria->compare('LOWER(no_12)',strtolower($this->no_12),true);
		$criteria->compare('LOWER(no_13)',strtolower($this->no_13),true);
		$criteria->compare('LOWER(no_14)',strtolower($this->no_14),true);
		$criteria->compare('LOWER(no_15)',strtolower($this->no_15),true);
		$criteria->compare('LOWER(no_16)',strtolower($this->no_16),true);
		$criteria->compare('LOWER(no_17)',strtolower($this->no_17),true);
		$criteria->compare('LOWER(no_18)',strtolower($this->no_18),true);
		$criteria->compare('LOWER(no_21)',strtolower($this->no_21),true);
		$criteria->compare('LOWER(no_22)',strtolower($this->no_22),true);
		$criteria->compare('LOWER(no_23)',strtolower($this->no_23),true);
		$criteria->compare('LOWER(no_24)',strtolower($this->no_24),true);
		$criteria->compare('LOWER(no_25)',strtolower($this->no_25),true);
		$criteria->compare('LOWER(no_26)',strtolower($this->no_26),true);
		$criteria->compare('LOWER(no_27)',strtolower($this->no_27),true);
		$criteria->compare('LOWER(no_28)',strtolower($this->no_28),true);
		$criteria->compare('LOWER(no_51)',strtolower($this->no_51),true);
		$criteria->compare('LOWER(no_52)',strtolower($this->no_52),true);
		$criteria->compare('LOWER(no_53)',strtolower($this->no_53),true);
		$criteria->compare('LOWER(no_54)',strtolower($this->no_54),true);
		$criteria->compare('LOWER(no_55)',strtolower($this->no_55),true);
		$criteria->compare('LOWER(no_61)',strtolower($this->no_61),true);
		$criteria->compare('LOWER(no_62)',strtolower($this->no_62),true);
		$criteria->compare('LOWER(no_63)',strtolower($this->no_63),true);
		$criteria->compare('LOWER(no_64)',strtolower($this->no_64),true);
		$criteria->compare('LOWER(no_65)',strtolower($this->no_65),true);
		$criteria->compare('LOWER(no_71)',strtolower($this->no_71),true);
		$criteria->compare('LOWER(no_72)',strtolower($this->no_72),true);
		$criteria->compare('LOWER(no_73)',strtolower($this->no_73),true);
		$criteria->compare('LOWER(no_74)',strtolower($this->no_74),true);
		$criteria->compare('LOWER(no_75)',strtolower($this->no_75),true);
		$criteria->compare('LOWER(no_81)',strtolower($this->no_81),true);
		$criteria->compare('LOWER(no_82)',strtolower($this->no_82),true);
		$criteria->compare('LOWER(no_83)',strtolower($this->no_83),true);
		$criteria->compare('LOWER(no_84)',strtolower($this->no_84),true);
		$criteria->compare('LOWER(no_85)',strtolower($this->no_85),true);
		$criteria->compare('LOWER(no_31)',strtolower($this->no_31),true);
		$criteria->compare('LOWER(no_32)',strtolower($this->no_32),true);
		$criteria->compare('LOWER(no_33)',strtolower($this->no_33),true);
		$criteria->compare('LOWER(no_34)',strtolower($this->no_34),true);
		$criteria->compare('LOWER(no_35)',strtolower($this->no_35),true);
		$criteria->compare('LOWER(no_36)',strtolower($this->no_36),true);
		$criteria->compare('LOWER(no_37)',strtolower($this->no_37),true);
		$criteria->compare('LOWER(no_38)',strtolower($this->no_38),true);
		$criteria->compare('LOWER(no_41)',strtolower($this->no_41),true);
		$criteria->compare('LOWER(no_42)',strtolower($this->no_42),true);
		$criteria->compare('LOWER(no_43)',strtolower($this->no_43),true);
		$criteria->compare('LOWER(no_44)',strtolower($this->no_44),true);
		$criteria->compare('LOWER(no_45)',strtolower($this->no_45),true);
		$criteria->compare('LOWER(no_46)',strtolower($this->no_46),true);
		$criteria->compare('LOWER(no_47)',strtolower($this->no_47),true);
		$criteria->compare('LOWER(no_48)',strtolower($this->no_48),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('odontogrampasien_id',$this->odontogrampasien_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_11)',strtolower($this->no_11),true);
		$criteria->compare('LOWER(no_12)',strtolower($this->no_12),true);
		$criteria->compare('LOWER(no_13)',strtolower($this->no_13),true);
		$criteria->compare('LOWER(no_14)',strtolower($this->no_14),true);
		$criteria->compare('LOWER(no_15)',strtolower($this->no_15),true);
		$criteria->compare('LOWER(no_16)',strtolower($this->no_16),true);
		$criteria->compare('LOWER(no_17)',strtolower($this->no_17),true);
		$criteria->compare('LOWER(no_18)',strtolower($this->no_18),true);
		$criteria->compare('LOWER(no_21)',strtolower($this->no_21),true);
		$criteria->compare('LOWER(no_22)',strtolower($this->no_22),true);
		$criteria->compare('LOWER(no_23)',strtolower($this->no_23),true);
		$criteria->compare('LOWER(no_24)',strtolower($this->no_24),true);
		$criteria->compare('LOWER(no_25)',strtolower($this->no_25),true);
		$criteria->compare('LOWER(no_26)',strtolower($this->no_26),true);
		$criteria->compare('LOWER(no_27)',strtolower($this->no_27),true);
		$criteria->compare('LOWER(no_28)',strtolower($this->no_28),true);
		$criteria->compare('LOWER(no_51)',strtolower($this->no_51),true);
		$criteria->compare('LOWER(no_52)',strtolower($this->no_52),true);
		$criteria->compare('LOWER(no_53)',strtolower($this->no_53),true);
		$criteria->compare('LOWER(no_54)',strtolower($this->no_54),true);
		$criteria->compare('LOWER(no_55)',strtolower($this->no_55),true);
		$criteria->compare('LOWER(no_61)',strtolower($this->no_61),true);
		$criteria->compare('LOWER(no_62)',strtolower($this->no_62),true);
		$criteria->compare('LOWER(no_63)',strtolower($this->no_63),true);
		$criteria->compare('LOWER(no_64)',strtolower($this->no_64),true);
		$criteria->compare('LOWER(no_65)',strtolower($this->no_65),true);
		$criteria->compare('LOWER(no_71)',strtolower($this->no_71),true);
		$criteria->compare('LOWER(no_72)',strtolower($this->no_72),true);
		$criteria->compare('LOWER(no_73)',strtolower($this->no_73),true);
		$criteria->compare('LOWER(no_74)',strtolower($this->no_74),true);
		$criteria->compare('LOWER(no_75)',strtolower($this->no_75),true);
		$criteria->compare('LOWER(no_81)',strtolower($this->no_81),true);
		$criteria->compare('LOWER(no_82)',strtolower($this->no_82),true);
		$criteria->compare('LOWER(no_83)',strtolower($this->no_83),true);
		$criteria->compare('LOWER(no_84)',strtolower($this->no_84),true);
		$criteria->compare('LOWER(no_85)',strtolower($this->no_85),true);
		$criteria->compare('LOWER(no_31)',strtolower($this->no_31),true);
		$criteria->compare('LOWER(no_32)',strtolower($this->no_32),true);
		$criteria->compare('LOWER(no_33)',strtolower($this->no_33),true);
		$criteria->compare('LOWER(no_34)',strtolower($this->no_34),true);
		$criteria->compare('LOWER(no_35)',strtolower($this->no_35),true);
		$criteria->compare('LOWER(no_36)',strtolower($this->no_36),true);
		$criteria->compare('LOWER(no_37)',strtolower($this->no_37),true);
		$criteria->compare('LOWER(no_38)',strtolower($this->no_38),true);
		$criteria->compare('LOWER(no_41)',strtolower($this->no_41),true);
		$criteria->compare('LOWER(no_42)',strtolower($this->no_42),true);
		$criteria->compare('LOWER(no_43)',strtolower($this->no_43),true);
		$criteria->compare('LOWER(no_44)',strtolower($this->no_44),true);
		$criteria->compare('LOWER(no_45)',strtolower($this->no_45),true);
		$criteria->compare('LOWER(no_46)',strtolower($this->no_46),true);
		$criteria->compare('LOWER(no_47)',strtolower($this->no_47),true);
		$criteria->compare('LOWER(no_48)',strtolower($this->no_48),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function polaGigi($pk=null,$condition='',$params=array())
	{
		Yii::trace(get_class($this).'.findByPk()','system.db.ar.CActiveRecord');
		$prefix=$this->getTableAlias(true).'.';
//		$criteria=$this->getCommandBuilder()->createPkCriteria($this->getTableSchema(),$pk=null,$condition,$params,$prefix);
                $criteria = new CDbCriteria();
                //$criteria->compare('odontogrampasien_id',$pk);
                $criteria->addCondition('odontogrampasien_id = '.(empty($pk)?'0':$pk));
		$odontogram = $this->query($criteria);
                $gigi = array();
                $i = 18;
                // dewasa ==============================
                for($i=18;$i>10;$i--){
                    $urutan = "no_".$i;
                    $gigi[$i] = (!empty($odontogram->$urutan)) ? $odontogram->$urutan : 'wwwww';
                }
                for($j=21;$j<29;$j++){
                    $urutan = "no_".$j;
                    $gigi[$j] = (!empty($odontogram->$urutan)) ? $odontogram->$urutan : 'wwwww';
                }
                for($i=48;$i>40;$i--){
                    $urutan = "no_".$i;
                    $gigi[$i] = (!empty($odontogram->$urutan)) ? $odontogram->$urutan : 'wwwww';
                }
                for($j=31;$j<39;$j++){
                    $urutan = "no_".$j;
                    $gigi[$j] = (!empty($odontogram->$urutan)) ? $odontogram->$urutan : 'wwwww';
                }
                // =====================================
                
                
                // anak ================================
                for($i=55;$i>50;$i--){
                    $urutan = "no_".$i;
                    $gigi[$i] = (!empty($odontogram->$urutan)) ? $odontogram->$urutan : 'wwwww';
                }
                for($j=61;$j<66;$j++){
                    $urutan = "no_".$j;
                    $gigi[$j] = (!empty($odontogram->$urutan)) ? $odontogram->$urutan : 'wwwww';
                }
                for($i=85;$i>80;$i--){
                    $urutan = "no_".$i;
                    $gigi[$i] = (!empty($odontogram->$urutan)) ? $odontogram->$urutan : 'wwwww';
                }
                for($j=71;$j<76;$j++){
                    $urutan = "no_".$j;
                    $gigi[$j] = (!empty($odontogram->$urutan)) ? $odontogram->$urutan : 'wwwww';
                }
                // =====================================
                
                return $gigi;
	}
}