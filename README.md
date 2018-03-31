# Basic Codeigniter Sign-in Class

## Installation

Place `Teknicode_signin.php` into you application/libraries directory.

Setup a users mysql database table with the following fields:
id (int) Primary Key Auto Increment, username (varchar 255), password (varchar 255), last_update (datetime)

## Usage

#### Load the library 

Add `teknicode_signin` to the `$autoload['libraries']` array in application/config/autoload.php

Alternatively you can load in the controller using

```php
$this->load->library("teknicode_signin")
```

#### Create a Login controller

```php
class Login extends CI_Controller {
    public function __construct(){
        parent::__construct();
        /*
        * if $_POST['username'] && $_POST['password'] exist,
        * this class function will attempt to login 
        */
        $this->teknicode_signin->login();
    }
    
    public function index(){
        /*
        * A visit to base_url("login") will land here, destroy the user session
        * and show your login template
        */
        $this->teknicode_signin->logout();
        $this->load->view('login');
    }
}
```

#### Force user to login

To force a user login, add this to the `__construct` function of the controller in question.
All routes through that controller will require login before access is granted.

```php
$this->teknicode_signin->secure();
```
If your controller doesn't have a `__construct` function use you'll need to create one.

```php
public function __construct(){
    parent::__construct();
    $this->teknicode_signin->secure();
}
```

#### How it works

If a user session isn't present a redirection will occur to

```
base_url("login");
```

#### Create a login page

Your login page should post "username" and "password" to `base_url("login");`. Here is a basic login page using Bootstrap 4.

```html
<!DOCTYPE html>
<html class="h-100">
<head>
    <title>My Application</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
</head>
<body class="h-100 bg-primary d-flex align-items-center">

<div class="mx-auto bg-light rounded p-3 text-center" style="width:400px;max-width:100%;">
    <form action="" method="post">
    <h3 class="mt-3 mb-4">Login</h3>
        
        <!--
        DISPLAY SUCCESSFUL LOGOUT MESSAGE
        -->
        <?php if( !empty($this->session->flashdata('logout_msg')) ){ ?>
        <div class="alert alert-success"><?=$this->session->flashdata('logout_msg')?></div>
        <?php } ?>
        <!--END-->
        
        <!--
        DISPLAY THE FAILED LOGIN MESSAGE
        -->
        <?php if( $this->session->flashdata('login_failed_msg') ){ ?>
            <div class="alert alert-danger"><?=$this->session->flashdata('login_failed_msg')?></div>
        <?php } ?>
        <!--END-->
        
    <div class="form-group">
        <input type="text" class="form-control form-control-lg text-center" id="username" name="username" placeholder="Username">
    </div>
    <div class="form-group">
        <input type="password" class="form-control form-control-lg text-center" id="password" name="password" placeholder="Password">
    </div>
    <div class="form-group mt-4">
        <button class="btn btn-primary btn-lg">Login</button>
    </div>
    </form>
</div>

</body>
</html>
```

#### Copyright

Copyright 2018 Teknicode

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.