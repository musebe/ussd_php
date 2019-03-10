<?php
// // Session tracking not used 
// function startTracker($phoneNumber){
// 	$session = session_id($phoneNumber);
// 	session_start();
// 	return $session;
// }	

// File logging for debuging
function flog($session){
	$File = "mylog.log";
	$Handle = fopen($File, 'a');
	fwrite($Handle, $session);
	fwrite($Handle,"\n");
	fclose($Handle);
}

// extract display txt from array
function structureDisplayString($loc,$arr){
	$final_str = "";
	$retrieved_obj = $arr[(int)$loc-2];
	$final_str = $final_str.$retrieved_obj["questionText"];
	$options = $retrieved_obj["options"];
	$optNumber = 0;
	foreach ($options as $option) {
		// Modification
		$optNumber += 1; // either directly use this variable or
		$option["optNumber"] = $optNumber;
		$final_str = $final_str."\n".$option["optNumber"]." . ".$option["optionText"];
	}
	flog($final_str."|FUNCTION|".__FUNCTION__);
	return $final_str;
}

// Assignmet of user session array values for depth
$no_inputs = explode("-",$_GET['UserInput']);

// Assist in transversion of user session from start to end 
function moveDisplays($no_inputs){
	$usr_session = sizeof($no_inputs);
	$data = json_decode(sampleApiCallResponse() ,true);
	flog(json_encode($no_inputs)."|FUNCTION|".__FUNCTION__);
	if($usr_session > sizeof($data)+1){
		return "Thank you for corparation";
	}else{
		return structureDisplayString($usr_session, $data);
		// move to the next page
	}
}

// Log of entire user request
flog(json_encode($_GET));

// Log of user sessions tracking
flog(json_encode($no_inputs));


$phone = $_GET["phoneNumber"];
if($phone !="" && $_GET["SessionID"]==""){
	$_SESSION['ID'] = $phone;
	$progress = explode("-",$_GET['UserInput']);
	echo displayText("Enter ID Number",$phone,true);
}elseif($_GET["phoneNumber"]!="" && $_GET["SessionID"] != ""){
	$disp = moveDisplays($no_inputs);
	echo displayText($disp,$phone,true);
}else{
	echo displayText("Invalid Session or phone number",null,false);
}

/**
 * Response formulater to the Get request
 */
function displayText($text,$phone,$success){
	return json_encode(
		array(
			"message"=>$text,
			"session"=>$phone,
			"success"=>$success,
			"phone" => $phone
		)
	);
}

/**
 * Simulation 
 */
function sampleApiCallResponse(){
	return file_get_contents("sample.json");
}
