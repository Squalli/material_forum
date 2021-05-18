
function handleLockTopic(event, link){
    event.preventDefault()
    link.classList.remove("done")
    let url = link.getAttribute("href")
    let lock = link.dataset.lock

    url = url +"&actualLock=" + lock
    
    fetch(url, { 
        method: 'GET',
        headers: {
            'X-Requested-With' : "XMLHTTPRequest"
        },
        mode: 'cors',
        cache: 'default' })//émet une requete AJAX (XMLHTTPRequest) au serveur concerné par l'url
        //si la promesse d'une réponse est tenue
        .then(response => response.json())//on la formate en json
        //si la promesse du formatage est tenue
        .then(json => {//voici toute la logique de mise à jour de la page à appliquer
            let result = json.result//on récupère le résultat venant du serveur
            let icon = link.children[0]//récupère le i avec l'icone cadenas
            
            link.dataset.lock = result ? 1 : 0
            if(result){
                icon.classList.remove("fa-lock-open")
                icon.classList.add("fa-lock")
            }
            else{
                icon.classList.remove("fa-lock")
                icon.classList.add("fa-lock-open")
            }
            link.classList.add("done")
        })
        //si une promesse est rejetée, on alerte avec l'erreur que JS a levé
        .catch(error => console.error(error))
    
}
