import './bootstrap';
import { createApp } from 'vue';

import PenukaranStep2 from './pages/PenukaranStep2.vue';
import PenukaranStep3_2 from './pages/PenukaranStep3_2.vue';
import PenukaranKoin from './pages/PenukaranKoin.vue';
import Jelajah from './pages/Jelajah.vue';
import Tentang from './pages/Tentang.vue';
import PenukaranStep1 from './pages/PenukaranStep1.vue';
import Beranda from './pages/Beranda.vue';
import PenukaranStep3 from './pages/PenukaranStep3.vue';
import ManajemenUser from './pages/ManajemenUser.vue';
import Profil from './pages/Profil.vue';

const el = document.getElementById('app');

if (el) {
  const page = el.dataset.page;
  let component = null;

  switch (page) {
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
    case 'tentang':
      component = Tentang;
      break;
    // case 'profile':

    //   break;
    // case 'riwayat-recycle':

    //   break;
    case 'manajemen-user':
        component = ManajemenUser;
        break;
    case 'profil':
        component = Profil;
        break;
    default:
        console.error('Unknown page component:', page);
        break;
  }

  if (component) {
    createApp(component).mount('#app');
    console.log(`Mounted ${page} component`);
  }
}
