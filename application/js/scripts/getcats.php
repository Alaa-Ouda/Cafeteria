<?php
$category = new Application_Model_Category();
$res      = $category->listCategories();
print_r($res);
