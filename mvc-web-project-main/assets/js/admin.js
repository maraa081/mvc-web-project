document.addEventListener("DOMContentLoaded", () => {

    /* ===== SIDEBAR : submenu dashboard ===== */
    const submenuToggle = document.getElementById("submenu-toggle");
    const dashboardSubmenu = document.getElementById("dashboard-submenu");
    const chevronArrow = document.getElementById("chevron-arrow");

    if (submenuToggle) {
        submenuToggle.addEventListener("click", (e) => {
            e.preventDefault();
            dashboardSubmenu.classList.toggle("open");
            chevronArrow.classList.toggle("rotate");
        });
    }

    /* ===== NOTIFICATIONS ===== */
    const notifBtn = document.getElementById("notif-btn");
    const notifMenu = document.getElementById("notif-menu");

    if (notifBtn) {
        notifBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            notifMenu.classList.toggle("show");
            closeMenu(profileMenu);
        });
    }

    /* ===== PROFIL ===== */
    const profileBtn = document.getElementById("profile-btn");
    const profileMenu = document.getElementById("profile-menu");

    if (profileBtn) {
        profileBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle("show");
            closeMenu(notifMenu);
        });
    }

    /* ===== SORT DROPDOWN ===== */
    const sortBtn = document.getElementById("sort-btn");
    const sortMenu = document.getElementById("sort-menu");
    const sortArrow = document.getElementById("sort-arrow");
    const currentSort = document.getElementById("current-sort");

    if (sortBtn) {
        sortBtn.addEventListener("click", () => {
            sortMenu.classList.toggle("show");
            sortArrow.classList.toggle("rotate");
        });
    }

    document.querySelectorAll(".sort-option").forEach(option => {
        option.addEventListener("click", () => {
            currentSort.textContent = "Trier par : " + option.textContent;
            sortMenu.classList.remove("show");
            sortArrow.classList.remove("rotate");
        });
    });

    /* ===== CLICK EXTERIEUR ===== */
    document.addEventListener("click", () => {
        closeMenu(profileMenu);
        closeMenu(notifMenu);
        closeMenu(sortMenu);
        sortArrow?.classList.remove("rotate");
    });

    function closeMenu(menu) {
        if (menu) menu.classList.remove("show");
    }
});
