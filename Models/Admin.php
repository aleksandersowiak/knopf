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
        $select = $this->select('Select `c`.`' . $lang . '` as value from `content` as `c`
        left join `top_menu` as `tm` on `tm`.`id` = `c`.`menu_id`
         where `c`.`id` = ' . $id . ' and `tm`.`controller` like "' . $controller . '" and `tm`.`action` LIKE "' . $action . '"');
        if (!empty($select)) {
            return $select[0]['value'];
        }
        return false;
    }

    public function insertData($params = array())
    {
        $data = explode('/', $params['value']);

        $save[$params['language']] = '';

        $saveContent['controller'] = $data[0];
        $saveContent['action'] = $data[1];

        $menu_id = $this->select("select id from `top_menu` where `controller` LIKE '" . $data[0] . "' and `action` LIKE '" . $data[1] . "'");
        $save['menu_id'] = $menu_id[0]['id'];
        if ($this->insert('content', $save) == false) {
            return false;
        }
        return true;
    }

    public function updateData($params = array())
    {
        $save = $saveContent = array();
        $save[$params['language']] = $params['editor'];
        $update = $this->update('content', $save, '`id` = ' . $params['dataId']);
        if ($update == false) return false;
        return true;
    }

    public function getContents($view)
    {
        $query = null;
        switch ($view) {
            case 'home' :
                $query = 'select `c`.*, `tm`.controller, `tm`.action from `top_menu` as `tm` left join `content` as `c` on `tm`.id = `c`.menu_id';
                break;
            case 'products' :
                $query = 'Select * from `products` ';
                break;
        }
        if ($query != NULL) {
            return $this->select($query);
        }
        return false;
    }
    public function delete($view, $where = '') {
        $table = NULL;
        switch ($view) {
            case 'home' :
                $table = '`content`' ;
                break;
            case 'products' :
                $query = 'Select * from `products` ';
                break;
        }
        if ($table != NULL) {
            return $this->_db->query('DELETE FROM ' . $table . ' WHERE ' . $where);
        }
        return false;
    }
}