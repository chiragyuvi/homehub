<header id="header" class="transparent-header-modern fixed-header-bg-white w-100">
            <div class="top-header bg-secondary">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="top-contact list-text-white  d-table">
                                <li><a href="#"><i class="fas fa-phone-alt text-success mr-1"></i>+91 1800-765-4321</a></li>
                                <li><a href="#"><i class="fas fa-envelope text-success mr-1"></i>homehub@realestate.com</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="top-contact float-right">
                                <ul class="list-text-white d-table">
								<li><i class="fas fa-user text-success mr-1"></i>
								<?php  if(isset($_SESSION['uemail']))
								{ ?>
								<a href="logout.php">Logout</a>&nbsp;&nbsp;<?php } else { ?>
								<a href="login.php">Login</a>&nbsp;&nbsp;
								
								| </li>
								<li><i class="fas fa-user-plus text-success mr-1"></i><a href="register.php"> Register</li><?php } ?>
								</ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-nav secondary-nav hover-success-nav py-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <nav class="navbar navbar-expand-lg navbar-light p-0"> <a class="navbar-brand position-relative" href="index.php"><img class="nav-logo" src="images/logo/brand.png" alt=""></a>
                            <style>
.navbar {
    height: 40px; 
    padding: 0 !;
    display: flex ;
    align-items: center; 
}

.navbar-brand {
    margin: 0 ; 
    display: flex ;
    align-items: center ;
    padding-left: 10px; 
}

.nav-logo {
    height: 40px ; 
    width: auto ; 
    max-height: 100% ; 
    margin-top: 0 ; 
}
/* #header.transparent-header-modern {
    background: transparent !important; /* Make the entire header transparent */
    /* position: fixed; Keep it fixed at the top */
    /* width: 100%; Ensure it spans the full width */
    /* z-index: 1000; Ensure it's above other content */
/* } */

/* #header.transparent-header-modern .top-header { */
    /* background: rgba(0, 0, 0, 0.5); Semi-transparent background for top bar */
    /* color: white; Text color for top bar */
/* } */

/* #header.transparent-header-modern .main-nav {
    background: transparent; /* Make the main nav transparent */
    /* color: white; Text color for main nav */
/* } */ 

/* #header.transparent-header-modern .navbar-nav .nav-link,
#header.transparent-header-modern .top-contact a,
#header.transparent-header-modern .top-contact li,
#header.transparent-header-modern .navbar-brand img {
    color: white; /* Ensure all text and logo are white */
/* }  */
</style>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav mr-auto">
                                        <li class="nav-item dropdown"> <a class="nav-link" href="index.php" role="button" aria-haspopup="true" aria-expanded="false">Home</a></li>
										
										<li class="nav-item"> <a class="nav-link" href="about.php">About</a> </li>
										
                                        <li class="nav-item"> <a class="nav-link" href="contact.php">Contact</a> </li>										
										
                                        <li class="nav-item"> <a class="nav-link" href="property.php">Properties</a> </li>
                                        
                                        <li class="nav-item"> <a class="nav-link" href="agent.php">Agent</a> </li>
                                        <li class="nav-item">  <a class="nav-link" href="designer.php">Interior Designers</a></li>
                                        <li class="nav-item">  <a class="nav-link" href="loan.php">Loan</a></li>
                                        <li class="nav-item">  <a class="nav-link" href="https://copilot.cloud.microsoft/?fromCode=cmcv2&redirectId=61A0EEDDEF294E8C9A62A3ADC2284F62&auth=2">Chat with AI</a></li>

										
										<?php  if(isset($_SESSION['uemail']))
										{ ?>
										<li class="nav-item dropdown">
											<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>
											<ul class="dropdown-menu">
												<li class="nav-item"> <a class="nav-link" href="profile.php">Profile</a> </li>
												<!-- <li class="nav-item"> <a class="nav-link" href="request.php">Property Request</a> </li> -->
												<li class="nav-item"> <a class="nav-link" href="feature.php">Your Property</a> </li>
												<li class="nav-item"> <a class="nav-link" href="logout.php">Logout</a> </li>	
											</ul>
                                        </li>
										<?php } else { ?>
										<li class="nav-item"> <a class="nav-link" href="https://copilot.cloud.microsoft/?fromCode=cmcv2&redirectId=61A0EEDDEF294E8C9A62A3ADC2284F62&auth=2">Chat with AI</a> </li>
										<?php } ?>
										
                                    </ul>
                                    
									
									<a class="btn btn-success d-none d-xl-block" style="border-radius:30px;" href="submitproperty.php">Submit Peoperty</a> 
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>

      