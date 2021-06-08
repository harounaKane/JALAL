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
                var result = JSON.parse(res);
                resultat(result, "+", "like"+id);
            }
        });
    });

    //UNLIKE
    $('.unlike').click(function () {
        var id = $(this).attr('value');
        $.ajax({
            url: "/commentaireUnLike/" + id,
            type: 'GET',
            data: {id: id},
            success: function (res) {
                var result = JSON.parse(res);
                resultat(result, "-", "unlike"+id);
            }
        });
    });

    //POST
//     $('#commentaire_Poster').click(function (e) {
//         e.preventDefault();
//         var id = $(this).attr('value');
//         $.ajax({
//             url: "/article/" + id,
//             type: 'POST',
//             data: {id: id},
//             success: function (res) {
//                 //var result = JSON.parse(res);
//                 console.log(res);
//                 for(let c of res){
//                     console.log(c.comment);
//                 }
//             }
//         });
//     })
 })
//  //  response(result);       //        var result = JSON.parse(res);
/*
COMMENTAIRE

$('#div-comment').append()


*/