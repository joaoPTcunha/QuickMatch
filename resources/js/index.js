document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const menuItems = document.getElementById("menu-items");

    if (menuToggle && menuItems) {
        menuToggle.addEventListener("click", function () {
            menuItems.classList.toggle("hidden");
        });
    }

    function addDropdownToggle(toggleElementId, contentElementId) {
        const toggleElement = document.getElementById(toggleElementId);
        const contentElement = document.getElementById(contentElementId);

        if (toggleElement && contentElement) {
            toggleElement.addEventListener("click", function (e) {
                e.stopPropagation();
                contentElement.classList.toggle("hidden");
            });
        }
    }

    addDropdownToggle("mobile-play-dropdown-toggle", "mobile-play-dropdown-content");
    addDropdownToggle("mobile-profile-dropdown-toggle", "mobile-profile-dropdown-content");

    addDropdownToggle("desktop-play-dropdown-toggle", "play-dropdown-content");
    addDropdownToggle("desktop-profile-dropdown-toggle", "profile-dropdown-content");

    document.addEventListener("click", function (e) {
        const allDropdowns = [
            { toggle: "mobile-play-dropdown-toggle", content: "mobile-play-dropdown-content" },
            { toggle: "mobile-profile-dropdown-toggle", content: "mobile-profile-dropdown-content" },
            { toggle: "desktop-play-dropdown-toggle", content: "play-dropdown-content" },
            { toggle: "desktop-profile-dropdown-toggle", content: "profile-dropdown-content" },
        ];

        allDropdowns.forEach(({ toggle, content }) => {
            const toggleElement = document.getElementById(toggle);
            const contentElement = document.getElementById(content);

            if (toggleElement && contentElement && !toggleElement.contains(e.target) && !contentElement.contains(e.target)) {
                contentElement.classList.add("hidden");
            }
        });
    });
});
