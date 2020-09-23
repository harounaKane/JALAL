var btn_image  = document.getElementById("btn_image");
var new_image = document.getElementById("new_image");
var nom = document.getElementById("media_nom");
var div_img = document.getElementsByClassName("uploaded_image");
var legende = document.getElementById("media_legende");
var texte = document.getElementById("media_texte");

var div_img = document.querySelector(".uploaded_image");

var i = 10;
var tableau = [["nom"], ["legende"], ["texte"]];


btn_image.addEventListener("click", function(){
    i--;

});

new_image.addEventListener("click", function(){
    /*for( i = 9; i > 3; i--){
        tableau["nom"]= nom.files;
        tableau["legende"]= legende.value;
        tableau["texte"]= texte.value;
        var btn_test = document.createElement("button");
        var test = document.createTextNode(tableau["nom"][0]["name"]);
        btn_test.appendChild(test);
        div_img.appendChild(btn_test);
        console.log(tableau["nom"][0]["name"]);
        console.log(tableau["legende"]);
        
    }*/
    
    if( i >= 7){
        tableau["nom"]= nom.files;
        tableau["legende"]= legende.value;
        tableau["texte"]= texte.value;
        var btn_test = document.createElement("button");
        var test = document.createTextNode(tableau["nom"][0]["name"]);
        btn_test.appendChild(test);
        div_img.appendChild(btn_test);
        console.log(tableau["nom"][0]["name"]);
        console.log(tableau["legende"]);
        i--;
    }else{
        console.log("mesage entre guillemets");
    }
    
});



