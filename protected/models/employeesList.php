<?php
/**
 * @deprecated No longer used by internal code and not recommended.
 * Created by PhpStorm.
 * User: Sasha
 * Date: 07.08.2019
 * Time: 17:24
 */
class EmployeesList extends CModel
{
    private $names;
    private $buddies;
    public function Header()
    {
        return 'Список сотрудников';
    }
    public function NamesList()
    {
        return $this->names;
    }

    public function RelativesList($who)
    {
        return $this->buddies[$who];
    }

    public function QueryNames()
    {
        $sql = "SELECT * FROM people";
        $this->names = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($this->names as $item)
        {
            $idval=$item['ID'];
            $sql = "SELECT m.Meeting FROM people p, meets m, relations r WHERE m.ID=r.MID AND p.ID=r.EID AND p.ID=$idval";
           //$sql2 = "SELECT m.Meeting FROM people p, meets m, relations r WHERE m.ID=r.MID AND p.ID=r.EID AND p.ID="+strval($item['ID']);//fails miserably
            //$sql=text+$item['ID'];//returns ID number instead of string

            $this->buddies[$item['Name']] = Yii::app()->db->createCommand($sql)->queryAll();
        }

    }
    public function attributeNames(){
        return array('employees');
    }
}