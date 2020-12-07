$('.deleteArticle').click(function(){
    href = $(this).data('href');
    Swal.fire({
        title: 'Êtes-vous sur de vouloir supprimer cet article ?',
        icon: 'danger',
        showCancelButton: true,
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Retour'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = href;
        }
    })
});


$('.showArticle').click(function(){

    var article_id = $(this).data('article');

    $.post( "/searchById", { article_id: article_id }).done(function(data) {
        result = JSON.parse(data);
        Swal.fire({
            title: "<h1>"+result.title+"</h1>",
            html: result.content,
            showCloseButton: false,
            showCancelButton: false,
            customClass: 'swal-wide',
            footer: "<h3>"+result.author.nom+" "+result.author.prenom+" - "+result.modifiedAt+"</h3>"
        });
    });
});