document.getElementById('showPass').addEventListener('click', ()=>{
    const inputPsw =  document.getElementById('password_registry');
    const type = inputPsw.getAttribute('type') === 'password' ? 'text' : 'password';
    inputPsw.setAttribute('type', type);
})