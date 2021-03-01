"use strict";

$(document).ready(function() {

    function resultat(data, op, id){
      $("#"+id).html(op + data)
    }

    //LIKE
    $('.like').click(function () {
        var id = $(this).attr('value');

        $.ajax({
            url: "/likeCommentaire/" + id,
            type: 'GET',
            data: {id: id},
            success: function (res) {
                console.log(res)
                var result = JSON.parse(res);
                resultat(result, "+", "like"+id);
                console.log(result)
            }
        });
    })

    //UNLIKE
    $('.unlike').click(function () {
        var id = $(this).attr('value');
        console.log(this)
        $.ajax({
            url: "/commentaireUnLike/" + id,
            type: 'GET',
            data: {id: id},
            success: function (res) {
                var result = JSON.parse(res);
                resultat(result, "-", "unlike"+id);
            }
        });
    })

    //POST
    $('#commentaire_Poster').submit(function () {
        console.log('bidule');
        var pseudo = $('#commentaire_user').val();
        var commentaire = $('#commentaire_comment').val();
        /* 
            (?) Obligation d'insérer le html du commentaire en JS ?
            Affichage des commentaires avec append()
        */
        if (pseudo != '' && commentaire != '') {
            $.ajax({
                url: "/article/",
                type: 'POST',
                data: {pseudo:pseudo, commentaire:commentaire},
                success: function () {
                    $('#div-comment').append("<p>" + pseudo + " dit : " + commentaire + "</p>");
                }
            });
        }

    })

})
//  //  response(result);       //        var result = JSON.parse(res);
