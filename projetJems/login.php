<?php 


  

	$title = 'se connecter';
	include 'header.php';


	
?>


<body style="font-family: Bangers, cursive;">
    <div class="login-clean mt-5">
        <form method="post">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="fas fa-user-lock"></i></div>
            <div class="form-group"><input class="form-control" type="email" name="login" placeholder="&#128512 Email"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="&#128272 Mot de passe"></div>
            <div class="form-group"><button class="btn btn-secondary btn-block " data-bs-hover-animate="pulse" type="submit" href="index.php">se connecter</button>
        </div>
        <a class="forgot" href="#">perdu votre email ou votre mot de passe?</a></form>
    </div>

</body>

</html>
<?php 
include 'footer.php';?>