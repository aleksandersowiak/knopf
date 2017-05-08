<?php
class HomeModel extends BaseModel{
    public function getSlide() {
        $query = 'Select * from `products` order by `id` asc LIMIT 5';
        $result = $this->select($query);
        return $result;
    }
}