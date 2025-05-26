<template>
  <div v-if="visible" class="modal-overlay">
    <div class="modal-container">
      <!-- Gambar verifikasi -->
      <img class="verification-icon" :src="icon" alt="Verifikasi Icon" />

      <!-- Teks verifikasi -->
      <p class="success-text">Verifikasi Berhasil</p>

      <!-- Tombol lanjut -->
      <button class="btn proceed" @click="$emit('confirm')">Lanjut</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "RedeemMoneyModal",
  props: {
    visible: {
      type: Boolean,
      required: true
    },
    icon: {
      type: String,
      default: "/images/VerificationIcon.png" // Ganti ini dengan path ikon verifikasi kamu
    }
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

.modal-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.4);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-container {
  background-color: #f4f4f4;
  padding: 40px 24px;
  border-radius: 12px;
  text-align: center;
  width: 90%;
  max-width: 400px;
  font-family: 'Poppins', sans-serif;
  box-shadow: 0 0 0 3px #333;
}

.verification-icon {
  width: 80px;
  height: 80px;
  margin: 0 auto 24px;
  display: block;
}

.success-text {
  font-size: 22px;
  font-weight: 600;
  color: #006666;
  margin-bottom: 32px;
}

.btn.proceed {
  background-color: #006666;
  color: white;
  padding: 12px 32px;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  font-size: 16px;
  cursor: pointer;
  outline: 3px solid #1d9bf0;
  outline-offset: -3px;
  transition: transform 0.2s ease;
}

.btn.proceed:hover {
  transform: scale(1.02);
}
</style>
