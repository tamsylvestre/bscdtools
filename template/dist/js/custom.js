$(document).ready(function () {
    // Ouvrir le popup
    $('#openPopupAD').on('click', function () {
        $('#overlayAD').css('display', 'flex').hide().fadeIn(300);
    });

    // Fermer le popup au clic sur le X ou sur le bouton "D'accord"
    $('#closePopup, .btn-confirm').on('click', function () {
        $('#overlayAD').fadeOut(300);
    });

    // Fermer si l'utilisateur clique en dehors de la boîte blanche
    $('#overlayAD').on('click', function (e) {
        if (e.target !== this) return; // Si on clique sur le popup, on ne ferme pas
        $(this).fadeOut(300);
    });

    $('#asignbtn').on('click', function (e) {
        $('#overlayAD').css('display', 'flex').hide().fadeIn(300);

    });

    $('#searchAD').on('click', function () {

        $('.loader').css('display', 'flex').hide().fadeIn(300);
        let searchItem = $("#searchtxtAD").val();
        // alert(BASE_URL+'/ad/SearchByName/'+searchItem);

        $.ajax(BASE_URL + '/ad/SearchByName/' + searchItem)
            .done(function (data) {
                // alert(data);
                let txt = '';
                JSON.parse(data).forEach(element => {
                    //    console.log(element); 
                    txt = txt +
                        `<option value='${element.samaccountname}'> ${element.cn} </option>`;

                    $('.loader').css('display', 'none').hide().fadeOut(300);
                });

                $('#selectAD').html(txt);

            })
            .fail(function (jqXHR, textStatus) {
                alert("Requête échouée : " + textStatus);
                $('.loader').css('display', 'none').hide().fadeOut(300);
            })
            .always(function () {
                console.log("Appel terminé (succès ou échec).");
            });

    });

    $('.btnValidAD').on('click', function (e) {
        // alert($('#selectAD option:selected').text() + "--" + $('#selectAD option:selected').val());
        $(".txtFldAssign").val($('#selectAD option:selected').val());
        $('#overlayAD').fadeOut(300);
    });

});

function exec(batch) {
    alert('hello word');
    const $console = $('#retour');
    $console.val(''); // Vider la console

    // Initialisation de la connexion EventSource
    const eventSource = new EventSource(BASE_URL + '/batch/execute/' + batch);

    eventSource.onmessage = function (e) {
        // Ajouter la nouvelle ligne au textarea
        $console.val($console.val() + e.data + '\n');

        // Auto-scroll vers le bas
        $console.scrollTop($console[0].scrollHeight);
    };

    eventSource.onerror = function () {
        console.log("Fin du flux ou erreur.");
        eventSource.close();
    };
}

