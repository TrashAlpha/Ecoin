<template>
    <div v-if="visible" class="modal-overlay">
      <div class="modal-container">
        <img class="icon" :src="icon" alt="Voucher Icon" />
        <p class="text">
          Apakah anda yakin ingin menukar {{ coins }} koin dengan voucher ini?
        </p>
        <div class="button-group">
          <button class="btn cancel" @click="$emit('cancel')">Batal</button>
          <button class="btn confirm" @click="$emit('confirm')">Lanjut</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "RedeemVoucherModal",
    props: {
      visible: {
        type: Boolean,
        required: true
      },
      coins: {
        type: Number,
        default: 0
      },
      icon: {
        type: String,
        default: "/public/images/mdi_voucher.png" // Ganti jika icon berada di path lain
      }
    }
  };
  </script>
  
  <style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
  
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
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
  }
  
  .text {
    font-size: 18px;
    color: #4a4a4a;
    margin-bottom: 24px;
    font-weight: 600;
  }
  
  .button-group {
    display: flex;
    justify-content: space-between;
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
  