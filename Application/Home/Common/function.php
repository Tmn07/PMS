<?php
// 公共函数库
function getNotice($uid)
{
	// return "hello";
}

function Protoid($name)
{
	$filename = "./Public/json/pro.json";
	$json_string = file_get_contents($filename);
	$arr = json_decode($json_string,true);
	if (isset($name)) {
		foreach ($arr as $key => $value) {
			if ($value['name'] == $name) {
				return $value['id'];
			}
		}
	}
	return $arr;
}