const messageFlash = document.getElementById("flash"); 

const closeBtn = document.getElementById("closeBtn"); 


closeBtn.addEventListener('click', () => {
    console.log("hello");
    messageFlash.classList.add('d-none'); 
})