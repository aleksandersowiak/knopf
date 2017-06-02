<?php
require_once(APPLICATION_PATH.'/data/config.php');
require_once(APPLICATION_PATH.'/data/recaptcha/recaptchalib.php');

abstract class BaseModel extends ViewModel
{
    private $database;
    private $_name = 'defaults'; // used to select default database, can be change to use.
    protected $_db;
    public $_configApp = null;
    public $_email;

    public function __construct()
    {
        $this->database = $this->getDb();
        $this->_configApp = $this->getConfig();
        $schema = $this->database[$this->_name];
        $port = ($schema['port'] != '') ? ':' . $schema['port'] : '';
        $this->_db = mysqli_connect(
            $schema['host'] . $port,
            $schema['un'],
            $schema['pw']
        )
        or die(mysqli_connect_error());
        $this->_db->set_charset("utf8");
        $this->_db->query('USE `' . $schema['db'] . '`');
    }

    protected function getDb()
    {
        global $db;
        $this->database = $db;
        return $this->database;
    }

    public function getConfig()
    {
        global $configApp;
        $this->_configApp = $configApp;
        return $this->_configApp;
    }

    public function select($query)
    {
        $sql = $this->_db->query($query);
        if (mysqli_errno($this->_db) > 0) {
            die($this->_db->error);
        }
        $data = array();
        while ($d = mysqli_fetch_assoc($sql)) {
            $data[] = $d;
        }
        return $data;
    }
    public function insert($table, $insData, $wheres = '')
    {
        $escaped_values = array();
        $columns = implode(", ", array_keys($insData));
        foreach (array_values($insData) as $val) {
            $escaped_values[] = $this->_quote($val);
        }
        $values = implode(", ", $escaped_values);
        $where = ($wheres != '') ? ' WHERE ' . $wheres : '';
        $sql = "INSERT INTO `" . $table . "` ($columns) VALUES ($values) $where";
        $result = $this->_db->query($sql);
        if ($result === FALSE) {
//            return false;
            die($this->_db->error);
        }
        return ($this->_db->insert_id);
    }

    public function update($table,$upData, $wheres = '')
    {
        foreach ($upData as $key => $testimonials) {
            $column = ($key);
            $value = ($testimonials);
            $where = ($wheres != '') ? ' WHERE ' . $wheres : '';
            $sql = "UPDATE `" . $table . "` SET `" . $column . "`='" . $value . "' $where";

            $result = $this->_db->query($sql);
            if ($result === FALSE) {
                return false;
//                die($this->_db->error);
            }
            return true;
        }
    }

    public function delete($table, $id) {

    }

    protected function _quote($value)
    {
        if (is_int($value) || is_float($value)) {
            return $value;
        }
        return "'" . $this->_db->real_escape_string($value) . "'";
    }
    public function getTopMenu() {
        $query = 'Select * from `top_menu` order by `order` asc';
        $result = $this->select($query);
        return $result;
    }
    public function getContent($controller = '', $action = '', $lang = DEFAULT_LANG) {
        if($lang == '') $lang = DEFAULT_LANG;
        $query = 'Select `c`.`description_'.$lang.'` as value, `c`.*, `tm`.controller, `tm`.action from `content` as `c`
        left join `top_menu` as `tm` on `tm`.id = `c`.menu_id
        where `tm`.`action` LIKE "'.str_replace('Action','',$action).'" AND `tm`.`controller` LIKE "'.$controller.'"';

        $result = $this->select($query);
        return $result;
    }
}
