<?php
include("v1/config.php");

$sql = "SELECT * FROM categories WHERE recommands='1' ";
$result = mysqli_query($db, $sql);
$recommands = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT * FROM subcategories WHERE ";
foreach ($recommands as $key => $value) {
	if($key == 0){
		$sql .= 'category='.(string)$value['id'];
	}else{
		$sql .= ' OR category='.(string)$value['id'];
	}
}
$result = mysqli_query($db, $sql);
$tab_recommands = mysqli_fetch_all($result, MYSQLI_ASSOC);

for($i=0; $i<count($recommands); $i++){
	$recommands[$i]['tab'] = array();
	for($j=0; $j<count($tab_recommands); $j++){
		if($tab_recommands[$j]['category'] == $recommands[$i]['id']){
			array_push($recommands[$i]['tab'], $tab_recommands[$j]);
		}
	}
}

$sql = "SELECT * FROM categories";
$result = mysqli_query($db, $sql);
$all_category = mysqli_fetch_all($result, MYSQLI_ASSOC);


$sql = "SELECT service_review.rate as rating, register.fname, register.lname, user_services.id, user_services.userid, city.name as cityName, user_services.category, user_services.scategory, user_services.image, user_services.description, user_services.title,user_services.price, categories.name as category, subcategories.name as scategory FROM service_review, user_services, categories, subcategories, register,city WHERE categories.id = user_services.category and subcategories.id = user_services.scategory and service_review.serviceid = user_services.id  and user_services.userid = register.id and user_services.city = city.id and service_review.rate >= '4.5' GROUP BY id ORDER BY rate DESC LIMIT 10";

$result = mysqli_query($db, $sql);
$services = mysqli_fetch_all($result, MYSQLI_ASSOC);