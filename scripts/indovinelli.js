function fetchIndovinelli(){
    fetch("API/getIndovinelli.php?lista=1").then((risposta) => 
    {
        if(risposta.ok)
            return risposta.json();
    }).then((json)=>{
        for(const indovinello of json)
            createIndovinello(indovinello);
    });
}

function createIndovinello(indovinello){
    const indovinelloContainer = document.createElement('div');
    indovinelloContainer.classList.add('indovinelloContainer');

    const info = document.createElement('div');
    info.classList.add('indovinelloInfo');
    indovinelloContainer.appendChild(info);

    const titolo = document.createElement('h2');
    titolo.innerText = indovinello.Titolo;
    info.appendChild(titolo);

    const testo = document.createElement('p');
    testo.innerText = indovinello.Descrizione;
    info.appendChild(testo);
    
    const span = document.createElement('span');
    span.innerText = getStringTimeAgo(indovinello.Data) + " - Sorrisi: " + indovinello.Sorrisi + " - Commenti: " + indovinello.NCommenti;
    info.appendChild(span);

    const indovinelloStatusFrame = document.createElement('div');
    indovinelloStatusFrame.classList.add('indovinelloStatusFrame');
    indovinelloContainer.appendChild(indovinelloStatusFrame);

    const divColoreStato = document.createElement('div');
    divColoreStato.classList.add('indovinelloStatus');
    let colore = 'red';
    let messaggio = "Rifiutato";
    switch(indovinello.Stato){
        case 'ACCETTATO':
            colore='green';
            messaggio="Accettato";
            break;
        case 'ATTESA':
            colore='yellow';
            messaggio="In attesa";
            break;
    }
    divColoreStato.classList.add(colore);
    indovinelloStatusFrame.appendChild(divColoreStato);

    const emStatus = document.createElement('em');
    emStatus.innerText = messaggio;
    indovinelloStatusFrame.appendChild(emStatus);

    document.querySelector('#container').appendChild(indovinelloContainer);
}

function showModal(event){
    modale.classList.remove('hidden');
    document.body.classList.add('no-scroll');
}

function closeModal(event){
    modale.classList.add('hidden');
    document.body.classList.remove('no-scroll');
}

function addIndovinello(event){

    const titolo = document.querySelector('#titolo');
    const descrizione = document.querySelector('.newTesto');
    const soluzione = document.querySelector('#soluzione');
    
    const formData = new FormData();
    formData.append('titolo', titolo.value);
    formData.append('descrizione', descrizione.value);
    formData.append('soluzione', soluzione.value);

    if(!checkIndovinello(titolo.value, descrizione.value))
    {
        return;
    } 

    fetch("API/addIndovinello.php", {method: 'post', body: formData}).then((risposta) => 
    {
        if(risposta.ok)
            return risposta.json();
    }).then((json)=>{
        console.log(json);

        createIndovinello(json);

        descrizione.value="";
        soluzione.value="";

        closeModal();
        
    });
}

function checkIndovinello(titolo, descrizione){
    if(descrizione.length==0 || titolo.length==0)
        return false;
    return true;
}

fetchIndovinelli();

const modale=document.querySelector('#modalIndovinelli');
document.querySelector('#showModal').addEventListener('click', showModal);
document.querySelector('.closeModale').addEventListener('click', closeModal);
document.querySelector('#newIndovinelloButton').addEventListener('click', addIndovinello);
document.querySelector('#soluzione').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        addIndovinello(e);
    }
});