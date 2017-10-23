<!DOCTYPE html>
<html>
<header>ExpenseIT</header>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="jquery.validate.min.js"></script>
</head>

<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">


<div class="w3-bar w3-top w3-black w3-large">
  <span class="w3-bar-item w3-right">ExpenseIT</span> 
</div>


<div class="w3-container w3-display-middle">
    <h5 class="w3-center">ExpenseIT Login</h5>
    <?php 
        if(isset($_GET['error'])) {
            if($_GET["error"] == 1){
                echo("<h5 class='w3-center' style='color:red'>Passwords do not match!</h5>");
            } else if ($_GET["error"] == 2) {
                echo("<h5 class='w3-center' style='color:red'>Email already registered!</h5>");
            }
            else { }
        }
        
    ?>
    <form class="w3-container" action="php/createUser.php" method="POST">
        <div class="w3-section">
            <label><b>Username</b></label>
            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="username" required>
            <label><b>E-Mail</b></label>
            <input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Enter Email" name="email" required>
            <label><b>Password</b></label>
            <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Enter Password" name="psw" required>
            <label><b>Confirm Password</b></label>
            <input class="w3-input w3-border" type="password" placeholder="Enter Password Again" name="pswC" required>
            <input class="w3-button w3-block w3-green w3-section w3-padding" type="submit"></input>
        </div>
    </form>
        
    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey w3-center">
        <span class="w3-center w3-padding"><a href="index.php">Back</a></span>
    </div>
</div>    
        


<footer class="w3-container w3-bottom w3-padding-16 w3-light-grey">
        <h4>FOOTER</h4>
        <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        <p>Code by Tiago Ribeiro</a></p>
</footer>
</body>    
</html>