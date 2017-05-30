<?php
class ProductsModel extends BaseModel {
    public function getProducts($where = '') {
        $where .= '(1=1)';
        $query = 'Select `p`.id, `p`.`title`, `p`.`description`, `g`.`image` from `products` as `p` LEFT JOIN `gallery` as `g` on `g`.product_id = `p`.id where '.$where.' order by `p`.`id` asc';
        $result = $this->select($query);
        return $result;
    }
}