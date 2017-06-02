<?php
class GalleryModel extends BaseModel {
    public function getImages($where = '') {
        if($where == '' ) {
            $where = 'LIMIT 10';
        }
        $query = "SELECT id,image, category, product_id, realization re from `gallery` " . $where;
        return $this->select($query);
    }
    public function getCategoryId($name) {
        $query = "select category_id from gallery where category LIKE '".$name."'";
        $result = $this->select($query);
        return $result[0]['category_id'];
    }
}