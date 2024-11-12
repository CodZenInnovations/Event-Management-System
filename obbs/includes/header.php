<div class="header">
    <div class="container">
        <div class="header-top-grids">
            <div class="agileits-logo">
                <h1><a href="index.php">OEMS</a></h1>
            </div>
            <div class="top-nav">
                <nav class="navbar navbar-default">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
                        <nav>
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="index.php">Home</a></li>
                                <li><a href="about.php">About</a></li>
                                <li><a href="services.php">Events</a></li>
                                <?php if (strlen($_SESSION['obbsuid'] != 0)) { ?>
                                <li class="">
                                    <a href="#" class="dropdown-toggle hvr-bounce-to-bottom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a class="hvr-bounce-to-bottom" href="profile.php">Profile</a></li>
                                        <li><a class="hvr-bounce-to-bottom" href="booking-history.php">Booking History</a></li>
                                        <li><a class="hvr-bounce-to-bottom" href="change-password.php">Change Password</a></li>
                                        <li><a class="hvr-bounce-to-bottom" href="logout.php">Logout</a></li>
                                    </ul>
                                </li>
                                <?php } ?>
                                <li><a href="mail.php">Mail Us</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- /.navbar-collapse -->
                </nav>
            </div>

            <!-- Button and links in the same line -->
            <div class="row" style="display: flex; align-items: center; justify-content: flex-end; position: relative;">
                <!-- Button with hover effect and no caption -->
                <button id="toggle-links-btn" class="btn btn-primary" style=" border: none; padding: 10px 20px; cursor: pointer; margin-left: 15px; margin-top: -70px;">
                    <!-- Optionally, add an icon inside the button (example: font-awesome) -->
                    <i class="fa fa-bars" aria-hidden="true"></i> <!-- Optional -->
                </button>

                <!-- Hidden links that will be shown when button is clicked, placed to the right -->
                <div id="login-register-links" style="display: none; position: absolute; top: -60px; left: calc(100% + 10px); margin-top: -20px;">
                    <ul style="list-style: none; padding-left: 0; margin: 0;  border-radius: 5px;">
                        <?php if (strlen($_SESSION['obbsuid'] == 0)) { ?>
                        <li style="margin-bottom: 5px;"><a href="login.php" style=" text-decoration: none; display: block; padding: 5px 5px;">Login</a></li>
                        <li style="margin-bottom: 5px;"><a href="signup.php" style=" text-decoration: none; display: block; padding: 5px 5px;">Register</a></li>
                        <li><a href="admin/login.php" style=" text-decoration: none; display: block; padding: 5px 5px;">Admin</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- JavaScript to handle button click and toggle the visibility of links -->
<script>
    document.getElementById('toggle-links-btn').addEventListener('click', function() {
        var links = document.getElementById('login-register-links');
        if (links.style.display === 'none' || links.style.display === '') {
            links.style.display = 'block'; // Show links in a vertical list when button is clicked
        } else {
            links.style.display = 'none'; // Hide links when button is clicked again
        }
    });
</script>

<!-- CSS for hover effects -->
<style>
    /* Fixed button positioning */
    #toggle-links-btn {
        position: relative; /* Ensures it stays in place */
    }

    /* Hover effect for the button */
    #toggle-links-btn:hover {
        background-color:  black; /* Color change on hover */
        color: white; /* Text color change on hover */
    }
    #login-register-links:hover {
       
        color: red; /* Text color change on hover */
    }
    /* Style for login/register/admin links */
    #login-register-links {
        z-index: 10; /* Ensures it appears above other elements */
        width: 100px; /* Set a width for the dropdown */
        font: 1em sans-serif;
        font-weight: 700;
        background:mix-blend-multiply;
    }

    /* Align the button and links in a single row */
    .row {
        position: relative;
        width: 100%;
    }
    
    
</style>
