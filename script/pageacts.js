function updatePage(isAuth = true, mainUpd = true){
    if (isAuth){
        const authCont = document.querySelector('.auth_form');
        const inputs = authCont.querySelectorAll('input');
        inputs.forEach((elem) => elem.remove());
        const divs = authCont.querySelectorAll('div');
        divs.forEach((elem) => elem.remove());
        const labels = authCont.querySelectorAll('label');
        labels.forEach((elem) => elem.remove());
        const butLeave = document.createElement('input');
        butLeave.type="submit";
        butLeave.classList.add('leave_but');
        butLeave.name="leave_but";
        butLeave.value="Выйти";
        authCont.classList.toggle('auth_form_logout');
        authCont.appendChild(butLeave); 
        if (mainUpd)
        {
            const btnCont = document.querySelector('.btn_cont');  
            const btns = btnCont.querySelectorAll('input'); 
            btns.forEach((elem) => elem.disabled = false);
        }   
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const toMain = document.querySelector('.to_main_btn').addEventListener('click',function (e) {
        e.preventDefault(); 
        e.stopPropagation();
        window.location.href = "index.php";
     });
});
   
function onCatClChange(sel){
    const catClText = document.querySelector('.cat_client_text');    
    catClText.textContent = sel.options[sel.selectedIndex].getAttribute('data-cat') == 1 ? "Физическое лицо" : "Юридическое лицо";
}
    
function setCaseFormStartValsNew(namesArr, catClArr){
    const clientSelect = document.querySelector('.id_name_client_select');
    for(let clId in namesArr){
        const option = document.createElement('option');
        option.value = clId;
        option.text = namesArr[clId];
        option.setAttribute('data-cat', catClArr[clId]);
        clientSelect.appendChild(option);
    }
    clientSelect.dispatchEvent(new Event('change')); //to call 'onchange' immediately    
}

function setCaseFormStartValsExisting(nameCl, catCl){ 
    //set name of client in form field
   
        let nameField = document.querySelector('.id_name_client_select');                     
        opt = new Option(nameCl, 'val');
        nameField.append(opt);        
        nameField.disabled = true;  
    
    //set client category in form field
    let catField = document.querySelector('.cat_client_text');
    catField.textContent = (catCl== 1 ? "Физическое лицо" : "Юридическое лицо"); 
       
    
}

