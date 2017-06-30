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
        $select = $this->select('Select `c`.`description_' . $lang . '` as value from `content` as `c`
        left join `top_menu` as `tm` on `tm`.`id` = `c`.`menu_id`
         where `c`.`id` = ' . $id . ' and `tm`.`controller` like "' . $controller . '" and `tm`.`action` LIKE "' . $action . '"');
        if (!empty($select)) {
            return $select[0]['value'];
        }
        return false;
    }

    public function getProductToEdit($id = null, $lang = DEFAULT_LANG)
    {
        $where = '';
        if ($id != null) {
            $where = ' WHERE `id` = ' . $id;
        }
        $select = $this->select('select id,`title_' . $lang . '` as title, `description_' . $lang . '` as description from `products` ' . $where);
        if (!empty($select)) {
            return $select[0];
        }
        return false;
    }

    public function insertData($params = array())
    {

        switch ($params['dataController']) {
            case 'products' :
                $table = 'products';
                $save['title_' . $params['language']] = $params['title_' . $params['language']];
                $save['description_' . $params['language']] = $params['description_' . $params['language']];
                break;
            default:
                $table = 'content';

                $data = explode('/', $params['value']);
                $saveContent['controller'] = $data[0];
                $saveContent['action'] = $data[1];

                $save['description_' . $params['language']] = '';
                $menu_id = $this->select("select id from `top_menu` where `controller` LIKE '" . $data[0] . "' and `action` LIKE '" . $data[1] . "'");
                $save['menu_id'] = $menu_id[0]['id'];
        }

        if ($this->insert($table, $save) == false) {
            return false;
        }
        return true;
    }

    public function updateData($params = array())
    {
        switch ($params['dataController']) {
            case 'products' :
                $table = 'products';
                break;
            default:
                $table = 'content';
        }
        $save = $saveContent = array();
        $save['description_' . $params['language']] = str_replace("'", "&#8217;", $params['description_' . $params['language']]);
        if (isset($params['title_' . $params['language']])) {
            $save['title_' . $params['language']] = $params['title_' . $params['language']];
        }
        $update = $this->update($table, $save, '`id` = ' . $params['dataId']);
        if ($update == false) return false;
        return true;
    }

    public function updateDataImage ($params = array()) {
        $update = $this->update('gallery', array('category_id' => $params['droppedCategoryId']), '`id` = ' . $params['imageId']);
        if ($update == false) return false;
        return true;
    }
    public function getContents($view, $lang = DEFAULT_LANG)
    {
        $query = null;
        switch ($view) {
            case 'home' :
                $query = 'select `c`.* , `tm`.controller, `tm`.action from `top_menu` as `tm` left join `content` as `c` on `tm`.id = `c`.menu_id';
                break;
            case 'products' :
                $query = 'Select `id`,`title_' . $lang . '` as title, `description_' . $lang . '` as description  from `products` ';
                break;
            case 'gallery' :
                $query = 'select `category_' . $lang . '` as category, id as category_id from category';
                break;
        }
        if ($query != NULL) {
            return $this->select($query);
        }
        return false;
    }

    public function delete($view, $where = '')
    {
        $table = NULL;
        switch ($view) {
            case 'home' :
                $table = '`content`';
                break;
            case 'products' :
                $table = '`products`';
                break;
        }
        if ($table != NULL) {
            return $this->_db->query('DELETE FROM ' . $table . ' WHERE ' . $where);
        }
        return false;
    }

    public function assignImages($params)
    {
        $save = array();
        if ($params['action'] == 'delete') {
            $save[$params['dataType']] = "NULL";
        } else {
            $save[$params['dataType']] = $params['prodId'];
        }
        $update = $this->update('gallery', $save, '`id` = ' . $params['imgId']);
        if ($update == false) return false;
        return true;
    }
}