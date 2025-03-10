/**
 * @fileoverview Handles sidebar functionality including toggle and submenu operations
 * @version 1.0.0
 */

/** @type {HTMLElement} Button element that toggles the sidebar */
const toggleButton = document.getElementById("toggle-btn");

/** @type {HTMLElement} Main sidebar container element */
const sidebar = document.getElementById("sidebar");

/**
 * Toggles the sidebar open/closed state
 * Handles both the sidebar visibility and rotation of the toggle button
 * Also ensures all submenus are closed when sidebar is toggled
 * @global
 */
window.toggleSidebar = function () {
    sidebar.classList.toggle("close");
    toggleButton.classList.toggle("rotate");

    Array.from(sidebar.getElementsByClassName("show")).forEach((ul) => {
        ul.classList.remove("show");
        ul.previousElementSibling.classList.remove("rotate");
    });

    closeAllSubMenus();
};

/**
 * Toggles a specific submenu open/closed state
 * @param {HTMLElement} button - The button element that triggers the submenu
 * @global
 */
window.toggleSubMenu = function (button) {
    if (!button.nextElementSibling.classList.contains("show")) {
        closeAllSubMenus();
    }

    button.nextElementSibling.classList.toggle("show");
    button.classList.toggle("rotate");

    if (sidebar.classList.contains("close")) {
        sidebar.classList.toggle("close");
        toggleButton.classList.toggle("rotate");
    }
};

/**
 * Closes all open submenus in the sidebar
 * Removes both 'show' class from submenu and 'rotate' class from trigger buttons
 * @private
 */
function closeAllSubMenus() {
    Array.from(sidebar.getElementsByClassName("show")).forEach((ul) => {
        ul.classList.remove("show");
        ul.previousElementSibling.classList.remove("rotate");
    });
}

/**
 * Opens submenu containing active items on page load
 * Adds 'show' class to parent submenu and 'rotate' class to corresponding button
 * @private
 */
function openActiveSubmenu() {
    const activeItems = sidebar.getElementsByClassName("submenu-item active");
    Array.from(activeItems).forEach((item) => {
        const parentSubmenu = item.closest(".sub-menu");
        if (parentSubmenu) {
            parentSubmenu.classList.add("show");
            const dropdownBtn = parentSubmenu.previousElementSibling;
            dropdownBtn.classList.add("rotate");
        }
    });
}

// Initialize active submenu functionality when DOM is ready
document.addEventListener("DOMContentLoaded", openActiveSubmenu);
