<template>
<header class="navbar">
    <div class="navbar-left">
    <img src="/public/images/logoheader.png" alt="Ecoin Logo" class="logo" />
    </div>
    <nav class="navbar-right">
    <ul class="nav-links">
        <li><a href="#">Beranda</a></li>
        <li class="dropdown" @mouseenter="openDropdown" @mouseleave="closeDropdown">
        <a href="#">Penukaran</a>
        <ul v-if="isDropdownOpen" class="dropdown-menu">
            <li><a href="#">Sampah</a></li>
            <li><a href="#">Koin</a></li>
        </ul>
        </li>
        <li><a href="#">Jelajah</a></li>
        <li><a href="#">Tentang</a></li>
    </ul>
    <button class="login-button">Masuk</button>
    </nav>
</header>
</template>
  
<script>
import { theme } from '../config/theme';

export default {
name: 'Navbar',
data() {
    return {
    isDropdownOpen: false,
    };
},
mounted() {
    // Set CSS variables from theme
    const root = document.documentElement;
    root.style.setProperty('--primaryGreen', theme.colors.primaryGreen);
    root.style.setProperty('--accentGreen1', theme.colors.accentGreen1);
    root.style.setProperty('--textGrey', theme.colors.textGrey);
    root.style.setProperty('--textField', theme.colors.textField);
    root.style.setProperty('--accentGreen2', theme.colors.accentGreen2);
    root.style.setProperty('--textBlack', theme.colors.textBlack);
    root.style.setProperty('--backgroundWhite', theme.colors.backgroundWhite);

    root.style.setProperty('--fontFamily', theme.fonts.family);
    root.style.setProperty('--fontSizeSmall', theme.fonts.size.small);
    root.style.setProperty('--fontSizeNormal', theme.fonts.size.normal);
    root.style.setProperty('--fontSizeMedium', theme.fonts.size.medium);
    root.style.setProperty('--fontSizeLarge', theme.fonts.size.large);
    root.style.setProperty('--fontSizeHeading', theme.fonts.size.heading);
    root.style.setProperty('--fontWeightBold', theme.fonts.weight.bold);
    root.style.setProperty('--fontWeightSemiBold', theme.fonts.weight.semibold);
    root.style.setProperty('--fontWeightMedium', theme.fonts.weight.medium);
    root.style.setProperty('--fontWeightRegular', theme.fonts.weight.regular);
},
methods: {
    openDropdown() {
    this.isDropdownOpen = true;
    },
    closeDropdown() {
    this.isDropdownOpen = false;
    }
}
}
</script>

<style scoped>
    .navbar {
        font-family: var(--fontFamily);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 32px;
        background-color: var(--backgroundWhite);
        border-bottom: 1px solid var(--accentGreen1);
    }

    .navbar-left {
        display: flex;
        align-items: center;
    }

    .logo {
        height: 40px;
        margin-right: 10px;
    }

    .navbar-right {
        display: flex;
        align-items: center;
    }

    .nav-links {
        list-style: none;
        display: flex;
        gap: 24px;
        margin: 0;
        padding: 0;
    }

    .nav-links li {
        position: relative;
    }

    .nav-links a {
        text-decoration: none;
        color: var(--textBlack);
        font-size: var(--fontSizeNormal);
        font-weight: 500;
    }

    .login-button {
        margin-left: 24px;
        padding: 8px 20px;
        background-color: var(--primaryGreen);
        color: var(--backgroundWhite);
        border: none;
        border-radius: 2px;
        font-weight: 600;
        cursor: pointer;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        background-color: var(--backgroundWhite);
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 8px 0;
        min-width: 120px;
        border-radius: 4px;
    }

    .dropdown-menu li {
        padding: 6px 16px;
    }

    .dropdown-menu li a {
        color: var(--textGrey);
        text-decoration: none;
    }

    .dropdown-menu li:hover {
        background-color: var(--accentGreen2);
    }
</style>
