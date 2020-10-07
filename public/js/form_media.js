console.log("qsrfer");
// add-collection-widget.js
jQuery(document).ready(function () {
    jQuery('.add-another-collection-widget').click(function (e) {
        var list = jQuery(jQuery(this).attr('data-list-selector'));
        // Try to find the counter of the list or use the length of the list
        var counter = list.data('widget-counter') || list.children().length;
        if(!counter){
            counter = 1;
        }
        // grab the prototype template
        var newWidget = list.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter);
        // Increase the counter
        counter++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list.data('widget-counter', counter);

        // create a new list element and add it to the list
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });
    console.log("script exécuté");
});


/*
var btn_image  = document.getElementById("btn_image");
var new_image = document.getElementById("new_image");
var btn_video  = document.getElementById("btn_video");
var new_video = document.getElementById("new_video");
var btn_audio  = document.getElementById("btn_audio");
var new_audio = document.getElementById("btn_audio");
var nom_input = document.getElementById("media_nom");
var legende_input = document.getElementById("media_legende");
var texte_input = document.getElementById("media_texte");
var type_input = document.getElementById("media_type");

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
var x = 0;
var ordre_input = 0;

//var tableau = [["nom"], ["legende"], ["texte"], ["ordre"], ["type"]];
var tableau = new Array();

//IMAGES
btn_image.addEventListener("click", function(){

    console.log("Vous pouvez ajouter une image !");
    form_img.appendChild(form_media);
    type_input.value = "image";
    new_image.classList.toggle("d-inline-block");

    new_image.addEventListener("click", function(){ //si les champs "file" et "légende" ne sont pas vides   
        if( i > 0){
            tableau.push([nom_input.files, legende_input.value, texte_input.value, ++ordre_input, type_input.value]);
            console.log(nom_input.files[0].name);
            var btn_file = document.createElement("button");
            btn_file.classList.add("border", "border-light", "bg-muted", "p-1");
            var prev_img = document.createElement("img");
            prev_img.setAttribute("id", "preview"+x);
            prev_img.setAttribute("height", "80");
            //var new_nom = document.createTextNode(nom_input.files[0].name);
            btn_file.appendChild(prev_img);
            //btn_file.appendChild(new_nom);
            div_img.appendChild(btn_file);
            console.log([tableau]);
            previewImage(x);
            resetFields();
            x++;
            i--;
        }else{
            new_image.disabled = true;
            console.log("Nombre maximal d'images atteint");
        }
    console.log(i+" fichiers restants");
    });
});

//-----------------------

function resetFields(){
    //nom_input.value = null; // réinitialiser le champ "file"
    legende_input.value = "";
    texte_input.value = "";
}

function previewImage(x) {
    var prev = nom_input.files;
    var fileReader = new FileReader();

    fileReader.onload = function (event) {
        document.getElementById("preview"+x).setAttribute("src", event.target.result);
        //document.getElementById("preview"+x).setAttribute("height", event.target.result);
    };
    console.log("x = "+x);
    fileReader.readAsDataURL(prev[0]);
    
}

// function previewImage() {
//     var prev = nom.files;
//     if (prev.length > 0) {
//         var fileReader = new FileReader();

//         fileReader.onload = function (event) {
//             document.getElementById("preview").setAttribute("src", event.target.result);
//             document.getElementById("preview").setAttribute("height", event.target.result);
//         };

//         fileReader.readAsDataURL(prev[0]);
//     }
// }






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
            console.log([tableau]);
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

*/