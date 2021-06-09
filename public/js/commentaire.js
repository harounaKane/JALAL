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
    $('.commentaire_Poster').click(function (e) {
        e.preventDefault();

        //récup valeur des input
        let id = $(this).attr('value');
        let prenom = $("#prenom").val();
        let nom = $("#commentaire_user").val();
        let commentaire = $("#commentaire_comment").val();

        $.ajax({
            url: "/article/" + id,
            type: 'POST',
            //envoie des données du formulaire
            data: {id: id, data: {"prenom": prenom, "nom": nom, "commentaire": commentaire}},
            success: function (commentaire) {

                //si c le 1er commentaire, ajout du titre "commentaire"
                if( commentaire[6][0].length === 1 ){
                    $("#div-comment").append("<h3 class=\"bg-secondary p-2 text-light\">Commentaires</h3>");
                }

                $("#div-comment").append(
                    "<div class='row'>" +
                        "<div class='unchange col-2'>" +
                            "<div class='row'>" +
                                "<img src='../images/logo/avatar_commentaire.png' class='avatar-author rounded-circle col-12' alt='avatar'>"+
                            "</div>"+
                        "</div>"+
                        "<div class='mt-4 col-10'>" +
                            "<div class='row'>" +
                                "<strong class='userComment col-12'>" + commentaire[1] + "</strong>"+
                                "<span class=\"dateComment col-12 font-italic \">le "+ commentaire[2]+"</span>"+
                            "</div>"+
                        "</div>"+
                    "</div>"+
                    "<div class=\"contentComment my-3\">"+ commentaire[3] +"</div>"+
                    "<div>"+
                    "    <button value=\""+commentaire[0]+"\" class=\"btn p-1 like\">" +
                    "        <i class=\"fa fa-thumbs-up\"><span class=\"badge ml-2 likeCompt\" id=\"like"+commentaire[0]+"\"> "+ commentaire[4] +"</span></i>" +
                    "    </button>" +
                    "    <span class=\"VerticalLine\"></span>" +
                    "    <button value=\""+commentaire[0]+"\" class=\"btn p-1 unlike\">" +
                    "        <i class=\"fa fa-thumbs-down\"><span class=\"badge ml-2 unlikeCompt\" id=\"unlike"+commentaire[0]+"\">-"+ commentaire[5] +"</span></i>" +
                    "    </button>" +
                    "</div>"+
                    "<hr class=\"border-bottom border-dark\">"
                );
                efface_form_input();
            }
        });
    });

    //Effacer les données du formulaire après avoir posté le comm
    function efface_form_input(){
        $(":input").val('');
    }
});