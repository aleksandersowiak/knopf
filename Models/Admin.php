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
        $data = $this->getLanguagesCase('description');
        $select = 'SELECT DISTINCT IF(ISNULL(description_' . $lang . '),
        CASE idx
        '.$data['list'].'
        END
        , description_' . $lang . ') AS description,
         IF(ISNULL(description_' . $lang . '), 1,0) AS empty_description, c.ordering, c.category_id
        FROM content as c
        JOIN (
        SELECT 1 AS idx
        '.$data['listSelect'].') t
        left join `top_menu` as `tm` on `tm`.`id` = `c`.`menu_id`
        where `c`.`id` = ' . $id . ' and `tm`.`controller` like "' . $controller . '" and `tm`.`action` LIKE "' . $action . '"

        HAVING description IS NOT NULL order by c.ordering Limit 1 ;';
        $select = $this->select($select);

        if (!empty($select)) {
            return $select[0];
        }
        return false;
    }

    public function getProductToEdit($id = null, $lang = DEFAULT_LANG)
    {
        $description = $this->getLanguagesCase('description');
        $title = $this->getLanguagesCase('title');
        $where = '';
        if ($id != null) {
            $where = ' WHERE `id` = ' . $id;
        }

        $select = 'SELECT DISTINCT IF(ISNULL(description_'.$lang.'),
CASE idx
	'.$description['list'].'
END
, description_'.$lang.') AS description,

IF(ISNULL(title_'.$lang.'),
CASE idx
	'.$title['list'].'
END
, title_'.$lang.') AS title,
IF(ISNULL(title_'.$lang.'), 1,0) AS empty_title,
IF(ISNULL(description_'.$lang.'), 1,0) AS empty_description
FROM products AS c
JOIN (
SELECT 1 AS idx
'.$title['listSelect'].') t
'. $where . '
HAVING description IS NOT NULL AND title IS NOT NULL; ';
      $select = $this->select($select);
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
            case 'category' :
                $table = 'category';
                $save['category_' . $params['language']] = $params['category_' . $params['language']];
                if (isset($params['edit_category_type'])) {
                    $save['category_id'] = $params['edit_category_type'];
                }
                break;
            default:
                $table = 'content';

                $data = explode('/', $params['value']);
                $saveContent['controller'] = $data[0];
                $saveContent['action'] = $data[1];

                $save['description_' . $params['language']] = '';
                $menu_id = $this->select("select id from `top_menu` where `controller` LIKE '" . $data[0] . "' and `action` LIKE '" . $data[1] . "'");

                $save['menu_id'] = $menu_id[0]['id'];
                $order = $this->select('select max(`ordering`) as ordering from '.$table.' where menu_id = '. $save['menu_id']);
                $save['ordering'] = $order[0]['ordering']+1;
        }
        if ($this->insert($table, $save) == false) {
            return false;
        }
        return true;
    }

    public function updateData($params = array())
    {
        $save = $saveContent = array();
        switch ($params['dataController']) {
            case 'products' :
                $table = 'products';
                break;
            default:
                if (isset($params['edit_category_type'])) {
                    $save['category_id'] = $params['edit_category_type'];
                }
                $table = 'content';
        }
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
                $query = 'select `c`.id, c.menu_id, IF(ISNULL(c.description_' . $lang . '),c.description_' . DEFAULT_LANG . ', c.description_' . $lang . ') as description , `tm`.controller, `tm`.action from `top_menu` as `tm` left join `content` as `c` on `tm`.id = `c`.menu_id order by c.ordering asc';
                break;
            case 'products' :
                $description = $this->getLanguagesCase('description');
                $title = $this->getLanguagesCase('title');

               $query = 'SELECT * FROM (SELECT DISTINCT IF(ISNULL(description_'.$lang.'),
                            CASE idx
                                '.$description['list'].'
                            END
                            , description_'.$lang.') AS description,

                            IF(ISNULL(title_'.$lang.'),
                            CASE idx
                                '.$title['list'].'
                            END
                            , title_'.$lang.') AS title, id,
                            IF(ISNULL(title_'.$lang.'), 1,0) AS empty_title,
                            IF(ISNULL(description_'.$lang.'), 1,0) AS empty_description
                            FROM products AS c
                            JOIN (
                            SELECT 1 AS idx
                            '.$title['listSelect'].') t
                            HAVING description IS NOT NULL AND title IS NOT NULL) AS ts GROUP BY `ts`.`id` order by `ts`.`id` asc;';
                break;
            case 'gallery' :
                $data = $this->getLanguagesCase('category');
                $fields = '  id as category_id ';
                $query = 'SELECT DISTINCT IF(ISNULL(category_'.$lang.'),
                            CASE idx
                                '.$data['list'].'
                            END
                            , category_'.$lang.') AS category,
                            '.$fields.',
                            IF(ISNULL(category_'.$lang.'), 1,0) AS empty_category
                            FROM category
                            JOIN (
                            SELECT 1 AS idx
                            '.$data['listSelect'].') t
                            WHERE category_type = 1
                            HAVING category IS NOT NULL ';
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
            case 'category' :
                $table = '`category`';
                $this->update('gallery', array('category_id' => 1), str_replace("`id`", '`category_id`', $where));
                break;
            case 'gallery' :
                $table = '`gallery`';

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
            $save[$params['dataType']] = NULL;
        } else {
            $save[$params['dataType']] = $params['prodId'];
        }
        $update = $this->update('gallery', $save, '`id` = ' . $params['imgId']);
        if ($update == false) return false;
        return true;
    }
}