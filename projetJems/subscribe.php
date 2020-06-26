<?php
$title = 's\'incrire';
include 'header.php';

$civility = '';                                     
$lastname = '';
$firstname = '';
$email = '';
$birthdate = '';
$password = '';
$password2 = '';
$cgu = '';
$errors = [];

                                      //==== création des variables de regex ====//
// ==== regex noms et prénoms ====//
$regexNames = '/^[a-zéèîïêëç]+((?:\-|\s)[a-zéèéîïêëç]+)?$/i';
// ==== année - mois - jour ==== //
$regexBirthdate = '/^((?:19|20)[0-9]{2})-((?:0[1-9])|(?:1[0-2]))-((?:0[1-9])|(?:1[0-9])|(?:2[0-9])|(?:3[01]))$/';
//==== regex mot de passe ====//
$regexpassword= '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}/';

//==== validation du formuliare ====//
$isSubmitted = false;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isSubmitted = true;
                                      // ==== validation des champs ====//

    //**********INFORMATION SUR LA PERSONNE**********//
    // ===== civilité ====/
    $civility = trim(filter_input(INPUT_POST, 'civility', FILTER_SANITIZE_STRING));
    if (empty('$civility')) {
        $errors['civility'] = 'Veuillez renseigner votre civilité!';
    } 
    // ==== Prénom ====//
    $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
    if (empty('$firstname')) {
        $errors['firstname'] = 'Veuillez renseigner votre prénom!';
    } elseif (!preg_match($regexNames, $firstname)) {
        $errors['firstname'] = 'Le champs n\'est pas valide!';
    }
    // ==== Nom ====//
    $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
    if (empty('$lastname')) {
        $errors['lastname'] = 'Veuillez renseigner votre nom!';
    } elseif (!preg_match($regexNames, $lastname)) {
        $errors['lastname'] = 'Le champs n\'est pas valide!';
    }
    // ==== date de naissance ====//
    // filtre la date de naissance
    $birthdate = trim(filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING));
    if (!empty($birthdate)) {
        // si input type date pas besoin DEBUT
        // convertion de la date avant de vérifier les données
        $birthdate = DateTime::createFromFormat('d/m/Y', $birthdate);
        $birthdate = $birthdate -> format('Y-m-d');
        // FIN

        // créé le timestamp d'aujourd'hui
        $today = strtotime("NOW");
        // timestamp de mon input date
        $convertBirthdate = strtotime($birthdate);
        if (!preg_match('/^((?:19|20)[0-9]{2})-((?:0[1-9])|(?:1[0-2]))-((?:0[1-9])|(?:1[0-9])|(?:2[0-9])|(?:3[01]))$/', $birthdate)) {
            $errors['birthdate'] = 'Veuillez renseigner une date correcte';
        }
        // vérifie que la date reste inférieur à NOW
        elseif ($convertBirthdate > $today) {
            $errors['birthdate'] = 'Votre date ne peut pas être supérieur à la date du jour';
        }
    }
    else{
        $errors['birthdate'] = 'Veuillez renseigner votre date de naissance';
    }
    // ==== email ====//
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
    if (empty('$email')) {
        $errors['email'] = 'Veuillez renseigner votre adresse email!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Le champs n\'est pas valide!';
    }
        if (!isset($_POST ['cgu'])){
        $errors['cgu'] = 'veuillez cocher la case pour envoyer le formulaire. <i class="far fa-smile-wink"></i>';
    }
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    if (empty($password)) {
        $errors['password'] = 'Merci de choisir votre mot de passe.';
    } elseif ($password != $password2) {
        $errors['password'] = 'Vos mots de passe ne correspondent pas.<i class="far fa-thumbs-down"></i>';
    } elseif (!preg_match($regexpassword, $password)) {
        $errors['password'] = '8 caractères(Majuscule,minuscule,chiffre et caractère special)minimum! <i class="far fa-smile-wink"></i> ';
    }
    if(count($errors) == 0){
        //==== transforme le tableau POST en chaîne de caractères ====//
        $user = serialize($_POST);
        //==== création du cookie d'utilisateur avec la chaine des P ====//
        setcookie('user',$user,time()+3600, '/', '', false, false);
    }
}

if($isSubmitted && count($errors) == 0): ?>

<div class="alert alert-success" role alert>
    Votre compte a été créé avec succès <i class="far fa-grin-alt"></i>!!!
</div>
<?php endif; ?>
<body>
    <div class="contact-clean mt-5">
        <form class="text-center  border-info" method="POST">
            <!-- //==== début du formulaire ====// -->
            <h1 class="text-center"><i class="fas fa-sign-in-alt"></i></h1>
            <!-- //==== civilité ====// -->
            <label class="text-left" style="margin: 8px;font-size: 22px;">Monsieur</label>
            <input type="radio" name="civility" value="Monsieur">
            <label class="text-center" style="margin: 13px;font-size: 23px;">Madame</label>
            <input type="radio" name="civility" value="Madame">
            <!-- //==== Nom ====// -->

            <div class="form-group">
                <!-- <label for="lastname">Nom</label> -->
                <input class="form-control text-center" value="<?=$lastname?>" type="text" name="lastname" placeholder="Nom">
                <span class="error"><?= $errors['lastname'] ?? '' ?></span>
            </div>
            <!-- //==== Prénom ====// -->

            <div class="form-group">
                <!-- <label for="firstname">Prénom</label> -->
                <input class="form-control text-center" value="<?=$firstname?>" type="text" name="firstname" placeholder="Prénom">
                <span class="error"><?= $errors['firstname'] ?? '' ?></span>
            </div>
            <!-- //==== Date de naissance ====// -->
            <div class="form-group">
                <!-- <label for="birthdate">Date de naissance</label> -->
                <input class="form-control text-center" value="<?=preg_replace($regexBirthdate,'$3/$2/$1',$birthdate); ?>" type="text" id="birthdate" name="birthdate" placeholder="Date de naissance" autocomplete="off">
                <span class="error"><?= $errors['birthdate'] ?? '' ?></span>
            </div>
            <!-- //==== Email ====// -->
            <div class="form-group">
                <!-- <label for="email" class="">Email</label> -->
                <input class="form-control text-center" value="<?=$email?>" type="email" name="email" placeholder="Email">
                <span class="error"><?= $errors['email'] ?? '' ?></span>
            </div>
            <!-- //==== Mot de passe et confirmation ====// -->
            <div class="form-group">
            <!-- <label for="password">Mot de passe</label> -->
            <input class="form-control text-center" data-toggle="tooltip" title="8 caractères minimum, une majuscule,une minuscule, un chiffre et un caractère spécial" value="<?=$password?>" type="password" placeholder="Mot de passe"
                name="password">
                <div id="forcePassword">
								<div class="force-progress w-100 rounded-pill">
  									<div id="progress" class="p-bar" role="progressbar" aria-valuemin="0" aria-valuemax="4"></div>
								</div>
								<div id="force" class="small text-secondary">Faible</div>
							</div>
                </div>
                <div class="form-group mb-5">
            <!-- <label for="password2">Confirmation du mot de passe</label> -->
            <input class="form-control text-center" value="<?=$password2?>" type="password" name="password2"
                placeholder="Confirmation du mot de passe" name="password">
                <span class="error"><?= $errors['password'] ?? '' ?></span>
                </div>
            <!-- //==== conditions générales d'utilistation ====// -->
            <div class="form-check">
                <input class="form-check-input text-center" value="<?=$cgu?>" type="checkbox" name="cgu" id="formCheck-1">
                <label class="form-check-label" for="formCheck-1" style="height: 56px;">
                    En cochant cette case vous acceptez les conditions générale d'utilisation</label>
                <span class="error"><?= $errors['cgu'] ?? '' ?></span>
            </div>
            <div class="form-group">
                <button class="btn btngo text-center text-white border rounded shadow-lg" type="submit"
                    name="submited">go!
                </button>
            </div>
        </form>
    </div>

   
    </div>

    </div>
    <script src="assets/js/jquery.js"></script>
     <script src="assets/js/bs-init.js"></script>
     <script type="text/javascript" src="assets/calendar/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="assets/calendar/locales/bootstrap-datepicker.fr.min.js"></script>
    <script src="https://kit.fontawesome.com/1bf269ba25.js" crossorigin="anonymous"></script>
    <script src="fontawesome.js"></script>
    <script src="assets/libs/js/bootstrap.bundle.min.js"></script>

    
    <script type="text/javascript">
    // calendrier birthdate
    $("#birthdate").datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: 3,
            language: "fr",
            daysOfWeekHighlighted: "0,6",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true,
            orientation: "bottom auto",
            todayHighlight: true,
            endDate: "now"
        });


        $("input[name='password']").keyup(function(){
			// prend la value du selecteur choisi précédement
			var password = $(this).val();
			var force = 0;

			// vérifie que la regex est true ou false
			// var regex = (/(?=.*[a-z])/).test(password);
			
			// vérifie que la value de l'input contient des lettres
			// Si c'est le cas, la force prend +1
			if (password.match(/(?=.*[a-z])/) || password.match(/(?=.*[A-Z])/)) {
				force ++;
			}

			// vérifie que la value de l'input contient des chiffres
			if (password.match(/(?=.*[0-9])/)) {
				force ++;
			}

			// vérifie que la value de l'input contient des caractères spéciaux
			if (password.match(/(?=.*\W)/)) {
				force ++;
			}


			// vérifie que le password contient au moins 8 caractères
			if (password.length >= 8) {
				force ++;
			}

			// couleur en fonction de la force
			var textForce = $("#force");
// couleur et texte en fonction de la force
            if (force == 1) {
                var bgColor = '#dc3545';
                textForce.text('Faible');
            }
            else{
                if (force == 2) {
                    var bgColor = '#ffc107';
                    textForce.text('Moyen');
                }
                else{
                    if (force == 3) {
                        var bgColor = '#28a745';
                        textForce.text('Fort');
                    }
                    else{
                        if (force == 4) {
                            var bgColor = '#0d6e25';
                            textForce.text('Très fort');
                        }
                    }
                }
            }
			document.getElementById('progress').style.backgroundColor = bgColor;
			document.getElementById('progress').style.width = 25*force+'%';

			//document.getElementById('progress').setAttribute('style', 'width:'+25*force+'%; background-color: '+bgColor);

			// change le css de la progressbar
			/* $("#progress").css({
				'width': 25*force+'%',
				'background-color': bgColor
			}); */
		})
    // fait disparaitre la progressbar quand on quitte le champ password
		$("input[name='password']").blur(function(){
			$("#forcePassword").slideUp();
        })
        // Fait apparaitre la progressbar quand on focus le champ password
		document.querySelector(`input[name="password"]`).addEventListener('focus', function(){ 
			let forcePassword = $("#forcePassword").slideDown();
		})

		/* $("input[name='password']").focus(function(){
			$("#forcePassword").slideDown();
		}) */
    </script>
<script src="assets/js/script.js"></script>

    <?php include 'footer.php';