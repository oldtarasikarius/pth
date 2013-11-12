function regVal() {
  var name=document.forms["reg_form"]["login"].value;
    if (name==null || name=="") {
      alert("Enter login, please");
      return false;
    }
    if (name.length<2) {
      alert('Login must consist more than 1 simbol');
      return false;
    }
  
  var pass=document.forms["reg_form"]["password"].value;
    if (pass==null || pass=="") {
      alert("Enter password, please");
      return false;
    }
    if (pass.length<3) {
      alert('Password must consist more than 2 simbols');
      return false;
    }
  
  var conf_pass=document.forms['reg_form']['repeat_password'].value;
    if (conf_pass!==pass) {
      alert("Fields 'Password' and 'Confirm password' must have the same values!!!");
      return false;
    }
  var mail=document.forms["reg_form"]["email"].value;
    var atpos=mail.indexOf("@");
    var dotpos=mail.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos>=mail.length+2) {
      alert("Not a valid mail address!");
      return false;
    }
}
////////
function fieldValidation(value,field){
  if (field=="pass") {
    document.getElementById(field+"Val").innerHTML="";
    if (value=="" || value==null || value.length<3) {
      document.getElementById(field+"Val").innerHTML="&otimes;";
      return;
    }
    exit();
  }
  if (field=="conf_pass") {
    document.getElementById(field+"Val").innerHTML="";
    if (value!==document.forms["reg_form"]["password"].value) {
      document.getElementById(field+"Val").innerHTML="&otimes;";
      return;
    }
    exit();
  }
  if (field=="login") {
    if (value=="" || value==null || value.length<2) {
      document.getElementById(field+"Val").innerHTML="&otimes;";
      return;
    }
  }
  if (field=="mail") {
    var atpos=value.indexOf("@");
    var dotpos=value.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos>=value.length+2) {
      document.getElementById(field+"Val").innerHTML="&otimes;";
      return false;
    }
  }
  xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById(field+"Val").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","validation.php?value="+value+"&field="+field,true);
  xmlhttp.send();
}