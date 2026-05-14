const toggleBtn = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');
if(window.innerWidth <= 991){
    sidebar.classList.add('sidebar-hide');
}
toggleBtn.addEventListener('click', () => {

    sidebar.classList.toggle('sidebar-hide');
    

});