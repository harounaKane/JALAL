var btn_image  = document.getElementById("btn_image");
var new_image = document.getElementById("new_image");
var btn_video  = document.getElementById("btn_video");
var new_video = document.getElementById("new_video");
var btn_audio  = document.getElementById("btn_audio");
var new_audio = document.getElementById("new_audio");
var nom = document.getElementById("media_nom");
var legende = document.getElementById("media_legende");
var texte = document.getElementById("media_texte");
var type = document.getElementById("media_type");

var div_img = document.getElementsByClassName("uploaded_image");
var div_vid = document.getElementsByClassName("uploaded_video");
var div_aud = document.getElementsByClassName("uploaded_audio");

var form_media = document.querySelector("#formMedia");
var form_img = document.querySelector(".form_img");
var form_video = document.querySelector(".form_video");
var form_audio = document.querySelector(".form_audio");
var div_img = document.querySelector(".uploaded_image");

var i = 10;
var j = 2;
var k = 2;
var tableau = [["nom"], ["legende"], ["texte"]];

//IMAGES
btn_image.addEventListener("click", function(){
    console.log("Vous pouvez ajouter une image !");
    form_img.appendChild(form_media);
    type.value = "image";
    console.log("type = "+type.value);
    new_image.classList.toggle("d-block");
    new_image.addEventListener("click", function(){    
        if( i > 0){
            tableau["nom"]= nom.files;
            tableau["legende"]= legende.value;
            tableau["texte"]= texte.value;
            var btn_test = document.createElement("button");
            btn_test.classList.add("border", "rounded", "border-dark", "bg-muted");
            var test = document.createTextNode(tableau["nom"][0]["name"]);
            btn_test.appendChild(test);
            div_img.appendChild(btn_test);
            console.log(tableau["nom"][0]["name"]);
            console.log(tableau["legende"]);
            resetFields();
            i--;
        }else{
            console.log("Nombre maximal d'images atteint");
        }
    console.log(i);
    });
});

//VIDEOS

btn_video.addEventListener("click", function(){
    console.log("Vous pouvez ajouter une vidéo !");
    form_video.appendChild(form_media);
    type.value = "video";
    console.log("type = "+type.value);
    new_video.classList.toggle("d-block");
    new_video.addEventListener("click", function(){    
        if( j > 0){
            tableau["nom"]= nom.files;
            tableau["legende"]= legende.value;
            tableau["texte"]= texte.value;
            var btn_test = document.createElement("button");
            var test = document.createTextNode(tableau["nom"][0]["name"]);
            btn_test.appendChild(test);
            div_vid.appendChild(btn_test);
            console.log(tableau["nom"][0]["name"]);
            console.log(tableau["legende"]);
            resetFields();
            j--;
        }else{
            console.log("Nombre maximal de vidéos atteint");
        }
    console.log(j);
    });
});

//AUDIOS

btn_audio.addEventListener("click", function(){
    console.log("Vous pouvez ajouter un audio !");
    form_audio.appendChild(form_media);
    type.value = "audio";
    console.log("type = "+type.value);
    new_audio.classList.toggle("d-block");
    new_audio.addEventListener("click", function(){    
        if( k > 0){
            tableau["nom"]= nom.files;
            tableau["legende"]= legende.value;
            tableau["texte"]= texte.value;
            var btn_test = document.createElement("button");
            var test = document.createTextNode(tableau["nom"][0]["name"]);
            btn_test.appendChild(test);
            div_aud.appendChild(btn_test);
            console.log(tableau["nom"][0]["name"]);
            console.log(tableau["legende"]);
            resetFields();
            k--;
        }else{
            console.log("Nombre maximal d'audios atteint");
        }
    console.log(k);
    });

});


//-----------------------

function resetFields(){
    //nom.value = "";
    legende.value = "";
    texte.value = "";
}

