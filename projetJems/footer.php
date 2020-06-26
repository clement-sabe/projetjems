<footer>
    <a class="contact d-flex justify-content-center text-secondary " href="#">Contact</a>
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
        <a class="text-secondary" href="mailto:clem.sabe@gmail.com"> clem.sabe@gmail.com</a>
    </div>
</footer>

<script src="assets/js/jquery.js"></script>
     <script src="assets/js/bs-init.js"></script>
     <script type="text/javascript" src="assets/calendar/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="assets/calendar/locales/bootstrap-datepicker.fr.min.js"></script>
    <script src="https://kit.fontawesome.com/1bf269ba25.js" crossorigin="anonymous"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="fontawesome.js"></script>
    <script src="assets/libs/js/jquery-3.4.1.min.js"></script>
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
</body>

</html>