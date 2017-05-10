<?php
class ProductsModel extends BaseModel {
    public function getProducts($where = '') {
        $where .= '(1=1)';
        $query = 'Select * from `products` where '.$where.' order by `id` asc';
        $result = $this->select($query);
        return $result;
    }
}