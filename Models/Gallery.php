<?php
class GalleryModel extends BaseModel {
    public function getImages() {
        $query = "SELECT image FROM `products` UNION SELECT image from `gallery`";
        return $this->select($query);
    }
}