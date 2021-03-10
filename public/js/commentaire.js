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
    $('#commentaire_Poster').click(function (e) {
        e.preventDefault();
        console.log(e);
    })
})
//  //  response(result);       //        var result = JSON.parse(res);
