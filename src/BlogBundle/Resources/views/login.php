<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <img src="../img/logo.png" id="icon" alt="User Icon" />
        </div>

        <!-- Login Form -->
        <?php
            if (isset($_SESSION['error'])){ ?>
                <div class="alert alert-danger fadeIn second" role="alert">
                    <?= $_SESSION['error'] ?>
                </div>
        <?php unset($_SESSION['error']); } ?>
        <form action="/verificationLogin" method="POST">
            <input type="text" id="login" class="fadeIn second" placeholder="Pseudo" name="pseudo" required>
            <input type="password" id="password" class="fadeIn third" placeholder="Mot de passe" name="password" required>
            <input type="submit" class="fadeIn fourth" value="Connexion">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <p>Pas encore inscrit ? <a href="/inscription">Inscrivez vous</a></p>
        </div>

    </div>
</div>