let sessionTrack = "";

function clear(location) {
    while(location.hasChildNodes()){
        location.removeChild(location.lastChild);
    }

}

function sendGet(){


    let html_export = document.querySelector('#main');

    clear(html_export);
    $.get({
        type:"GET",
        url:"http://localhost/ussd/ussd.php",
		dataType:"json",
		data: getData(),
        async:true,
        success:function (responce) {
            // if (responce.Success){
			if (responce.success){
				setData(responce);
				console.log(responce);
				// alerts("success",JSON.parse(responce));
			}else {
				console.log(responce);
				setData(responce);
            }

        }

	});
}

// function setData($parentElement,$value){
// 	// let element = document.querySelector($parentElement);
// 	let html_export = document.querySelector("#"+$parentElement);
// 	let element = document.getElementById($parentElement);
// 	clear(html_export);
// 	let textDisplay = document.createElement('p');
// 	textDisplay.innerText = $value;
// 	element.appendChild(textDisplay);
// }

function getData(){
	let phone = document.getElementById('phoneNumber').value;
	// let session;
	// try {
	// 	session = document.getElementById('session').value;
	// } catch (e) {
	// 	console.log(e);
	// 	session = "";
	// }
	
	let input = document.getElementById('input').value;
	// let phone = document.getElementById('phoneNumber').value;
	return {
		UserInput : localSessionSave(input),
		phoneNumber : phone,
		SessionID : phone
	}
}

function setData(responce){
	document.getElementById("phoneNumber").value = responce['phone'];
	document.getElementById("main").innerText = responce['message'];
	document.getElementById("ses").value = responce['session'];
	document.getElementById("input").value = "";
}
function localSessionSave(input){
	sessionTrack = sessionTrack +"-"+ input;
	return sessionTrack;
}
function clearLocal(){
	sessionTrack = "";
}