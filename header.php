<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Tradetex</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">  
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css">
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom_style.css">
   
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	   
   <link rel="icon" href="<?php echo base_url();?>assets/images/trade-fav.ico" type="image/gif" sizes="16x16">
  </head>
<style>


  #eth_msg {
	color: red;
	font-size: 16px;
	margin: 10px;
}

.btc_err {
	color: red;
	font-size: 16px;
	margin: 10px;
}


  
  
.token_head h3 {
	margin: 0;
	font-size: 21px;
}
.token_head {
	background: #dc9901;
	font-size: 29px;
	padding: 12px;
}

@media only screen and (max-width : 480px) {

	
}


@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}


.total132 {
    height: 100%;
    width: 100%;
    z-index: 999999999;
    float: left;
    position: fixed;
    text-align: center;
    background-color: #00000061;
}
.total132 .loader  {
	position: absolute;
	top: 0;
	bottom: 0;
	right: 0;
	left: 0;
	margin: auto;
}


.currency input {
	width: 70%;
	height: 27px;
	text-indent: 10px;
	float: left;
}
.amount input {
	width: 70%;
	height: 27px;
	text-indent: 10px;
	float: left;
}
.currency.primaryCurrency {
	background: #222126 !important;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.chytjtj {
    background: none;
    border: none;
    color: #fff;
	
}
.total-investments span{
color: #232127;
}


</style>
<link rel="stylesheet" type="text/css" href="/DataTables/datatables.css">
 
<script type="text/javascript" charset="utf8" src="/DataTables/datatables.js"></script>

<script>
$(document).ready( function () {
    $('#example').DataTable();
} );
</script>
<body>
  
	<div id="use_id" style="display:none"><?php if(isset($_SESSION['users']['user_id'] )){echo $_SESSION['users']['user_id'] ;}?></div>
	<div id="dashboard" class="dashboard-wrapper">
	  <div class="dash-header">
	    <div class="container-fluid">
		   <div class="row">
		      <div class="col-md-12 col-sm-12 col-xs-12">
				   <div class="col-md-3 col-sm-3 col-xs-4">
				     <div class="">
				     <a class="brand" href="<?php echo base_url();?>"> <img class="img-responsive" src="<?php echo base_url();?>assets/images/logo.png" alt="logo"> </a>
				   </div>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-8"> 
				<nav class="navbar navbar-default" style="  border:  none; background:  no-repeat;"> 
								<div class="navbar-header">
								    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
									    <span class="sr-only">Toggle navigation</span>
									    <span class="icon-bar"></span>
									    <span class="icon-bar"></span>
										<span class="icon-bar"></span>
								    </button>	
		    					</div>
		        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">				
				     <ul class="nav-bar">
					  <li class="active"><a href="<?php echo base_url('user/support');?>"><i class="fa fa-question-circle" aria-hidden="true"></i>Support</a></li>
					  <li class="active"><a href="<?php echo base_url('user/setting');?>"><i class="fa fa-cogs" aria-hidden="true"></i>Settings</a></li>
					<?php  
					   if(isset($_SESSION['users']['user_id'] ))
					   {
						?>
						<li class="active"><a href="<?php echo base_url('user/logout');?>"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>
						<?php   
					   }
					   else{?>
					   
					   <li class="active"><a href="<?php echo base_url('user/logout');?>"><i class="fa fa-sign-out" aria-hidden="true"></i>Login</a></li>
					    <li class="active"><a href="<?php echo base_url('user/signup');?>"><i class="fa fa-sign-out" aria-hidden="true"></i>Signup</a></li>
					   
					   <?php
						   
					   }
					?>
					
					  
					  
					  </ul>
				</div>
				</nav>
				</div>				
			  </div>
		   </div>
		</div>
	  </div>
	  </div>

<nav class="navbar navbar-inverse top-tabs1">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse"          data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
       <ul class="nav navbar-nav">
      <li class="active"><a href="<?php echo base_url('user/balance'); ?>">Balance</a></li>
      <li class="active"><a href="<?php echo base_url('user/dashboard'); ?>">Dashboard</a></li>
	  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Exchange <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo base_url('user/user_settings'); ?>">Exchange</a></li>
          <li><a href="<?php echo base_url('user/margin_trading'); ?>">Margin Exchange</a></li>
		  <li><a href="<?php echo base_url('user/virtual_trading'); ?>">virtual_trading</a></li>
         

        </ul>
      </li>
	  <?php     
		if(isset($_SESSION['users']['user_id']))
	  {
	  
	  ?>
       <li><a href="<?php echo base_url('user/buy_tocken'); ?>">BuyToken</a></li>
      <li><a href="<?php echo base_url('user/start_stack'); ?>">Staking</a></li>
      <li><a href="<?php echo base_url('user/lendings'); ?>">Lending</a></li>
	   <li><a href="<?php echo base_url('user/profit_wallet'); ?>">Profit Wallet</a></li>
	  <?php }?>
    <!--  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Funds <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo base_url('user/Withdrawals'); ?>">Withdrawals</a></li>
          <li><a href="<?php echo base_url('user/Deposits'); ?>">Deposits</a></li>
          <li><a href="<?php echo base_url('user/profits'); ?>">Profits</a></li>

        </ul>
      </li>-->
    </ul>
    </div>
  </div>
</nav>

<script src="https://use.fontawesome.com/70df1ffdcc.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
   <script>
    
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {
    var myDropdown = document.getElementById("myDropdown");
      if (myDropdown.classList.contains('show')) {
        myDropdown.classList.remove('show');
      }
  }
}
</script>