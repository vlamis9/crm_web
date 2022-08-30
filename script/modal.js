function openModal(strToShow){
    const modalDiv = document.createElement('div');
    modalDiv.classList.add('modal');    
    const innerModalDiv = `<div id="close_modal">+</div>
                           <div class="modal_message">strToShow</div>`; //Message
    modalDiv.innerHTML += innerModalDiv; 
    const body = document.getElementsByTagName('body')[0];
    body.parentNode.insertBefore(modalDiv, body.nextSibling);
    const msgEl = document.querySelector('.modal_message');
    //msgEl.textContent = strToShow;
    msgEl.innerHTML = strToShow;

    const close_modal = document.getElementById('close_modal');     
    modalDiv.classList.add('modal_vis'); 
    body.classList.add('body_block'); 
    close_modal.onclick = function() {        
        modalDiv.classList.remove('modal_vis'); 
        body.classList.remove('body_block'); 
    }; 
}

function checkForEmptyF(){
    const evtVal = document.activeElement.value;
    if (evtVal == 'Отмена') window.location.href='clients.php?selCl=fizClient';
    else {    
        if(!document.querySelector('.f_SURNAME').value){ 
        const strToShow = `Необходимо указать <br><br> <b>\"Фамилию\"</b> клиента`;
        openModal(strToShow);
        return false;
        }
    }
    return true; 
}

function checkForEmptyY(){
    const evtVal = document.activeElement.value;
    if (evtVal == 'Отмена') window.location.href='clients.php?selCl=yurClient';
    else {    
        result = ((document.querySelector('.y_OGRN').value == "") && (document.querySelector('.y_INN').value == "")); 
        if (result){
            const strToShow = `Необходимо указать один из реквизитов: <br><br> <b>\"ОГРН\"</b>
                                                          <br><br> или
                                                          <br><br>
                                                          <b>\"ИНН\"</b>`;
            openModal(strToShow);
            return false;
        }
    }
    return true;    
}










