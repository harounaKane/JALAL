"use strict";

$(document).ready(function() {

    function resultat(data, op, id){
      $("#"+id).html(op + data)
    }

    //LIKE
    $('.like').click(function () {
        var id = $(this).attr('value');
        console.log(this)
        $.ajax({
            url: "/likeCommentaire/" + id,
            type: 'GET',
            data: {id: id},
            success: function (res) {
                var result = JSON.parse(res);
                resultat(result, "+", "like"+id);
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
})
//  //  response(result);       //        var result = JSON.parse(res);
