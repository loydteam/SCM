<?php

$U = User::$User;

//var_dump(User::$User);
?>

<center> 
<h1>My Profile Edit</h1><br/>

<table style="width:10%">
  <tr>
      <td>
          

<section class="my-profile-edit">
    
        <label for="Email">Email:<br/>
            <input type="email" name="Email" placeholder="yourname@email.com" value="<?php echo $U->Email;?>" required>
            <label class="E"></label>
        </label><br/>
        
        <label for="Pass">Password:<br/>
        <input type="password" name="Pass" placeholder="password" required>
        <label class="E"></label>
        </label><br/>      
        
        <label for="Pass2">Re enter Password:<br/>
        <input type="password" name="Pass2" placeholder="password" required>
        <label class="E"></label>
        </label><br/>    
        
        <label for="FirstName">First Name:<br/>
        <input type="text" name="FirstName" placeholder="First Name" value="<?php echo $U->FirstName;?>" required>
        <label class="E"></label>
        </label><br/>  
        
        <label for="LastName">Last Name:<br/>
        <input type="text" name="LastName" placeholder="Last Name" value="<?php echo $U->LastName;?>" required>
        <label class="E"></label>
        </label><br/>
         
        <br/>
        <label for="g-recaptcha-response">
        <div class="g-recaptcha" data-sitekey="6LejaxkTAAAAAKL1SZUnrd9I5TL__3cj61E5vKUR"></div>
        <label class="E"></label>
        </label>
        <br/>
        <button type="button" class="my-profile-edit-bytton">Edit</button>
</section>

          
      </td>
  </tr>
</table>          
          
</center>