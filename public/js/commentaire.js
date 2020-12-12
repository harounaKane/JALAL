"use strict";

$(document).ready(function() {
    var btnLike = byId("like");
    var btnUnLike = byId("unlike");


    function byId(id) {
        return document.getElementById(id);
    }

    $('button').click(function () {
        var id = $(this).attr('value');
        console.log($(this).attr('id'));

        $.ajax({
            url: "/commentaire/" + id,
            type: 'GET',
            data: {id: id},
            success: function (res) {

                console.log(res);

            }
        });
    })
});
//  //  response(result);       //        var result = JSON.parse(res);
