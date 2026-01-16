/*=============== SHOW MENU MOBILE (HAMBURGER) ===============*/
const showMenu = (toggleId, navId) => {
    const toggle = document.getElementById(toggleId),
        nav = document.getElementById(navId)

    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            // Menampilkan/menyembunyikan menu nav
            nav.classList.toggle('show-menu')
                // Mengubah ikon burger menjadi close
            toggle.classList.toggle('show-icon')
        })
    }
}
showMenu('nav-toggle', 'nav-menu')

/*=============== MODAL POPUP LOGIC REVISED ===============*/
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('webinar-modal');
    // Menggunakan querySelectorAll karena id "open-modal" ada di Header dan Footer
    const openBtns = document.querySelectorAll('#open-modal');
    const closeBtn = document.getElementById('close-modal');

    // 1. Logika Membuka Modal
    if (openBtns.length > 0 && modal) {
        openBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                // Menambahkan class active (CSS akan mengubah display: none menjadi grid/flex)
                modal.classList.add('active');
                // Kunci scroll body agar tidak bergeser saat modal buka
                document.body.style.overflow = 'hidden';

                // Debugging di console browser
                console.log("Modal dibuka melalui:", btn.closest('footer') ? "Footer Mobile" : "Header Desktop");
            });
        });
    }

    // 2. Logika Menutup Modal (Tombol Batal/Close)
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto'; // Aktifkan kembali scroll
        });
    }

    // 3. Menutup jika klik area hitam di luar form
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    });
});

/*=============== LOGIKA FORM (UNIVERSITAS) ===============*/
// Fungsi ini dipanggil melalui atribut onchange="toggleUniversitas()" di HTML
function toggleUniversitas() {
    const statusSelect = document.getElementById('status_peserta');
    const univInput = document.getElementById('univ_input');

    if (statusSelect && univInput) {
        const inputField = univInput.querySelector('input');

        if (statusSelect.value === 'Mahasiswa') {
            univInput.style.display = 'block';
            if (inputField) inputField.setAttribute('required', 'true');
        } else {
            univInput.style.display = 'none';
            if (inputField) inputField.removeAttribute('required');
        }
    }
}

document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.querySelector('input[name="search"]'); // Sesuaikan selector dengan input search Anda
    const footerMobile = document.getElementById('footer-mobile');

    if (searchInput && footerMobile) {
        // Saat input search diklik/fokus
        searchInput.addEventListener('focus', () => {
            footerMobile.style.display = 'none';
        });

        // Saat input search ditinggalkan (blur)
        searchInput.addEventListener('blur', () => {
            // Beri sedikit delay agar klik pada tombol search tidak terganggu
            setTimeout(() => {
                footerMobile.style.display = 'block';
            }, 100);
        });
    }
});