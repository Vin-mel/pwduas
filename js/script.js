// toggle class active
const navbarNav = document.querySelector(".navbar-nav");
// menu ketika diklik
document.querySelector("#menu").onclick = (e) => {
  e.preventDefault();
  navbarNav.classList.toggle("active");
};

//klik di luar sidebar untuk menghilangkan nav
const menu = document.querySelector("#menu");
document.addEventListener("click", function (e) {
  if (!menu.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
});
// untuk bagian atas navbar
const navbar = document.querySelector(".navbar");
window.addEventListener("scroll", () => {
  if (window.scrollY > 10) {
    navbar.classList.add("navbar-scrolled");
  } else {
    navbar.classList.remove("navbar-scrolled");
  }
});

//animasi untuk visi misi
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate");
        entry.target.classList.add("muncul");
      } else {
        entry.target.classList.remove("animate");
        entry.target.classList.remove("muncul");
      }
    });
  },
  {
    threshold: 0.1,
  },
);
//js buat mengawasi kotak visi misi
const elemenAnimasi = document.querySelectorAll(
  ".vismis, .misvis, .hero .content, .jadwal, .borderjadwal",
);
elemenAnimasi.forEach((el) => observer.observe(el));

//ambil element foto
const modal = document.getElementById("imageModal");
const modalImg = document.getElementById("imgFull");
const closeModal = document.querySelector(".close-modal");
//cari foto di dalam div .image
const allImage = document.querySelectorAll(".images img");
allImage.forEach((img) => {
  img.style.cursor = "pointer";
  img.onclick = function () {
    modal.style.display = "block";
    modalImg.src = this.src;
  };
});
// klik x buat tutup
closeModal.onclick = function () {
  modal.style.display = "none";
};
//klik di luar x untuk close
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
// Animasi gambar bergerak
const slider = document.querySelector(".documentation");
let isDown = false;
let startX;
let scrollLeft;
let scrollAmount = 0;
let speed = 0.5;
let isPaused = false;

// fungsi gerak otomatis
function autoScroll() {
  if (!isPaused && !isDown) {
    scrollAmount += speed;
    slider.scrollLeft = scrollAmount;
    if (scrollAmount >= slider.scrollWidth / 2) {
      scrollAmount = 0;
    }
  }
  requestAnimationFrame(autoScroll);
}
autoScroll();

// jeda otomatis di tempel mose
slider.addEventListener("mouseenter", () => (isPaused = true));
slider.addEventListener("mouseleave", () => {
  if (!isDown) isPaused = false;
});
// fungsi drag manual//
slider.addEventListener("mousedown", (e) => {
  isDown = true;
  isPaused = true;
  slider.style.cursor = "grabbing";
  startX = e.clientX - slider.offsetLeft;
  scrollLeft = slider.scrollLeft;
});

slider.addEventListener("mouseup", () => {
  isDown = false;
  isPaused = false;
  scrollAmount = slider.scrollLeft;
  slider.style.cursor = "grab";
});

slider.addEventListener("mouseleave", () => {
  isDown = false;
  isPaused = false;
  slider.style.cursor = "grab";
});

slider.addEventListener("mousemove", (e) => {
  if (!isDown) return;
  e.preventDefault();
  const x = e.pageX - slider.offsetLeft;
  const walk = (x - startX) * 2;
  slider.scrollLeft = scrollLeft - walk;
});

// Permohonan doa redirect ke wa
// document.addEventListener('DOMContentLoaded', function() {
//     const doaForm = document.getElementById('doaForm');
//     if(doaForm){
//         doaForm.addEventListener('submit', function(e){
//             e.preventDefault();

//             const nama = document.getElementById('fname').value.trim();
//             const doa = document.getElementById('doa').value.trim();
//             if(nama === "" || doa === "") {
//                 alert("tolong isi Nama dan Permohonan Doanya dulu yah!");
//                 return;
//             }
//             const nomorWA = '6285122299481';
//             const pesan = `*Permohonan Doa*\n\n*Nama:* ${nama} \n*Permohonan:* ${doa}\n\n_Mohon dukungan doanya, Terima Kasih._`;
//             const pesanEncoded = encodeURIComponent(pesan);
//             window.open(`https://Wa.me/6285122299481?text=${pesanEncoded}`, '_blank');
//             document.getElementById('doaForm').reset();
//         });
//     }
// });
