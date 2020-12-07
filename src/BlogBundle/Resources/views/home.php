<div class="container mt-5 pt-5">
    <h1 class="home-text">Le blog :</h1>
    <div class="row">
        <div class="col-8">
            <?php
            if ($attributes['articles'] == NULL) {
                echo '<div class="text-center"><h2>Aucun articles</h2><br>
                <a href="/add-article">Ajouter un article</a></div>';
            } else {
                ?>
                <?php foreach ($attributes['articles'] as $article): ?>
                    <div class="display-article">
                        <h1 class="text-left"><?= $article->getTitle() ?></h1>
                        <div class="meta-data">
                            <h3 class="author">Auteur: <?php echo $article->getAuthor()->getNom().' '.$article->getAuthor()->getPrenom() ?> -
                                Catégorie: <?= $article->getCategory() ?> -
                                Date: <?= date("d/m/Y", strtotime($article->getModifiedAt())) ?></h3>
                            <?php
                            $articleArray = [];
                            $authorArray = [];
                            foreach ((array)$article as $key => $arti){
                                $articleArray[str_replace("\x00Article\x00", "", $key)] = $arti;
                            }

                            foreach ((array)$articleArray['_author'] as $key => $arti){
                                $authorArray[str_replace("\x00Users\x00", "", $key)] = $arti;
                            }
                            $articleArray['_author'] = $authorArray;
                             if (strlen($article->getContent()) > 75){ ?>
                                 <p><?= substr($article->getContent(), 0, 75);  ?>...
                                     <a href="#" class="showArticle"
                                            data-article="<?= $article->getId() ?>"
                                     >Voir plus</a>
                                 </p>
                            <?php
                             } else { ?>
                                 <p><?= $article->getContent() ?></p>
                            <?php
                             }
                            ?>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; } ?>
        </div>

        <div class="col-4">
            <div class="display-right">
                <form action="/" class="w-100">
                    <input type="text" class="form-control" placeholder="Rechercher" name="query">
                    <input type="submit" value="continuer" >
                </form>

                <div class="group-categories">
                    <h2>Catégories :</h2>
                    <?php foreach ($attributes['categories'] as $category): ?>
                        <div class="display-cat">
                            <a href="/searchCat?query=<?= urlencode($category['name']) ?>"><?= $category['name'] ?> (<?= $category['count'] ?>)</a>
                        </div>
                    <?php endforeach; ?>
                    <?php if  (count($attributes['categories']) === 0): ?>
                        <div class="display-cat">
                            <a href="#">Aucune catégorie</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
