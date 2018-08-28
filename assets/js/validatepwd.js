function validatePassword()
{
if(document.login.register_password.value!==document.login.confirm_password.value){
alert("Your passwords did not match!. Please check and register again");

return false;
}
else {
return true;
}
}

