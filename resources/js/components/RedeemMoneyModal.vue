<template>
  <div v-if="visible" class="modal-overlay">
    <div class="modal-container">
      <img class="icon" :src="icon" alt="Icon" />
      <p class="text">Anda akan menukar <strong>{{ coins }}</strong> koin menjadi <strong>Rp {{ ((coins * 1000) - adminFee).toLocaleString('id-ID') }}</strong> ke <strong>{{ bankName }}</strong>.</p>
      
      <input v-model="rekening" type="text" placeholder="Masukkan Nomor Rekening" class="input-field" />
      <input v-model="password" type="password" placeholder="Masukkan Password Rekening" class="input-field" />

      <div class="button-group">
        <button class="btn cancel" @click="$emit('cancel')">Batal</button>
        <button class="btn confirm" @click="submit">Konfirmasi</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';

const props = defineProps({
  visible: Boolean,
  coins: Number,
  icon: String,
  adminFee: Number,
  bankName: String
});

const emits = defineEmits(['cancel', 'confirm']);

const rekening = ref('');
const password = ref('');

function submit() {
  if (!rekening.value || !password.value) {
    alert('Mohon isi nomor rekening dan password!');
    return;
  }
  emits('confirm', { rekening: rekening.value, password: password.value });
}
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
  background-color: white;
  padding: 24px;
  border-radius: 12px;
  text-align: center;
  width: 90%;
  max-width: 400px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  font-family: 'Poppins', sans-serif;
}

.icon {
  width: 48px;
  height: 48px;
  margin-bottom: 16px;
  display: block;
  margin-left: auto;
  margin-right: auto;
}

.text {
  font-size: 16px;
  color: #333;
  margin-bottom: 16px;
  font-weight: 500;
}

.input-field {
  width: 100%;
  padding: 10px;
  margin: 8px 0;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-family: 'Poppins', sans-serif;
}

.button-group {
  display: flex;
  justify-content: space-between;
  margin-top: 16px;
}

.btn {
  flex: 1;
  padding: 10px;
  border: none;
  color: white;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
  font-family: 'Poppins', sans-serif;
}

.btn.cancel {
  background-color: #b0c4c4;
  margin-right: 10px;
}

.btn.confirm {
  background-color: #006666;
}
</style>
