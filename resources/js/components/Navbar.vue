<template>
  <header class="navbar">
    <div class="navbar-left">
      <a href="/beranda">
        <img src="/public/images/logoheader.png" alt="Ecoin Logo" class="logo" />
      </a>
    </div>
    <nav class="navbar-right">
      <!-- Tombol hamburger -->
      <button class="hamburger" @click="toggleMobileMenu">☰</button>

      <!-- Desktop menu -->
      <ul class="nav-links desktop">
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

      <!-- Mobile menu -->
      <ul class="nav-links mobile" :class="{ open: isMobileMenuOpen }">
        <li><a href="/beranda">Beranda</a></li>
        <li>
          <a @click.prevent="toggleDropdownMobile">Penukaran</a>
          <ul v-if="isMobileDropdownOpen" class="dropdown-menu">
            <li><a href="/penukaran1">Sampah</a></li>
            <li><a href="/penukaran_koin">Koin</a></li>
          </ul>
        </li>
        <li><a href="/jelajah">Jelajah</a></li>
        <li><a href="/tentang">Tentang</a></li>
        <li v-if="role === 'admin'"><a href="/admin/verifikasi_penukaran">Verifikasi Penukaran</a></li>
        <li v-if="role === 'admin'"><a href="/admin/manajemen_voucher">Manajemen Voucher</a></li>
        <li v-if="role === 'admin'"><a href="/admin/manajemen_user">Manajemen User</a></li>
      </ul>

      <!-- Login / Profile -->
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
      isMobileDropdownOpen: false,
      isMobileMenuOpen: false,
      isLoggedIn: false,
      profileImage: '/public/images/user-icon.png',
      role: null,
      user: null,
    };
  },
  async mounted() {
    const saved = localStorage.getItem('user');
    if (saved) {
      this.user = JSON.parse(saved);
      this.isLoggedIn = true;
      this.role = this.user.role;
      this.profileImage = this.user.photo_profile_url || '/images/user-icon.png';
    }

    await this.fetchUserData();
    this.setThemeVariables();
    window.addEventListener('popstate', this.fetchUserData);
  },
  beforeUnmount() {
    window.removeEventListener('popstate', this.fetchUserData);
  },
  methods: {
    async fetchUserData() {
      try {
        const response = await axios.get('http://localhost:8000/api/get-user', {
          withCredentials: true,
          headers: { Accept: 'application/json' }
        });

        if (response.data && response.data.user) {
          this.user = response.data.user;
          this.isLoggedIn = true;
          this.role = this.user.role;
          this.profileImage = this.user.photo_profile_url || '/images/user-icon.png';
          localStorage.setItem('user', JSON.stringify(this.user));
        } else {
          this.isLoggedIn = false;
          this.user = null;
          this.role = null;
          localStorage.removeItem('user');
        }
      } catch (error) {
        console.error('Error fetching user data:', error);
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
      Object.entries(theme.colors).forEach(([key, value]) => {
        root.style.setProperty(`--${key}`, value);
      });
      Object.entries(theme.fonts.size).forEach(([key, value]) => {
        root.style.setProperty(`--fontSize${key[0].toUpperCase() + key.slice(1)}`, value);
      });
      Object.entries(theme.fonts.weight).forEach(([key, value]) => {
        root.style.setProperty(`--fontWeight${key[0].toUpperCase() + key.slice(1)}`, value);
      });
      root.style.setProperty('--fontFamily', theme.fonts.family);
    },
    openDropdown() {
      this.isDropdownOpen = true;
    },
    closeDropdown() {
      this.isDropdownOpen = false;
    },
    toggleDropdownMobile() {
      this.isMobileDropdownOpen = !this.isMobileDropdownOpen;
    },
    toggleMobileMenu() {
      this.isMobileMenuOpen = !this.isMobileMenuOpen;
    },
    isActive(path) {
      return window.location.pathname === path;
    },
    goToProfile() {
      window.location.href = '/profile';
    },
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
  position: relative;
}

.logo {
  height: 40px;
  cursor: pointer;
}

.navbar-right {
  display: flex;
  align-items: center;
  position: relative;
}

.hamburger {
  display: none;
  font-size: 26px;
  background: none;
  border: none;
  cursor: pointer;
  color: var(--textBlack);
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
}

.nav-links a:hover {
  color: var(--accentGreen1);
  transition: 0.3s;
}

.nav-links li.active > a {
  color: var(--accentGreen1);
  font-weight: var(--fontWeightNormal);
  border-bottom: 2px solid var(--accentGreen1);
}

.login-button {
  margin-left: 24px;
  padding: 8px 20px;
  background-color: var(--primaryGreen);
  color: var(--backgroundWhite);
  border: 2px solid transparent;
  font-weight: 600;
  cursor: pointer;
  border-radius: 4px;
  text-decoration: none;
}

.login-button:hover {
  border: 2px solid var(--primaryGreen);
  background-color: var(--accentGreen2);
  color: var(--primaryGreen);
  transition: 0.3s;
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
}

.dropdown-menu li:hover {
  background-color: var(--accentGreen2);
  font-weight: var(--fontWeightBold);
  color: var(--accentGreen1);
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

/* Responsive */
@media (max-width: 768px) {
  .nav-links.desktop {
    display: none;
  }

  .hamburger {
    display: block;
  }

  .nav-links.mobile {
    display: none;
    flex-direction: column;
    position: absolute;
    top: 70px;
    right: 32px;
    background-color: var(--backgroundWhite);
    padding: 12px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    z-index: 999;
    gap: 12px;
  }

  .nav-links.mobile.open {
    display: flex;
  }

  .dropdown-menu {
    position: relative;
    top: 0;
    box-shadow: none;
    padding-left: 16px;
  }
}
</style>
