
  <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
    }

    .topnav {
      overflow: hidden;
      background-color: #253a55;
      /*
      margin-left solution
       */
    }

    .topnav a {
      float: left;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;
    }

    .topnav a:hover {
      background-color: #ddd;
      color: black;
    }

    .topnav a.active {
      background-color: #324e6c;
      color: white;
    }


    .dropdown {
      float: left;
      overflow: hidden;
    }

    .dropdown .dropbtn {
      font-size: 16px;
      border: none;
      outline: none;
      color: white;
      padding: 14px 16px;
      background-color: inherit;
      font-family: inherit;
      margin: 0;
    }

    .navbar a:hover, .dropdown:hover .dropbtn {
      background-color: #00950c;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 68, 255, 0.2);
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

    .dropdown-content a:hover {
      background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

  </style>



<div class="topnav">
  <a class="active" href="./index.php">Home</a>

    <?php
    if (isset($_SESSION['uname'])) {
        if ($_SESSION['ugroup']!=='Subscriber') {
            $sg = $_SESSION['ugroup'];
            echo "
            <div class='dropdown'>
                    <button class='dropbtn'>$sg Panel
            ";
            echo '
                  <!--i class="fa fa-caret-down"></i-->
                  <i class=""></i>
                    </button>
                    <div class="dropdown-content">
                      <a href="./dashboard.php">Dashboard</a>
                      <a href="./trackers.php">Trackers</a>
                      <a href="./accounts.php">Accounts</a>
                      <a href="./view_profile.php">View Profile</a>
                      <a href="./edit_profile.php">Edit Profile</a>
                      <a href="./profile_picture.php">Change Profile Picture</a>
                      <a href="./change_password.php">Change Password</a>
                      <a href="./logout.php">Logout</a>
                    </div>
                  </div>
            ';
        } else {
            echo '
            <div class="dropdown">
                <button class="dropbtn">User Panel
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                  <a href="./dashboard.php">Dashboard</a>
                  <a href="./my_trackers.php">Trackers</a>
                  <a href="./view_profile.php">View Profile</a>
                  <a href="./edit_profile.php">Edit Profile</a>
                  <a href="./change_password.php">Change Password</a>
                  <a href="./logout.php">Logout</a>
                </div>
              </div>
       <a href="./logout.php">Logout</a>
       <a href="#contact">Contact</a>
       <a href="#about">About</a>
      ';
        }
    } else {
        echo '
       <a href="./login.php">Login</a>
       <a href="./contact.php">Contact</a>
       <a href="./privacy-policy.php">Privacy Policy</a>
       <a href="./about.php">About</a>
      ';
    }
    ?>

</div>



