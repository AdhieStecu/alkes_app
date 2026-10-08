<template>
  <div class="min-h-screen bg-slate-950 text-slate-100 flex flex-col font-sans">
    <!-- Toast Notification -->
    <transition
      enter-active-class="transition duration-300 ease-out transform"
      enter-from-class="-translate-y-4 opacity-0"
      enter-to-class="translate-y-0 opacity-100"
      leave-active-class="transition duration-200 ease-in transform"
      leave-from-class="translate-y-0 opacity-100"
      leave-to-class="-translate-y-4 opacity-0"
    >
      <div
        v-if="toast.show"
        class="fixed top-5 right-5 z-50 flex items-center space-x-3 px-4 py-3 rounded-xl shadow-2xl border text-sm max-w-md"
        :class="toast.type === 'error' ? 'bg-rose-950/90 text-rose-200 border-rose-800' : 'bg-emerald-950/90 text-emerald-200 border-emerald-800'"
      >
        <span class="text-lg">{{ toast.type === 'error' ? '⚠️' : '✅' }}</span>
        <span class="font-medium">{{ toast.message }}</span>
        <button @click="toast.show = false" class="text-slate-400 hover:text-white ml-2">✕</button>
      </div>
    </transition>

    <!-- Top Navigation Bar (Always Visible) -->
    <header class="border-b border-slate-800/80 bg-slate-900/70 backdrop-blur-md sticky top-0 z-40">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <!-- Logo & Title -->
        <a href="/" @click.prevent="navigate('/')" class="flex items-center space-x-3 group cursor-pointer">
          <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-cyan-500 via-teal-500 to-emerald-400 p-[2px] shadow-lg shadow-teal-500/20 group-hover:scale-105 transition-transform">
            <div class="h-full w-full bg-slate-950 rounded-[10px] flex items-center justify-center font-bold text-lg text-teal-400">
              🩺
            </div>
          </div>
          <div>
            <div class="flex items-center space-x-2">
              <span class="font-extrabold text-lg tracking-tight bg-gradient-to-r from-teal-400 to-emerald-400 bg-clip-text text-transparent">
                Alkes App
              </span>
              <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-teal-500/10 text-teal-300 border border-teal-500/20 uppercase tracking-wider">
                UMPKU
              </span>
            </div>
            <p class="text-[11px] text-slate-400 hidden sm:block">Sistem Informasi Alat Kesehatan</p>
          </div>
        </a>

        <!-- Center Nav Links -->
        <nav class="hidden md:flex items-center space-x-2">
          <button
            v-if="user"
            @click="navigate('/dashboard')"
            class="px-3 py-1.5 rounded-lg text-sm font-medium transition"
            :class="currentPath === '/dashboard' || currentPath === '/' ? 'bg-slate-800 text-teal-400' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'"
          >
            Dashboard
          </button>
          <button
            v-if="user"
            @click="navigate('/profile')"
            class="px-3 py-1.5 rounded-lg text-sm font-medium transition"
            :class="currentPath === '/profile' ? 'bg-slate-800 text-teal-400' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'"
          >
            Manajemen Profil
          </button>
          <a
            href="/alat"
            class="px-3.5 py-1.5 rounded-lg text-xs sm:text-sm font-semibold text-teal-300 bg-teal-500/10 border border-teal-500/30 hover:bg-teal-500/20 transition flex items-center space-x-1.5"
          >
            <span>🩺</span>
            <span>CRUD Alat Medis (Bootstrap)</span>
          </a>
        </nav>

        <!-- Right Side: Auth buttons or Profile Menu (Pojok Kanan Atas) -->
        <div class="flex items-center space-x-3">
          <!-- When Logged Out -->
          <div v-if="!user" class="flex items-center space-x-2">
            <button
              @click="navigate('/login')"
              class="px-3.5 py-1.5 rounded-lg text-xs sm:text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/60 transition"
              :class="{ 'text-teal-400 bg-slate-800/40': currentPath === '/login' }"
            >
              Masuk (Login)
            </button>
            <button
              @click="navigate('/register')"
              class="px-3.5 py-1.5 rounded-lg text-xs sm:text-sm font-semibold bg-gradient-to-r from-teal-500 to-emerald-500 text-slate-950 hover:from-teal-400 hover:to-emerald-400 transition shadow-sm shadow-emerald-500/20"
            >
              Registrasi
            </button>
          </div>

          <!-- When Logged In: Menu Profil (Pojok Kanan Atas) -->
          <div v-else class="relative" ref="profileDropdownRef">
            <button
              @click="profileMenuOpen = !profileMenuOpen"
              class="flex items-center space-x-2.5 p-1.5 rounded-xl hover:bg-slate-800/70 border border-slate-800 transition focus:outline-none focus:ring-2 focus:ring-teal-500/50"
            >
              <img
                :src="user.profile_photo_url"
                :alt="user.name"
                class="w-8 h-8 rounded-lg object-cover ring-2 ring-teal-500/40"
              />
              <div class="text-left hidden sm:block pr-1">
                <div class="text-xs font-semibold text-white leading-tight truncate max-w-[120px]">{{ user.name }}</div>
                <div class="text-[10px] text-teal-400 leading-tight">Menu Profil ▼</div>
              </div>
            </button>

            <!-- Dropdown Menu -->
            <transition
              enter-active-class="transition duration-150 ease-out"
              enter-from-class="scale-95 opacity-0"
              enter-to-class="scale-100 opacity-100"
              leave-active-class="transition duration-100 ease-in"
              leave-from-class="scale-100 opacity-100"
              leave-to-class="scale-95 opacity-0"
            >
              <div
                v-if="profileMenuOpen"
                class="absolute right-0 mt-2 w-56 rounded-xl bg-slate-900 border border-slate-800 shadow-2xl py-2 z-50 divide-y divide-slate-800"
              >
                <div class="px-4 py-2.5">
                  <p class="text-xs text-slate-400">Masuk sebagai:</p>
                  <p class="text-sm font-semibold text-white truncate">{{ user.name }}</p>
                  <p class="text-[11px] text-teal-400 truncate">{{ user.email }}</p>
                </div>

                <div class="py-1">
                  <button
                    @click="navigate('/profile'); profileMenuOpen = false"
                    class="w-full text-left px-4 py-2 text-xs font-medium text-slate-200 hover:bg-slate-800 hover:text-teal-400 flex items-center space-x-2 transition"
                  >
                    <span>👤</span>
                    <span>Manajemen Profil</span>
                  </button>
                  <button
                    @click="navigate('/dashboard'); profileMenuOpen = false"
                    class="w-full text-left px-4 py-2 text-xs font-medium text-slate-200 hover:bg-slate-800 hover:text-teal-400 flex items-center space-x-2 transition"
                  >
                    <span>📊</span>
                    <span>Dashboard Utama</span>
                  </button>
                </div>

                <div class="py-1">
                  <button
                    @click="handleLogout"
                    :disabled="loading"
                    class="w-full text-left px-4 py-2 text-xs font-medium text-rose-400 hover:bg-rose-500/10 flex items-center space-x-2 transition"
                  >
                    <span>🚪</span>
                    <span>Keluar (Logout)</span>
                  </button>
                </div>
              </div>
            </transition>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

      <!-- ============================================== -->
      <!-- VIEW: REGISTER                                 -->
      <!-- ============================================== -->
      <section v-if="currentPath === '/register'" class="max-w-md mx-auto">
        <div class="rounded-2xl bg-slate-900/80 border border-slate-800 p-6 sm:p-8 shadow-2xl backdrop-blur-sm">
          <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-teal-500/10 text-teal-400 border border-teal-500/20 text-2xl mb-3">
              📝
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Tugas Registrasi User</h1>
            <p class="text-xs text-slate-400 mt-1">Daftarkan akun institusi Anda untuk mengakses sistem Alkes</p>
          </div>

          <!-- Quick Autofill Helper for Task Convenience -->
          <div class="mb-5 p-3 rounded-xl bg-slate-950/60 border border-teal-500/20 flex items-center justify-between text-xs">
            <span class="text-slate-300">💡 Format email institusi UMPKU</span>
            <button
              type="button"
              @click="autofillDemo"
              class="text-teal-400 hover:underline font-semibold"
            >
              Isi Contoh
            </button>
          </div>

          <form @submit.prevent="handleRegister" class="space-y-4">
            <!-- Name -->
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">
                Name <span class="text-slate-500 font-normal">(Nama Lengkap Anda)</span>
              </label>
              <input
                v-model="registerForm.name"
                type="text"
                required
                placeholder="Contoh: Karina Fatah Binway"
                class="w-full bg-slate-950 border rounded-xl px-3.5 py-2.5 text-sm text-white focus:outline-none transition placeholder-slate-600"
                :class="errors.name ? 'border-rose-500 focus:border-rose-400' : 'border-slate-800 focus:border-teal-500'"
              />
              <p v-if="errors.name" class="text-[11px] text-rose-400 mt-1">{{ errors.name[0] }}</p>
            </div>

            <!-- Email -->
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">
                Email <span class="text-slate-500 font-normal">(format: nim@students.umpku.ac.id)</span>
              </label>
              <input
                v-model="registerForm.email"
                type="email"
                required
                placeholder="1202407014@students.umpku.ac.id"
                class="w-full bg-slate-950 border rounded-xl px-3.5 py-2.5 text-sm text-white focus:outline-none transition placeholder-slate-600 font-mono text-xs sm:text-sm"
                :class="errors.email ? 'border-rose-500 focus:border-rose-400' : 'border-slate-800 focus:border-teal-500'"
              />
              <p v-if="errors.email" class="text-[11px] text-rose-400 mt-1">{{ errors.email[0] }}</p>
            </div>

            <!-- Password -->
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">
                Password <span class="text-slate-500 font-normal">(minimal 8 karakter)</span>
              </label>
              <input
                v-model="registerForm.password"
                type="password"
                required
                placeholder="••••••••"
                class="w-full bg-slate-950 border rounded-xl px-3.5 py-2.5 text-sm text-white focus:outline-none transition placeholder-slate-600"
                :class="errors.password ? 'border-rose-500 focus:border-rose-400' : 'border-slate-800 focus:border-teal-500'"
              />
              <p v-if="errors.password" class="text-[11px] text-rose-400 mt-1">{{ errors.password[0] }}</p>
            </div>

            <!-- Password Confirmation -->
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">
                Konfirmasi Password
              </label>
              <input
                v-model="registerForm.password_confirmation"
                type="password"
                required
                placeholder="••••••••"
                class="w-full bg-slate-950 border rounded-xl px-3.5 py-2.5 text-sm text-white focus:outline-none transition placeholder-slate-600"
                :class="errors.password_confirmation ? 'border-rose-500 focus:border-rose-400' : 'border-slate-800 focus:border-teal-500'"
              />
            </div>

            <!-- Submit Button -->
            <button
              type="submit"
              :disabled="loading"
              class="w-full mt-2 py-3 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 text-slate-950 font-bold text-sm hover:from-teal-400 hover:to-emerald-400 transition shadow-lg shadow-emerald-500/20 disabled:opacity-60 flex items-center justify-center space-x-2"
            >
              <span v-if="loading" class="animate-spin">🌀</span>
              <span>{{ loading ? 'Memproses...' : 'Daftar Akun Baru' }}</span>
            </button>
          </form>

          <div class="mt-6 text-center text-xs text-slate-400">
            Sudah memiliki akun?
            <a href="/login" @click.prevent="navigate('/login')" class="text-teal-400 font-semibold hover:underline ml-1">
              Masuk di sini
            </a>
          </div>
        </div>
      </section>

      <!-- ============================================== -->
      <!-- VIEW: LOGIN                                    -->
      <!-- ============================================== -->
      <section v-else-if="currentPath === '/login'" class="max-w-md mx-auto">
        <div class="rounded-2xl bg-slate-900/80 border border-slate-800 p-6 sm:p-8 shadow-2xl backdrop-blur-sm">
          <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-2xl mb-3">
              🔐
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Masuk ke Sistem</h1>
            <p class="text-xs text-slate-400 mt-1">Masuk dengan akun institusi yang telah Anda buat</p>
          </div>

          <form @submit.prevent="handleLogin" class="space-y-4">
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Email Institusi</label>
              <input
                v-model="loginForm.email"
                type="email"
                required
                placeholder="nim@students.umpku.ac.id"
                class="w-full bg-slate-950 border rounded-xl px-3.5 py-2.5 text-sm text-white focus:outline-none transition placeholder-slate-600"
                :class="errors.email ? 'border-rose-500' : 'border-slate-800 focus:border-teal-500'"
              />
              <p v-if="errors.email" class="text-[11px] text-rose-400 mt-1">{{ errors.email[0] }}</p>
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Password</label>
              <input
                v-model="loginForm.password"
                type="password"
                required
                placeholder="••••••••"
                class="w-full bg-slate-950 border rounded-xl px-3.5 py-2.5 text-sm text-white focus:outline-none transition placeholder-slate-600"
                :class="errors.password ? 'border-rose-500' : 'border-slate-800 focus:border-teal-500'"
              />
            </div>

            <button
              type="submit"
              :disabled="loading"
              class="w-full mt-2 py-3 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 text-slate-950 font-bold text-sm hover:from-teal-400 hover:to-emerald-400 transition shadow-lg shadow-emerald-500/20 disabled:opacity-60 flex items-center justify-center space-x-2"
            >
              <span v-if="loading" class="animate-spin">🌀</span>
              <span>{{ loading ? 'Masuk...' : 'Masuk Sekarang' }}</span>
            </button>
          </form>

          <div class="mt-6 text-center text-xs text-slate-400">
            Belum punya akun?
            <a href="/register" @click.prevent="navigate('/register')" class="text-teal-400 font-semibold hover:underline ml-1">
              Daftar di sini (Tugas Registrasi)
            </a>
          </div>
        </div>
      </section>

      <!-- ============================================== -->
      <!-- VIEW: PROFILE MANAGEMENT                      -->
      <!-- ============================================== -->
      <section v-else-if="currentPath === '/profile'" class="max-w-3xl mx-auto space-y-6">
        <!-- Top Breadcrumb & Title -->
        <div class="flex items-center justify-between pb-2 border-b border-slate-800">
          <div>
            <div class="flex items-center space-x-2 text-xs text-slate-400 mb-1">
              <a href="/dashboard" @click.prevent="navigate('/dashboard')" class="hover:text-teal-400">Dashboard</a>
              <span>/</span>
              <span class="text-teal-400">Manajemen Profil</span>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Manajemen Profil</h1>
            <p class="text-xs text-slate-400">Kelola foto profil dan informasi akun Anda sesuai instruksi tugas</p>
          </div>
          <button
            @click="navigate('/dashboard')"
            class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-xs text-slate-300 hover:text-white transition"
          >
            ← Kembali ke Dashboard
          </button>
        </div>

        <div v-if="!user" class="p-8 text-center rounded-2xl bg-slate-900/60 border border-slate-800">
          <p class="text-sm text-slate-400 mb-4">Anda belum masuk ke sistem. Silakan login terlebih dahulu.</p>
          <button
            @click="navigate('/login')"
            class="px-4 py-2 bg-teal-500 text-slate-950 font-bold text-xs rounded-xl hover:bg-teal-400 transition"
          >
            Menuju Halaman Login
          </button>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
          <!-- Card: Foto Profil (Sesuai Butir 6 Tugas) -->
          <div class="md:col-span-1 rounded-2xl bg-slate-900/80 border border-slate-800 p-6 shadow-xl flex flex-col items-center text-center">
            <h3 class="text-sm font-bold text-white mb-1">Foto Profil</h3>
            <p class="text-[11px] text-slate-400 mb-4">Unggah satu gambar bebas sebagai "Foto Profil"</p>

            <!-- Avatar Preview Frame -->
            <div class="relative group mb-4">
              <div class="w-32 h-32 rounded-2xl overflow-hidden ring-4 ring-teal-500/30 shadow-2xl bg-slate-950 flex items-center justify-center">
                <img
                  :src="photoPreview || user.profile_photo_url"
                  :alt="user.name"
                  class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
                />
              </div>
              <div v-if="user.profile_photo_path" class="absolute -bottom-2 -right-2 bg-emerald-500 text-slate-950 text-[10px] font-extrabold px-2 py-0.5 rounded-full shadow">
                Aktif ✓
              </div>
            </div>

            <!-- Upload Controls -->
            <input
              type="file"
              ref="fileInputRef"
              accept="image/*"
              class="hidden"
              @change="onFileSelected"
            />

            <div class="w-full space-y-2">
              <button
                type="button"
                @click="$refs.fileInputRef.click()"
                class="w-full py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-white border border-slate-700 transition flex items-center justify-center space-x-1.5"
              >
                <span>📁</span>
                <span>{{ selectedFile ? 'Ganti Pilihan Gambar' : 'Pilih Gambar Bebas' }}</span>
              </button>

              <button
                v-if="selectedFile"
                type="button"
                :disabled="uploadingPhoto"
                @click="uploadProfilePhoto"
                class="w-full py-2 px-3 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 text-slate-950 text-xs font-bold hover:from-teal-400 hover:to-emerald-400 transition shadow-md shadow-emerald-500/20 disabled:opacity-60 flex items-center justify-center space-x-1.5"
              >
                <span v-if="uploadingPhoto" class="animate-spin">🌀</span>
                <span>{{ uploadingPhoto ? 'Mengunggah...' : 'Simpan Foto Profil' }}</span>
              </button>

              <button
                v-if="user.profile_photo_path && !selectedFile"
                type="button"
                @click="deleteProfilePhoto"
                class="w-full py-1.5 text-[11px] text-rose-400 hover:text-rose-300 transition"
              >
                Hapus Foto Kustom
              </button>
            </div>

            <p class="text-[10px] text-slate-500 mt-4 leading-normal">
              Mendukung file JPG, PNG, atau WebP (Maks. 5MB).
            </p>
          </div>

          <!-- Card: Detail Informasi Akun -->
          <div class="md:col-span-2 rounded-2xl bg-slate-900/80 border border-slate-800 p-6 shadow-xl space-y-5">
            <div class="border-b border-slate-800 pb-3">
              <h3 class="text-sm font-bold text-white">Informasi Akun Institusi</h3>
              <p class="text-xs text-slate-400">Data registrasi yang terdaftar pada sistem Alkes App</p>
            </div>

            <form @submit.prevent="updateProfileName" class="space-y-4">
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Lengkap</label>
                <input
                  v-model="profileForm.name"
                  type="text"
                  required
                  class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-teal-500"
                />
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Email Institusi</label>
                <input
                  :value="user.email"
                  type="email"
                  disabled
                  class="w-full bg-slate-950/50 border border-slate-800/60 rounded-xl px-3.5 py-2.5 text-sm text-slate-400 font-mono cursor-not-allowed"
                />
                <p class="text-[10px] text-slate-500 mt-1">Email terikat dengan identitas mahasiswa UMPKU.</p>
              </div>

              <div class="p-3.5 rounded-xl bg-slate-950/70 border border-slate-800 text-xs space-y-2">
                <div class="flex items-center justify-between text-slate-300">
                  <span class="text-slate-400">Status Tugas:</span>
                  <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    {{ user.profile_photo_path ? 'Lengkap (Foto Profil Terunggah)' : 'Menunggu Unggah Foto Profil' }}
                  </span>
                </div>
                <div class="flex items-center justify-between text-slate-300">
                  <span class="text-slate-400">Institusi Kampus:</span>
                  <span class="font-semibold text-teal-400">Universitas Muhammadiyah Kudus (UMPKU)</span>
                </div>
              </div>

              <button
                type="submit"
                :disabled="updatingName"
                class="px-4 py-2.5 rounded-xl bg-teal-500 text-slate-950 font-bold text-xs hover:bg-teal-400 transition disabled:opacity-60"
              >
                {{ updatingName ? 'Menyimpan...' : 'Perbarui Nama' }}
              </button>
            </form>
          </div>
        </div>
      </section>

      <!-- ============================================== -->
      <!-- VIEW: DASHBOARD / HOME                        -->
      <!-- ============================================== -->
      <section v-else class="space-y-8">
        <!-- Hero / Welcome Banner -->
        <div class="rounded-3xl p-6 sm:p-10 bg-gradient-to-r from-slate-900 via-slate-900 to-teal-950/50 border border-slate-800/80 shadow-2xl relative overflow-hidden">
          <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

          <div class="max-w-2xl relative z-10">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-teal-500/10 border border-teal-500/20 text-xs text-teal-300 mb-4">
              <span>🩺</span>
              <span>Sistem Informasi Inventaris Alat Kesehatan (Alkes)</span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
              {{ user ? `Selamat Datang, ${user.name}!` : 'Sistem Alkes App UMPKU' }}
            </h1>

            <p class="text-slate-400 text-sm sm:text-base mt-2 leading-relaxed">
              {{ user
                ? 'Akun Anda telah aktif dan terhubung ke sistem. Anda dapat mengelola profil atau meninjau katalog alat kesehatan di bawah ini.'
                : 'Aplikasi manajemen registrasi dan profil alat kesehatan dengan integrasi Laravel 10 dan Vue 3.'
              }}
            </p>

            <div class="mt-6 flex flex-wrap items-center gap-3">
              <template v-if="user">
                <button
                  @click="navigate('/profile')"
                  class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 text-slate-950 font-bold text-xs sm:text-sm hover:from-teal-400 hover:to-emerald-400 transition shadow-lg shadow-emerald-500/20 flex items-center space-x-2"
                >
                  <span>📷</span>
                  <span>Buka Menu Profil & Unggah Foto</span>
                </button>
                <a
                  href="/alat"
                  class="px-5 py-2.5 rounded-xl bg-teal-500/10 border border-teal-500/30 text-teal-300 font-semibold text-xs sm:text-sm hover:bg-teal-500 hover:text-slate-950 transition flex items-center space-x-2"
                >
                  <span>🩺</span>
                  <span>Buka CRUD Inventaris (/alat)</span>
                </a>
              </template>
              <template v-else>
                <button
                  @click="navigate('/register')"
                  class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-500 text-slate-950 font-bold text-xs sm:text-sm hover:from-teal-400 hover:to-emerald-400 transition shadow-lg shadow-emerald-500/20"
                >
                  Mulai Registrasi User (/register)
                </button>
                <button
                  @click="navigate('/login')"
                  class="px-5 py-2.5 rounded-xl bg-slate-800 text-white font-semibold text-xs sm:text-sm hover:bg-slate-700 transition border border-slate-700"
                >
                  Masuk Akun (/login)
                </button>
                <a
                  href="/alat"
                  class="px-5 py-2.5 rounded-xl bg-teal-500/10 border border-teal-500/30 text-teal-300 font-semibold text-xs sm:text-sm hover:bg-teal-500 hover:text-slate-950 transition flex items-center space-x-2"
                >
                  <span>🩺</span>
                  <span>Buka CRUD Inventaris (/alat)</span>
                </a>
              </template>
            </div>
          </div>
        </div>

        <!-- Checklist Tugas Tracker Card -->
        <div class="rounded-2xl p-6 bg-slate-900/80 border border-slate-800 shadow-xl">
          <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-800">
            <div class="flex items-center space-x-2.5">
              <span class="text-xl">📋</span>
              <div>
                <h2 class="text-base font-bold text-white">Status Verifikasi Tugas Registrasi User</h2>
                <p class="text-xs text-slate-400">Pantau setiap butir persyaratan tugas secara langsung</p>
              </div>
            </div>
            <span class="text-xs px-2.5 py-1 rounded-full font-semibold"
              :class="user && user.profile_photo_path ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20'"
            >
              {{ user && user.profile_photo_path ? 'Tugas Selesai 100%' : 'Sedang Dikerjakan' }}
            </span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            <div class="p-3.5 rounded-xl bg-slate-950/60 border border-slate-800/80 flex items-start space-x-3">
              <span class="text-base text-emerald-400">✅</span>
              <div>
                <div class="font-semibold text-slate-200">1. Akses alkes-app.test/register</div>
                <div class="text-slate-400 text-[11px] mt-0.5">Domain Herd dan route /register aktif dan dapat dibuka langsung.</div>
              </div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-950/60 border border-slate-800/80 flex items-start space-x-3">
              <span class="text-base" :class="user ? 'text-emerald-400' : 'text-slate-600'">{{ user ? '✅' : '⏳' }}</span>
              <div>
                <div class="font-semibold text-slate-200">2-5. Registrasi Nama, Email Institusi & Password >= 8</div>
                <div class="text-slate-400 text-[11px] mt-0.5">
                  {{ user ? `Terdaftar: ${user.name} (${user.email})` : 'Belum melakukan registrasi akun baru.' }}
                </div>
              </div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-950/60 border border-slate-800/80 flex items-start space-x-3">
              <span class="text-base" :class="user ? 'text-emerald-400' : 'text-slate-600'">{{ user ? '✅' : '⏳' }}</span>
              <div>
                <div class="font-semibold text-slate-200">6. Login ke sistem dengan akun baru</div>
                <div class="text-slate-400 text-[11px] mt-0.5">
                  {{ user ? 'Berhasil masuk ke sesi aplikasi.' : 'Silakan login di halaman /login.' }}
                </div>
              </div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-950/60 border border-slate-800/80 flex items-start space-x-3">
              <span class="text-base" :class="user && user.profile_photo_path ? 'text-emerald-400' : 'text-amber-400'">
                {{ user && user.profile_photo_path ? '✅' : '⚡' }}
              </span>
              <div>
                <div class="font-semibold text-slate-200">6b. Manajemen Profil & Unggah "Foto Profil"</div>
                <div class="text-slate-400 text-[11px] mt-0.5">
                  {{ user && user.profile_photo_path ? 'Foto profil telah berhasil diunggah!' : 'Buka menu profil di pojok kanan atas untuk mengunggah gambar.' }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Alkes Showcase Catalog (Visual Context) -->
        <div>
          <div class="flex items-center justify-between mb-4">
            <div>
              <h3 class="text-base font-bold text-white">Katalog Sampel Alat Kesehatan (Alkes)</h3>
              <p class="text-xs text-slate-400">Modul informasi produk dan inventaris alat medis</p>
            </div>
            <span class="text-xs text-teal-400 bg-teal-500/10 px-2.5 py-1 rounded-lg border border-teal-500/20 font-medium">
              4 Item Tersedia
            </span>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div
              v-for="item in alkesItems"
              :key="item.id"
              class="p-4 rounded-xl bg-slate-900/70 border border-slate-800/80 hover:border-teal-500/30 transition-all duration-200 flex flex-col justify-between"
            >
              <div>
                <div class="text-3xl mb-2">{{ item.icon }}</div>
                <h4 class="font-bold text-sm text-white">{{ item.name }}</h4>
                <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">{{ item.desc }}</p>
              </div>
              <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between text-xs">
                <span class="text-teal-400 font-semibold">{{ item.stock }} Unit</span>
                <span class="text-[10px] px-2 py-0.5 rounded bg-slate-800 text-slate-300">{{ item.category }}</span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800/80 bg-slate-900/40 py-6 text-center text-xs text-slate-500">
      <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span>Alkes App • Universitas Muhammadiyah Kudus (UMPKU)</span>
        <span>Laravel 10 • Vue 3 • Vite • Tailwind CSS</span>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue';

// Auth User State
const user = ref(window.__AUTH_USER__ || null);
const currentPath = ref(window.location.pathname);
const loading = ref(false);
const profileMenuOpen = ref(false);
const profileDropdownRef = ref(null);

// Forms
const registerForm = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const loginForm = reactive({
  email: '',
  password: '',
});

const profileForm = reactive({
  name: user.value ? user.value.name : '',
});

// Photo upload state
const fileInputRef = ref(null);
const selectedFile = ref(null);
const photoPreview = ref(null);
const uploadingPhoto = ref(false);
const updatingName = ref(false);

const errors = ref({});
const toast = reactive({
  show: false,
  message: '',
  type: 'success',
});

const showToast = (message, type = 'success') => {
  toast.message = message;
  toast.type = type;
  toast.show = true;
  setTimeout(() => {
    toast.show = false;
  }, 4000);
};

// Catalog demo items
const alkesItems = [
  { id: 1, name: 'Tensimeter Digital', desc: 'Pengukur tekanan darah otomatis presisi tinggi dengan display LCD.', stock: 15, category: 'Diagnostik', icon: '🩺' },
  { id: 2, name: 'Pulse Oximeter Fingertip', desc: 'Pemantau saturasi oksigen (SpO2) dan denyut nadi praktis.', stock: 24, category: 'Monitoring', icon: '❤️' },
  { id: 3, name: 'Termometer Inframerah', desc: 'Termometer non-kontak respons 1 detik dengan alarm suhu.', stock: 30, category: 'Diagnostik', icon: '🌡️' },
  { id: 4, name: 'Nebulizer Portabel', desc: 'Alat terapi pernapasan ultrasonik dengan partikel kabut halus.', stock: 8, category: 'Terapi', icon: '💨' },
];

const getCsrfToken = () => {
  return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.__CSRF_TOKEN__ || '';
};

// Client-side Navigation
const navigate = (path) => {
  window.history.pushState({}, '', path);
  currentPath.value = path;
  errors.value = {};
  window.scrollTo({ top: 0, behavior: 'smooth' });
};

// Handle Browser Back / Forward buttons
const handlePopState = () => {
  currentPath.value = window.location.pathname;
};

// Close dropdown on outside click
const handleClickOutside = (e) => {
  if (profileDropdownRef.value && !profileDropdownRef.value.contains(e.target)) {
    profileMenuOpen.value = false;
  }
};

onMounted(() => {
  window.addEventListener('popstate', handlePopState);
  document.addEventListener('click', handleClickOutside);

  // If path is root and user not logged in, remain or navigate to /register if desired
  if (window.location.pathname === '/register' || window.location.pathname === '/login') {
    currentPath.value = window.location.pathname;
  }
});

onUnmounted(() => {
  window.removeEventListener('popstate', handlePopState);
  document.removeEventListener('click', handleClickOutside);
});

// Helper for quick demo filling
const autofillDemo = () => {
  registerForm.name = 'Karina Fatah Binway';
  registerForm.email = '1202407014@students.umpku.ac.id';
  registerForm.password = 'password123';
  registerForm.password_confirmation = 'password123';
};

// Handlers
const handleRegister = async () => {
  loading.value = true;
  errors.value = {};

  try {
    const res = await fetch('/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
      body: JSON.stringify(registerForm),
    });

    const data = await res.json();

    if (!res.ok) {
      if (data.errors) {
        errors.value = data.errors;
      } else {
        showToast(data.message || 'Registrasi gagal.', 'error');
      }
      return;
    }

    user.value = data.user;
    profileForm.name = data.user.name;
    showToast('Registrasi berhasil! Anda telah masuk ke sistem.');
    navigate('/profile'); // Sesuai petunjuk langsung arahkan ke profile
  } catch (err) {
    showToast('Terjadi kesalahan jaringan.', 'error');
  } finally {
    loading.value = false;
  }
};

const handleLogin = async () => {
  loading.value = true;
  errors.value = {};

  try {
    const res = await fetch('/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
      body: JSON.stringify(loginForm),
    });

    const data = await res.json();

    if (!res.ok) {
      if (data.errors) {
        errors.value = data.errors;
      } else {
        showToast(data.message || 'Login gagal.', 'error');
      }
      return;
    }

    user.value = data.user;
    profileForm.name = data.user.name;
    showToast('Login berhasil!');
    navigate('/dashboard');
  } catch (err) {
    showToast('Terjadi kesalahan jaringan.', 'error');
  } finally {
    loading.value = false;
  }
};

const handleLogout = async () => {
  loading.value = true;
  try {
    await fetch('/logout', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
    });

    user.value = null;
    photoPreview.value = null;
    selectedFile.value = null;
    showToast('Anda telah keluar.');
    navigate('/login');
  } catch (err) {
    showToast('Gagal logout.', 'error');
  } finally {
    loading.value = false;
  }
};

const onFileSelected = (e) => {
  const file = e.target.files[0];
  if (!file) return;

  selectedFile.value = file;
  const reader = new FileReader();
  reader.onload = (event) => {
    photoPreview.value = event.target.result;
  };
  reader.readAsDataURL(file);
};

const uploadProfilePhoto = async () => {
  if (!selectedFile.value) return;

  uploadingPhoto.value = true;
  const formData = new FormData();
  formData.append('photo', selectedFile.value);

  try {
    const res = await fetch('/api/profile/photo', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
      body: formData,
    });

    const data = await res.json();

    if (!res.ok) {
      showToast(data.message || 'Gagal mengunggah foto profil.', 'error');
      return;
    }

    user.value = data.user;
    selectedFile.value = null;
    photoPreview.value = null;
    showToast('Foto Profil berhasil diperbarui!');
  } catch (err) {
    showToast('Gagal mengunggah gambar.', 'error');
  } finally {
    uploadingPhoto.value = false;
  }
};

const deleteProfilePhoto = async () => {
  if (!confirm('Apakah Anda yakin ingin menghapus foto profil?')) return;

  try {
    const res = await fetch('/api/profile/photo', {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
    });

    const data = await res.json();
    if (res.ok) {
      user.value = data.user;
      showToast('Foto profil dihapus.');
    }
  } catch (err) {
    showToast('Gagal menghapus foto profil.', 'error');
  }
};

const updateProfileName = async () => {
  updatingName.value = true;
  try {
    const res = await fetch('/api/profile', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': getCsrfToken(),
      },
      body: JSON.stringify({ name: profileForm.name }),
    });

    const data = await res.json();
    if (!res.ok) {
      showToast(data.message || 'Gagal memperbarui nama.', 'error');
      return;
    }

    user.value = data.user;
    showToast('Nama profil berhasil disimpan.');
  } catch (err) {
    showToast('Gagal menyimpan profil.', 'error');
  } finally {
    updatingName.value = false;
  }
};
</script>
