<?php
class AdminModel extends BaseModel{
    public function checkUser($userName) {
        $select =  $this->select('select count(*) as count from `user` where userName like "' . $userName . '"');
        return $select[0]['count'];

    }
    public function checkPassword($userName, $userPassword) {
        $password = sha1($this->_configApp['htpsw'] .'.'.$userPassword );
        $select =  $this->select('select id from `user` where userName like "' . $userName . '" and userPassword LIKE "' . $password . '"');
        if (!empty($select)) {
            return $select[0]['id'];
        }
        return false;
    }
    public function getUser($id) {
        return $this->select('select id, name, surname, city, street, postCode from `user` where id = "' . $id . '"');
    }
}