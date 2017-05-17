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
        $data = explode('/',$params['value']);

        $save = $saveContent = array();
        $save[$params['language']] = '';
        $id = $this->insert('translate', $save);

        $saveContent['controller'] = $data[0];
        $saveContent['action'] = $data[1];
        $saveContent['translate_id'] = $id;

        if($this->insert('content',$saveContent) == false) {
            return false;
        }
        return true;
    }

    public function updateData($params = array())
    {
        $save = $saveContent = array();
        $save[$params['language']] = $params['editor'];

        $translate_id = $this->select('select translate_id from content where id = ' .$params['dataId']);
        $update = $this->update('translate', $save, '`id` = ' . $translate_id[0]['translate_id']);
         if($update == false) return false;
        return true;
    }

    public function getContents($view) {
        $query = null;
        switch ($view) {
            case 'home' :
                $query = 'Select * from `content` ';
                break;
            case 'products' :
                $query = 'Select * from `products` ';
                break;
        }
        if($query != NULL) {
            return $this->select($query);
        }
        return false;
    }
}