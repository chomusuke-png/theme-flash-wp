document.addEventListener("DOMContentLoaded", function() {

    // =============== FECHA Y HORA ===============
    const datetimeElement = document.getElementById("datetime");
    if (datetimeElement) {
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            datetimeElement.textContent = now.toLocaleString('es-ES', options);
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
    }


    // =============== MENÚ HAMBURGUESA ===============
    const hamburgerBtn = document.getElementById("hamburgerBtn");
    const mobileMenu = document.getElementById("mobileMenu");

    if (hamburgerBtn && mobileMenu) {
        hamburgerBtn.addEventListener("click", () => {
            mobileMenu.style.display =
                mobileMenu.style.display === "block" ? "none" : "block";
        });
    }


    // =============== BOTÓN VOLVER ARRIBA ================
    const btnTop = document.getElementById("btnTop");

    if (btnTop) {
        const toggleBtn = () => {
            if (window.scrollY > 300) {
                btnTop.style.display = "flex";
            } else {
                btnTop.style.display = "none";
            }
        };
        window.addEventListener("scroll", toggleBtn);
        toggleBtn();
        btnTop.addEventListener("click", () => {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }

});