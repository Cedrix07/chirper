document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("theme-toggle");
    const lightIcon = document.getElementById("theme-toggle-light");
    const darkIcon = document.getElementById("theme-toggle-dark");

    const setTheme = (theme) => {
        if (theme === "dark") {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");
            lightIcon.classList.add("hidden");
            darkIcon.classList.remove("hidden");
        } else {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
            darkIcon.classList.add("hidden");
            lightIcon.classList.remove("hidden");

        }
    }

    // Load theme preference from localStorage
    const savedTheme = localStorage.getItem("theme") || "light";
    setTheme(savedTheme);

    // Toggle theme on button click
    themeToggle.addEventListener("click", function () {
        const currentTheme = document.documentElement.classList.contains("dark") ? "light" : "dark";
        setTheme(currentTheme);
    });
});
