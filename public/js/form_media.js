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

let imageHolder;

document.addEventListener("DOMContentLoaded", function() {
    // Get the ul that holds the collection of tags
    var addImgButton = document.querySelector('#btn_image');
    imageHolder = document.querySelector('#image_holder');


    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)

    // remplir le imgCount en js avec document.queryselectorall et compter les éléments
    // imageHolder.dataset.imgCount = imageHolder.find('fieldset').length;

    addImgButton.addEventListener('click', function(e) {
        e.preventDefault();
        // add a new tag form (see next code block)
        addMediaForm(imageHolder, 5);
    });
    // addVideoButton.addEventListener('click', function(e) {
    // 	e.preventDefault();
    // 	// add a new tag form (see next code block)
    // 	addMediaForm(imageHolder, 2);
    // });
});

/*function addMediaForm(mediaHolder, maxItem) {
    // Get the data-prototype explained earlier
    var prototype = document.querySelector('#media_prototype').dataset.prototype;

    // get the new index
    var index = mediaHolder.dataset.imgCount;

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    mediaHolder.dataset.imgCount ++;
    
    console.log('newForm : ', newForm);
    console.log('index : ', index);
    console.log('mediaHolder : ', mediaHolder);

    // Display the form in the page in an li, before the "Add a tag" link li
    mediaHolder.innerHTML = mediaHolder.innerHTML + newForm;*/
}