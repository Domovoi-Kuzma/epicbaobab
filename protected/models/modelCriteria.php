<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 14.08.2019
 * Time: 13:25
 */

/**
 * Class ModelCriteria
 * ищет большие встречи, на которой сотрудников больше критерия
 */
class ModelCriteria extends CFormModel{
    public $criteria;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
              [['criteria'],  'required', 'message' => 'Введите предельное число участников'],
              [['criteria'],  'compare', 'compareValue' => 0,'operator' => '>=', 'message' => 'Введите неотрицательное число - лимит участников'],
              [['criteria'],  'numerical', 'message'=>'введите предельное число участников десятичным положительным числом'],
        ];
            //"ModelCriteria.integer" is not defined.
            //"ModelCriteria.0" is not defined.
        /*return [
          [ ['criteria', ],
              'required'
          ],
        ];*/
    }
    /**
    * Declares customized attribute labels.
    * If not declared here, an attribute would have a label that is
    * the same as its name with the first letter in upper case.
    */
    public function attributeLabels()
    {
        return array(
            'criteria'=>'Вывести встречи с числом участников не меньше',
        );
    }
    public $results;
    public $buddies;
    /**
     * запрашивает в базе список  больших встречи, на которой сотрудников больше критерия
     */
    public function QueryNames()
    {
        $sql="SELECT Meeting,ID FROM meets JOIN relations ON ID=MID GROUP BY ID HAVING COUNT(*)>=$this->criteria";
        $this->results=Yii::app()->db->createCommand($sql)->queryAll();
    }
    public function QueryBuddies()
    {
        foreach($this->results as $MeetingLine)
        {
            $sql="SELECT Name FROM people JOIN relations ON ID=EID AND ".$MeetingLine["ID"]."=MID";
            $this->buddies[$MeetingLine['ID']]=Yii::app()->db->createCommand($sql)->queryAll();
        }
    }
}