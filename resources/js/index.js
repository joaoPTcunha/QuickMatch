document.addEventListener("DOMContentLoaded", function () {
    // Menu toggle functionality
    const menuToggle = document.getElementById("menu-toggle");
    const menuItems = document.getElementById("menu-items");

    if (menuToggle && menuItems) {
        menuToggle.addEventListener("click", function () {
            menuItems.classList.toggle("hidden");
        });
    }

    // Mobile dropdowns
    const mobilePlayToggle = document.getElementById(
        "mobile-play-dropdown-toggle",
    );
    const mobilePlayContent = document.getElementById(
        "mobile-play-dropdown-content",
    );
    const mobileProfileToggle = document.getElementById(
        "mobile-profile-dropdown-toggle",
    );
    const mobileProfileContent = document.getElementById(
        "mobile-profile-dropdown-content",
    );

    // Play dropdown toggle
    if (mobilePlayToggle && mobilePlayContent) {
        mobilePlayToggle.addEventListener("click", function (e) {
            e.stopPropagation();
            mobilePlayContent.classList.toggle("hidden");
            mobileProfileContent.classList.add("hidden");

            // Toggle arrow rotation
            const arrow = mobilePlayToggle.querySelector("svg");
            arrow.classList.toggle("rotate-180");
            mobileProfileToggle
                .querySelector("svg")
                .classList.remove("rotate-180");
        });
    }

    // Profile dropdown toggle
    if (mobileProfileToggle && mobileProfileContent) {
        mobileProfileToggle.addEventListener("click", function (e) {
            e.stopPropagation();
            mobileProfileContent.classList.toggle("hidden");
            mobilePlayContent.classList.add("hidden");

            // Toggle arrow rotation
            const arrow = mobileProfileToggle.querySelector("svg");
            mobilePlayToggle
                .querySelector("svg")
                .classList.remove("rotate-180");
        });
    }

    // Desktop dropdowns
    const desktopPlayToggle = document.getElementById(
        "desktop-play-dropdown-toggle",
    );
    const desktopPlayContent = document.getElementById("play-dropdown-content");
    const desktopProfileToggle = document.getElementById(
        "desktop-profile-dropdown-toggle",
    );
    const desktopProfileContent = document.getElementById(
        "profile-dropdown-content",
    );

    // Desktop play dropdown hover
    if (desktopPlayToggle && desktopPlayContent) {
        const playDropdownGroup = desktopPlayToggle.closest(".group");
        playDropdownGroup.addEventListener("mouseenter", function () {
            desktopPlayContent.classList.remove("hidden");
            desktopPlayToggle.querySelector("svg").classList.add("rotate-180");
        });
        playDropdownGroup.addEventListener("mouseleave", function () {
            desktopPlayContent.classList.add("hidden");
            desktopPlayToggle.querySelector("svg");
        });
    }

    // Desktop profile dropdown hover
    if (desktopProfileToggle && desktopProfileContent) {
        const profileDropdownGroup = desktopProfileToggle.closest(".group");
        profileDropdownGroup.addEventListener("mouseenter", function () {
            desktopProfileContent.classList.remove("hidden");
            desktopProfileToggle.querySelector("svg");
        });
        profileDropdownGroup.addEventListener("mouseleave", function () {
            desktopProfileContent.classList.add("hidden");
            desktopProfileToggle.querySelector("svg");
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener("click", function (e) {
        // Verifica se o clique foi fora do dropdown de jogo
        if (
            mobilePlayToggle &&
            !mobilePlayToggle.contains(e.target) &&
            !mobilePlayContent.contains(e.target)
        ) {
            mobilePlayContent.classList.add("hidden");
        }

        // Verifica se o clique foi fora do dropdown de perfil
        if (
            mobileProfileToggle &&
            !mobileProfileToggle.contains(e.target) &&
            !mobileProfileContent.contains(e.target)
        ) {
            mobileProfileContent.classList.add("hidden");
        }

        // Verifica se o clique foi fora do menu desktop
        if (
            desktopPlayToggle &&
            !desktopPlayToggle.contains(e.target) &&
            !desktopPlayContent.contains(e.target)
        ) {
            desktopPlayContent.classList.add("hidden");
        }

        // Verifica se o clique foi fora do dropdown de perfil no desktop
        if (
            desktopProfileToggle &&
            !desktopProfileToggle.contains(e.target) &&
            !desktopProfileContent.contains(e.target)
        ) {
            desktopProfileContent.classList.add("hidden");
        }
    });
});
