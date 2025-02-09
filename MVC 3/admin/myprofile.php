<?php
include "includes/db.php";
?>
<!doctype html>
<html lang="en">

<head>
    <!-- important meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1">

    <!-- Title-->
    <title>Notes-MarketPlace</title>

    <!--Favicon-->
    <link rel="shortcut icon" href="images/Homepage/favicon.ico">

    <!-- Goggle Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!--Fontawesom -->
    <link rel="stylesheet" href="css/font-awesom/css/font-awesome.min.css">

    <!--Bootstrap Css-->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css.css">

    <!-- custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!--responsive css-->
    <link rel="stylesheet" href="css/responsive.css">
    <script type="text/javascript">
        function validate(){
            
            var fname=document.form.fname.value;
            var lname=document.form.lname.value;
            var email=document.form.email.value;
            var email1=document.form.email1.value;
            var phone=document.form.phone.value;
            var img=document.form.img.value;
            
            if(!fname || !lname || !email || !phone || !email1 || !img){
                
                alert('enter all required fields');
                return false;
            }
            if(phone.length>10 || phone.length<10){
                alert("phone no should be 10 digit only!!");
                document.form.phone.focus();
                return false;
            }
            if(!/^\d{10}$/.test(phone)){
                alert("enter valid phone no");
                return false;
            }
            if(!/^[a-zA-Z]+$/.test(fname)){
                alert("Numeric value not allowed in first name");
                return false;
            }
            if(!/^[a-zA-Z]+$/.test(lname)){
                alert("Numeric value not allowed in last name");
                return false;
            }
            else{
                return true;
            }
        }
        
    </script>
</head>

<body>
    <!-- Preloader -->
<!--
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
-->
    <!--Header-->
    <?php
    include "includes/header.php";    
    ?>
    <?php
    $id_member=$_SESSION['id'];
    $fname='';
    $lname='';
    $email='';
    $query="SELECT * FROM users WHERE ID='{$id_member}'";
    $result=mysqli_query($conn,$query);
    while($row=mysqli_fetch_assoc($result)){
        $fname1=$row['FirstName'];
        $lname1=$row['LastName'];
        $email1=$row['EmailID'];
    }
    $count=mysqli_num_rows($result);
    if($count>0 && isset($_POST['profile'])){
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $semail=$_POST['email1'];
        
        
        $target_dir="../member/$id_member/";
        mkdir($target_dir);
        $file=basename($_FILES['img']['name']);
        $new=$target_dir."DP_".time();
        $p=rename($file,$new);
        move_uploaded_file($_FILES['img']['tmp_name'],$new);
        
        
        $phn=$_POST['phone'];
        $cc=$_POST['cc'];
        $dt=date('Y-m-d h:i:s');
        $query5="SELECT * FROM userprofile WHERE UserID='{$id_member}'";
        $result5=mysqli_query($conn,$query5);
        $count5=mysqli_num_rows($result5);
        if($count5==0){
         $query_userp="INSERT INTO userprofile(ID,UserID,DOB,Gender,SecondaryEmailAddress,CoutryCode,PhoneNumber,ProfilePicture,AddressLine1,AddressLine2,City,State,ZipCode,Country,University,College,CreatedDate,CreatedBy,ModifiedDate,ModifiedBy) VALUES('','{$id_member}','','7','{$semail}','{$cc}','{$phn}','{$new}','','','','','','','','','{$dt}','','','')";
        $result1=mysqli_query($conn,$query_userp);
        if(!$result1){
            die("fail".mysqli_error($conn));
        }   
        }
        else{
            $query_userp="UPDATE userprofile SET SecondaryEmailAddress='{$semail}',CoutryCode='{$cc}',Phonenumber='{$phn}',ProfilePicture='{$new}' WHERE UserID='{$id_member}'";
            $result2=mysqli_query($conn,$query_userp);
            if(!$result2){
                die("fai".mysqli_error($conn));
            }
        }
        
        $query_user="UPDATE users SET FirstName='{$fname}',LastName='{$lname}',EmailID='{$email1}' WHERE ID='{$id_member}'";
        $result2=mysqli_query($conn,$query_user);
        if(!$result2){
            die("fai".mysqli_error($conn));
        }
    }
    else if(isset($_POST['profile'])){
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $semail=$_POST['email1'];
        $img=$_FILES['img']['name'];
        
        $target_dir="../member/$id_member/";
        mkdir($target_dir);
        $file=basename($_FILES['img']['name']);
        $new=$target_dir."DP_".time();
        $p=rename($file,$new);
        move_uploaded_file($_FILES['img']['tmp_name'],$new);
        
        $phn=$_POST['phone'];
        $cc=$_POST['cc'];
        $dt=date('Y-m-d h:i:s');
        $query="INSERT INTO userprofile(ID,UserID,DOB,Gender,SecondaryEmailAddress,CoutryCode,PhoneNumber,ProfilePicture,AddressLine1,AddressLine2,City,State,ZipCode,Country,University,College,CreatedDate,CreatedBy,ModifiedDate,ModifiedBy)   VALUES('','{$id_member}','','','{$semail}','{$cc}','{$phn}','{$new}','','','','','','','','','{$dt}','','','')";
        $result=mysqli_query($conn,$query);
    }
    ?>
    <!--Content-->
    <form method="post" name="form" onsubmit="return(validate());" enctype="multipart/form-data">
    <section id="my-profile-admin">
        <div class="my-profile">
            <h1 class="admin-heading">My Profile</h1>
            <div class="form-group-left form-admin">
                <label for="exampleInputEmail1"><span class="label">First Name*</span></label>
                <input type="text" class="form-control user user1" id="exampleInputEmail1"
                    name="fname" aria-describedby="emailHelp" placeholder="Enter Your Email" value="<?php echo $fname1;  ?>">
            </div>
            <div class="form-group-left form-admin">
                <label for="exampleInputEmail1"><span class="label">Last Name*</span></label>
                <input type="text" class="form-control user user1" id="exampleInputEmail1"
                    name="lname" aria-describedby="emailHelp" placeholder="Enter Your Email" value="<?php echo $lname1; ?>">
            </div>
            <div class="form-group-left form-admin">
                <label for="exampleInputEmail1"><span class="label">Email*</span></label>
                <?php
                if($email1){
                    echo "<input type='text' class='form-control user user1' id='exampleInputEmail1'
                    name='email' aria-describedby='emailHelp' placeholder='Enter Your Email' value=$email1 disabled>";
                }
                else{
                   echo "<input type='text' class='form-control user user1' id='exampleInputEmail1'
                    name='email' aria-describedby='emailHelp' placeholder='Enter Your Email' value=$email1>";
                }
                
                ?>
               
            </div>
            <div class="form-group-left form-admin">
                <label for="exampleInputEmail1"><span class="label">Secondary Email</span></label>
                <input type="text" class="form-control user user1" id="exampleInputEmail1"
                    name="email1" aria-describedby="emailHelp">
            </div>
            <div class="form-group-left form-admin">
                <label for="exampleInputEmail1"><span class="label">Phone Number</span></label><br>
                <select name="cc" class="custom-select-01 form-control user user1 admin-select">
                   
                    <option value="+91">+91</option>
                    <option value="+81">+81</option>
                    <option value="+90">+90</option>
                    <input type="text" id="phone" name="phone" class="form-control user tel-admin"
                        maxlength="10" >
                </select>
            </div>
            <div class="form-group-left form-admin">
                <label for="exampleFormControlTextarea1"><span class="label">Profile
                        Picture</span></label>
                <input type="file" class="form-control user" id="img" 
                    title="upload a picture" style="height:100px;width:650px;" name='img' accept="image/jpeg">
                
            </div>
        </div>
    </section>
    <button type="submit" class="btn-userP btn-admin"
    name="profile" value="Cancel">SUBMIT</button>
    </form>
    <hr>
    
    

    <!--Footer-->
    <footer id="footer">
        <p>
            <span class="footer-p">Version : 1.1.24</span>
            <span class="footer2">Copyright &copy; TatvaSoft All rights reserved.</span>
        </p>
    </footer>
    <!--Footer Ends-->

    <!-- jQuery -->
    <script src="js/jquery.min.js.js"></script>

    <!-- BootStrap js -->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!-- Custom js -->
    <script src="js/script.js"></script>

</body>

</html>