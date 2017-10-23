<?php
    include "php/connect.php";
    if(!isset($_SESSION['username'])){
        $conn->close();
        header("Location: index.php?error=3");
        exit();
    }

?>

<!DOCTYPE html>
<html>
<amount>ExpenseIT</amount>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="jquery.validate.min.js"></script>
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>

<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right">ExpenseIT</span> 
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="images/avatar.png" class="w3-circle w3-margin-right w3-margin-top" style="width:50px">
    </div>
    <div class="w3-col s8 w3-bar w3-margin-top">
      <span>Welcome, <strong><?php echo($_SESSION['username'])?></strong></span><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
      <a href="php/logOut.php" class="w3-bar-item w3-button"><i class="fa fa-close"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Options</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" amount="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  Overview</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bar-chart"></i>  Graphs</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-tag"></i>  Types</a><br><br>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" amount="close side menu" id="myOverlay"></div>

<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
<!-- !PAGE CONTENT! -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i>My Expenses</b></h5>
  </header>

  <div class="w3-container">
    <h5>Expenses</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
      <tr>
        <th>Type of Expense</th>
        <th>Description(Optional)</th>
        <th>Date</th>
        <th>Amount</th>
      <?php
        $id = $_SESSION['id'];
        $query="SELECT PRICE, DATE, TYPE, DESCRIPTION FROM EXPENSE INNER JOIN TYPE ON EXPENSE.Type_IDType = TYPE.IDType WHERE EXPENSE.Type_User_idUser='$id' ORDER BY DATE DESC";
        $result = $conn->query($query);
        $total = 0;

        //Used to check if matches the current same
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['TYPE'] . "</td>";
                echo "<td>" . $row['DESCRIPTION'] . "</td>";
                echo "<td>" . $row['DATE'] . "</td>";
                echo "<td>" . $row['PRICE'] . " DKK</td>";
                echo "</tr>";
            }
        }
        else {
            echo "<tr>";
            echo "<td colspan='4'> No Results Found </td>";
            echo "</tr>";
        }
        $currentMonth = date("n");
        $query = "SELECT SUM(PRICE) as TOTAL, MONTH(DATE) as m, YEAR(DATE) as y
                    FROM EXPENSE 
                    WHERE EXPENSE.Type_User_idUser='$id'
                    GROUP BY MONTH(DATE), year(DATE)
                    HAVING m='$currentMonth'";
        $result = $conn->query($query);
        $total = $result->fetch_assoc();
        echo "<tr>";
        echo "<td colspan='3'> <b>Total this month:</b> </td>";
        echo "<td><b>" . $total['TOTAL'] . " DKK</b></td>";
        echo "</tr>";
      ?>
    </table><br>
  </div>
  <style>
        input[type="date"]:before {
            content: attr(placeholder) !important;
            color: #aaa;
            margin-right: 0.5em;
        }
        input[type="date"]:focus:before,
        input[type="date"]:valid:before {
            content: "";
        }
  </style>
    <form id="expenseForm" method="post" class="w3-container" action="php/insertExpense.php">
        <h5>Add Expense</h5>
        <input type="text" class="w3-input" name="amount" placeholder="Amount" />
        <input list="types" class="w3-input" name="type" placeholder="Type">
            <datalist id="types">
                <!-- Options from Database -->
                <?php
                    $id = $_SESSION['id'];
                    $query="SELECT TYPE FROM TYPE WHERE User_idUser='$id'";
                    $result = $conn->query($query);
                    
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $type = $row['TYPE'];
                            echo ("<option value='$type'>");
                        }
                    }
                ?>
            </datalist>
        </input>
        <input type="date" class="w3-input" name="date" placeholder="(If empty, sets today)"/>
        <input type="text" class="w3-input" name="description" placeholder="Description (Optional)" />
        <br>
        <input type="submit" value="Add Expense" class="w3-button w3-dark-grey"></input>
    </form>
  </div>
  <hr>

  <!-- Footer -->
  <footer class="w3-container w3-bottom w3-padding-16 w3-light-grey">
    <h4>FOOTER</h4>
    <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    <p>Code by Tiago Ribeiro</a></p>
  </footer>

  <!-- End page content -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}

$(document).ready(function() {
    var amountValidators = {
            row: '.col-xs-4',   // The amount is placed inside a <div class="col-xs-4"> element
            validators: {
                notEmpty: {
                    message: 'The amount is required'
                },
                numeric:{
                   message: 'The description must  be a numeric number'
                }
            }
        },
        typeValidators = {
            row: '.col-xs-4',
            validators: {
                notEmpty: {
                    message: 'The type is required'
                },
                type: {
                    message: 'The type is not valid'
                }
            }
        },
        descriptionValidators = {
            row: '.col-xs-2',
        },
        expenseIndex = 0;

    $('#expenseForm')
        // Add button click handler
        .on('click', '.addButton', function() {
            expenseIndex++;
            var $template = $('#expenseTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-expense-index', expenseIndex)
                                .insertBefore($template);

            // Update the name attributes
            $clone
                .find('[name="amount"]').attr('name', 'expense[' + expenseIndex + '].amount').end()
                .find('[name="type"]').attr('name', 'expense[' + expenseIndex + '].type').end()
                .find('[name="description"]').attr('name', 'expense[' + expenseIndex + '].description').end();
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row  = $(this).parents('.form-group'),
                index = $row.attr('data-expense-index');
            // Remove element containing the fields
            $row.remove();
        });
});
</script>

</body>
</html>