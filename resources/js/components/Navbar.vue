<template>
    <header class="navbar">
      <div class="navbar-left">
        <a href="/beranda">
          <img src="/public/images/logoheader.png" alt="Ecoin Logo" class="logo" />
        </a>
      </div>
      <nav class="navbar-right">
        <ul class="nav-links">
          <li :class="{ active: isActive('/beranda') }"><a href="/beranda">Beranda</a></li>

          <li
            class="dropdown"
            @mouseenter="openDropdown"
            @mouseleave="closeDropdown"
            :class="{ active: isActive('/penukaran1') || isActive('/penukaran_koin') || isActive('/penukaran2') || isActive('/penukaran3') || isActive('/penukaran3_2') }"
          >
            <a href="#">Penukaran</a>
            <ul v-if="isDropdownOpen" class="dropdown-menu">
              <li><a href="/penukaran1">Sampah</a></li>
              <li><a href="/penukaran_koin">Koin</a></li>
            </ul>
          </li>

          <li :class="{ active: isActive('/jelajah') }"><a href="/jelajah">Jelajah</a></li>
          <li :class="{ active: isActive('/tentang') }"><a href="/tentang">Tentang</a></li>

          <li v-if="role === 'admin'" :class="{ active: isActive('/admin/verifikasi_penukaran') }"><a href="/admin/verifikasi_penukaran">Verifikasi Penukaran</a></li>
          <li v-if="role === 'admin'" :class="{ active: isActive('/admin/manajemen_voucher') }"><a href="/admin/manajemen_voucher">Manajemen Voucher</a></li>
          <li v-if="role === 'admin'" :class="{ active: isActive('/admin/manajemen_user') }"><a href="/admin/manajemen_user">Manajemen User</a></li>
        </ul>
        <!-- Toggle between login button and profile icon -->
        <template v-if="!isLoggedIn">
          <a href="/login" class="login-button">Masuk</a>
        </template>
        <template v-else>
          <img
            :src="user?.photo_profile_url || '/images/user-icon.png'"
            alt="Profile"
            class="profile-icon"
            @click="goToProfile"
          />
        </template>
      </nav>
    </header>
  </template>

<script>
import { theme } from '../config/theme';
import axios from 'axios';

export default {
    name: 'Navbar',
    data() {
        return {
            isDropdownOpen: false,
            isLoggedIn: false,
            profileImage: '/public/images/user-icon.png', // Default profile image
            role: null,
            user: null,
        };
    },
    async mounted() {
        // Pertama, cek localStorage untuk UX yang lebih cepat
        const saved = localStorage.getItem('user');
        if (saved) {
            this.user = JSON.parse(saved);
            this.isLoggedIn = true;
            this.role = this.user.role;
            this.profileImage = this.user.photo_profile_url || '/images/user-icon.png';
        }

        // Kemudian, selalu ambil data terbaru dari API
        await this.fetchUserData();

        // Set CSS variables from theme
        this.setThemeVariables();

        // Tambahkan event listener untuk menangani navigasi
        window.addEventListener('popstate', this.fetchUserData);
    },
    beforeUnmount() {
        // Bersihkan event listener ketika komponen di-unmount
        window.removeEventListener('popstate', this.fetchUserData);
    },
    methods: {
        async fetchUserData() {
            try {
                const response = await axios.get('http://localhost:8000/api/get-user', {
                  withCredentials: true,
                  headers: {
                    'Accept': 'application/json'
                  }
                });

                if (response.data && response.data.user) {
                    this.user = response.data.user;
                    this.isLoggedIn = true;
                    this.role = this.user.role;
                    this.profileImage = this.user.photo_profile_url || '/images/user-icon.png';

                    // Simpan ke localStorage untuk akses lebih cepat next time
                    localStorage.setItem('user', JSON.stringify(this.user));
                    console.log('User data fetched:', this.user);
                } else {
                    // Jika tidak ada user yang login
                    this.isLoggedIn = false;
                    this.user = null;
                    this.role = null;
                    localStorage.removeItem('user');
                }
            } catch (error) {
                console.error('Error fetching user data:', error);
                // Jika error (misal: token expired), anggap user tidak login
                if (error.response && error.response.status === 401) {
                    this.isLoggedIn = false;
                    this.user = null;
                    this.role = null;
                    localStorage.removeItem('user');
                }
            }
        },
        setThemeVariables() {
            const root = document.documentElement;
            root.style.setProperty('--primaryGreen', theme.colors.primaryGreen);
            root.style.setProperty('--accentGreen1', theme.colors.accentGreen1);
            root.style.setProperty('--textGrey', theme.colors.textGrey);
            root.style.setProperty('--textField', theme.colors.textField);
            root.style.setProperty('--accentGreen2', theme.colors.accentGreen2);
            root.style.setProperty('--textBlack', theme.colors.textBlack);
            root.style.setProperty('--backgroundWhite', theme.colors.backgroundWhite);
            root.style.setProperty('--accentRed', theme.colors.accentRed);

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
        openDropdown() {
            this.isDropdownOpen = true;
        },
        closeDropdown() {
            this.isDropdownOpen = false;
        },
        isActive(path) {
            return window.location.pathname === path;
        },
        goToProfile() {
            window.location.href = '/profile';
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
}

.navbar-left {
    display: flex;
    align-items: center;
    cursor: pointer; /* logo juga bisa diklik */
}

.logo {
    height: 40px;
    margin-right: 10px;
    cursor: pointer; /* kursor jadi pointer di logo */
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
    cursor: pointer;
}

.nav-links a {
    text-decoration: none;
    color: var(--textBlack);
    font-size: var(--fontSizeNormal);
    font-weight: 500;
    cursor: pointer;
}

.nav-links a:hover {
    color: var(--accentGreen1);
    transition-duration: 0.3s;
    /* font-weight: var(--fontWeightBold); */
}

.login-button {
    display: inline-block;
    text-align: center;
    text-decoration: none; /* hilangkan underline */
    margin-left: 24px;
    padding: 8px 20px;
    background-color: var(--primaryGreen);
    color: var(--backgroundWhite);
    border: 2px solid transparent;
    font-weight: 600;
    cursor: pointer;
    border-radius: 4px;
}

.login-button:hover {
    border: 2px solid var(--primaryGreen);
    background-color: var(--accentGreen2);
    color: var(--primaryGreen);
    transition-duration: 0.3s;
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
    z-index: 1000;
}

.dropdown-menu li {
    padding: 6px 16px;
    cursor: pointer;
}

.dropdown-menu li a {
    color: var(--textBlack);
    text-decoration: none;
    cursor: pointer;
}

.dropdown-menu li:hover {
    background-color: var(--accentGreen2);
    font-weight: var(--fontWeightBold);
    color: var(--accentGreen1);
}

.nav-links li.active > a {
  color: var(--accentGreen1);
  font-weight: var(--fontWeightNormal);
  border-bottom: 2px solid var(--accentGreen1);
}

.profile-icon {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  border: 2px solid var(--primaryGreen);
  margin-left: 24px;
  cursor: pointer;
  padding: 3px;
  object-fit: cover;
}

</style>