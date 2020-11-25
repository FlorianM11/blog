<div class="wrapper fadeInDown">
    <div id="formContent">

        <h2>Modifier un article : </h2>
        <!-- Login Form -->
        <form action="/validateEdit?id=<?= $attributes['article']->getId() ?>" method="POST">
            <input type="text" class="fadeIn second text-left" placeholder="Catégorie" name="category" value="<?= $attributes['article']->getCategory() ?>">
            <input type="text" class="fadeIn second text-left" placeholder="Titre" name="title" value="<?= $attributes['article']->getTitle() ?>">
            <textarea class="fadeIn second" name="content" id="" cols="30" rows="10" placeholder="Contenue de l'article"><?= $attributes['article']->getContent() ?></textarea>
            <input type="submit" class="fadeIn fourth" value="Modifier">
        </form>
    </div>
</div>