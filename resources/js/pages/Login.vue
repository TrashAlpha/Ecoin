<template>
    <div class="login-container">
      <!-- Left Section - Login Form -->
      <div class="login-section">
        <img src="/public/images/ic_back.png" alt="back" class="back-icon" @click="goToHome" />
        <div class="login-content">
          <div class="eco-title">
            <img src="/public/images/logo_ecoin.png" alt="Logo" class="logo-icon" />
            <span>ECOIN</span>
          </div>
          <h2 class="login-title">Masuk Ke Akun Ecoin</h2>
  
          <div class="social-login">
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
  
          <div class="separator">
            <hr class="line">
            <span class="separator-text">Atau masuk dengan menggunakan akun Anda</span>
            <hr class="line">
          </div>
  
          <!-- Login Form -->
          <form class="login-form" @submit.prevent="handleLogin">
            <!-- Simulasi CSRF Token -->
            <input type="hidden" name="_token" :value="csrfToken" />
  
            <div class="form-group">
              <input v-model="email" type="email" class="form-input" placeholder="Email" required>
            </div>
  
            <div class="form-group">
              <input v-model="password" type="password" class="form-input" placeholder="Password" required>
            </div>
  
            <a href="#" class="forgot-password">Lupa Password?</a>
  
            <button type="submit" class="login-btn">Masuk</button>
  
            <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
          </form>
        </div>
      </div>
  
      <!-- Right Section - Welcome Message -->
      <div class="welcome-section">
        <div class="welcome-content">
          <h1 class="welcome-title">Hello, Pengguna</h1>
          <p class="welcome-text">
            Ayo Bergabunglah Bersama Kami, Dan Jadilah Bagian Dari Misi Kami Untuk Mengurangi Sampah Plastik Dan Meningkatkan Daur Ulang Di Indonesia.
          </p>
          <button class="welcome-btn" @click="goToRegister">Daftar</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
    import { theme } from '../config/theme'
  
    export default {
      name: 'LoginPage',
      data() {
        return {
          email: '',
          password: '',
          errorMessage: '',
          csrfToken: '' 
        }
      },
      mounted() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
        root.style.setProperty('--fontWeightSemiBold', theme.fonts.weight.semibold);
      },
      methods: {
        async handleLogin() {
          try {
            const response = await axios.post('http://localhost:8000/api/login', {
              email: this.email,
              password: this.password
            },);

            if(response.status === 200) {
              localStorage.setItem('user', JSON.stringify(response.data.user));
              console.log("User data:", response.data.user);
            }

            // Login sukses, arahkan ke halaman beranda
            this.errorMessage = '';
            window.location.href = '/beranda';
          } catch (error) {
            if (error.response && error.response.data && error.response.data.message) {
              this.errorMessage = error.response.data.message;
            } else {
              this.errorMessage = 'Terjadi kesalahan saat login.';
            }
          }
        },
        goToRegister() {
          window.location.href = '/register';
        },
        goToHome() {
          window.location.href = '/beranda';
        }
      }
    }
  </script>
  
  <style scoped>
  .login-container {
    display: flex;
    min-height: 100vh;
    font-family: var(--fontFamily);
  }

  .back-icon {
    width: 32px;
    height: 32px;
    position: absolute;
    top: 20px;
    left: 20px;
    cursor: pointer;
    border-radius: 5px;
    background-color: var(--primaryGreen);
  }
  
  .login-section {
    flex: 1;
    background-color: var(--backgroundWhite);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
  }
  
  .welcome-section {
    flex: 1;
    background-color: var(--primaryGreen);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
  }
  
  .login-content {
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
  
  .login-title {
    color: var(--textBlack);
    font-size: 1.2rem;
    text-align: center;
    font-weight: bold;
    margin-bottom: 2rem;
  }
  
  .social-login {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2rem;
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
  
  .separator {
    display: flex;
    align-items: center;
    margin: 2rem 0;
  }
  
  .line {
    flex: 1;
    border: 1px solid var(--textGrey);
  }
  
  .separator-text {
    padding: 0 1rem;
    color: var(--textGrey);
    font-size: 0.85rem;
    white-space: nowrap;
  }
  
  .form-group {
    margin-bottom: 1.5rem;
  }
  
  .form-input {
    width: 100%;
    padding: 0.8rem;
    border: 2px solid var(--textField);
    border-radius: 4px;
    font-size: 1rem;
    background-color: var(--textField);
  }
  
  .forgot-password {
    display: block;
    text-align: right;
    color: var(--textGrey);
    text-decoration: none;
    margin: 1rem 0;
    font-size: 0.85rem;
  }
  
  .login-btn {
    width: 100%;
    padding: 0.8rem;
    background-color: var(--primaryGreen);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
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
  
  .error-message {
    margin-top: 1rem;
    color: red;
    font-size: 0.9rem;
    text-align: center;
  }
  </style>
  