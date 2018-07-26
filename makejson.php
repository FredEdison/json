<?php

//$results= json_encode($result);
//echo json_encode($result);
//file_put_contents("data.json",$results);


//$data= json_decode($_POST['data']);
//foreach ($data as $d){

	//echo "The Data is $d";
//}

//$_POST['color']="255 ,255 ,255";


$items=json_decode($_POST["data"],true);


$color=array("R"=>intval($_POST["r"]),
			 "G"=>intval($_POST["g"]),
			 "B"=>intval($_POST["b"]));

$data= array();

$fred1=array();
$fred1_dataA=array();
$fred1_dataB=array();

$fred2=array();
$fred2_dataA=array();
$fred2_dataB=array();

$fred3=array();
$fred3_dataA=array();
$fred3_dataB=array();

$dataf=file_get_contents("data.json");

if($dataf){
$data=json_decode($dataf,true);

$fred1=$data["Fred 1"];
$fred2=$data["Fred 2"];
$fred3=$data["Fred 3"];

	
$fred1_dataA=$fred1['Data A'];
$fred1_dataB=$fred1['Data B'];
$fred1_dataC=$fred1['Data C'];
$fred1_dataD=$fred1['Data D'];



$fred2_dataA=$fred2['Data A'];
$fred2_dataB=$fred2['Data B'];
$fred2_dataC=$fred2['Data C'];
$fred2_dataD=$fred2['Data D'];


$fred3_dataA=$fred3['Data A'];
$fred3_dataB=$fred3['Data B'];
$fred3_dataC=$fred3['Data C'];
$fred3_dataD=$fred3['Data D'];

}


//$rows = intval($_POST["rows"]);

for($i=0;$i<=24;$i++){
	
 ///////////////////// FRED 1
	if (in_array($i."_checkA1",$items)){
		
		$fred1_dataA[$i."A"]=$color;	
	}
	
	if (in_array($i."_checkB1",$items)){
		
		$fred1_dataB[$i."B"]=$color;
	}
	
	if (in_array($i."_checkC1",$items)){
		
		$fred1_dataC[$i."C"]=$color;
	}
	if (in_array($i."_checkD1",$items)){
		
		$fred1_dataD[$i."D"]=$color;
	}
	
	//////////////////////////FRED 2 ///////////////////////
	
	if (in_array($i."_checkA2",$items)){
	$fred2_dataA[$i."A"]=$color;
	}
	
	
	if (in_array($i."_checkB2",$items)){
		$fred2_dataB[$i."B"]=$color;
	}
	
	
	if (in_array($i."_checkC2",$items)){
		$fred2_dataC[$i."C"]=$color;
	}
	
	if (in_array($i."_checkD2",$items)){
		$fred2_dataD[$i."D"]=$color;
	}
	
///////////////////////////////FRED 3 ///////////////////////	
	
	
	if (in_array($i."_checkA3",$items)){
	
		$fred3_dataA[$i."A"]=$color;
	
	}
	
	if (in_array($i."_checkB3",$items)){
		
		$fred3_dataB[$i."B"]=$color;
		
	}
	
	if (in_array($i."_checkC3",$items)){
		
		$fred3_dataC[$i."C"]=$color;
		
	}
	if (in_array($i."_checkD3",$items)){
		
		$fred3_dataD[$i."D"]=$color;
		
	}
	
}


$fred1['Data A'] = $fred1_dataA;
$fred1['Data B'] = $fred1_dataB;
$fred1['Data C'] = $fred1_dataC;
$fred1['Data D'] = $fred1_dataD;



$fred2['Data A'] = $fred2_dataA;
$fred2['Data B'] = $fred2_dataB;
$fred2['Data C'] = $fred2_dataC;
$fred2['Data D'] = $fred2_dataD;


$fred3['Data A'] = $fred3_dataA;
$fred3['Data B'] = $fred3_dataB;
$fred3['Data C'] = $fred3_dataC;
$fred3['Data D'] = $fred3_dataD;


$data["Fred 1"] = $fred1;
$data["Fred 2"] = $fred2;
$data["Fred 3"] = $fred3;

file_put_contents("data.json",json_encode($data));
file_put_contents("fred1.json",json_encode($fred1));
file_put_contents("fred2.json",json_encode($fred2));
file_put_contents("fred3.json",json_encode($fred3));

//echo "<pre>";
//var_dump($fred1_dataA);

echo  "ready for devices";

//echo $dataf=file_get_contents("data.json");





