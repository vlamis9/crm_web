function openModal(strToShow){
    const modalDiv = document.createElement('div');
    modalDiv.classList.add('modal');    
    const innerModalDiv = `<div id="close_modal">+</div>
                           <div class="modal_message">strToShow</div>`; 
    modalDiv.innerHTML += innerModalDiv; 
    const body = document.getElementsByTagName('body')[0];
    body.parentNode.insertBefore(modalDiv, body.nextSibling);
    const msgEl = document.querySelector('.modal_message');    
    msgEl.innerHTML = strToShow;

    const close_modal = document.getElementById('close_modal');     
    modalDiv.classList.add('modal_vis'); 
    body.classList.add('body_block'); 
    close_modal.onclick = function() {        
        modalDiv.classList.remove('modal_vis'); 
        body.classList.remove('body_block'); 
    }; 
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.btn_clients').addEventListener('click',function (e) {
        e.preventDefault(); 
        e.stopPropagation();
        window.location.href = "clients.php";
     });
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.btn_cases').addEventListener('click',function (e) {
        e.preventDefault(); 
        e.stopPropagation();
        window.location.href = "cases.php";
     });
});

