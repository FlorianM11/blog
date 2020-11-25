<div class="wrapper fadeInDown">
    <div id="formContent">

        <h2>Ajouter un article : </h2>
        <!-- Login Form -->
        <?php
        if (isset($_SESSION['error'])){ ?>
            <div class="alert alert-danger fadeIn second" role="alert">
                <?= $_SESSION['error'] ?>
            </div>
        <?php unset($_SESSION['error']); } ?>
        <form action="/addArticle" method="POST">
            <input type="text" class="fadeIn second text-left" placeholder="Titre" name="title">
            <input type="text" class="fadeIn second text-left" placeholder="Catégorie" name="category">
            <textarea class="fadeIn second" name="content" id="" cols="30" rows="10" placeholder="Contenue de l'article"></textarea>
            <input type="submit" class="fadeIn fourth" value="Ajouter">
        </form>
    </div>
</div>