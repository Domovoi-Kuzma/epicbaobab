<?php

/**
 * This is the model class for table "room".
 *
 * The followings are the available columns in table 'room':
 * @property integer $ID
 * @property string $Number
 *
 * The followings are the available model relations:
 * @property Meets[] $meets
 */
class Room extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'room';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('Number', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, Number', 'safe', 'on'=>'search'),
        );
    }
    /**
     * Сохраняет параметры $_POST в модель и в БД
     * @return  boolean успешность сохранения
     * @author  Sasha
     * @data    21.08.2019
     */
    public function saveAs()
    {
        $this->Number = $_POST['NumberInput'];
        return $this->save();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'meets' => array(self::HAS_MANY, 'Meets', 'Place'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ID' => 'ID',
            'Number' => 'Number',
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

        $criteria->compare('ID',$this->ID);
        $criteria->compare('Number',$this->Number,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Room the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    /**
     * Обрывает все отношения с другими таблицами перед удалением записи
     * @return boolean whether the Room record should be deleted.
     * @author  Sasha
     * @data    28.08.2019
     */
    public function beforeDelete()
    {
        foreach ($this->meets as $meeting) {
            $meeting->related_people=[];
            $meeting->save();
            $meeting->delete();//Cannot delete parent row-foreign key constraint
        }
        return parent::beforeDelete();
    }
}
