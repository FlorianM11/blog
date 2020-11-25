$('.deleteArticle').click(function(){
    href = $(this).data('href');
    Swal.fire({
        title: 'Êtes-vous sur de vouloir supprimer cet article ?',
        icon: 'danger',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Supprimer',
        cancelButtonText: 'Retour'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = href;
        }
    })
});


$('.showArticle').click(function(){

    Swal.fire({
        title: "<h1>"+$(this).data('title')+"</h1>",
        text: $(this).data('content'),
        showCloseButton: false,
        showCancelButton: false,
        customClass: 'swal-wide',
        footer: "<h3>"+ $(this).data('author')+" - "+ $(this).data('date') +"</h3>"
    });
});
