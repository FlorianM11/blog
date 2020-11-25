<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <img src="../img/logo.png" id="icon" alt="User Icon"/>
        </div>

        <!-- Login Form -->
        <?php
        if (isset($_SESSION['error'])){ ?>
            <div class="alert alert-danger fadeIn second" role="alert">
                <?= $_SESSION['error'] ?>
            </div>
        <?php unset($_SESSION['error']); } ?>
        <form action="/validateInscription" method="POST">
            <input type="text" class="fadeIn second" placeholder="Nom" name="nom" required>
            <input type="text" class="fadeIn second" placeholder="Prénom" name="prenom" required>
            <input type="text" class="fadeIn second" placeholder="Pseudo" name="pseudo" required>
            <input type="password" class="fadeIn third" placeholder="Mot de passe" name="password" required>
            <input type="submit" class="fadeIn fourth" value="Inscription">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <p>Déjà inscrit ? <a href="/login">Connectez-vous</a></p>
        </div>

    </div>
</div>