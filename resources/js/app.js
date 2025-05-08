import './bootstrap';
import { createApp } from 'vue';

import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Beranda from './pages/Beranda.vue';
import Jelajah from './pages/Jelajah.vue';
import PenukaranStep1 from './pages/penukaranstep1.vue';
import PenukaranStep2 from './pages/PenukaranStep2.vue';
import PenukaranStep3 from './pages/PenukaranStep3.vue';
import PenukaranStep3_2 from './pages/PenukaranStep3_2.vue';
import PenukaranKoin from './pages/PenukaranKoin.vue';
import VerifikasiPenukaran from './pages/VerifikasiPenukaran.vue';

const el = document.getElementById('app'); 

if (el) {
  const page = el.dataset.page;
  let component = null;
  // console.log(page) // apakah bisa jika pake parameter?, karena di cek di console jika menggunakan parameter tdk menampilkan apa2

  switch (page) {
    case 'login':
      component = Login;
      break;
    case 'register':
      component = Register;
      break;
    case 'beranda':
      component = Beranda;
      break;
    case 'penukaran-step-1':
      component = PenukaranStep1;
      break;
    case 'penukaran-step-2':
      component = PenukaranStep2;
      break;
    case 'penukaran-step-3':
      component = PenukaranStep3;
      break;
    case 'penukaran-step-3-2':
      component = PenukaranStep3_2;
      break;
    case 'penukaran-koin':
      component = PenukaranKoin;
      break;
    case 'jelajah':
      component = Jelajah;
      break;
    // case 'tentang':
    //   component = Jelajah;
    //   break;
    // case 'profile':
    //   component = Profile;
    //   break;
    // case 'riwayat-recycle':
    //   component = RiwayatRecycle;
    //   break;
    case 'verifikasi-penukaran':
      component = VerifikasiPenukaran;
      break;
    
    // case 'kelola-voucher':
    //   component = KelolaVoucher;
    //   break;
    // case 'kelola-user':
    //   component = KelolaUser;
    //   break;
    default:
        console.error('Unknown page component:', page);
        break;
  }

  if (component) {
    createApp(component).mount('#app');
    console.log(`Mounted ${page} component`);
  }
}
