function back(active, future) {
    $(active).addClass('invisible');
    $(future).removeClass('invisible');
}



/**
 * 
 *  Les fonctions
 */

function getUser(userid) {
    return (users).find(element => element.userid == userid);
}

function getDomaine(iddomaine) {
    return (domaines).find(element => element.iddomaine == iddomaine);
}

function getService(idservice) {
    return (services).find(element => element.idservice == idservice);
}

function getIndicateur(idindicateur) {
    return (indicateurs).find(element => element.idindicateur == idindicateur);
}

function getMois(idmois) {
    return (moiss).find(element => element.idmois == idmois);
}