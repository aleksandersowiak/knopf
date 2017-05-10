<?php
class HomeModel extends BaseModel{
    public function getSlide() {
        $query = 'Select * from `products` order by `id` asc LIMIT 5';
        $result = $this->select($query);
        return $result;
    }
    public function getContact() {
        $query = 'Select value from `contact` LIMIT 1';
        $result = $this->select($query);
        return $result[0]['value'];
    }
}