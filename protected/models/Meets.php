<?php

/**
 * This is the model class for table "meets".
 *
 * The followings are the available columns in table 'meets':
 * @property integer $ID
 * @property string $Meeting
 * @property integer $Place
 *
 * The followings are the available model relations:
 * @property Room $place
 * @property Relations[] $relations
 */
class Meets extends CActiveRecord
{
	public function saveAs()
	{
		$this->Meeting = $_POST['NameInput'];
		$this->Place=intval($_POST['room']);

		//isset($_POST['options'])?$_POST['options']:[]
		$this->save();
		foreach($_POST['options'] as $opt)
		{
			$rel=new Relations();
			$rel->EID=$opt;
			$rel->MID=$this->ID;
			$rel->save();
		}
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'meets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('Place', 'required'),
			array('Place', 'numerical', 'integerOnly'=>true),
			array('Meeting', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, Meeting, Place', 'safe', 'on'=>'search'),
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
			'related_people'=>array(self::MANY_MANY, 'People', 'relations(MID, EID)'),
			'room' => array(self::BELONGS_TO, 'Room', 'Place'),
			'memberCount' => array(self::STAT, 'People', 'relations(MID, EID)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'Meeting' => 'Meeting',
			'Place' => 'Place',
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

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('Meeting',$this->Meeting,true);
		$criteria->compare('Place',$this->Place);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Meets the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
