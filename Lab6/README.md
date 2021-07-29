# LAB 6 Task

I believe I have implemented everything asked. You can check the codes and screenshots to verify. I am listing some implemented functions/features and information about the task.

- `screenshots/`: A folder. Contains all screenshots.
- `templates/`: A folder. Contains all the include/require static files.
- `uploads/`: A folder. Contains all the user uploaded image/data.
- `login.php`: Page for login. Strict data validation present.
- `forgot.php`: Lets user to see password by entering email address.
- `logout.php`: Logout code. Redirects to login page after logout.
- `registration.php`: Page for new user registration. Strict data validation present.
- `index.php`: Front page of the app. If logged in, redirects to dashboard.php
- `dashboard.php`: Front page for the logged in user. if logged out, redirects to login.php
- `view_profile.php`: View user data from database.
- `edit_profile.php`: To edit a profile data. Updated data also gets saved into database. Data validation also present on the backend.
- `profile_picture.php`: Allows to update/upload profile picture. Data validation present.
- `change_password.php`: Allows to change current password. Strict data validation present.
```
  If any one tries to access any of the page other than index.php and login.php without logged in then they will be redirect to login.php page.
```

## Features
- Mysql Database
- Session and Cookies implemented.

**Thanks**