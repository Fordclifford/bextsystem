<fieldset>
    <div class="row">
        <div  class="col-md-2"></div>
        <div  class="col-md-3">
                        <h1 style="font-size: 22px;" class="text-center">Church Details</h1>
 <div class="form-group">  <?php if ($msg <> "") { ?>
                            <div class="alert alert-dismissable alert-<?php echo $msgType; ?>">
                                <button data-dismiss="alert" class="close" onclick="this.parentElement.style.display = 'none';" type="button">x</button>
                                <p><?php echo $msg; ?></p>
                            </div>
                        <?php } ?></div>
                        <div id="error_msg" class="form-group"></div>
<div class="form-group">
        <label>Union/Mission</label>
        
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                <select required="true"  style="height:40px" id="union_mission" name="union_mission"  placeholder="union" class="form-control"  autocomplete="off"></select>
            </div>
       
    </div>
  <div class="form-group">
        <label >Conference</label>
        
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                <select   style="height:40px"  name="conference" placeholder="Conference" id="conference" class="form-control"  autocomplete="off"></select>
            </div>
       
    </div>

   <div class="form-group">
        <label>Church name</label>
       
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
                <input style="height:40px" type="text" name="name" placeholder="church name" id="name" class="form-control"  autocomplete="off">
            </div>
        
    </div>


   <div class="form-group">
        <label >Mobile number</label>
       
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                <input style="height:40px" type="test" name="mobile" placeholder="Mobile Number" id="mobile" class="form-control"  autocomplete="off">
         
        </div>
    </div>
    </div>
        <div class="col-md-2"></div>
        <div class="col-md-3">
            <h1 style="font-size: 22px;" class="text-center">User Details</h1>
       <div class="form-group">
        <label >Email</label>
        
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input style="height:40px" type="text" name="uemail" placeholder="Email address " id="uemail" class="form-control"  autocomplete="off">
            </div>
       
    </div>
    
        <div class="form-group">
        <label >Username</label>
       
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input style="height:40px" type="text" name="uname" placeholder="Username" id="uname" class="form-control"  autocomplete="off">
            </div>
      
    </div>
    
          <div class="form-group">
        <label >Password</label>
       
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input style="height:40px" type="password" name="passwd" id="passwd" placeholder="Password" class="form-control"  autocomplete="off">
            </div>
      
    </div>
   
           <div class="form-group">
        <label >Confirm Password</label>
       
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input style="height:40px" type="password" name="pass2" id="pass2" placeholder="Confirm Password" class="form-control"  autocomplete="off">
            </div>
       
    </div>   
        </div>
    </div>
    <hr>
    <div class="row ">
       
            <div class="col-md-2"></div>
           <div class="col-md-2">
           <a title="Click to signin"  href="../login.php"   data-toggle="tooltip"   ><span class="glyphicon glyphicon-log-in"></span> Signin</a>
         </div>
        <div  class="col-md-3">
         <button title="Click to Clear Input" type="reset" value="reset" data-toggle="tooltip"  class="btn btn-default" ><span class="glyphicon glyphicon-erase"></span> Clear</button>
</div>
          <div class="col-md-2">
        <label></label>
        <button type="button"  name="sub" id="reg_btn" class="btn  btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
        </div>
         
        </div>

       
  
</fieldset>
