const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () =>{
    container.classList.add("active");
});

loginBtn.addEventListener('click',() =>{
    container.classList.remove("active");
});

function myFunction(){
    alert ("Bạn đã thêm 1 sản phẩm vào giỏ hàng");
}