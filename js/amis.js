$('#recherche').autocomplete({      // fonction responsable de l'autocomplétion
    minLength: 2,                   // nb de caractères mini à entrer avant déclenchement de la fonction
    source : "/users/hint.php",            // source donnant la liste des possibilités
    select: function( event, ui ) { 
        // redirect to the right page
        //window.location.href = ui.item.link;
    }        
})
