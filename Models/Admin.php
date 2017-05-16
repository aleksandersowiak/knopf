<?php

class AdminModel extends BaseModel
{
    public function checkUser($userName)
    {
        $select = $this->select('select count(*) as count from `user` where userName like "' . $userName . '"');
        return $select[0]['count'];

    }

    public function checkPassword($userName, $userPassword)
    {
        $password = sha1($this->_configApp['htpsw'] . '.' . $userPassword);
        $select = $this->select('select id from `user` where userName like "' . $userName . '" and userPassword LIKE "' . $password . '"');
        if (!empty($select)) {
            return $select[0]['id'];
        }
        return false;
    }

    public function getUser($id)
    {
        return $this->select('select id, name, surname, city, street, postCode from `user` where id = "' . $id . '"');
    }

    public function getDataToEdit($controller, $action, $id, $lang = DEFAULT_LANG)
    {
        $select = $this->select('Select `t`.`' . $lang . '` as value from `content` as `c`
        left join `translate` as `t` on `t`.`id` = `c`.`translate_id`
         where `c`.`id` = ' . $id . ' and `c`.`controller` like "' . $controller . '" and `c`.`action` LIKE "' . $action . '"');
        if (!empty($select)) {
            return $select[0]['value'];
        }
        return false;
    }

    public function insertData($params = array())
    {
//        array(4) {
//        ["editor"]=>
//  string(0) ""
//        ["dataController"]=>
//  string(4) "home"
//        ["dataAction"]=>
//  string(5) "index"
//        ["action"]=>
//  string(6) "insert"
//}
        $save = $saveContent = array();
        $save[$params['language']] = $params['editor'];
        $id = $this->insert('translate', $save);

        $saveContent['controller'] = $params['dataController'];
        $saveContent['action'] = $params['dataAction'];
        $saveContent['translate_id'] = $id;

        $this->insert('content',$saveContent);

    }

    public function updateData($params = array())
    {

    }

    public function getContents() {
        $query = 'Select * from `content`';
        return $this->select($query);
    }
}