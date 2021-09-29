document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            $(function(){
                if (!chkExtFile($('input[data-type=dragfile]').val(), $('input[data-type=dragfile]').attr("accept").split("|"))) {
                    return false;
                }else{
                    updateThumbnail(dropZoneElement, inputElement.files[0]);
                }
            });
        }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();

        if (e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            // $(function(){
                if (!chkExtFile($('input[data-type=dragfile]').val(), $('input[data-type=dragfile]').attr("accept").split("|"))) {
                    return false;
                }else{
                    updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                }
            // });
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
});

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    // First time - remove the prompt
    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    // First time - there is no thumbnail element, so lets create it
    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }
    thumbnailElement.dataset.label = file.name;


    // Show thumbnail for image files
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    } else {
        thumbnailElement.style.backgroundImage = null;
    }
}
function chkExtFile(file, exts) {
    // first check if file field has any value
    if (file) {
        // split file name at dot
        var get_ext = file.split('.');
        // reverse name to check extension
        get_ext = get_ext.reverse();
        // check file type is valid as given in 'exts' array
        if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {
            return true;
        } else {
            return false;
        }
    }
}
$(function(){
    $('input[data-type=dragfile]').change(function(){
        if(!chkExtFile($(this).val(), $(this).attr("accept").split("|")))
        {
            alert('Invalid file extension !');
            $(this).val("");
            readURL(this);
            return false;
        }
    });
});
function readURL(input) {
    var id = $(input).attr('name');
    $('#' + id).show();
    // alert(id);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#'+ id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
