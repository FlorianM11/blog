 <div class="container mt-5">

    <h2 class="pt-3 pb-3">Page d'administration</h2>

     <?php
     if (isset($_SESSION['error'])){ ?>
         <div class="alert alert-danger w-100" role="alert">
             <?= $_SESSION['error'] ?>
         </div>
     <?php unset($_SESSION['error']); } ?>

     <?php if ($attributes['articles'] == NULL) {
     echo '<div class="text-center"><h2>Aucun articles</h2><br>
         <a href="/add-article">Ajouter un article</a></div>';
     } else { ?>
     <table class="table">
         <thead class="thead-light">
         <tr>
             <th scope="col">Titre</th>
             <th scope="col">Auteur</th>
             <th scope="col">Catégorie</th>
             <th scope="col">Date de création</th>
             <th scope="col">Date de modification</th>
             <th scope="col">Action</th>
         </tr>
         </thead>
         <tbody>
         <?php foreach ($attributes['articles'] as $article): ?>
         <tr>
             <th scope="row"><?= $article->getTitle() ?></th>
             <td><?php echo $article->getAuthor()->getNom().' '.$article->getAuthor()->getPrenom() ?></td>
             <td><?= $article->getCategory() ?></td>
             <td><?= date("d/m/Y", strtotime($article->getCreatedAt())) ?></td>
             <td><?= date("d/m/Y", strtotime($article->getModifiedAt())) ?></td>
             <td>
                 <div class="btn-group" role="group">
                     <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         Action
                     </button>
                     <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                         <a class="dropdown-item deleteArticle" data-href="/deleteArticle?id=<?= $article->getId() ?>">Supprimer</a>
                         <a class="dropdown-item" href="/editArticle?id=<?= $article->getId() ?>">Modifier</a>
                     </div>
                 </div>
             </td>
         </tr>
         <?php endforeach; }?>
         </tbody>
     </table>
</div>