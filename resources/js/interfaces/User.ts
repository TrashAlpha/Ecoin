export interface User {
    id: number;
    name: string;
    email: string;
    saldo_koin: number;
    akun_facebook: string | null;
    akun_twitter: string | null;
    role: 'admin' | 'user'; // tambahkan sesuai kebutuhan
    status: 'active' | 'inactive' | 'banned';
    created_at: string;
    updated_at: string;
  }