
var name = "";
var last = "";
var user = "";
var pass = "";
var bp = "";
var level = "";
var users = [];
var passwords = [];

let validate_login = function (){
	username = document.getElementById("user");
	password = document.getElementById("password");

	usernames = localStorage.getItem("users");
	passwords = localStorage.getItem("passwords");

	user_ind = usernames.indexOf(username);
	pass_ind = passwords.indexOf(password);

	if (user_ind == -1 || pass_ind == -1 || user_ind != pass_ind){
		alert("Password Username Combination not Valid");
	}
	else
	{
		location.href = "portfolio.php";
	}

}

document.getElementById('signup').addEventListener("click", validate_form);

let validate_form = function (){

	name = document.forms["signup"]["first"].value;
	last = document.forms["signup"]["first"].value;
	user = document.forms["signup"]["user"].value;
	pass = document.forms["signup"]["password"].value;
	bp = document.forms["signup"]["bp"].value;
	level = document.forms["signup"]["level"].value;

	alert("HHE");

	if (name == "" || last == "" || user == "" || pass == "" || bp == ""){
		alert("Enter All Fields");
	}
	else if ( !(/^\d+$/.test(bp)) ){
		alert("Enter Valid Buying Power");
	} 
	else 
	{
	location.href = "portfolio.php";
	}	
}

window.onload = () => document.getElementById("currBP").innerHTML = "Buying Power: 	" + localStorage.getItem("bp");

function addEntry() {
    // Parse any JSON previously stored in allEntries
    var existingEntries = JSON.parse(localStorage.getItem(key));
    if(existingEntries == null) existingEntries = [];
    var user = document.getElementById("user").value;
    var password = document.getElementById("pass").value;
    var entry = {
        "username": user,
        "password": password
    };
    localStorage.setItem("entry", JSON.stringify(entry));
    // Save allEntries back to local storage
    existingEntries.push(entry);
    localStorage.setItem("allCredentials", JSON.stringify(existingEntries));
}

function logout() {
	<?php
	session_destroy();
	?>
	location.href = "login.php";
}