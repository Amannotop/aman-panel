<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center pt-5">
    <div class="col-lg-4">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="card shadow-sm mb-5">
            <div class="card-header h5 p-3">
                Login
            </div>
            <div class="card-body">
                <?= form_open() ?>
                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control mt-2" name="username" id="username" aria-describedby="help-username" placeholder="Your username" required minlength="4">
                    <?php if ($validation->hasError('username')) : ?>
                        <small id="help-username" class="form-text text-danger"><?= $validation->getError('username') ?></small>
                    <?php endif; ?>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control mt-2" name="password" id="password" aria-describedby="help-password" placeholder="Your password" required minlength="6">
                    <?php if ($validation->hasError('password')) : ?>
                        <small id="help-password" class="form-text text-danger"><?= $validation->getError('password') ?></small>
                    <?php endif; ?>
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label" data-bs-toggle="tooltip" data-bs-placement="top" title="Keep session more than 30 minutes">
                        <input type="checkbox" class="form-check-input" name="stay_log" id="stay_log" value="yes">
                        Stay login?
                    </label>
                </div>
                <div class="form-group mb-2">
                    <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-box-arrow-in-right"></i> Log in</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
        
        
        
        
        
        
        
  

<p class="text-center text-muted after-card">
            <small class="bg-white px-auto p-2 rounded">
                
    
           
        
       <?php
       


       
$buttonText = "Install BGMI 2.7 IOS";
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Style the button */
        .install-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        /* Hover effect */
        .install-button:hover {
            background-color: #2980b9;
        }
        /* Center the button */
        .center {
            text-align: center;
            margin-top: 50px; /* Add space from the top if needed */
        }
    </style>
</head>
<body>
    <a class="install-button" href="https://t.me/cheatbot_tele"><?php echo $buttonText; ?></a>
</body>
</html>
        

 </small>
        </p>









<p class="text-center text-muted after-card">
            <small class="bg-white px-auto p-2 rounded">
                
    
           
        
       <?php
       


       
$buttonTextgl = "Install GLOBAL 2.7 IOS";
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Style the button */
        .install-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        /* Hover effect */
        .install-button:hover {
            background-color: #2980b9;
        }
        /* Center the button */
        .center {
            text-align: center;
            margin-top: 50px; /* Add space from the top if needed */
        }
    </style>
</head>
<body>
    <a class="install-button" href="https://t.me/cheatbot_tele"><?php echo $buttonTextgl; ?></a>
</body>
</html>
        

 </small>
        </p>

        
        
        
        
        
        
        <p class="text-center text-muted after-card">
            <small class="bg-white px-auto p-2 rounded">
                Register as Reseller?
                <a href="<?= site_url('register') ?>" class="text-info">Register here</a>
            </small>
        </p>
        
        
        
        

        
        
 





        
    </div>
</div>

<?= $this->endSection() ?>