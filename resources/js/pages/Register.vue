<template>
    <div class="register-container">
      <!-- Left Section - Welcome Message -->
      <div class="welcome-section">
        <div class="welcome-content">
          <h1 class="welcome-title">Hello, Pengguna</h1>
          <p class="welcome-text">
            Ayo Bergabunglah Bersama Kami, Dan Jadilah Bagian Dari Misi Kami Untuk Mengurangi Sampah Plastik Dan Meningkatkan Daur Ulang Di Indonesia.
          </p>
          <button class="welcome-btn" @click="goToLogin">Masuk</button>
        </div>
      </div>
  
      <!-- Right Section - Register Form -->
      <div class="register-section">
        <div class="register-content">
          <div class="eco-title">
            <img src="/public/images/logo_ecoin.png" alt="Logo" class="logo-icon" />
            <span>ECOIN</span>
          </div>
          <h2 class="register-title">Daftar Akun Ecoin</h2>
  
          <div class="social-register">
            <button class="social-btn">
              <img src="/public/images/ic_facebook.png" alt="Facebook" class="social-icon" />
            </button>
            <button class="social-btn">
              <img src="/public/images/ic_googleplus.png" alt="Google" class="social-icon" />
            </button>
            <button class="social-btn">
              <img src="/public/images/ic_twitter.png" alt="Twitter" class="social-icon" />
            </button>
          </div>
  
          <p class="register-subtitle">Atau daftarkan akun Ecoin Anda</p>
  
          <form class="register-form" @submit.prevent="handleRegister">
            <input type="hidden" name="_token" :value="csrfToken" />
  
            <div class="form-group">
              <input v-model="name" type="text" class="form-input" placeholder="Nama" required>
            </div>
  
            <div class="form-group">
              <input v-model="email" type="email" class="form-input" placeholder="Email" required>
            </div>
  
            <div class="form-group">
              <input v-model="password" type="password" class="form-input" placeholder="Password" required>
            </div>
  
            <div class="form-group">
              <input v-model="confirmPassword" type="password" class="form-input" placeholder="Confirm Password" required>
            </div>
  
            <button type="submit" class="register-btn">Buat Akun</button>
  
            <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
<script>
import axios from 'axios'
import { theme } from '../config/theme'

export default {
  name: 'RegisterPage',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      confirmPassword: '',
      errorMessage: '',
      csrfToken: '' 
    }
  },
  mounted() {
    const root = document.documentElement;
    root.style.setProperty('--primaryGreen', theme.colors.primaryGreen);
    root.style.setProperty('--accentGreen1', theme.colors.accentGreen1);
    root.style.setProperty('--textGrey', theme.colors.textGrey);
    root.style.setProperty('--textField', theme.colors.textField);
    root.style.setProperty('--accentGreen2', theme.colors.accentGreen2);
    root.style.setProperty('--textBlack', theme.colors.textBlack);
    root.style.setProperty('--backgroundWhite', theme.colors.backgroundWhite);
    root.style.setProperty('--fontFamily', theme.fonts.family);
    root.style.setProperty('--fontSizeHeading', theme.fonts.size.heading);
    root.style.setProperty('--fontWeightBold', theme.fonts.weight.bold);
  },
  methods: {
    async handleRegister() {
      if (this.password !== this.confirmPassword) {
        this.errorMessage = 'Password dan konfirmasi tidak cocok.';
        return;
      }

      try {
        const response = await axios.post('http://localhost:8000/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.confirmPassword
        });

        // Registrasi sukses, arahkan ke halaman login
        this.errorMessage = '';
        alert("Pendaftaran berhasil! Silakan login.");
        this.goToLogin();
      } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
          this.errorMessage = error.response.data.message;
        } else {
          this.errorMessage = 'Terjadi kesalahan saat mendaftar.';
        }
      }
    },
    goToLogin() {
      window.location.href = '/login';
    }
  }
}
</script>
  
  <style scoped>
  .register-container {
    display: flex;
    min-height: 100vh;
    font-family: var(--fontFamily);
  }
  
  .welcome-section {
    flex: 1;
    background-color: var(--primaryGreen);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
  }
  
  .register-section {
    flex: 1;
    background-color: var(--backgroundWhite);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
  }
  
  .welcome-content {
    max-width: 400px;
    text-align: center;
    color: white;
  }
  
  .welcome-title {
    font-size: var(--fontSizeHeading);
    font-weight: bold;
    margin-bottom: 1.5rem;
  }
  
  .welcome-text {
    margin-bottom: 2rem;
    font-size: 0.9rem;
    line-height: 1.6;
  }
  
  .welcome-btn {
    padding: 0.8rem 2rem;
    border: 1px solid white;
    color: white;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    background: transparent;
  }
  
  .register-content {
    max-width: 400px;
    width: 100%;
  }
  
  .eco-title {
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primaryGreen);
    font-size: var(--fontSizeHeading);
    margin-bottom: 1.5rem;
    gap: 0.5rem;
    font-weight: var(--fontWeightBold);
  }
  
  .logo-icon {
    width: 32px;
    height: 32px;
  }
  
  .register-title {
    color: var(--textBlack);
    font-size: 1.2rem;
    text-align: center;
    font-weight: bold;
    margin-bottom: 2rem;
  }
  
  .social-register {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1rem;
  }
  
  .social-btn {
    width: 40px;
    height: 40px;
    border: 2px solid var(--textGrey);
    border-radius: 8px;
    background: none;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .social-icon {
    width: 20px;
    height: 20px;
  }
  
  .register-subtitle {
    text-align: center;
    color: var(--textGrey);
    font-size: 0.85rem;
    margin: 1rem 0;
  }
  
  .form-group {
    margin-bottom: 1.2rem;
  }
  
  .form-input {
    width: 100%;
    padding: 0.8rem;
    border: 2px solid var(--textField);
    border-radius: 4px;
    font-size: 1rem;
    background-color: var(--textField);
  }
  
  .register-btn {
    width: 100%;
    padding: 0.8rem;
    background-color: var(--primaryGreen);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
  }
  
  .error-message {
    margin-top: 1rem;
    color: red;
    font-size: 0.9rem;
    text-align: center;
  }
  </style>
  